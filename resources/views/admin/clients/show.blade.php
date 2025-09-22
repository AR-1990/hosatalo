<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>View Client - Admin Panel</title>
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
            <h1>Client Details</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
              <div class="breadcrumb-item"><a href="{{ route('admin.clients.index') }}">Manage Clients</a></div>
              <div class="breadcrumb-item active">Client Details</div>
            </div>
          </div>

          <!-- Client Overview -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4><i class="fas fa-user"></i> {{ $client->name }}</h4>
                  <div class="card-header-action">
                    @if($client->is_verified)
                      <span class="badge badge-success">Verified</span>
                    @else
                      <span class="badge badge-warning">Pending Verification</span>
                    @endif
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <h5>{{ $client->hostel_name ?? 'N/A' }}</h5>
                      <p class="text-muted">{{ $client->hostel_description ?? 'No description available' }}</p>
                      
                      <div class="row">
                        <div class="col-md-6">
                          <strong>Owner:</strong> {{ $client->name }}<br>
                          <strong>Email:</strong> {{ $client->email }}<br>
                          <strong>Phone:</strong> {{ $client->phone ?? 'N/A' }}<br>
                          <strong>NIC:</strong> {{ $client->nic ?? 'N/A' }}
                        </div>
                        <div class="col-md-6">
                          <strong>Type:</strong> {{ ucfirst($client->hostel_type ?? 'N/A') }}<br>
                          <strong>Total Rooms:</strong> {{ $client->total_rooms ?? 'N/A' }}<br>
                          <strong>Check-in:</strong> {{ $client->check_in_time ? $client->check_in_time->format('H:i') : 'N/A' }}<br>
                          <strong>Check-out:</strong> {{ $client->check_out_time ? $client->check_out_time->format('H:i') : 'N/A' }}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Contact Information -->
          <div class="row">
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h4><i class="fas fa-address-book"></i> Contact Information</h4>
                </div>
                <div class="card-body">
                  <table class="table table-borderless">
                    <tr>
                      <td><strong>Personal Address:</strong></td>
                      <td>{{ $client->address ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                      <td><strong>Hostel Address:</strong></td>
                      <td>{{ $client->hostel_address ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                      <td><strong>Hostel Phone:</strong></td>
                      <td>{{ $client->hostel_phone ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                      <td><strong>Hostel Email:</strong></td>
                      <td>{{ $client->hostel_email ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                      <td><strong>Website:</strong></td>
                      <td>
                        @if($client->hostel_website)
                          <a href="{{ $client->hostel_website }}" target="_blank">{{ $client->hostel_website }}</a>
                        @else
                          N/A
                        @endif
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h4><i class="fas fa-map-marker-alt"></i> Location</h4>
                </div>
                <div class="card-body">
                  <table class="table table-borderless">
                    <tr>
                      <td><strong>City:</strong></td>
                      <td>{{ $client->city ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                      <td><strong>State:</strong></td>
                      <td>{{ $client->state ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                      <td><strong>Country:</strong></td>
                      <td>{{ $client->country ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                      <td><strong>Postal Code:</strong></td>
                      <td>{{ $client->postal_code ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                      <td><strong>Coordinates:</strong></td>
                      <td>
                        @if($client->latitude && $client->longitude)
                          {{ $client->latitude }}, {{ $client->longitude }}
                        @else
                          N/A
                        @endif
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!-- Business Information -->
          <div class="row">
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h4><i class="fas fa-briefcase"></i> Business Information</h4>
                </div>
                <div class="card-body">
                  <table class="table table-borderless">
                    <tr>
                      <td><strong>Business License:</strong></td>
                      <td>{{ $client->business_license ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                      <td><strong>Tax Number:</strong></td>
                      <td>{{ $client->tax_number ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                      <td><strong>Verification Status:</strong></td>
                      <td>
                        @if($client->is_verified)
                          <span class="badge badge-success">Verified</span>
                          @if($client->verified_at)
                            <br><small class="text-muted">Verified on {{ $client->verified_at->format('M d, Y') }}</small>
                          @endif
                        @else
                          <span class="badge badge-warning">Pending</span>
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Registered:</strong></td>
                      <td>{{ $client->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h4><i class="fas fa-info-circle"></i> Additional Information</h4>
                </div>
                <div class="card-body">
                  @if($client->special_offers)
                    <strong>Special Offers:</strong>
                    <p>{{ $client->special_offers }}</p>
                  @else
                    <p class="text-muted">No special offers available.</p>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <!-- Images -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4><i class="fas fa-images"></i> Images & Media</h4>
                </div>
                <div class="card-body">
                  <!-- Logo Section -->
                  <div class="mb-4">
                    <h6><i class="fas fa-image"></i> Hostel Logo</h6>
                    @if($client->hostel_logo)
                      <img src="{{ asset($client->hostel_logo) }}" alt="Hostel Logo" class="img-fluid rounded" style="max-width: 200px;">
                    @else
                      <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 200px; height: 200px;">
                        <i class="fas fa-building fa-3x text-muted"></i>
                        <br><small class="text-muted">No logo uploaded</small>
                      </div>
                    @endif
                  </div>

                  <!-- Banner Section -->
                  <div class="mb-4">
                    <h6><i class="fas fa-image"></i> Hostel Banner</h6>
                    @if($client->hostel_banner)
                      <img src="{{ asset($client->hostel_banner) }}" alt="Hostel Banner" class="img-fluid rounded" style="max-width: 600px;">
                    @else
                      <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 600px; height: 200px;">
                        <i class="fas fa-image fa-3x text-muted"></i>
                        <br><small class="text-muted">No banner uploaded</small>
                      </div>
                    @endif
                  </div>
                  
                  <!-- Gallery Section -->
                  <div>
                    <h6><i class="fas fa-images"></i> Gallery Images</h6>
                    @if($client->hostel_gallery && count($client->hostel_gallery) > 0)
                      <div class="row">
                        @foreach($client->hostel_gallery as $image)
                          <div class="col-md-3 mb-3">
                            <img src="{{ asset($image) }}" alt="Gallery Image" class="img-fluid rounded" style="max-width: 100%; height: 150px; object-fit: cover;">
                          </div>
                        @endforeach
                      </div>
                    @else
                      <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 100%; height: 200px;">
                        <i class="fas fa-images fa-3x text-muted"></i>
                        <br><small class="text-muted">No gallery images uploaded</small>
                      </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Actions -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between">
                    <div>
                      <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                      </a>
                      <a href="{{ route('admin.clients.edit', $client) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Client
                      </a>
                    </div>
                    <div>
                      @if($client->is_verified)
                        <form method="POST" action="{{ route('admin.clients.unverify', $client) }}" class="d-inline">
                          @csrf
                          @method('PATCH')
                          <button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure you want to unverify this client?')">
                            <i class="fas fa-times-circle"></i> Unverify
                          </button>
                        </form>
                      @else
                        <form method="POST" action="{{ route('admin.clients.verify', $client) }}" class="d-inline">
                          @csrf
                          @method('PATCH')
                          <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to verify this client?')">
                            <i class="fas fa-check-circle"></i> Verify
                          </button>
                        </form>
                      @endif
                      <form method="POST" action="{{ route('admin.clients.destroy', $client) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this client? This action cannot be undone.')">
                          <i class="fas fa-trash"></i> Delete
                        </button>
                      </form>
                    </div>
                  </div>
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
