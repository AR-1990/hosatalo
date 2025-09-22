<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Support\Facades\Validator;
use App\Models\Contact;
use App\Models\Payment;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'client') {
                return redirect()->route('client.dashboard');
            } else {
                return redirect()->route('user.dashboard');
            }
        }

        return redirect()->back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    /**
     * Show registration form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role for new registrations
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        Auth::login($user);

        return redirect()->route('user.dashboard')->with('success', 'Registration successful!');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'You have been successfully logged out!');
    }

    /**
     * Show user dashboard
     */
    public function userDashboard()
    {
        $user = Auth::user();
        $bookings = $user->bookings()->with('room')->latest()->get();
        
        return view('user.dashboard', compact('user', 'bookings'));
    }

    /**
     * Show client dashboard
     */
    public function clientDashboard()
    {
        $user = Auth::user();
        $rooms = Room::where('user_id', $user->id)->get();
        
        return view('client.dashboard', compact('user', 'rooms'));
    }

    /**
     * Show admin dashboard
     */
    public function adminDashboard()
    {
        try {
            // Basic counts
            $totalUsers = User::count();
            $totalRooms = Room::count();
            $totalBookings = Booking::count();
            $totalLeads = Contact::count();
            
            // Hostel/Client counts
            $totalHostels = User::where('role', 'client')->count();
            $totalCustomers = User::where('role', 'customer')->count();
            $totalAdmins = User::where('role', 'admin')->count();
            
            // Room statistics by hostel
            $roomsByHostel = Room::with('user')
                ->get()
                ->groupBy('user_id')
                ->map(function($rooms, $userId) {
                    $user = $rooms->first()->user;
                    return [
                        'hostel_name' => $user->name ?? 'Unknown Hostel',
                        'total_rooms' => $rooms->count(),
                        'available_rooms' => $rooms->where('status', 'available')->count(),
                        'booked_rooms' => $rooms->where('status', 'booked')->count(),
                        'hostel_id' => $userId
                    ];
                });
            
            // Recent bookings with proper error handling
            $recentBookings = Booking::with(['user', 'room'])
                ->latest()
                ->take(5)
                ->get()
                ->map(function($booking) {
                    return [
                        'id' => $booking->id,
                        'customer_name' => $booking->user->name ?? 'N/A',
                        'customer_email' => $booking->user->email ?? 'N/A',
                        'room_name' => $booking->room->name ?? 'N/A',
                        'hostel_name' => $booking->room->user->name ?? 'N/A',
                        'status' => $booking->status ?? 'pending',
                        'check_in' => $booking->check_in_date ?? 'N/A',
                        'check_out' => $booking->check_out_date ?? 'N/A',
                        'amount' => $booking->total_amount ?? 0,
                        'created_at' => $booking->created_at
                    ];
                });
            
            // Recent leads
            $recentLeads = Contact::latest()->take(5)->get();
            
            // Payment statistics
            $totalRevenue = Payment::where('status', 'completed')->sum('amount');
            $pendingPayments = Payment::where('status', 'pending')->sum('amount');
            $totalPayments = Payment::count();
            
            // Revenue by hostel
            $revenueByHostel = Payment::with(['booking.room.user'])
                ->where('status', 'completed')
                ->get()
                ->groupBy('booking.room.user_id')
                ->map(function($payments, $userId) {
                    $firstPayment = $payments->first();
                    $hostelName = $firstPayment->booking->room->user->name ?? 'Unknown Hostel';
                    return [
                        'hostel_name' => $hostelName,
                        'total_revenue' => $payments->sum('amount'),
                        'total_payments' => $payments->count(),
                        'hostel_id' => $userId
                    ];
                });
            
            // Monthly revenue trend (last 6 months)
            $monthlyRevenue = Payment::where('status', 'completed')
                ->where('created_at', '>=', now()->subMonths(6))
                ->get()
                ->groupBy(function($payment) {
                    return $payment->created_at->format('Y-m');
                })
                ->map(function($payments) {
                    return $payments->sum('amount');
                });
            
            // Top performing hostels
            $topHostels = $revenueByHostel->sortByDesc('total_revenue')->take(5);
            
            // Recent activities
            $recentActivities = collect();
            
            // Add recent bookings
            $recentActivities = $recentActivities->merge(
                $recentBookings->map(function($booking) {
                    return [
                        'type' => 'booking',
                        'title' => 'New booking from ' . $booking['customer_name'],
                        'description' => 'Room: ' . $booking['room_name'] . ' at ' . $booking['hostel_name'],
                        'time' => $booking['created_at'],
                        'icon' => 'calendar',
                        'color' => 'success'
                    ];
                })
            );
            
            // Add recent leads
            $recentActivities = $recentActivities->merge(
                $recentLeads->map(function($lead) {
                    return [
                        'type' => 'lead',
                        'title' => 'New lead from ' . $lead->name,
                        'description' => 'Email: ' . $lead->email,
                        'time' => $lead->created_at,
                        'icon' => 'user-plus',
                        'color' => 'info'
                    ];
                })
            );
            
            // Sort activities by time
            $recentActivities = $recentActivities->sortByDesc('time')->take(10);
            
            return view('admin.dashboard', compact(
                'totalUsers', 
                'totalRooms', 
                'totalBookings', 
                'totalLeads',
                'totalHostels',
                'totalCustomers',
                'totalAdmins',
                'roomsByHostel',
                'recentBookings',
                'recentLeads',
                'totalRevenue',
                'pendingPayments',
                'totalPayments',
                'revenueByHostel',
                'monthlyRevenue',
                'topHostels',
                'recentActivities'
            ));
            
        } catch (\Exception $e) {
            \Log::error('Admin dashboard error: ' . $e->getMessage());
            
            // Return basic data even if there's an error
            return view('admin.dashboard', [
                'totalUsers' => 0,
                'totalRooms' => 0,
                'totalBookings' => 0,
                'totalLeads' => 0,
                'totalHostels' => 0,
                'totalCustomers' => 0,
                'totalAdmins' => 0,
                'roomsByHostel' => collect(),
                'recentBookings' => collect(),
                'recentLeads' => collect(),
                'totalRevenue' => 0,
                'pendingPayments' => 0,
                'totalPayments' => 0,
                'revenueByHostel' => collect(),
                'monthlyRevenue' => collect(),
                'topHostels' => collect(),
                'recentActivities' => collect(),
                'error' => 'Some data could not be loaded. Please check the logs.'
            ]);
        }
    }
}
