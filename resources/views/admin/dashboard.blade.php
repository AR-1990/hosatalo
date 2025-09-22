@extends('admin.layout.app')

@section('title', 'Super Admin Dashboard - Hostalo')

@section('content')
<div class="section-header">
  <h1><i class="fas fa-crown"></i> Super Admin Dashboard</h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item active">Dashboard</div>
  </div>
</div>

@if(isset($error))
<div class="alert alert-warning alert-dismissible show fade">
  <div class="alert-body">
    <button class="close" data-dismiss="alert">
      <span>&times;</span>
    </button>
    <i class="fas fa-exclamation-triangle"></i> {{ $error }}
  </div>
</div>
@endif

<!-- Main Statistics Cards -->
<div class="row">
  <div class="col-lg-2 col-md-4 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-primary">
        <i class="fas fa-users"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Total Users</h4>
        </div>
        <div class="card-body">
          {{ $totalUsers ?? 0 }}
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-lg-2 col-md-4 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-success">
        <i class="fas fa-building"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Total Hostels</h4>
        </div>
        <div class="card-body">
          {{ $totalHostels ?? 0 }}
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-lg-2 col-md-4 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-info">
        <i class="fas fa-user-friends"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Customers</h4>
        </div>
        <div class="card-body">
          {{ $totalCustomers ?? 0 }}
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-lg-2 col-md-4 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-warning">
        <i class="fas fa-home"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Total Rooms</h4>
        </div>
        <div class="card-body">
          {{ $totalRooms ?? 0 }}
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-lg-2 col-md-4 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-danger">
        <i class="fas fa-calendar-check"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Bookings</h4>
        </div>
        <div class="card-body">
          {{ $totalBookings ?? 0 }}
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-lg-2 col-md-4 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-secondary">
        <i class="fas fa-user-plus"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Total Leads</h4>
        </div>
        <div class="card-body">
          {{ $totalLeads ?? 0 }}
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Financial Overview -->
<div class="row">
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-success">
        <i class="fas fa-money-bill-wave"></i>
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
  
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-warning">
        <i class="fas fa-clock"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Pending Payments</h4>
        </div>
        <div class="card-body">
          PKR {{ number_format($pendingPayments ?? 0, 2) }}
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
          <h4>Total Transactions</h4>
        </div>
        <div class="card-body">
          {{ $totalPayments ?? 0 }}
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-primary">
        <i class="fas fa-chart-line"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Avg. Revenue/Hostel</h4>
        </div>
        <div class="card-body">
          PKR {{ $totalHostels > 0 ? number_format(($totalRevenue ?? 0) / $totalHostels, 2) : '0.00' }}
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Quick Actions -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4><i class="fas fa-bolt"></i> Quick Actions</h4>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-2 col-sm-4 mb-3">
            <a href="{{ route('admin.leads.index') }}" class="btn btn-primary btn-block">
              <i class="fas fa-user-plus"></i> Manage Leads
            </a>
          </div>
          <div class="col-md-2 col-sm-4 mb-3">
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-success btn-block">
              <i class="fas fa-calendar-check"></i> Manage Bookings
            </a>
          </div>
          <div class="col-md-2 col-sm-4 mb-3">
            <a href="{{ route('admin.payments.index') }}" class="btn btn-warning btn-block">
              <i class="fas fa-credit-card"></i> Manage Payments
            </a>
          </div>
          <div class="col-md-2 col-sm-4 mb-3">
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-info btn-block">
              <i class="fas fa-home"></i> Manage Rooms
            </a>
          </div>
          <div class="col-md-2 col-sm-4 mb-3">
            <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary btn-block">
              <i class="fas fa-building"></i> Manage Hostels
            </a>
          </div>
          <div class="col-md-2 col-sm-4 mb-3">
            <a href="{{ route('admin.payments.report') }}" class="btn btn-dark btn-block">
              <i class="fas fa-chart-bar"></i> View Reports
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Hostel Overview -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4><i class="fas fa-building"></i> Hostel Overview</h4>
      </div>
      <div class="card-body">
        @if(isset($roomsByHostel) && $roomsByHostel->count() > 0)
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Hostel Name</th>
                  <th>Total Rooms</th>
                  <th>Available</th>
                  <th>Booked</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($roomsByHostel as $hostelId => $hostelData)
                  <tr>
                    <td>
                      <strong>{{ $hostelData['hostel_name'] }}</strong>
                    </td>
                    <td>
                      <span class="badge badge-info">{{ $hostelData['total_rooms'] }}</span>
                    </td>
                    <td>
                      <span class="badge badge-success">{{ $hostelData['available_rooms'] }}</span>
                    </td>
                    <td>
                      <span class="badge badge-warning">{{ $hostelData['booked_rooms'] }}</span>
                    </td>
                    <td>
                      <a href="{{ route('admin.rooms.index') }}?hostel={{ $hostelId }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye"></i> View Rooms
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="text-center py-3">
            <i class="fas fa-building fa-2x text-muted mb-2"></i>
            <p class="text-muted">No hostels found</p>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Top Performing Hostels -->
