<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            $payments = Payment::with(['booking', 'user'])->latest()->paginate(25);
        } elseif ($user->role === 'client') {
            $payments = Payment::whereHas('booking.room', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with(['booking', 'user'])->latest()->paginate(25);
        } else {
            $payments = $user->payments()->with(['booking'])->latest()->paginate(25);
        }
        
        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new payment
     */
    public function create(Booking $booking)
    {
        $paymentMethods = ['cash', 'bank_transfer', 'credit_card', 'online_payment'];
        $paymentTypes = ['advance', 'partial', 'full'];
        
        return view('admin.payments.create', compact('booking', 'paymentMethods', 'paymentTypes'));
    }

    /**
     * Store a newly created payment
     */
    public function store(Request $request, Booking $booking)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . $booking->outstanding_balance,
            'payment_type' => 'required|in:advance,partial,full',
            'payment_method' => 'required|in:cash,bank_transfer,credit_card,online_payment',
            'transaction_id' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        
        try {
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'user_id' => Auth::id(),
                'amount' => $request->amount,
                'payment_type' => $request->payment_type,
                'payment_method' => $request->payment_method,
                'transaction_id' => $request->transaction_id,
                'notes' => $request->notes,
                'status' => 'completed',
                'paid_at' => now(),
            ]);

            // Update booking payment status
            $booking->updatePaymentStatus();
            
            DB::commit();

            return redirect()->route('admin.bookings.show', $booking)
                ->with('success', 'Payment recorded successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to record payment. Please try again.']);
        }
    }

    /**
     * Display the specified payment
     */
    public function show(Payment $payment)
    {
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified payment
     */
    public function edit(Payment $payment)
    {
        $paymentMethods = ['cash', 'bank_transfer', 'credit_card', 'online_payment'];
        $paymentTypes = ['advance', 'partial', 'full'];
        
        return view('admin.payments.edit', compact('payment', 'paymentMethods', 'paymentTypes'));
    }

    /**
     * Update the specified payment
     */
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_type' => 'required|in:advance,partial,full',
            'payment_method' => 'required|in:cash,bank_transfer,credit_card,online_payment',
            'transaction_id' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,completed,failed,refunded',
        ]);

        DB::beginTransaction();
        
        try {
            $oldAmount = $payment->amount;
            
            $payment->update([
                'amount' => $request->amount,
                'payment_type' => $request->payment_type,
                'payment_method' => $request->payment_method,
                'transaction_id' => $request->transaction_id,
                'notes' => $request->notes,
                'status' => $request->status,
                'paid_at' => $request->status === 'completed' ? now() : null,
            ]);

            // Update booking payment status if amount changed
            if ($oldAmount != $request->amount) {
                $payment->booking->updatePaymentStatus();
            }
            
            DB::commit();

            return redirect()->route('admin.payments.show', $payment)
                ->with('success', 'Payment updated successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update payment. Please try again.']);
        }
    }

    /**
     * Remove the specified payment
     */
    public function destroy(Payment $payment)
    {
        DB::beginTransaction();
        
        try {
            $booking = $payment->booking;
            $payment->delete();
            
            // Update booking payment status
            $booking->updatePaymentStatus();
            
            DB::commit();

            return redirect()->route('admin.payments.index')
                ->with('success', 'Payment deleted successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to delete payment. Please try again.']);
        }
    }

    /**
     * Generate payment report
     */
    public function report(Request $request)
    {
        try {
            // Public route - no authentication required
            // Start with a simple query to avoid relationship issues
            $query = Payment::query();
            
            // Apply date filters
            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }
            
            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }
            
            // Apply payment method filter
            if ($request->filled('payment_method')) {
                $query->where('payment_method', $request->payment_method);
            }
            
            // Apply status filter
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            
            $payments = $query->latest()->get();
            
            // Calculate totals
            $totalAmount = $payments->where('status', 'completed')->sum('amount');
            $totalPending = $payments->where('status', 'pending')->sum('amount');
            $totalFailed = $payments->where('status', 'failed')->sum('amount');
            
            return view('admin.payments.report', compact('payments', 'totalAmount', 'totalPending', 'totalFailed'));
            
        } catch (\Exception $e) {
            // Log the error
            Log::error('Payment report error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Return a simple error response for debugging
            return response()->json([
                'error' => 'Payment report failed: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    /**
     * Export payments to Excel/PDF
     */
    public function export(Request $request)
    {
        // Public route - no authentication required
        $query = Payment::with(['booking', 'user']);
        
        $payments = $query->latest()->get();
        
        $filename = 'payments_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($payments) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'ID', 'Booking ID', 'Customer', 'Amount', 'Payment Type', 
                'Payment Method', 'Status', 'Date', 'Transaction ID', 'Notes'
            ]);
            
            // CSV data
            foreach ($payments as $payment) {
                fputcsv($file, [
                    $payment->id,
                    $payment->booking_id,
                    $payment->user->name,
                    $payment->amount,
                    ucfirst($payment->payment_type),
                    ucfirst(str_replace('_', ' ', $payment->payment_method)),
                    ucfirst($payment->status),
                    $payment->created_at->format('Y-m-d H:i:s'),
                    $payment->transaction_id,
                    $payment->notes,
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show the form for creating a new standalone payment
     */
    public function createStandalone()
    {
        $paymentMethods = ['cash', 'bank_transfer', 'credit_card', 'online_payment'];
        $paymentTypes = ['advance', 'partial', 'full'];
        
        return view('admin.payments.create-standalone', compact('paymentMethods', 'paymentTypes'));
    }

    /**
     * Store a newly created standalone payment
     */
    public function storeStandalone(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_type' => 'required|in:advance,partial,full',
            'payment_method' => 'required|in:cash,bank_transfer,credit_card,online_payment',
            'transaction_id' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $booking = Booking::findOrFail($request->booking_id);
        
        // Validate amount doesn't exceed outstanding balance
        if ($request->amount > $booking->outstanding_balance) {
            return back()->withErrors(['amount' => 'Amount cannot exceed outstanding balance of PKR ' . number_format($booking->outstanding_balance, 2)]);
        }

        DB::beginTransaction();
        
        try {
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'user_id' => Auth::id(),
                'amount' => $request->amount,
                'payment_type' => $request->payment_type,
                'payment_method' => $request->payment_method,
                'transaction_id' => $request->transaction_id,
                'notes' => $request->notes,
                'status' => 'completed',
                'paid_at' => now(),
            ]);

            // Update booking payment status
            $booking->updatePaymentStatus();
            
            DB::commit();

            return redirect()->route('admin.payments.index')
                ->with('success', 'Payment recorded successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to record payment. Please try again.']);
        }
    }

    /**
     * Search customers for payment creation
     */
    public function searchCustomers(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }
        
        $customers = User::where('role', 'customer')
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%")
                  ->orWhere('nic', 'LIKE', "%{$query}%")
                  ->orWhere('phone', 'LIKE', "%{$query}%");
            })
            ->with(['bookings' => function($q) {
                $q->where('status', '!=', 'cancelled')
                  ->where('payment_status', '!=', 'paid')
                  ->with('room')
                  ->latest();
            }])
            ->limit(10)
            ->get();
            
        return response()->json($customers->map(function($customer) {
            return [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'nic' => $customer->nic,
                'phone' => $customer->phone,
                'bookings' => $customer->bookings->map(function($booking) {
                    return [
                        'id' => $booking->id,
                        'room_name' => $booking->room->name ?? 'N/A',
                        'total_amount' => $booking->total_amount,
                        'outstanding_balance' => $booking->outstanding_balance,
                        'payment_status' => $booking->payment_status,
                        'check_in' => $booking->check_in,
                        'check_out' => $booking->check_out,
                    ];
                })
            ];
        }));
    }
}
