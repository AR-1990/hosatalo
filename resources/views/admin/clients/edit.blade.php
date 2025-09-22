<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Edit Client - Admin Panel</title>
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
            <h1>Edit Client</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
              <div class="breadcrumb-item"><a href="{{ route('admin.clients.index') }}">Manage Clients</a></div>
              <div class="breadcrumb-item active">Edit Client</div>
            </div>
          </div>

          <form action="{{ route('admin.clients.update', $client) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Basic Information -->
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4><i class="fas fa-user"></i> Basic Information</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="name">Full Name <span class="text-danger">*</span></label>
                          <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                 id="name" name="name" value="{{ old('name', $client->name) }}" required>
                          @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="email">Email Address <span class="text-danger">*</span></label>
                          <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                 id="email" name="email" value="{{ old('email', $client->email) }}" required>
                          @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="phone">Phone Number <span class="text-danger">*</span></label>
                          <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                 id="phone" name="phone" value="{{ old('phone', $client->phone) }}" required>
                          @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="nic">NIC Number <span class="text-danger">*</span></label>
                          <input type="text" class="form-control @error('nic') is-invalid @enderror" 
                                 id="nic" name="nic" value="{{ old('nic', $client->nic) }}" required>
                          @error('nic')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="password">New Password (Leave blank to keep current)</label>
                          <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                 id="password" name="password">
                          <small class="form-text text-muted">Only enter if you want to change the password</small>
                          @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="password_confirmation">Confirm New Password</label>
                          <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                 id="password_confirmation" name="password_confirmation">
                          @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <label for="address">Address <span class="text-danger">*</span></label>
                          <textarea class="form-control @error('address') is-invalid @enderror" 
                                    id="address" name="address" rows="3" required>{{ old('address', $client->address) }}</textarea>
                          @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Hostel Information -->
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4><i class="fas fa-building"></i> Hostel Information</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="hostel_name">Hostel Name <span class="text-danger">*</span></label>
                          <input type="text" class="form-control @error('hostel_name') is-invalid @enderror" 
                                 id="hostel_name" name="hostel_name" value="{{ old('hostel_name', $client->hostel_name) }}" required>
                          @error('hostel_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="hostel_type">Hostel Type <span class="text-danger">*</span></label>
                          <select class="form-control @error('hostel_type') is-invalid @enderror" 
                                  id="hostel_type" name="hostel_type" required>
                            <option value="">Select Type</option>
                            <option value="budget" {{ old('hostel_type', $client->hostel_type) == 'budget' ? 'selected' : '' }}>Budget</option>
                            <option value="mid-range" {{ old('hostel_type', $client->hostel_type) == 'mid-range' ? 'selected' : '' }}>Mid-Range</option>
                            <option value="luxury" {{ old('hostel_type', $client->hostel_type) == 'luxury' ? 'selected' : '' }}>Luxury</option>
                          </select>
                          @error('hostel_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <label for="hostel_description">Hostel Description <span class="text-danger">*</span></label>
                          <textarea class="form-control @error('hostel_description') is-invalid @enderror" 
                                    id="hostel_description" name="hostel_description" rows="4" required>{{ old('hostel_description', $client->hostel_description) }}</textarea>
                          @error('hostel_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <label for="hostel_address">Hostel Address <span class="text-danger">*</span></label>
                          <textarea class="form-control @error('hostel_address') is-invalid @enderror" 
                                    id="hostel_address" name="hostel_address" rows="3" required>{{ old('hostel_address', $client->hostel_address) }}</textarea>
                          @error('hostel_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="hostel_phone">Hostel Phone <span class="text-danger">*</span></label>
                          <input type="tel" class="form-control @error('hostel_phone') is-invalid @enderror" 
                                 id="hostel_phone" name="hostel_phone" value="{{ old('hostel_phone', $client->hostel_phone) }}" required>
                          @error('hostel_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="hostel_email">Hostel Email <span class="text-danger">*</span></label>
                          <input type="email" class="form-control @error('hostel_email') is-invalid @enderror" 
                                 id="hostel_email" name="hostel_email" value="{{ old('hostel_email', $client->hostel_email) }}" required>
                          @error('hostel_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="total_rooms">Total Rooms <span class="text-danger">*</span></label>
                          <input type="number" class="form-control @error('total_rooms') is-invalid @enderror" 
                                 id="total_rooms" name="total_rooms" value="{{ old('total_rooms', $client->total_rooms) }}" min="1" required>
                          @error('total_rooms')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="business_license">Business License Number <span class="text-danger">*</span></label>
                          <input type="text" class="form-control @error('business_license') is-invalid @enderror" 
                                 id="business_license" name="business_license" value="{{ old('business_license', $client->business_license) }}" required>
                          @error('business_license')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Location Information -->
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4><i class="fas fa-map-marker-alt"></i> Location Information</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="city">City <span class="text-danger">*</span></label>
                          <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                 id="city" name="city" value="{{ old('city', $client->city) }}" required>
                          @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="state">State/Province <span class="text-danger">*</span></label>
                          <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                 id="state" name="state" value="{{ old('state', $client->state) }}" required>
                          @error('state')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="country">Country <span class="text-danger">*</span></label>
                          <input type="text" class="form-control @error('country') is-invalid @enderror" 
                                 id="country" name="country" value="{{ old('country', $client->country ?: 'Pakistan') }}" required>
                          @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="postal_code">Postal Code <span class="text-danger">*</span></label>
                          <input type="text" class="form-control @error('postal_code') is-invalid @enderror" 
                                 id="postal_code" name="postal_code" value="{{ old('postal_code', $client->postal_code) }}" required>
                          @error('postal_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="latitude">Latitude</label>
                          <input type="text" class="form-control @error('latitude') is-invalid @enderror" 
                                 id="latitude" name="latitude" value="{{ old('latitude', $client->latitude) }}" placeholder="e.g., 33.6844">
                          @error('latitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="longitude">Longitude</label>
                          <input type="text" class="form-control @error('longitude') is-invalid @enderror" 
                                 id="longitude" name="longitude" value="{{ old('longitude', $client->longitude) }}" placeholder="e.g., 73.0479">
                          @error('longitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Images Upload -->
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4><i class="fas fa-images"></i> Images & Media</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="hostel_logo">Hostel Logo <span class="text-muted">(Max: 2MB)</span></label>
                          @if($client->hostel_logo)
                            <div class="mb-2">
                              <img src="{{ asset($client->hostel_logo) }}" alt="Current Logo" class="img-thumbnail" style="max-width: 100px;">
                              <small class="text-muted d-block">Current logo</small>
                            </div>
                          @endif
                          <input type="file" class="form-control @error('hostel_logo') is-invalid @enderror" 
                                 id="hostel_logo" name="hostel_logo" accept="image/*">
                          <small class="form-text text-muted">Recommended size: 200x200px, Max file size: 2MB, Formats: JPG, PNG, GIF. Leave blank to keep current.</small>
                          @error('hostel_logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="hostel_banner">Hostel Banner <span class="text-muted">(Max: 2MB)</span></label>
                          @if($client->hostel_banner)
                            <div class="mb-2">
                              <img src="{{ asset($client->hostel_banner) }}" alt="Current Banner" class="img-thumbnail" style="max-width: 200px;">
                              <small class="text-muted d-block">Current banner</small>
                            </div>
                          @endif
                          <input type="file" class="form-control @error('hostel_banner') is-invalid @enderror" 
                                 id="hostel_banner" name="hostel_banner" accept="image/*">
                          <small class="form-text text-muted">Recommended size: 1200x400px, Max file size: 2MB, Formats: JPG, PNG, GIF. Leave blank to keep current.</small>
                          @error('hostel_banner')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <label for="hostel_gallery">Hostel Gallery Images <span class="text-muted">(Max: 2MB each)</span></label>
                          @if($client->hostel_gallery && count($client->hostel_gallery) > 0)
                            <div class="mb-2">
                              <div class="row">
                                @foreach($client->hostel_gallery as $image)
                                  <div class="col-md-2 mb-2">
                                    <img src="{{ asset($image) }}" alt="Gallery Image" class="img-thumbnail" style="max-width: 100px;">
                                  </div>
                                @endforeach
                              </div>
                              <small class="text-muted d-block">Current gallery images</small>
                            </div>
                          @endif
                          <input type="file" class="form-control @error('hostel_gallery') is-invalid @enderror" 
                                 id="hostel_gallery" name="hostel_gallery[]" accept="image/*" multiple>
                          <small class="form-text text-muted">You can select multiple images. Max: 10 images, Max file size: 2MB each, Formats: JPG, PNG, GIF. Leave blank to keep current.</small>
                          @error('hostel_gallery')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Additional Information -->
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4><i class="fas fa-info-circle"></i> Additional Information</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="hostel_website">Website URL</label>
                          <input type="url" class="form-control @error('hostel_website') is-invalid @enderror" 
                                 id="hostel_website" name="hostel_website" value="{{ old('hostel_website', $client->hostel_website) }}" placeholder="https://example.com">
                          @error('hostel_website')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="tax_number">Tax Number <span class="text-danger">*</span></label>
                          <input type="text" class="form-control @error('tax_number') is-invalid @enderror" 
                                 id="tax_number" name="tax_number" value="{{ old('tax_number', $client->tax_number) }}" required>
                          @error('tax_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="check_in_time">Check-in Time <span class="text-danger">*</span></label>
                          <input type="time" class="form-control @error('check_in_time') is-invalid @enderror" 
                                 id="check_in_time" name="check_in_time" value="{{ old('check_in_time', $client->check_in_time ? $client->check_in_time->format('H:i') : '14:00') }}" required>
                          @error('check_in_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="check_out_time">Check-out Time <span class="text-danger">*</span></label>
                          <input type="time" class="form-control @error('check_out_time') is-invalid @enderror" 
                                 id="check_out_time" name="check_out_time" value="{{ old('check_out_time', $client->check_out_time ? $client->check_out_time->format('H:i') : '11:00') }}" required>
                          @error('check_out_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <label for="special_offers">Special Offers</label>
                          <textarea class="form-control @error('special_offers') is-invalid @enderror" 
                                    id="special_offers" name="special_offers" rows="3" 
                                    placeholder="Any special offers, discounts, or promotions...">{{ old('special_offers', $client->special_offers) }}</textarea>
                          @error('special_offers')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Form Actions -->
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Update Client
                      </button>
                      <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary btn-lg ml-2">
                        <i class="fas fa-arrow-left"></i> Back to List
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
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
  
  <!-- File Upload Validation Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Logo validation
      const logoInput = document.getElementById('hostel_logo');
      if (logoInput) {
        logoInput.addEventListener('change', function() {
          validateFile(this, 2, 'Logo');
        });
      }
      
      // Banner validation
      const bannerInput = document.getElementById('hostel_banner');
      if (bannerInput) {
        bannerInput.addEventListener('change', function() {
          validateFile(this, 2, 'Banner');
        });
      }
      
      // Gallery validation
      const galleryInput = document.getElementById('hostel_gallery');
      if (galleryInput) {
        galleryInput.addEventListener('change', function() {
          validateMultipleFiles(this, 2, 'Gallery');
        });
      }
      
      function validateFile(input, maxSizeMB, fieldName) {
        const file = input.files[0];
        if (file) {
          const fileSizeMB = file.size / (1024 * 1024);
          if (fileSizeMB > maxSizeMB) {
            alert(`${fieldName} file size (${fileSizeMB.toFixed(2)}MB) exceeds maximum allowed size (${maxSizeMB}MB)`);
            input.value = '';
            return false;
          }
          
          // Check file type
          const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
          if (!allowedTypes.includes(file.type)) {
            alert(`${fieldName} file type not allowed. Please use JPG, PNG, or GIF format.`);
            input.value = '';
            return false;
          }
        }
        return true;
      }
      
      function validateMultipleFiles(input, maxSizeMB, fieldName) {
        const files = input.files;
        if (files.length > 10) {
          alert(`${fieldName}: Maximum 10 images allowed. You selected ${files.length} images.`);
          input.value = '';
          return false;
        }
        
        for (let i = 0; i < files.length; i++) {
          if (!validateFile(input, maxSizeMB, `${fieldName} Image ${i + 1}`)) {
            return false;
          }
        }
        return true;
      }
    });
  </script>
</body>
</html>
