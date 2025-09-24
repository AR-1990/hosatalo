@extends('admin.layout.app')

@section('title', 'Add Payment - Hostalo Admin Panel')

@section('content')
<div class="section-header">
  <h1>Add Payment</h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
    <div class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}">Payments</a></div>
    <div class="breadcrumb-item active">Add Payment</div>
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <h4><i class="fas fa-credit-card"></i> Payment Details</h4>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.payments.store.standalone') }}" id="paymentForm">
          @csrf
          
          <!-- Customer Search Section -->
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label>Search Customer <span class="text-danger">*</span></label>
                <div class="input-group">
                  <input type="text" id="customerSearch" class="form-control" placeholder="Search by name, email, NIC, or phone..." autocomplete="off">
                  <div class="input-group-append">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                  </div>
                </div>
                <div id="customerResults" class="dropdown-menu w-100" style="display: none; max-height: 300px; overflow-y: auto;"></div>
              </div>
            </div>
          </div>

          <!-- Selected Customer Info -->
          <div id="selectedCustomerInfo" style="display: none;">
            <div class="alert alert-info">
              <h6><i class="fas fa-user"></i> Selected Customer</h6>
              <div id="customerDetails"></div>
            </div>
          </div>

          <!-- Hidden Fields -->
          <input type="hidden" name="user_id" id="selectedUserId">
          <input type="hidden" name="booking_id" id="selectedBookingId">
          
          <!-- Booking Selection -->
          <div id="bookingSelection" style="display: none;">
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label>Select Booking <span class="text-danger">*</span></label>
                  <select name="booking_display" id="bookingSelect" class="form-control" required>
                    <option value="">Select a booking</option>
                  </select>
                  <small class="form-text text-muted" id="bookingInfo"></small>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Payment Details -->
          <div id="paymentDetails" style="display: none;">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Amount <span class="text-danger">*</span></label>
                  <input type="number" name="amount" id="paymentAmount" class="form-control" step="0.01" min="0.01" required>
                  <small class="form-text text-muted" id="outstandingBalance"></small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Payment Type <span class="text-danger">*</span></label>
                  <select name="payment_type" class="form-control" required>
                    <option value="">Select Payment Type</option>
                    <option value="advance">Advance</option>
                    <option value="partial">Partial</option>
                    <option value="full">Full</option>
                  </select>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Payment Method <span class="text-danger">*</span></label>
                  <select name="payment_method" class="form-control" required>
                    <option value="">Select Payment Method</option>
                    <option value="cash">Cash</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="online_payment">Online Payment</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Transaction ID</label>
                  <input type="text" name="transaction_id" class="form-control" placeholder="Optional">
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label>Notes</label>
                  <textarea name="notes" class="form-control" rows="3" placeholder="Optional notes about this payment"></textarea>
                </div>
              </div>
            </div>
            
            <div class="form-group">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Record Payment
              </button>
              <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary ml-2">
                <i class="fas fa-times"></i> Cancel
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">
        <h4><i class="fas fa-info-circle"></i> Instructions</h4>
      </div>
      <div class="card-body">
        <ol>
          <li>Search for the customer by typing their name, email, NIC, or phone number</li>
          <li>Select the customer from the search results</li>
          <li>Choose the booking you want to add payment for</li>
          <li>Enter the payment amount and details</li>
          <li>Click "Record Payment" to save</li>
        </ol>
        
        <div class="alert alert-warning mt-3">
          <i class="fas fa-exclamation-triangle"></i>
          <strong>Note:</strong> Only customers with unpaid bookings will appear in search results.
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const customerSearch = document.getElementById('customerSearch');
    const customerResults = document.getElementById('customerResults');
    const selectedCustomerInfo = document.getElementById('selectedCustomerInfo');
    const customerDetails = document.getElementById('customerDetails');
    const bookingSelection = document.getElementById('bookingSelection');
    const bookingSelect = document.getElementById('bookingSelect');
    const bookingInfo = document.getElementById('bookingInfo');
    const paymentDetails = document.getElementById('paymentDetails');
    const selectedUserId = document.getElementById('selectedUserId');
    const selectedBookingId = document.getElementById('selectedBookingId');
    const paymentAmount = document.getElementById('paymentAmount');
    const outstandingBalance = document.getElementById('outstandingBalance');
    
    let searchTimeout;
    let selectedCustomer = null;
    let selectedBooking = null;
    
    // Customer search functionality
    customerSearch.addEventListener('input', function() {
        const query = this.value.trim();
        
        clearTimeout(searchTimeout);
        
        if (query.length < 2) {
            customerResults.style.display = 'none';
            return;
        }
        
        searchTimeout = setTimeout(() => {
            fetch(`{{ route('admin.api.customers.search') }}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(customers => {
                    displayCustomerResults(customers);
                })
                .catch(error => {
                    console.error('Search error:', error);
                });
        }, 300);
    });
    
    function displayCustomerResults(customers) {
        if (customers.length === 0) {
            customerResults.innerHTML = '<div class="dropdown-item-text">No customers found</div>';
        } else {
            customerResults.innerHTML = customers.map(customer => `
                <a href="#" class="dropdown-item customer-item" data-customer='${JSON.stringify(customer)}'>
                    <div>
                        <strong>${customer.name}</strong>
                        <br>
                        <small class="text-muted">
                            ${customer.email} | NIC: ${customer.nic || 'N/A'} | Phone: ${customer.phone || 'N/A'}
                        </small>
                        <br>
                        <small class="text-info">${customer.bookings.length} unpaid booking(s)</small>
                    </div>
                </a>
            `).join('');
        }
        
        customerResults.style.display = 'block';
        
        // Add click handlers to customer items
        document.querySelectorAll('.customer-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const customer = JSON.parse(this.dataset.customer);
                selectCustomer(customer);
            });
        });
    }
    
    function selectCustomer(customer) {
        selectedCustomer = customer;
        selectedUserId.value = customer.id;
        
        // Hide search results
        customerResults.style.display = 'none';
        customerSearch.value = customer.name;
        
        // Show customer info
        customerDetails.innerHTML = `
            <strong>${customer.name}</strong><br>
            <small>Email: ${customer.email} | NIC: ${customer.nic || 'N/A'} | Phone: ${customer.phone || 'N/A'}</small>
        `;
        selectedCustomerInfo.style.display = 'block';
        
        // Populate booking dropdown
        bookingSelect.innerHTML = '<option value="">Select a booking</option>';
        customer.bookings.forEach(booking => {
            const option = document.createElement('option');
            option.value = booking.id;
            option.textContent = `#${booking.id} - ${booking.room_name} (Outstanding: PKR ${parseFloat(booking.outstanding_balance).toLocaleString()})`;
            option.dataset.booking = JSON.stringify(booking);
            bookingSelect.appendChild(option);
        });
        
        bookingSelection.style.display = 'block';
    }
    
    // Booking selection handler
    bookingSelect.addEventListener('change', function() {
        if (this.value) {
            const booking = JSON.parse(this.options[this.selectedIndex].dataset.booking);
            selectBooking(booking);
        } else {
            paymentDetails.style.display = 'none';
        }
    });
    
    function selectBooking(booking) {
        selectedBooking = booking;
        selectedBookingId.value = booking.id;
        
        // Show booking info
        bookingInfo.innerHTML = `
            Room: ${booking.room_name} | 
            Check-in: ${booking.check_in} | 
            Check-out: ${booking.check_out} | 
            Status: ${booking.payment_status}
        `;
        
        // Set payment amount limits
        paymentAmount.max = booking.outstanding_balance;
        outstandingBalance.textContent = `Outstanding Balance: PKR ${parseFloat(booking.outstanding_balance).toLocaleString()}`;
        
        paymentDetails.style.display = 'block';
    }
    
    // Hide results when clicking outside
    document.addEventListener('click', function(e) {
        if (!customerSearch.contains(e.target) && !customerResults.contains(e.target)) {
            customerResults.style.display = 'none';
        }
    });
});
</script>
@endsection