<div class="row">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h4><i class="fas fa-trophy"></i> Top Performing Hostels</h4>
      </div>
      <div class="card-body">
        @if(isset($topHostels) && $topHostels->count() > 0)
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Rank</th>
                  <th>Hostel Name</th>
                  <th>Revenue</th>
                  <th>Transactions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($topHostels as $index => $hostel)
                  <tr>
                    <td>
                      @if($index === 0)
                        <span class="badge badge-warning">🥇 1st</span>
                      @elseif($index === 1)
                        <span class="badge badge-secondary">🥈 2nd</span>
                      @elseif($index === 2)
                        <span class="badge badge-info">🥉 3rd</span>
                      @else
                        <span class="badge badge-light">{{ $index + 1 }}</span>
                      @endif
                    </td>
                    <td><strong>{{ $hostel['hostel_name'] }}</strong></td>
                    <td>
                      <span class="text-success font-weight-bold">
                        PKR {{ number_format($hostel['total_revenue'], 2) }}
                      </span>
                    </td>
                    <td>
                      <span class="badge badge-info">{{ $hostel['total_payments'] }}</span>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="text-center py-3">
            <i class="fas fa-trophy fa-2x text-muted mb-2"></i>
            <p class="text-muted">No revenue data available</p>
          </div>
        @endif
      </div>
    </div>
  </div>
  
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h4><i class="fas fa-calendar-check"></i> Recent Bookings</h4>
      </div>
      <div class="card-body">
        @if(isset($recentBookings) && $recentBookings->count() > 0)
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Customer</th>
                  <th>Room</th>
                  <th>Hostel</th>
                  <th>Status</th>
                  <th>Amount</th>
                </tr>
              </thead>
              <tbody>
                @foreach($recentBookings->take(5) as $booking)
                  <tr>
                    <td>
                      <div>
                        <strong>{{ $booking['customer_name'] ?? 'N/A' }}</strong>
                        <br><small class="text-muted">{{ $booking['customer_email'] ?? 'N/A' }}</small>
                      </div>
                    </td>
                    <td>{{ $booking['room_name'] ?? 'N/A' }}</td>
                    <td>
                      <span class="badge badge-info">{{ $booking['hostel_name'] ?? 'N/A' }}</span>
                    </td>
                    <td>
                      <span class="badge badge-{{ $booking['status'] === 'confirmed' ? 'success' : ($booking['status'] === 'pending' ? 'warning' : 'secondary') }}">
                        {{ ucfirst($booking['status'] ?? 'N/A') }}
                      </span>
                    </td>
                    <td>
                      <span class="text-success font-weight-bold">
                        PKR {{ number_format($booking['amount'] ?? 0, 2) }}
                      </span>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="text-center py-3">
            <i class="fas fa-calendar-times fa-2x text-muted mb-2"></i>
            <p class="text-muted">No recent bookings</p>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Recent Leads & Activities -->
