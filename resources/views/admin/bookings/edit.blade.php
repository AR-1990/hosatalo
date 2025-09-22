@extends('admin.layout.app')

@section('title', 'Edit Booking')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">Bookings</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.bookings.show', $booking) }}">Booking #{{ $booking->id }}</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
                <h4 class="page-title">
                    <i class="fas fa-edit"></i> Edit Booking #{{ $booking->id }}
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calendar-check"></i> Update Booking Information
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.bookings.update', $booking) }}" id="editBookingForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Room Assignment -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="fw-bold">Assigned Room <span class="text-danger">*</span></label>
                                    <select name="assigned_room_id" class="form-control" required>
                                        <option value="">Select Room</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id }}" 
                                                {{ $booking->assigned_room_id == $room->id ? 'selected' : '' }}
                                                data-price="{{ $room->price_per_night }}"
                                                data-type="{{ $room->room_type }}">
                                                {{ $room->name }} - {{ $room->room_type }} (PKR {{ $room->price_per_night }}/night)
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Select the room to assign for this booking</small>
                                </div>
                            </div>

                            <!-- Booking Status -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="fw-bold">Booking Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control" required>
                                        <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Check-in Date -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="fw-bold">Check-in Date <span class="text-danger">*</span></label>
                                    <input type="date" name="check_in_date" class="form-control" 
                                           value="{{ $booking->check_in_date->format('Y-m-d') }}" required>
                                </div>
                            </div>

                            <!-- Check-out Date -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="fw-bold">Check-out Date <span class="text-danger">*</span></label>
                                    <input type="date" name="check_out_date" class="form-control" 
                                           value="{{ $booking->check_out_date->format('Y-m-d') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Total Amount -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="fw-bold">Total Amount (PKR) <span class="text-danger">*</span></label>
                                    <input type="number" name="total_amount" class="form-control" 
                                           value="{{ $booking->total_amount }}" step="0.01" min="0.01" required>
                                    <small class="text-muted">Total amount for the entire stay</small>
                                </div>
                            </div>

                            <!-- Payment Status -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="fw-bold">Payment Status</label>
                                    <select name="payment_status" class="form-control">
                                        <option value="pending" {{ isset($booking->payment_status) && $booking->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="advance" {{ isset($booking->payment_status) && $booking->payment_status === 'advance' ? 'selected' : '' }}>Advance</option>
                                        <option value="partial" {{ isset($booking->payment_status) && $booking->payment_status === 'partial' ? 'selected' : '' }}>Partial</option>
                                        <option value="full" {{ isset($booking->payment_status) && $booking->payment_status === 'full' ? 'selected' : '' }}>Full</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Admin Notes -->
                        <div class="form-group mb-3">
                            <label class="fw-bold">Admin Notes</label>
                            <textarea name="admin_notes" class="form-control" rows="3" 
                                      placeholder="Add any administrative notes or special instructions...">{{ $booking->admin_notes ?? '' }}</textarea>
                            <small class="text-muted">Internal notes for staff reference</small>
                        </div>

                        <!-- Current Booking Summary -->
                        <div class="alert alert-info">
                            <h6 class="mb-2"><i class="fas fa-info-circle"></i> Current Booking Summary</h6>
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Customer:</strong><br>
                                    <span class="text-muted">{{ $booking->user->name ?? 'N/A' }}</span>
                                </div>
                                <div class="col-md-3">
                                    <strong>Current Room:</strong><br>
                                    <span class="text-muted">{{ $booking->room->name ?? 'N/A' }}</span>
                                </div>
                                <div class="col-md-3">
                                    <strong>Nights:</strong><br>
                                    <span class="text-muted">{{ $booking->number_of_nights ?? 'N/A' }}</span>
                                </div>
                                <div class="col-md-3">
                                    <strong>Created:</strong><br>
                                    <span class="text-muted">{{ $booking->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Booking
                            </button>
                            
                            <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Management Section -->
    @if($booking->payments && $booking->payments->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-credit-card"></i> Payment History
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Method</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($booking->payments as $payment)
                                <tr>
                                    <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                                    <td class="fw-bold">PKR {{ number_format($payment->amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($payment->payment_type) }}</span>
                                    </td>
                                    <td>{{ ucfirst($payment->payment_method) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $payment->status === 'completed' ? 'success' : 'warning' }}">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $payment->notes ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Add New Payment Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus"></i> Add New Payment
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.payments.store', $booking) }}" id="addPaymentForm">
                        @csrf
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="fw-bold">Amount (PKR) <span class="text-danger">*</span></label>
                                    <input type="number" name="amount" class="form-control" step="0.01" min="0.01" required>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="fw-bold">Payment Type <span class="text-danger">*</span></label>
                                    <select name="payment_type" class="form-control" required>
                                        <option value="advance">Advance</option>
                                        <option value="partial">Partial</option>
                                        <option value="full">Full</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="fw-bold">Payment Method <span class="text-danger">*</span></label>
                                    <select name="payment_method" class="form-control" required>
                                        <option value="cash">Cash</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                        <option value="credit_card">Credit Card</option>
                                        <option value="online_payment">Online Payment</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="fw-bold">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="pending">Pending</option>
                                        <option value="completed" selected>Completed</option>
                                        <option value="failed">Failed</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="fw-bold">Notes</label>
                            <textarea name="notes" class="form-control" rows="2" 
                                      placeholder="Payment notes or transaction reference..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plus"></i> Add Payment
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Date validation
    $('input[name="check_out_date"]').on('change', function() {
        const checkIn = $('input[name="check_in_date"]').val();
        const checkOut = $(this).val();
        
        if (checkIn && checkOut && checkOut <= checkIn) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Dates!',
                text: 'Check-out date must be after check-in date.'
            });
            $(this).val('');
        }
    });

    // Form submission
    $('#editBookingForm').on('submit', function(e) {
        const checkIn = $('input[name="check_in_date"]').val();
        const checkOut = $('input[name="check_out_date"]').val();
        
        if (checkIn && checkOut && checkOut <= checkIn) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Invalid Dates!',
                text: 'Check-out date must be after check-in date.'
            });
            return false;
        }
    });

    // Payment form submission
    $('#addPaymentForm').on('submit', function(e) {
        const amount = $('input[name="amount"]').val();
        
        if (amount <= 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Invalid Amount!',
                text: 'Payment amount must be greater than zero.'
            });
            return false;
        }
    });
});
</script>
@endpush
