@extends('admin.layout.app')

@section('title', 'Add New Booking - Hostalo Admin Panel')

@section('content')
<div class="section-header">
  <h1>Add New Booking</h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
    <div class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">Bookings</a></div>
    <div class="breadcrumb-item active">Add New Booking</div>
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
        <h4><i class="fas fa-plus"></i> Direct Booking Form</h4>
        <p class="text-muted mb-0">Create a new booking for walk-in customers</p>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.bookings.store') }}" id="createBookingForm" enctype="multipart/form-data">
          @csrf
          
          <!-- Customer Information -->
          <div class="form-section mb-4">
            <h5 class="text-primary mb-3">
              <i class="fas fa-user"></i> Customer Information
            </h5>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="fw-bold">Customer Name <span class="text-danger">*</span></label>
                  <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="fw-bold">Email <span class="text-danger">*</span></label>
                  <input type="email" name="customer_email" class="form-control" value="{{ old('customer_email') }}" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="fw-bold">Phone <span class="text-danger">*</span></label>
                  <input type="text" name="customer_phone" class="form-control" value="{{ old('customer_phone') }}" required>
                </div>
              </div>
            </div>
            
            <!-- NIC Information -->
            <div class="row mt-3">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="fw-bold">NIC Number <span class="text-danger">*</span></label>
                  <input type="text" name="nic_number" class="form-control" id="nicNumber" 
                         value="{{ old('nic_number') }}" 
                         placeholder="e.g., 35202-1234567-1" 
                         pattern="[0-9]{5}-[0-9]{7}-[0-9]{1}"
                         maxlength="15"
                         required>
                  <small class="text-muted">Pakistani NIC Format: XXXXX-XXXXXXX-X (5 digits, 7 digits, 1 digit)</small>
                  <div class="invalid-feedback" id="nicError">
                    Please enter a valid Pakistani NIC number in format: XXXXX-XXXXXXX-X
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="fw-bold">NIC Image Upload <span class="text-danger">*</span></label>
                  <div class="custom-file">
                    <input type="file" name="nic_image" class="custom-file-input" id="nicImage" 
                           accept="image/*" required>
                    <label class="custom-file-label" for="nicImage">Choose NIC image...</label>
                  </div>
                  <small class="text-muted">Upload clear image of NIC (front/back)</small>
                </div>
              </div>
            </div>
            
            <!-- NIC Preview -->
            <div id="nicImagePreview" class="mt-3" style="display: none;">
              <div class="alert alert-info">
                <h6 class="mb-2"><i class="fas fa-image"></i> NIC Image Preview</h6>
                <div class="row">
                  <div class="col-md-6">
                    <img id="previewImage" src="" alt="NIC Preview" class="img-fluid rounded" style="max-height: 200px;">
                  </div>
                  <div class="col-md-6">
                    <div class="nic-preview-info">
                      <p><strong>File Name:</strong> <span id="fileName">-</span></p>
                      <p><strong>File Size:</strong> <span id="fileSize">-</span></p>
                      <p><strong>Image Type:</strong> <span id="imageType">-</span></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Room Selection -->
          <div class="form-section mb-4">
            <h5 class="text-primary mb-3">
              <i class="fas fa-bed"></i> Room Selection
            </h5>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="fw-bold">Room Type Filter</label>
                  <select class="form-control" id="roomTypeFilter">
                    <option value="">All Room Types</option>
                    @foreach($roomTypes as $type)
                      <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="fw-bold">Select Room <span class="text-danger">*</span></label>
                  <select name="room_id" class="form-control" id="roomSelect" required>
                    <option value="">Choose a room...</option>
                    @foreach($rooms as $room)
                      <option value="{{ $room->id }}" 
                              data-price="{{ $room->price_per_night }}" 
                              data-type="{{ $room->room_type }}"
                              data-capacity="{{ $room->capacity }}"
                              data-weekly-price="{{ $room->weekly_price ?? ($room->price_per_night * 7 * 0.9) }}"
                              data-monthly-price="{{ $room->monthly_price ?? ($room->price_per_night * 30 * 0.8) }}">
                        {{ $room->name }} - {{ ucfirst($room->room_type) }} (PKR {{ number_format($room->price_per_night, 2) }}/night)
                      </option>
                    @endforeach
                  </select>
                  <small class="text-muted">Only available rooms are shown</small>
                </div>
              </div>
            </div>
            
            <!-- Room Details Display -->
            <div id="roomDetails" class="mt-3" style="display: none;">
              <div class="alert alert-info">
                <h6 class="mb-2">Selected Room Details</h6>
                <div class="row">
                  <div class="col-md-3">
                    <strong>Room:</strong> <span id="selectedRoomName">-</span>
                  </div>
                  <div class="col-md-3">
                    <strong>Type:</strong> <span id="selectedRoomType">-</span>
                  </div>
                  <div class="col-md-3">
                    <strong>Capacity:</strong> <span id="selectedRoomCapacity">-</span>
                  </div>
                  <div class="col-md-3">
                    <strong>Price/Night:</strong> <span id="selectedRoomPrice">-</span>
                  </div>
                </div>
                <hr class="my-2">
                <div class="row">
                  <div class="col-md-4">
                    <strong>Weekly Rate:</strong> <span id="selectedRoomWeeklyPrice">-</span>
                  </div>
                  <div class="col-md-4">
                    <strong>Monthly Rate:</strong> <span id="selectedRoomMonthlyPrice">-</span>
                  </div>
                  <div class="col-md-4">
                    <strong>Discount:</strong> <span id="selectedRoomDiscount">-</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Booking Type and Dates -->
          <div class="form-section mb-4">
            <h5 class="text-primary mb-3">
              <i class="fas fa-calendar"></i> Booking Type & Dates
            </h5>
            
            <!-- Booking Type Selection -->
            <div class="row mb-3">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="fw-bold">Booking Type <span class="text-danger">*</span></label>
                  <select name="booking_type" class="form-control" id="bookingType" required>
                    <option value="per_night">Per Night</option>
                    <option value="weekly">Weekly (7 nights)</option>
                    <option value="monthly">Monthly (30 nights)</option>
                  </select>
                  <small class="text-muted">Select how you want to charge for this booking</small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="fw-bold">Rate Type</label>
                  <input type="text" id="rateType" class="form-control" readonly>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="fw-bold">Check-in Date <span class="text-danger">*</span></label>
                  <input type="date" name="check_in_date" class="form-control" value="{{ old('check_in_date', date('Y-m-d')) }}" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="fw-bold">Check-out Date <span class="text-danger">*</span></label>
                  <input type="date" name="check_out_date" class="form-control" value="{{ old('check_out_date', date('Y-m-d', strtotime('+1 day'))) }}" required>
                </div>
              </div>
            </div>
            
            <!-- Duration and Total Calculation -->
            <div class="row mt-3">
              <div class="col-md-3">
                <div class="form-group">
                  <label class="fw-bold">Duration</label>
                  <input type="text" id="duration" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="fw-bold">Base Rate</label>
                  <input type="text" id="baseRate" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="fw-bold">Discount Applied</label>
                  <input type="text" id="discountApplied" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="fw-bold">Total Amount <span class="text-danger">*</span></label>
                  <input type="number" name="total_amount" id="totalAmount" class="form-control" step="0.01" min="0.01" required>
                </div>
              </div>
            </div>
            
            <!-- Pricing Breakdown -->
            <div id="pricingBreakdown" class="mt-3" style="display: none;">
              <div class="alert alert-success">
                <h6 class="mb-2">Pricing Breakdown</h6>
                <div class="row">
                  <div class="col-md-4">
                    <strong>Base Rate:</strong> <span id="breakdownBaseRate">-</span>
                  </div>
                  <div class="col-md-4">
                    <strong>Discount:</strong> <span id="breakdownDiscount">-</span>
                  </div>
                  <div class="col-md-4">
                    <strong>Final Amount:</strong> <span id="breakdownFinalAmount">-</span>
                  </div>
                </div>
                <div class="row mt-2">
                  <div class="col-md-6">
                    <strong>Per Night Cost:</strong> <span id="breakdownPerNightCost">-</span>
                  </div>
                  <div class="col-md-6">
                    <strong>Savings:</strong> <span id="breakdownSavings">-</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Payment Information -->
          <div class="form-section mb-4">
            <h5 class="text-primary mb-3">
              <i class="fas fa-credit-card"></i> Payment Information
            </h5>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="fw-bold">Payment Status <span class="text-danger">*</span></label>
                  <select name="payment_status" class="form-control" id="paymentStatus" required>
                    <option value="pending">Pending</option>
                    <option value="advance">Advance Payment</option>
                    <option value="partial">Partial Payment</option>
                    <option value="full">Full Payment</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="fw-bold">Advance Amount</label>
                  <input type="number" name="advance_amount" class="form-control" id="advanceAmount" step="0.01" min="0" placeholder="0.00">
                  <small class="text-muted">Leave empty if no advance payment</small>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Additional Information -->
          <div class="form-section mb-4">
            <h5 class="text-primary mb-3">
              <i class="fas fa-sticky-note"></i> Additional Information
            </h5>
            <div class="form-group">
              <label class="fw-bold">Admin Notes</label>
              <textarea name="admin_notes" class="form-control" rows="3" placeholder="Any special requests, customer preferences, or additional notes...">{{ old('admin_notes') }}</textarea>
            </div>
          </div>
          
          <!-- Submit Buttons -->
          <div class="form-actions">
            <button type="submit" class="btn btn-success btn-lg">
              <i class="fas fa-check"></i> Create Booking
            </button>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary btn-lg ml-2">
              <i class="fas fa-times"></i> Cancel
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <div class="col-lg-4">
    <!-- Quick Actions -->
    <div class="card">
      <div class="card-header">
        <h4><i class="fas fa-bolt"></i> Quick Actions</h4>
      </div>
      <div class="card-body">
        <div class="d-grid gap-2">
          <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-bed"></i> View All Rooms
          </a>
          <a href="{{ route('admin.leads.index') }}" class="btn btn-outline-info">
            <i class="fas fa-users"></i> Manage Leads
          </a>
          <a href="{{ route('admin.bookings.report') }}" class="btn btn-outline-success">
            <i class="fas fa-chart-bar"></i> View Reports
          </a>
        </div>
      </div>
    </div>
    
    <!-- Booking Summary -->
    <div class="card">
      <div class="card-header">
        <h4><i class="fas fa-info-circle"></i> Booking Summary</h4>
      </div>
      <div class="card-body">
        <div id="bookingSummary">
          <p class="text-muted text-center">Select a room and dates to see booking summary</p>
        </div>
      </div>
    </div>
    
    <!-- Help Information -->
    <div class="card">
      <div class="card-header">
        <h4><i class="fas fa-question-circle"></i> Help</h4>
      </div>
      <div class="card-body">
        <div class="alert alert-info">
          <h6>Direct Booking Process:</h6>
          <ol class="mb-0">
            <li>Enter customer details</li>
            <li>Select available room</li>
            <li>Choose check-in/out dates</li>
            <li>Set payment status</li>
            <li>Add any special notes</li>
            <li>Create booking</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
