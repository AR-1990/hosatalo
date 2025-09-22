@extends('admin.layout.app')

@section('title', 'Booking Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">Bookings</a></li>
                        <li class="breadcrumb-item active">Booking #{{ $booking->id }}</li>
                    </ol>
                </div>
                <h4 class="page-title">
                    <i class="fas fa-calendar-check"></i> Booking Details
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Booking Information -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle"></i> Booking Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Booking ID:</td>
                                    <td>#{{ $booking->id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Status:</td>
                                    <td>
                                        <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : ($booking->status === 'pending' ? 'warning' : ($booking->status === 'cancelled' ? 'danger' : 'info')) }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Payment Status:</td>
                                    <td>
                                        @if(isset($booking->payment_status))
                                            <span class="badge bg-{{ $booking->payment_status === 'full' ? 'success' : ($booking->payment_status === 'partial' ? 'warning' : 'info') }}">
                                                {{ ucfirst($booking->payment_status) }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Not Set</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Total Amount:</td>
                                    <td class="fw-bold text-primary">PKR {{ number_format($booking->total_amount, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Check-in Date:</td>
                                    <td>{{ $booking->check_in_date->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Check-out Date:</td>
                                    <td>{{ $booking->check_out_date->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Number of Nights:</td>
                                    <td>{{ $booking->number_of_nights ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Created:</td>
                                    <td>{{ $booking->created_at->format('d M Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if(isset($booking->admin_notes) && $booking->admin_notes)
                    <div class="mt-3">
                        <h6 class="fw-bold">Admin Notes:</h6>
                        <p class="text-muted">{{ $booking->admin_notes }}</p>
                    </div>
                    @endif

                    @if(isset($booking->special_requests) && $booking->special_requests)
                    <div class="mt-3">
                        <h6 class="fw-bold">Special Requests:</h6>
                        <p class="text-muted">{{ $booking->special_requests }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Room Information -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bed"></i> Room Information
                    </h5>
                </div>
                <div class="card-body">
                    @if($booking->room)
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Room Name:</td>
                                    <td>{{ $booking->room->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Room Type:</td>
                                    <td>{{ $booking->room->room_type }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Capacity:</td>
                                    <td>{{ $booking->room->capacity }} person(s)</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Price per Night:</td>
                                    <td class="fw-bold text-success">PKR {{ number_format($booking->room->price_per_night, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Room Status:</td>
                                    <td>
                                        <span class="badge bg-{{ $booking->room->is_available ? 'success' : 'danger' }}">
                                            {{ $booking->room->is_available ? 'Available' : 'Occupied' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> Room information not available
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user"></i> Customer Information
                    </h5>
                </div>
                <div class="card-body">
                    @if($booking->user)
                    <div class="text-center mb-3">
                        <div class="avatar-lg mx-auto mb-3">
                            <div class="avatar-title bg-primary rounded-circle text-white font-size-24">
                                {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                            </div>
                        </div>
                        <h5 class="mb-1">{{ $booking->user->name }}</h5>
                        <p class="text-muted mb-0">{{ $booking->user->email }}</p>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold">Phone:</td>
                                <td>{{ $booking->user->phone ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Role:</td>
                                <td>
                                    <span class="badge bg-info">{{ ucfirst($booking->user->role) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Member Since:</td>
                                <td>{{ $booking->user->created_at->format('d M Y') }}</td>
                            </tr>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> Customer information not available
                    </div>
                    @endif

                    @if(isset($booking->customer_details))
                    <div class="mt-3">
                        <h6 class="fw-bold">Additional Details:</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless">
                                @foreach($booking->customer_details as $key => $value)
                                <tr>
                                    <td class="fw-bold">{{ ucfirst(str_replace('_', ' ', $key)) }}:</td>
                                    <td>{{ $value }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- NIC Information -->
            @if(isset($booking->nic_number) || isset($booking->nic_image_path))
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-id-card"></i> NIC Information
                    </h5>
                </div>
                <div class="card-body">
                    @if(isset($booking->nic_number))
                    <div class="mb-3">
                        <label class="fw-bold">NIC Number:</label>
                        <p class="mb-0">{{ $booking->nic_number }}</p>
                    </div>
                    @endif

                    @if(isset($booking->nic_image_path))
                    <div>
                        <label class="fw-bold">NIC Image:</label>
                        <div class="mt-2">
                            <img src="{{ asset($booking->nic_image_path) }}" alt="NIC Image" class="img-fluid rounded" style="max-height: 200px;">
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Payment Information -->
            @if($booking->payments && $booking->payments->count() > 0)
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-credit-card"></i> Payment History
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($booking->payments as $payment)
                    <div class="border-bottom pb-2 mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">PKR {{ number_format($payment->amount, 2) }}</h6>
                                <small class="text-muted">{{ ucfirst($payment->payment_type) }} - {{ ucfirst($payment->payment_method) }}</small>
                            </div>
                            <span class="badge bg-{{ $payment->status === 'completed' ? 'success' : 'warning' }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </div>
                        <small class="text-muted">{{ $payment->created_at->format('d M Y H:i') }}</small>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Booking
                        </a>
                        
                        @if($booking->status !== 'cancelled')
                        <button type="button" class="btn btn-warning" onclick="cancelBooking()">
                            <i class="fas fa-times"></i> Cancel Booking
                        </button>
                        @endif

                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Bookings
                        </a>

                        <button type="button" class="btn btn-info" onclick="printBooking()">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Booking Modal -->
<div class="modal fade" id="cancelBookingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cancel Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to cancel this booking?</p>
                <p class="text-muted">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Keep Booking</button>
                <button type="button" class="btn btn-danger" onclick="confirmCancel()">Yes, Cancel Booking</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function cancelBooking() {
    $('#cancelBookingModal').modal('show');
}

function confirmCancel() {
    // Add AJAX call to cancel booking
    $.ajax({
        url: '{{ route("admin.bookings.cancel", $booking) }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Booking Cancelled!',
                    text: response.message,
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    window.location.reload();
                });
            }
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to cancel booking. Please try again.'
            });
        }
    });
}

function printBooking() {
    window.print();
}
</script>
@endpush
