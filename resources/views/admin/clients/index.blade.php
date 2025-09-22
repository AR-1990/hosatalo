<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Manage Clients - Admin Panel</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets-admin/css/app.min.css') }}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets-admin/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets-admin/css/components.css') }}">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{ asset('assets-admin/css/style.css') }}">
  <link rel='shortcut icon' type='image/x-icon' href='{{ asset('assets-admin/img/favicon.ico') }}' />
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>      
      @include('admin.layout.header')
      @include('admin.layout.sidebar')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Client Management</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
              <div class="breadcrumb-item active">Manage Clients</div>
            </div>
          </div>

          <!-- Header Actions -->
          <div class="row mb-4">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <h5 class="mb-0"><i class="fas fa-users"></i> All Registered Clients</h5>
                      <p class="text-muted mb-0">Manage hostel owners and their properties</p>
                    </div>
                    <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">
                      <i class="fas fa-plus"></i> Add New Client
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Success Message -->
          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <i class="fas fa-check-circle"></i> {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          @endif

          <!-- Clients Table -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4><i class="fas fa-list"></i> Client List</h4>
                </div>
                <div class="card-body">
                  @if($clients->count() > 0)
                    <div class="table-responsive">
                      <table class="table table-striped table-hover">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Logo</th>
                            <th>Hostel Name</th>
                            <th>Owner</th>
                            <th>Contact</th>
                            <th>Location</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($clients as $client)
                            <tr>
                              <td>{{ $client->id }}</td>
                              <td>
                                @if($client->hostel_logo)
                                  <img src="{{ asset($client->hostel_logo) }}" alt="Logo" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                @else
                                  <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="fas fa-building text-muted"></i>
                                  </div>
                                @endif
                              </td>
                              <td>
                                <strong>{{ $client->hostel_name ?? 'N/A' }}</strong><br>
                                <small class="text-muted">{{ $client->hostel_type ?? 'N/A' }}</small>
                              </td>
                              <td>
                                <strong>{{ $client->name }}</strong><br>
                                <small class="text-muted">{{ $client->email }}</small>
                              </td>
                              <td>
                                <i class="fas fa-phone"></i> {{ $client->hostel_phone ?? 'N/A' }}<br>
                                <i class="fas fa-envelope"></i> {{ $client->hostel_email ?? 'N/A' }}
                              </td>
                              <td>
                                <i class="fas fa-map-marker-alt"></i> {{ $client->city ?? 'N/A' }}, {{ $client->state ?? 'N/A' }}
                              </td>
                              <td>
                                @if($client->hostel_type)
                                  <span class="badge badge-info">{{ ucfirst($client->hostel_type) }}</span>
                                @else
                                  <span class="badge badge-secondary">N/A</span>
                                @endif
                              </td>
                              <td>
                                @if($client->is_verified)
                                  <span class="badge badge-success">Verified</span>
                                @else
                                  <span class="badge badge-warning">Pending</span>
                                @endif
                              </td>
                              <td>
                                <div class="btn-group" role="group">
                                  <a href="{{ route('admin.clients.show', $client) }}" class="btn btn-sm btn-outline-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                  </a>
                                  <a href="{{ route('admin.clients.edit', $client) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                  </a>
                                  @if($client->is_verified)
                                    <form method="POST" action="{{ route('admin.clients.unverify', $client) }}" class="d-inline">
                                      @csrf
                                      @method('PATCH')
                                      <button type="submit" class="btn btn-sm btn-outline-warning" title="Unverify" onclick="return confirm('Are you sure you want to unverify this client?')">
                                        <i class="fas fa-times-circle"></i>
                                      </button>
                                    </form>
                                  @else
                                    <form method="POST" action="{{ route('admin.clients.verify', $client) }}" class="d-inline">
                                      @csrf
                                      @method('PATCH')
                                      <button type="submit" class="btn btn-sm btn-outline-success" title="Verify" onclick="return confirm('Are you sure you want to verify this client?')">
                                        <i class="fas fa-check-circle"></i>
                                      </button>
                                    </form>
                                  @endif
                                  <form method="POST" action="{{ route('admin.clients.destroy', $client) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this client? This action cannot be undone.')">
                                      <i class="fas fa-trash"></i>
                                    </button>
                                  </form>
                                </div>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  @else
                    <div class="text-center py-4">
                      <i class="fas fa-users fa-3x text-muted mb-3"></i>
                      <h5>No Clients Found</h5>
                      <p class="text-muted">No clients have been registered yet.</p>
                      <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">Add Your First Client</a>
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          <a href="#">Hostalo Admin Panel</a>
        </div>
        <div class="footer-right">
          Version 1.0.0
        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('assets-admin/js/app.min.js') }}"></script>
  <!-- JS Libraies -->
  <script src="{{ asset('assets-admin/bundles/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets-admin/bundles/chartjs/chart.min.js') }}"></script>
  <script src="{{ asset('assets-admin/bundles/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('assets-admin/bundles/summernote/summernote-bs4.min.js') }}"></script>
  <script src="{{ asset('assets-admin/bundles/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
  <!-- Template JS File -->
  <script src="{{ asset('assets-admin/js/scripts.js') }}"></script>
  <script src="{{ asset('assets-admin/js/custom.js') }}"></script>
</body>
</html>
