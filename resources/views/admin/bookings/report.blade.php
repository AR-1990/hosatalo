@extends('admin.layout.app')
@section('title', 'Bookings Report - Hostalo Admin Panel')
@section('content')
<div class="section-header">
    <h1>Bookings Report</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">Bookings</a></div>
        <div class="breadcrumb-item active">Report</div>
    </div>
</div>
<div class="section-body">
    <!-- Summary Statistics -->
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
                        {{ $totalBookings }}
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
                        {{ $confirmedBookings }}
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
                        {{ $pendingBookings }}
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
                        <h4>Total Revenue</h4>
                    </div>
                    <div class="card-body">
                        PKR {{ number_format($totalRevenue, 2) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Outstanding Balance Card -->
    <div class="row">
        <div class="col-lg-6 col-md-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Outstanding Balance</h4>
                    </div>
                    <div class="card-body">
                        PKR {{ number_format($totalOutstanding, 2) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-percentage"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Collection Rate</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalRevenue > 0 ? number_format((($totalRevenue - $totalOutstanding) / $totalRevenue) * 100, 1) : 0 }}%
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
                    <h4><i class="fas fa-filter"></i> Report Filters</h4>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.bookings.report') }}" id="reportFilterForm">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Date From</label>
                                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Date To</label>
                                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
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
                                        <option value="">All Payment Status</option>
                                        <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="advance" {{ request('payment_status') === 'advance' ? 'selected' : '' }}>Advance</option>
                                        <option value="partial" {{ request('payment_status') === 'partial' ? 'selected' : '' }}>Partial</option>
                                        <option value="full" {{ request('payment_status') === 'full' ? 'selected' : '' }}>Full</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-primary mr-2">
                                            <i class="fas fa-search"></i> Filter
                                        </button>
                                        <a href="{{ route('admin.bookings.report') }}" class="btn btn-secondary">
                                            <i class="fas fa-undo"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Report Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-table"></i> Detailed Bookings Report</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.bookings.export', request()->all()) }}" class="btn btn-success">
                            <i class="fas fa-download"></i> Export CSV
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-md">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Room</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th>Nights</th>
                                    <th>Total Amount</th>
                                    <th>Outstanding</th>
                                    <th>Status</th>
                                    <th>Payment Status</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-primary">
                                            #{{ $booking->id }}
                                        </a>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $booking->user->name ?? 'N/A' }}</strong><br>
                                            <small class="text-muted">{{ $booking->user->email ?? 'N/A' }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $booking->room->name ?? 'N/A' }}
                                    </td>
                                    <td>{{ $booking->check_in_date->format('d M Y') }}</td>
                                    <td>{{ $booking->check_out_date->format('d M Y') }}</td>
                                    <td>{{ $booking->nights }}</td>
                                    <td class="font-weight-bold">PKR {{ number_format($booking->total_amount, 2) }}</td>
                                    <td class="font-weight-bold {{ $booking->outstanding_balance > 0 ? 'text-danger' : 'text-success' }}">
                                        PKR {{ number_format($booking->outstanding_balance, 2) }}
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $booking->status === 'confirmed' ? 'success' : ($booking->status === 'pending' ? 'warning' : ($booking->status === 'cancelled' ? 'danger' : 'info')) }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $booking->payment_status === 'full' ? 'success' : ($booking->payment_status === 'partial' || $booking->payment_status === 'advance' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($booking->payment_status) }}
                                        </span>
                                    </td>
                                    <td>{{ $booking->created_at->format('d M Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="11" class="text-center py-4">
                                        <div class="empty-state">
                                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No bookings found</h5>
                                            <p class="text-muted">Try adjusting your filters or date range.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary by Status -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-chart-pie"></i> Bookings by Status</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            $statusCounts = $bookings->groupBy('status')->map->count();
                        @endphp
                        @foreach(['pending', 'confirmed', 'cancelled', 'completed'] as $status)
                        <div class="col-6 mb-3">
                            <div class="text-center">
                                <h6 class="text-{{ $status === 'confirmed' || $status === 'completed' ? 'success' : ($status === 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($status) }}
                                </h6>
                                <h4>{{ $statusCounts[$status] ?? 0 }}</h4>
                                <small class="text-muted">
                                    {{ $totalBookings > 0 ? number_format((($statusCounts[$status] ?? 0) / $totalBookings) * 100, 1) : 0 }}%
                                </small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-credit-card"></i> Payment Status Summary</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            $paymentCounts = $bookings->groupBy('payment_status')->map->count();
                        @endphp
                        @foreach(['pending', 'advance', 'partial', 'full'] as $paymentStatus)
                        <div class="col-6 mb-3">
                            <div class="text-center">
                                <h6 class="text-{{ $paymentStatus === 'full' ? 'success' : ($paymentStatus === 'partial' || $paymentStatus === 'advance' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($paymentStatus) }}
                                </h6>
                                <h4>{{ $paymentCounts[$paymentStatus] ?? 0 }}</h4>
                                <small class="text-muted">
                                    {{ $totalBookings > 0 ? number_format((($paymentCounts[$paymentStatus] ?? 0) / $totalBookings) * 100, 1) : 0 }}%
                                </small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection