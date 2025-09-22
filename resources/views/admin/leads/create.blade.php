@extends('admin.layout.app')

@section('title', 'Add New Lead - Hostalo Admin Panel')

@section('content')
<div class="section-header">
  <h1>Add New Lead</h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
    <div class="breadcrumb-item"><a href="{{ route('admin.leads.index') }}">Leads</a></div>
    <div class="breadcrumb-item active">Add New Lead</div>
  </div>
</div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible show fade">
    <div class="alert-body">
      <button class="close" data-dismiss="alert">
        <span>&times;</span>
      </button>
      {{ session('success') }}
    </div>
  </div>
@endif

@if($errors->any())
  <div class="alert alert-danger alert-dismissible show fade">
    <div class="alert-body">
      <button class="close" data-dismiss="alert">
        <span>&times;</span>
      </button>
      <ul class="mb-0">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  </div>
@endif

<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <h4><i class="fas fa-user-plus"></i> Lead Information</h4>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.leads.store') }}" id="leadForm">
          @csrf
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Full Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Email Address <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Phone Number <span class="text-danger">*</span></label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Source</label>
                <select name="source" class="form-control">
                  <option value="admin_created" {{ old('source') == 'admin_created' ? 'selected' : '' }}>Admin Created</option>
                  <option value="phone_call" {{ old('source') == 'phone_call' ? 'selected' : '' }}>Phone Call</option>
                  <option value="email" {{ old('source') == 'email' ? 'selected' : '' }}>Email</option>
                  <option value="website" {{ old('source') == 'website' ? 'selected' : '' }}>Website</option>
                  <option value="walk_in" {{ old('source') == 'walk_in' ? 'selected' : '' }}>Walk-in</option>
                  <option value="referral" {{ old('source') == 'referral' ? 'selected' : '' }}>Referral</option>
                  <option value="social_media" {{ old('source') == 'social_media' ? 'selected' : '' }}>Social Media</option>
                  <option value="other" {{ old('source') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label>Subject</label>
            <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" placeholder="e.g., Room Inquiry, Booking Request">
          </div>
          
          <div class="form-group">
            <label>Message/Notes</label>
            <textarea name="message" class="form-control" rows="4" placeholder="Lead details, requirements, or any notes">{{ old('message') }}</textarea>
          </div>
          
          <hr>
          
          <h5 class="mb-3"><i class="fas fa-bed"></i> Booking Details (Optional)</h5>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Room Type</label>
                <select name="room_type" class="form-control">
                  <option value="">Select Room Type</option>
                  <option value="standard" {{ old('room_type') == 'standard' ? 'selected' : '' }}>Standard Room</option>
                  <option value="deluxe" {{ old('room_type') == 'deluxe' ? 'selected' : '' }}>Deluxe Room</option>
                  <option value="suite" {{ old('room_type') == 'suite' ? 'selected' : '' }}>Suite</option>
                  <option value="family" {{ old('room_type') == 'family' ? 'selected' : '' }}>Family Room</option>
                  <option value="dormitory" {{ old('room_type') == 'dormitory' ? 'selected' : '' }}>Dormitory</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Booking Type</label>
                <select name="booking_type" class="form-control">
                  <option value="">Select Booking Type</option>
                  <option value="daily" {{ old('booking_type') == 'daily' ? 'selected' : '' }}>Daily</option>
                  <option value="monthly" {{ old('booking_type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                  <option value="yearly" {{ old('booking_type') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                </select>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Preferred Check-in Date</label>
                <input type="date" name="check_in_date" class="form-control" value="{{ old('check_in_date') }}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Preferred Check-out Date</label>
                <input type="date" name="check_out_date" class="form-control" value="{{ old('check_out_date') }}">
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> Create Lead
            </button>
            <a href="{{ route('admin.leads.index') }}" class="btn btn-secondary">
              <i class="fas fa-arrow-left"></i> Back to Leads
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">
        <h4><i class="fas fa-info-circle"></i> Lead Guidelines</h4>
      </div>
      <div class="card-body">
        <div class="alert alert-info">
          <h6><i class="fas fa-lightbulb"></i> Tips for Creating Leads</h6>
          <ul class="mb-0">
            <li>Ensure all contact information is accurate</li>
            <li>Add detailed notes about customer requirements</li>
            <li>Select appropriate source for tracking</li>
            <li>Fill booking details if customer has specific needs</li>
            <li>Follow up with the lead promptly</li>
          </ul>
        </div>
        
        <div class="alert alert-warning">
          <h6><i class="fas fa-exclamation-triangle"></i> Important</h6>
          <p class="mb-0">After creating the lead, you can:</p>
          <ul class="mb-0">
            <li>Add notes and track communication</li>
            <li>Convert to booking when ready</li>
            <li>Update status based on interactions</li>
          </ul>
        </div>
      </div>
    </div>
    
    <div class="card">
      <div class="card-header">
        <h4><i class="fas fa-chart-line"></i> Lead Statistics</h4>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-6">
            <div class="text-center">
              <h5 class="text-primary">{{ \App\Models\Contact::count() }}</h5>
              <p class="text-muted">Total Leads</p>
            </div>
          </div>
          <div class="col-6">
            <div class="text-center">
              <h5 class="text-success">{{ \App\Models\Contact::where('status', 'converted')->count() }}</h5>
              <p class="text-muted">Converted</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Auto-calculate check-out date if check-in is selected and booking type is set
  const checkInInput = document.querySelector('input[name="check_in_date"]');
  const checkOutInput = document.querySelector('input[name="check_out_date"]');
  const bookingTypeSelect = document.querySelector('select[name="booking_type"]');
  
  function calculateCheckOut() {
    if (checkInInput.value && bookingTypeSelect.value) {
      const checkInDate = new Date(checkInInput.value);
      let checkOutDate = new Date(checkInDate);
      
      switch (bookingTypeSelect.value) {
        case 'daily':
          checkOutDate.setDate(checkOutDate.getDate() + 1);
          break;
        case 'monthly':
          checkOutDate.setMonth(checkOutDate.getMonth() + 1);
          break;
        case 'yearly':
          checkOutDate.setFullYear(checkOutDate.getFullYear() + 1);
          break;
      }
      
      checkOutInput.value = checkOutDate.toISOString().split('T')[0];
    }
  }
  
  checkInInput.addEventListener('change', calculateCheckOut);
  bookingTypeSelect.addEventListener('change', calculateCheckOut);
  
  // Form validation
  document.getElementById('leadForm').addEventListener('submit', function(e) {
    const checkIn = new Date(checkInInput.value);
    const checkOut = new Date(checkOutInput.value);
    
    if (checkInInput.value && checkOutInput.value && checkOut <= checkIn) {
      e.preventDefault();
      alert('Check-out date must be after check-in date.');
      return false;
    }
  });
});
</script>
@endpush
