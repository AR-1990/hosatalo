@extends('admin.layout.app')

@section('title', 'Payment Details - Hostalo Admin Panel')

@section('content')
<div class="section-header">
    <h1>Payment Details</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}">Payments</a></div>
        <div class="breadcrumb-item active">Payment #{{ $payment->id }}</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <!-- Payment Information -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-credit-card"></i> Payment Information</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="font-weight-bold">Payment ID:</td>
                                    <td>#{{ $payment->id }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Amount:</td>
                                    <td class="font-weight-bold text-success">PKR {{ number_format($payment->amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Payment Type:</td>
                                    <td>
                                        <span class="badge badge-{{ $payment->payment_type === 'full' ? 'success' : ($payment->payment_type === 'partial' ? 'warning' : 'info') }}">
                                            {{ ucfirst($payment->payment_type) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Payment Method:</td>
                                    <td>
                                        <span class="badge badge-primary">
                                            {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Status:</td>
                                    <td>
                                        <span class="badge badge-{{ $payment->status === 'completed' ? 'success' : ($payment->status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="font-weight-bold">Transaction ID:</td>
                                    <td>{{ $payment->transaction_id ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Paid At:</td>
                                    <td>{{ $payment->paid_at ? $payment->paid_at->format('d M Y H:i') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Created:</td>
                                    <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Updated:</td>
                                    <td>{{ $payment->updated_at->format('d M Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($payment->notes)
                    <div class="mt-3">
                        <h6 class="font-weight-bold">Payment Notes:</h6>
                        <p class="text-muted">{{ $payment->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Related Booking Information -->
            @if($payment->booking)
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-calendar-check"></i> Related Booking</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="font-weight-bold">Booking ID:</td>
                                    <td>
                                        <a href="{{ route('admin.bookings.show', $payment->booking->id) }}" class="text-primary">
                                            #{{ $payment->booking->id }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Total Amount:</td>
                                    <td class="font-weight-bold">PKR {{ number_format($payment->booking->total_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Booking Status:</td>
                                    <td>
                                        <span class="badge badge-{{ $payment->booking->status === 'confirmed' ? 'success' : ($payment->booking->status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($payment->booking->status) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="font-weight-bold">Check-in:</td>
                                    <td>{{ $payment->booking->check_in_date->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Check-out:</td>
                                    <td>{{ $payment->booking->check_out_date->format('d M Y') }}</td>
                                </tr>
                                @if($payment->booking->room)
                                <tr>
                                    <td class="font-weight-bold">Room:</td>
                                    <td>{{ $payment->booking->room->name }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Customer Information -->
            @if($payment->user)
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-user"></i> Customer Information</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="font-weight-bold">Name:</td>
                                    <td>{{ $payment->user->name }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Email:</td>
                                    <td>{{ $payment->user->email }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="font-weight-bold">Phone:</td>
                                    <td>{{ $payment->user->phone ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Role:</td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ ucfirst($payment->user->role) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Action Panel -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-cogs"></i> Actions</h4>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Payments
                        </a>
                        
                        @if($payment->booking)
                        <a href="{{ route('admin.bookings.show', $payment->booking->id) }}" class="btn btn-info">
                            <i class="fas fa-calendar-check"></i> View Booking
                        </a>
                        @endif

                        @if($payment->status !== 'completed')
                        <form action="{{ route('admin.payments.mark-completed', $payment->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success w-100" onclick="return confirm('Mark this payment as completed?')">
                                <i class="fas fa-check"></i> Mark as Completed
                            </button>
                        </form>
                        @endif

                        <a href="{{ route('admin.payments.edit', $payment->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Payment
                        </a>

                        <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to delete this payment?')">
                                <i class="fas fa-trash"></i> Delete Payment
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Payment Summary -->
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-chart-pie"></i> Payment Summary</h4>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <h3 class="text-success">PKR {{ number_format($payment->amount, 2) }}</h3>
                        <p class="text-muted">Payment Amount</p>
                        
                        @if($payment->booking)
                        <hr>
                        <div class="row text-center">
                            <div class="col-6">
                                <h6 class="text-muted">Total Booking</h6>
                                <p class="font-weight-bold">PKR {{ number_format($payment->booking->total_amount, 2) }}</p>
                            </div>
                            <div class="col-6">
                                <h6 class="text-muted">This Payment</h6>
                                <p class="font-weight-bold text-success">{{ number_format(($payment->amount / $payment->booking->total_amount) * 100, 1) }}%</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection