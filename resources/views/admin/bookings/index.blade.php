@extends('admin.layout.app')

@section('title', 'Manage Bookings - Hostalo Admin Panel')

@section('content')
<div class="section-header">
  <h1>Manage Bookings</h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
    <div class="breadcrumb-item active">Manage Bookings</div>
  </div>
</div>

<!-- Statistics Cards -->
<div class="row">
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-primary">
        <i class="fas fa-calendar-check"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Total Bookings</h4>
        </div>
        <div class="card-body">
          {{ $totalBookings ?? 0 }}
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-success">
        <i class="fas fa-check-circle"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Confirmed</h4>
        </div>
        <div class="card-body">
          {{ $confirmedBookings ?? 0 }}
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-warning">
        <i class="fas fa-clock"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Pending</h4>
        </div>
        <div class="card-body">
          {{ $pendingBookings ?? 0 }}
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-info">
        <i class="fas fa-credit-card"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Total Revenue</h4>
        </div>
        <div class="card-body">
          PKR {{ number_format($totalRevenue ?? 0, 2) }}
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Filters -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4><i class="fas fa-filter"></i> Filters</h4>
      </div>
      <div class="card-body">
        <form method="GET" action="{{ route('admin.bookings.index') }}" id="filterForm">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Search</label>
                <input type="text" name="search" class="form-control" placeholder="Search by customer, room..." value="{{ request('search') }}">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                  <option value="">All Status</option>
                  <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                  <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                  <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                  <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Payment Status</label>
                <select name="payment_status" class="form-control">
                  <option value="">All Payments</option>
                  <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                  <option value="advance" {{ request('payment_status') === 'advance' ? 'selected' : '' }}>Advance</option>
                  <option value="partial" {{ request('payment_status') === 'partial' ? 'selected' : '' }}>Partial</option>
                  <option value="full" {{ request('payment_status') === 'full' ? 'selected' : '' }}>Full</option>
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>From Date</label>
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>To Date</label>
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
              </div>
            </div>
            <div class="col-md-1">
              <div class="form-group">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary btn-block">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Bookings Table -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4><i class="fas fa-list"></i> All Bookings</h4>
        <div class="card-header-action">
          <a href="{{ route('admin.bookings.create') }}" class="btn btn-success me-2">
            <i class="fas fa-plus"></i> Add New Booking
          </a>
          <a href="{{ route('admin.bookings.report') }}" class="btn btn-info">
            <i class="fas fa-chart-bar"></i> Generate Report
          </a>
        </div>
      </div>
      <div class="card-body">
        @if($bookings->count() > 0)
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Customer</th>
                  <th>Room</th>
                  <th>Check-in</th>
                  <th>Check-out</th>
                  <th>Total Amount</th>
                  <th>Payment Status</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($bookings as $booking)
                  <tr>
                    <td>{{ $booking->id }}</td>
                    <td>
                      <strong>{{ $booking->customer_name ?? 'N/A' }}</strong><br>
                      <small class="text-muted">{{ $booking->customer_email ?? 'N/A' }}</small>
                    </td>
                    <td>
                      <strong>{{ $booking->room_name ?? 'N/A' }}</strong><br>
                      <small class="text-muted">{{ $booking->room_type ?? 'N/A' }}</small>
                    </td>
                    <td>
                      @if($booking->check_in_date)
                        {{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}
                      @else
                        N/A
                      @endif
                    </td>
                    <td>
                      @if($booking->check_out_date)
                        {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}
                      @else
                        N/A
                      @endif
                    </td>
                    <td>
                      <strong>PKR {{ number_format($booking->total_amount ?? 0, 2) }}</strong><br>
                      @if($booking->outstanding_balance > 0)
                        <small class="text-danger">Outstanding: PKR {{ number_format($booking->outstanding_balance, 2) }}</small>
                      @endif
                    </td>
                    <td>
                      @php
                        $paymentStatus = $booking->payment_status ?? 'pending';
                        $statusColors = [
                          'pending' => 'secondary',
                          'advance' => 'warning',
                          'partial' => 'info',
                          'full' => 'success'
                        ];
                      @endphp
                      <span class="badge badge-{{ $statusColors[$paymentStatus] }}">
                        {{ ucfirst($paymentStatus) }}
                      </span>
                    </td>
                    <td>
                      @php
                        $status = $booking->status ?? 'pending';
                        $statusColors = [
                          'pending' => 'warning',
                          'confirmed' => 'success',
                          'cancelled' => 'danger',
                          'completed' => 'info'
                        ];
                      @endphp
                      <span class="badge badge-{{ $statusColors[$status] }}">
                        {{ ucfirst($status) }}
                      </span>
                    </td>
                    <td>
                      <div class="btn-group" role="group">
                        <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary" title="View">
                          <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                          <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('admin.payments.create', $booking) }}" class="btn btn-sm btn-outline-success" title="Add Payment">
                          <i class="fas fa-credit-card"></i>
                        </a>
                        @if($booking->status !== 'cancelled')
                          <button type="button" class="btn btn-sm btn-outline-danger" title="Cancel" onclick="cancelBooking({{ $booking->id }})">
                            <i class="fas fa-times"></i>
                          </button>
                        @endif
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          
          <!-- Pagination -->
          <div class="d-flex justify-content-center">
            {{ $bookings->appends(request()->query())->links() }}
          </div>
        @else
          <div class="text-center py-4">
            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
            <h5>No Bookings Found</h5>
            <p class="text-muted">No bookings match your current filters.</p>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Cancel Booking Modal -->
<div class="modal fade" id="cancelBookingModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cancel Booking</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="cancelBookingForm" method="POST">
        @csrf
        @method('POST')
        <div class="modal-body">
          <p>Are you sure you want to cancel this booking?</p>
          <div class="form-group">
            <label>Reason for Cancellation</label>
            <textarea name="cancellation_reason" class="form-control" rows="3" placeholder="Please provide a reason for cancellation"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Cancel Booking</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function cancelBooking(bookingId) {
  if (confirm('Are you sure you want to cancel this booking?')) {
    document.getElementById('cancelBookingForm').action = `/admin/bookings/${bookingId}/cancel`;
    $('#cancelBookingModal').modal('show');
  }
}

// Auto-submit form when filters change
document.querySelectorAll('#filterForm select, #filterForm input[type="date"]').forEach(function(element) {
  element.addEventListener('change', function() {
    document.getElementById('filterForm').submit();
  });
});
</script>
@endpush