<div class="row">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h4><i class="fas fa-user-plus"></i> Recent Leads</h4>
      </div>
      <div class="card-body">
        @if(isset($recentLeads) && $recentLeads->count() > 0)
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                @foreach($recentLeads->take(5) as $lead)
                  <tr>
                    <td><strong>{{ $lead->name ?? 'N/A' }}</strong></td>
                    <td>{{ $lead->email ?? 'N/A' }}</td>
                    <td>
                      <span class="badge badge-{{ $lead->status === 'converted' ? 'success' : 'warning' }}">
                        {{ ucfirst($lead->status ?? 'New') }}
                      </span>
                    </td>
                    <td>{{ $lead->created_at ? $lead->created_at->format('M d, Y') : 'N/A' }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="text-center py-3">
            <i class="fas fa-user-plus fa-2x text-muted mb-2"></i>
            <p class="text-muted">No recent leads</p>
          </div>
        @endif
      </div>
    </div>
  </div>
  
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h4><i class="fas fa-chart-line"></i> Monthly Revenue Trend</h4>
      </div>
      <div class="card-body">
        @if(isset($monthlyRevenue) && $monthlyRevenue->count() > 0)
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Month</th>
                  <th>Revenue</th>
                  <th>Trend</th>
                </tr>
              </thead>
              <tbody>
                @foreach($monthlyRevenue->take(6) as $month => $revenue)
                  <tr>
                    <td><strong>{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('M Y') }}</strong></td>
                    <td>
                      <span class="text-success font-weight-bold">
                        PKR {{ number_format($revenue, 2) }}
                      </span>
                    </td>
                    <td>
                      @if($loop->index > 0)
                        @php
                          $prevMonth = $monthlyRevenue->values()[$loop->index - 1];
                          $trend = $revenue > $prevMonth ? 'up' : ($revenue < $prevMonth ? 'down' : 'stable');
                        @endphp
                        @if($trend === 'up')
                          <span class="text-success"><i class="fas fa-arrow-up"></i> +{{ number_format((($revenue - $prevMonth) / $prevMonth) * 100, 1) }}%</span>
                        @elseif($trend === 'down')
                          <span class="text-danger"><i class="fas fa-arrow-down"></i> -{{ number_format((($prevMonth - $revenue) / $prevMonth) * 100, 1) }}%</span>
                        @else
                          <span class="text-muted"><i class="fas fa-minus"></i> Stable</span>
                        @endif
                      @else
                        <span class="text-muted">-</span>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="text-center py-3">
            <i class="fas fa-chart-line fa-2x text-muted mb-2"></i>
            <p class="text-muted">No revenue data available</p>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Recent Activities Timeline -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4><i class="fas fa-history"></i> Recent Activities</h4>
      </div>
      <div class="card-body">
        @if(isset($recentActivities) && $recentActivities->count() > 0)
          <div class="timeline">
            @foreach($recentActivities->take(10) as $activity)
              <div class="timeline-item">
                <div class="timeline-marker bg-{{ $activity['color'] }}">
                  <i class="fas fa-{{ $activity['icon'] }}"></i>
                </div>
                <div class="timeline-content">
                  <h6 class="timeline-title">{{ $activity['title'] }}</h6>
                  <p class="timeline-text">{{ $activity['description'] }}</p>
                  <small class="text-muted">{{ $activity['time']->diffForHumans() }}</small>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <div class="text-center py-3">
            <i class="fas fa-history fa-2x text-muted mb-2"></i>
            <p class="text-muted">No recent activities</p>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Quick Stats Summary -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4><i class="fas fa-chart-pie"></i> Quick Stats Summary</h4>
      </div>
      <div class="card-body">
        <div class="row text-center">
          <div class="col-md-2 col-sm-4 mb-3">
            <div class="border rounded p-3">
              <h5 class="text-primary">{{ $totalHostels ?? 0 }}</h5>
              <p class="text-muted mb-0">Active Hostels</p>
            </div>
          </div>
          <div class="col-md-2 col-sm-4 mb-3">
            <div class="border rounded p-3">
              <h5 class="text-success">{{ $totalRooms ?? 0 }}</h5>
              <p class="text-muted mb-0">Total Rooms</p>
            </div>
          </div>
          <div class="col-md-2 col-sm-4 mb-3">
            <div class="border rounded p-3">
              <h5 class="text-info">{{ $totalBookings ?? 0 }}</h5>
              <p class="text-muted mb-0">Total Bookings</p>
            </div>
          </div>
          <div class="col-md-2 col-sm-4 mb-3">
            <div class="border rounded p-3">
              <h5 class="text-warning">{{ $totalLeads ?? 0 }}</h5>
              <p class="text-muted mb-0">Total Leads</p>
            </div>
          </div>
          <div class="col-md-2 col-sm-4 mb-3">
            <div class="border rounded p-3">
              <h5 class="text-danger">{{ $totalPayments ?? 0 }}</h5>
              <p class="text-muted mb-0">Transactions</p>
            </div>
          </div>
          <div class="col-md-2 col-sm-4 mb-3">
            <div class="border rounded p-3">
              <h5 class="text-dark">PKR {{ number_format($totalRevenue ?? 0, 0) }}</h5>
              <p class="text-muted mb-0">Total Revenue</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
.timeline {
  position: relative;
  padding: 20px 0;
}

.timeline-item {
  position: relative;
  padding: 20px 0;
  border-left: 2px solid #e9ecef;
  margin-left: 20px;
}

.timeline-item:before {
  content: '';
  position: absolute;
  left: -8px;
  top: 24px;
  width: 14px;
  height: 14px;
  border-radius: 50%;
  background: #fff;
  border: 2px solid #007bff;
}

.timeline-marker {
  position: absolute;
  left: -12px;
  top: 20px;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 10px;
}

.timeline-content {
  margin-left: 30px;
  padding: 15px;
  background: #f8f9fa;
  border-radius: 5px;
  border-left: 3px solid #007bff;
}

.timeline-title {
  margin: 0 0 5px 0;
  font-weight: 600;
  color: #333;
}

.timeline-text {
  margin: 0 0 10px 0;
  color: #666;
}

.bg-success { background-color: #28a745 !important; }
.bg-info { background-color: #17a2b8 !important; }
.bg-warning { background-color: #ffc107 !important; }
.bg-danger { background-color: #dc3545 !important; }
.bg-primary { background-color: #007bff !important; }
.bg-secondary { background-color: #6c757d !important; }

.card-statistic-1 .card-body {
  font-size: 1.5rem;
  font-weight: bold;
}

.card-statistic-1 .card-header h4 {
  font-size: 0.9rem;
  margin-bottom: 0;
}

.btn-block {
  display: block;
  width: 100%;
}

.badge {
  font-size: 0.75rem;
  padding: 0.25rem 0.5rem;
}

.table th {
  font-weight: 600;
  background-color: #f8f9fa;
}

.border.rounded {
  transition: all 0.3s ease;
}

.border.rounded:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>
@endpush