.form-section {
  border: 1px solid #e9ecef;
  border-radius: 8px;
  padding: 20px;
  background: #f8f9fa;
}

.form-section h5 {
  color: #495057;
  font-weight: 600;
}

.form-actions {
  padding: 20px;
  background: #ffffff;
  border: 1px solid #e9ecef;
  border-radius: 8px;
  text-align: center;
}

.btn-lg {
  padding: 12px 24px;
  font-size: 1.1em;
}

#roomDetails .alert {
  margin-bottom: 0;
}

#roomDetails .row {
  margin: 0;
}

#roomDetails .col-md-3 {
  padding: 8px;
}

#bookingSummary {
  min-height: 100px;
}

/* NIC Image Preview Styling */
#nicImagePreview {
  border: 2px solid #e9ecef;
  border-radius: 8px;
}

#nicImagePreview .alert {
  margin-bottom: 0;
}

#previewImage {
  border: 2px solid #dee2e6;
  border-radius: 6px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.nic-preview-info p {
  margin-bottom: 8px;
  font-size: 0.9em;
}

.nic-preview-info strong {
  color: #495057;
}

/* Custom File Input Styling */
.custom-file {
  position: relative;
  display: inline-block;
  width: 100%;
  height: calc(1.5em + 0.75rem + 2px);
  margin-bottom: 0;
}

