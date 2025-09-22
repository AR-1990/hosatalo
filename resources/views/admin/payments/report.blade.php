@extends('admin.layout.app')

@section('title', 'Payment Report')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}">Payments</a></li>
                        <li class="breadcrumb-item active">Report</li>
                    </ol>
                </div>
                <h4 class="page-title">
                    <i class="fas fa-chart-bar"></i> Payment Report
                </h4>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded">
                                <span class="avatar-title bg-success rounded">
                                    <i class="fas fa-money-bill-wave font-size-20"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-1">Total Completed</h5>
                            <h4 class="mb-0 text-success">PKR {{ number_format($totalAmount, 2) }}</h4>
                            <small class="text-muted">All successful payments</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded">
                                <span class="avatar-title bg-warning rounded">
                                    <i class="fas fa-clock font-size-20"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-1">Total Pending</h5>
                            <h4 class="mb-0 text-warning">PKR {{ number_format($totalPending, 2) }}</h4>
                            <small class="text-muted">Awaiting completion</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded">
                                <span class="avatar-title bg-danger rounded">
                                    <i class="fas fa-times-circle font-size-20"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-1">Total Failed</h5>
                            <h4 class="mb-0 text-danger">PKR {{ number_format($totalFailed, 2) }}</h4>
                            <small class="text-muted">Failed transactions</small>
                        </div>
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
                    <h5 class="card-title mb-0">
                        <i class="fas fa-filter"></i> Filter Payments
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.payments.report') }}" id="filterForm">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="fw-bold">Date From</label>
                                    <input type="date" name="date_from" class="form-control" 
                                           value="{{ request('date_from') }}">
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="fw-bold">Date To</label>
                                    <input type="date" name="date_to" class="form-control" 
                                           value="{{ request('date_to') }}">
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="form-group mb-3">
                                    <label class="fw-bold">Payment Method</label>
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
                                <div class="form-group mb-3">
                                    <label class="fw-bold">Status</label>
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
                                <div class="form-group mb-3">
                                    <label class="fw-bold">&nbsp;</label>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Report Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list"></i> Payment Details
                        </h5>
                        <div>
                            <a href="{{ route('admin.payments.export') }}?{{ http_build_query(request()->all()) }}" 
                               class="btn btn-success me-2">
                                <i class="fas fa-download"></i> Export CSV
                            </a>
                            <button type="button" class="btn btn-info" onclick="printReport()">
                                <i class="fas fa-print"></i> Print
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($payments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="paymentsTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Booking</th>
                                        <th>Customer</th>
                                        <th>Amount</th>
                                        <th>Payment Type</th>
                                        <th>Method</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Transaction ID</th>
                                        <th>Notes</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                    <tr>
                                        <td>#{{ $payment->id }}</td>
                                        <td>
                                            @if($payment->booking)
                                                <a href="{{ route('admin.bookings.show', $payment->booking) }}" 
                                                   class="text-primary">
                                                    #{{ $payment->booking->id }}
                                                </a>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($payment->user)
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-2">
                                                        <div class="avatar-title bg-primary rounded-circle text-white">
                                                            {{ strtoupper(substr($payment->user->name, 0, 1)) }}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $payment->user->name }}</h6>
                                                        <small class="text-muted">{{ $payment->user->email }}</small>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="fw-bold text-success">
                                                PKR {{ number_format($payment->amount, 2) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ ucfirst($payment->payment_type) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $payment->status === 'completed' ? 'success' : ($payment->status === 'pending' ? 'warning' : ($payment->status === 'failed' ? 'danger' : 'info')) }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="fw-bold">{{ $payment->created_at->format('d M Y') }}</div>
                                                <small class="text-muted">{{ $payment->created_at->format('H:i') }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            @if($payment->transaction_id)
                                                <span class="text-monospace">{{ $payment->transaction_id }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($payment->notes)
                                                <span class="text-truncate d-inline-block" style="max-width: 150px;" 
                                                      title="{{ $payment->notes }}">
                                                    {{ $payment->notes }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.payments.show', $payment) }}" 
                                                   class="btn btn-sm btn-outline-primary" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.payments.edit', $payment) }}" 
                                                   class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Summary Footer -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="alert alert-info">
                                    <h6 class="mb-2"><i class="fas fa-info-circle"></i> Report Summary</h6>
                                    <p class="mb-1"><strong>Total Payments:</strong> {{ $payments->count() }}</p>
                                    <p class="mb-1"><strong>Date Range:</strong> 
                                        {{ request('date_from') ? request('date_from') : 'All Time' }} - 
                                        {{ request('date_to') ? request('date_to') : 'All Time' }}
                                    </p>
                                    <p class="mb-0"><strong>Generated:</strong> {{ now()->format('d M Y H:i:s') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="alert alert-success">
                                    <h6 class="mb-2"><i class="fas fa-chart-line"></i> Financial Summary</h6>
                                    <p class="mb-1"><strong>Total Completed:</strong> PKR {{ number_format($totalAmount, 2) }}</p>
                                    <p class="mb-1"><strong>Total Pending:</strong> PKR {{ number_format($totalPending, 2) }}</p>
                                    <p class="mb-0"><strong>Total Failed:</strong> PKR {{ number_format($totalFailed, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="avatar-lg mx-auto mb-3">
                                <div class="avatar-title bg-light rounded-circle text-muted">
                                    <i class="fas fa-receipt font-size-24"></i>
                                </div>
                            </div>
                            <h5 class="text-muted">No Payments Found</h5>
                            <p class="text-muted">No payments match your current filters.</p>
                            <a href="{{ route('admin.payments.report') }}" class="btn btn-primary">
                                <i class="fas fa-refresh"></i> Clear Filters
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable if available
    if ($.fn.DataTable) {
        $('#paymentsTable').DataTable({
            pageLength: 25,
            order: [[7, 'desc']], // Sort by date descending
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    }

    // Auto-submit form when filters change
    $('select[name="payment_method"], select[name="status"]').on('change', function() {
        $('#filterForm').submit();
    });

    // Date validation
    $('input[name="date_from"], input[name="date_to"]').on('change', function() {
        const dateFrom = $('input[name="date_from"]').val();
        const dateTo = $('input[name="date_to"]').val();
        
        if (dateFrom && dateTo && dateFrom > dateTo) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Date Range!',
                text: 'Start date cannot be after end date.'
            });
            $(this).val('');
        }
    });
});

function printReport() {
    window.print();
}
</script>
@endpush
