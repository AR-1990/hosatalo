@extends('admin.layout.app')

@section('title', 'Manage Payments - Hostalo Admin Panel')

@section('content')
<div class="section-header">
  <h1>Manage Payments</h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
    <div class="breadcrumb-item active">Manage Payments</div>
  </div>
</div>

<!-- Statistics Cards -->
<div class="row">
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-primary">
        <i class="fas fa-credit-card"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Total Payments</h4>
        </div>
        <div class="card-body">
          {{ $totalPayments ?? 0 }}
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
          <h4>Completed</h4>
        </div>
        <div class="card-body">
          {{ $completedPayments ?? 0 }}
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
          {{ $pendingPayments ?? 0 }}
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-info">
        <i class="fas fa-money-bill-wave"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Total Amount</h4>
        </div>
        <div class="card-body">
          PKR {{ number_format($totalAmount ?? 0, 2) }}
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
        <form method="GET" action="{{ route('admin.payments.index') }}" id="filterForm">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Search</label>
                <input type="text" name="search" class="form-control" placeholder="Search by customer, transaction..." value="{{ request('search') }}">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                  <option value="">All Status</option>
                  <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                  <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                  <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                  <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Payment Method</label>
                <select name="payment_method" class="form-control">
                  <option value="">All Methods</option>
                  <option value="cash" {{ request('payment_method') === 'cash' ? 'selected' : '' }}>Cash</option>
                  <option value="bank_transfer" {{ request('payment_method') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                  <option value="credit_card" {{ request('payment_method') === 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                  <option value="online_payment" {{ request('payment_method') === 'online_payment' ? 'selected' : '' }}>Online Payment</option>
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

<!-- Payments Table -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4><i class="fas fa-list"></i> All Payments</h4>
        <div class="card-header-action">
          <!-- <a href="{{ route('admin.payments.create.standalone') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Add Payment
          </a> -->
          <a href="{{ route('admin.payments.report') }}" class="btn btn-info ml-2">
            <i class="fas fa-chart-bar"></i> Generate Report
          </a>
        </div>
      </div>
      <div class="card-body">
        @if($payments->count() > 0)
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Customer</th>
                  <th>Booking</th>
                  <th>Amount</th>
                  <th>Payment Type</th>
                  <th>Method</th>
                  <th>Status</th>
                  <th>Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($payments as $payment)
                  <tr>
                    <td>{{ $payment->id }}</td>
                    <td>
                      <strong>{{ $payment->user->name ?? 'N/A' }}</strong><br>
                      <small class="text-muted">{{ $payment->user->email ?? 'N/A' }}</small>
                    </td>
                    <td>
                      <strong>#{{ $payment->booking->id ?? 'N/A' }}</strong><br>
                      <small class="text-muted">{{ $payment->booking->room_name ?? 'N/A' }}</small>
                    </td>
                    <td>
                      <strong class="text-success">PKR {{ number_format($payment->amount, 2) }}</strong>
                    </td>
                    <td>
                      @php
                        $paymentType = $payment->payment_type ?? 'advance';
                        $typeColors = [
                          'advance' => 'warning',
                          'partial' => 'info',
                          'full' => 'success'
                        ];
                      @endphp
                      <span class="badge badge-{{ $typeColors[$paymentType] }}">
                        {{ ucfirst($paymentType) }}
                      </span>
                    </td>
                    <td>
                      <span class="badge badge-secondary">
                        {{ ucfirst(str_replace('_', ' ', $payment->payment_method ?? 'N/A')) }}
                      </span>
                    </td>
                    <td>
                      @php
                        $status = $payment->status ?? 'pending';
                        $statusColors = [
                          'pending' => 'warning',
                          'completed' => 'success',
                          'failed' => 'danger',
                          'refunded' => 'info'
                        ];
                      @endphp
                      <span class="badge badge-{{ $statusColors[$status] }}">
                        {{ ucfirst($status) }}
                      </span>
                    </td>
                    <td>
                      @if($payment->paid_at)
                        {{ $payment->paid_at->format('M d, Y H:i') }}
                      @else
                        {{ $payment->created_at->format('M d, Y H:i') }}
                      @endif
                    </td>
                    <td>
                      <div class="btn-group" role="group">
                        <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-sm btn-outline-primary" title="View">
                          <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.payments.edit', $payment) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                          <i class="fas fa-edit"></i>
                        </a>
                        @if($payment->status === 'pending')
                          <button type="button" class="btn btn-sm btn-outline-success" title="Mark as Completed" onclick="markAsCompleted({{ $payment->id }})">
                            <i class="fas fa-check"></i>
                          </button>
                        @endif
                        <button type="button" class="btn btn-sm btn-outline-danger" title="Delete" onclick="deletePayment({{ $payment->id }})">
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          
          <!-- Pagination -->
          <div class="d-flex justify-content-center">
            {{ $payments->appends(request()->query())->links() }}
          </div>
        @else
          <div class="text-center py-4">
            <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
            <h5>No Payments Found</h5>
            <p class="text-muted">No payments match your current filters.</p>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function markAsCompleted(paymentId) {
  if (confirm('Are you sure you want to mark this payment as completed?')) {
    fetch(`/admin/payments/${paymentId}/mark-completed`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        location.reload();
      } else {
        alert('Error: ' + data.message);
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('An error occurred while updating the payment.');
    });
  }
}

function deletePayment(paymentId) {
  if (confirm('Are you sure you want to delete this payment? This action cannot be undone.')) {
    fetch(`/admin/payments/${paymentId}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        location.reload();
      } else {
        alert('Error: ' + data.message);
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('An error occurred while deleting the payment.');
    });
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