.custom-file-input {
  position: relative;
  z-index: 2;
  width: 100%;
  height: calc(1.5em + 0.75rem + 2px);
  margin: 0;
  opacity: 0;
}

.custom-file-label {
  position: absolute;
  top: 0;
  right: 0;
  left: 0;
  z-index: 1;
  height: calc(1.5em + 0.75rem + 2px);
  padding: 0.375rem 0.75rem;
  font-weight: 400;
  line-height: 1.5;
  color: #495057;
  background-color: #fff;
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
  cursor: pointer;
}

.custom-file-input:focus ~ .custom-file-label {
  border-color: #80bdff;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.custom-file-input:lang(en) ~ .custom-file-label::after {
  content: "Browse";
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  z-index: 3;
  display: block;
  height: calc(1.5em + 0.75rem);
  padding: 0.375rem 0.75rem;
  line-height: 1.5;
  color: #495057;
  background-color: #e9ecef;
  border-left: inherit;
  border-radius: 0 0.25rem 0.25rem 0;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
  // Room type filter
  $('#roomTypeFilter').on('change', function() {
    const selectedType = $(this).val();
    $('#roomSelect option').each(function() {
      if (!selectedType || $(this).data('type') === selectedType) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
    
    // Reset room selection if filtered out
    if (selectedType && $('#roomSelect option:selected').data('type') !== selectedType) {
      $('#roomSelect').val('');
      $('#roomDetails').hide();
    }
  });
  
  // Room selection change
  $('#roomSelect').on('change', function() {
    const selectedOption = $(this).find('option:selected');
    if (selectedOption.val()) {
      const room = {
        name: selectedOption.text().split(' - ')[0],
        type: selectedOption.data('type'),
        capacity: selectedOption.data('capacity'),
        price: selectedOption.data('price'),
        weeklyPrice: selectedOption.data('weekly-price'),
        monthlyPrice: selectedOption.data('monthly-price')
      };
      
      // Update room details display
      $('#selectedRoomName').text(room.name);
      $('#selectedRoomType').text(room.type);
      $('#selectedRoomCapacity').text(room.capacity + ' person(s)');
      $('#selectedRoomPrice').text('PKR ' + parseFloat(room.price).toFixed(2));
      $('#selectedRoomWeeklyPrice').text('PKR ' + parseFloat(room.weeklyPrice).toFixed(2));
      $('#selectedRoomMonthlyPrice').text('PKR ' + parseFloat(room.monthlyPrice).toFixed(2));
      
      // Calculate and show discount
      const weeklyDiscount = ((room.price * 7) - room.weeklyPrice) / (room.price * 7) * 100;
      const monthlyDiscount = ((room.price * 30) - room.monthlyPrice) / (room.price * 30) * 100;
      $('#selectedRoomDiscount').text(`Weekly: ${weeklyDiscount.toFixed(1)}%, Monthly: ${monthlyDiscount.toFixed(1)}%`);
      
      $('#roomDetails').show();
      
      // Calculate total amount based on current booking type
      calculateTotalAmount();
      
      // Update booking summary
      updateBookingSummary();
    } else {
      $('#roomDetails').hide();
      $('#pricingBreakdown').hide();
      $('#baseRate').val('');
      $('#discountApplied').val('');
      $('#totalAmount').val('');
      $('#bookingSummary').html('<p class="text-muted text-center">Select a room and dates to see booking summary</p>');
    }
  });
  
  // Booking type change handler
  $('#bookingType').on('change', function() {
    calculateTotalAmount();
    updateBookingSummary();
  });
  
  // Date change handlers
  $('input[name="check_in_date"], input[name="check_out_date"]').on('change', function() {
    calculateTotalAmount();
    updateBookingSummary();
  });
  
  // Payment status change
  $('#paymentStatus').on('change', function() {
    const status = $(this).val();
    if (status === 'advance' || status === 'partial') {
      $('#advanceAmount').prop('required', true);
    } else {
      $('#advanceAmount').prop('required', false);
    }
  });

  // NIC image preview
  $('#nicImage').on('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      $('#fileName').text(file.name);
      $('#fileSize').text(Math.round(file.size / 1024) + ' KB');
      $('#imageType').text(file.type.split('/')[1]);
      $('#nicImagePreview').show();
      $('#previewImage').attr('src', URL.createObjectURL(file));
    } else {
      $('#nicImagePreview').hide();
      $('#previewImage').attr('src', '');
      $('#fileName').text('-');
      $('#fileSize').text('-');
      $('#imageType').text('-');
    }
  });
  
  // NIC number validation
  $('#nicNumber').on('input', function() {
    const nic = $(this).val();
    const nicPattern = /^[0-9]{5}-[0-9]{7}-[0-9]{1}$/;
    const nicError = $('#nicError');
    
    // Auto-format NIC number as user types
    let formattedNic = nic.replace(/[^0-9]/g, ''); // Remove all non-digits
    
    if (formattedNic.length > 0) {
      if (formattedNic.length <= 5) {
        formattedNic = formattedNic;
      } else if (formattedNic.length <= 12) {
        formattedNic = formattedNic.substring(0, 5) + '-' + formattedNic.substring(5);
      } else if (formattedNic.length <= 13) {
        formattedNic = formattedNic.substring(0, 5) + '-' + formattedNic.substring(5, 12) + '-' + formattedNic.substring(12);
      }
    }
    
    // Update input value with formatting
    if (formattedNic !== nic) {
      $(this).val(formattedNic);
    }

    if (formattedNic.length > 0) {
      if (!nicPattern.test(formattedNic)) {
        if (formattedNic.length < 13) {
          nicError.text('Please complete the NIC number: ' + formattedNic.length + '/13 characters').show();
          nicError.removeClass('d-none text-success').addClass('text-danger');
        } else {
          nicError.text('Please enter a valid Pakistani NIC number in format: XXXXX-XXXXXXX-X').show();
          nicError.removeClass('d-none text-success').addClass('text-danger');
        }
        $(this).removeClass('is-valid').addClass('is-invalid');
      } else {
        nicError.text('✅ Valid Pakistani NIC number').show();
        nicError.removeClass('d-none text-danger').addClass('text-success');
        $(this).removeClass('is-invalid').addClass('is-valid');
      }
    } else {
      nicError.addClass('d-none');
      $(this).removeClass('is-invalid is-valid');
    }
  });
  
  // Prevent non-numeric input except backspace and delete
  $('#nicNumber').on('keydown', function(e) {
    const key = e.key;
    const allowedKeys = ['Backspace', 'Delete', 'Tab', 'Enter', 'ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown'];
    
    if (!allowedKeys.includes(key) && !/^[0-9]$/.test(key)) {
      e.preventDefault();
    }
  });

  // Calculate total amount based on booking type
  function calculateTotalAmount() {
    const checkIn = $('input[name="check_in_date"]').val();
    const checkOut = $('input[name="check_out_date"]').val();
    const bookingType = $('#bookingType').val();
    const selectedOption = $('#roomSelect option:selected');
    
    if (!checkIn || !checkOut || !selectedOption.val()) return;
    
    const startDate = new Date(checkIn);
    const endDate = new Date(checkOut);
    const nights = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
    
    if (nights <= 0) return;
    
    const room = {
      price: parseFloat(selectedOption.data('price')),
      weeklyPrice: parseFloat(selectedOption.data('weekly-price')),
      monthlyPrice: parseFloat(selectedOption.data('monthly-price'))
    };
    
    let baseRate, totalAmount, discount, rateType;
    
    switch(bookingType) {
      case 'per_night':
        baseRate = room.price * nights;
        totalAmount = baseRate;
        discount = 0;
        rateType = `Per Night (PKR ${room.price.toFixed(2)}/night)`;
        break;
        
      case 'weekly':
        const weeks = Math.ceil(nights / 7);
        baseRate = room.price * nights;
        totalAmount = room.weeklyPrice * weeks;
        discount = baseRate - totalAmount;
        rateType = `Weekly Rate (PKR ${room.weeklyPrice.toFixed(2)}/week)`;
        break;
        
      case 'monthly':
        const months = Math.ceil(nights / 30);
        baseRate = room.price * nights;
        totalAmount = room.monthlyPrice * months;
        discount = baseRate - totalAmount;
        rateType = `Monthly Rate (PKR ${room.monthlyPrice.toFixed(2)}/month)`;
        break;
        
      default:
        baseRate = room.price * nights;
        totalAmount = baseRate;
        discount = 0;
        rateType = `Per Night (PKR ${room.price.toFixed(2)}/night)`;
    }
    
    // Update form fields
    $('#duration').val(nights + ' night(s)');
    $('#baseRate').val('PKR ' + baseRate.toFixed(2));
    $('#discountApplied').val('PKR ' + discount.toFixed(2));
    $('#totalAmount').val(totalAmount.toFixed(2));
    $('#rateType').val(rateType);
    
    // Show pricing breakdown
    if (discount > 0) {
      $('#pricingBreakdown').show();
      
      const perNightCost = totalAmount / nights;
      const savings = discount;
      
      $('#breakdownBaseRate').text('PKR ' + baseRate.toFixed(2));
      $('#breakdownDiscount').text('PKR ' + discount.toFixed(2));
      $('#breakdownFinalAmount').text('PKR ' + totalAmount.toFixed(2));
      $('#breakdownPerNightCost').text('PKR ' + perNightCost.toFixed(2));
      $('#breakdownSavings').text('PKR ' + savings.toFixed(2));
    } else {
      $('#pricingBreakdown').hide();
    }
  }
  
  // Update booking summary
  function updateBookingSummary() {
    const roomName = $('#selectedRoomName').text();
    const checkIn = $('input[name="check_in_date"]').val();
    const checkOut = $('input[name="check_out_date"]').val();
    const totalAmount = $('#totalAmount').val();
    
    if (roomName && roomName !== '-' && checkIn && checkOut && totalAmount) {
      const summary = `
        <div class="alert alert-success">
          <h6 class="mb-2">Booking Summary</h6>
          <p><strong>Room:</strong> ${roomName}</p>
          <p><strong>Check-in:</strong> ${new Date(checkIn).toLocaleDateString()}</p>
          <p><strong>Check-out:</strong> ${new Date(checkOut).toLocaleDateString()}</p>
          <p><strong>Total Amount:</strong> PKR ${parseFloat(totalAmount).toFixed(2)}</p>
        </div>
      `;
      $('#bookingSummary').html(summary);
    }
  }
  
  // Form validation
  $('#createBookingForm').on('submit', function(e) {
    const roomId = $('#roomSelect').val();
    const checkIn = $('input[name="check_in_date"]').val();
    const checkOut = $('input[name="check_out_date"]').val();
    const totalAmount = $('#totalAmount').val();
    
    if (!roomId) {
      e.preventDefault();
      alert('Please select a room.');
      return false;
    }
    
    if (!checkIn || !checkOut) {
      e.preventDefault();
      alert('Please select check-in and check-out dates.');
      return false;
    }
    
    if (!totalAmount || totalAmount <= 0) {
      e.preventDefault();
      alert('Please ensure total amount is calculated correctly.');
      return false;
    }
    
    // Show loading state
    const submitBtn = $(this).find('button[type="submit"]');
    const originalText = submitBtn.html();
    submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Creating Booking...');
    submitBtn.prop('disabled', true);
  });
});
</script>
@endpush
