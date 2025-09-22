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
        <form method="POST" action="{{ route('admin.payments.store') }}" id="paymentForm">
          @csrf
          <input type="hidden" name="booking_id" value="{{ $booking->id }}">
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Amount <span class="text-danger">*</span></label>
                <input type="number" name="amount" class="form-control" step="0.01" min="0.01" max="{{ $booking->outstanding_balance ?? $booking->total_amount }}" required>
                <small class="form-text text-muted">
                  Outstanding Balance: PKR {{ number_format($booking->outstanding_balance ?? $booking->total_amount, 2) }}
                </small>
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
                <input type="text" name="transaction_id" class="form-control" placeholder="Optional transaction reference">
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label>Notes</label>
            <textarea name="notes" class="form-control" rows="3" placeholder="Any additional notes about this payment"></textarea>
          </div>
          
          <div class="form-group">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> Record Payment
            </button>
            <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-secondary">
              <i class="fas fa-arrow-left"></i> Back to Booking
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">
        <h4><i class="fas fa-info-circle"></i> Booking Summary</h4>
      </div>
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-6">
            <strong>Booking ID:</strong>
          </div>
          <div class="col-6">
            #{{ $booking->id }}
          </div>
        </div>
        
        <div class="row mb-3">
          <div class="col-6">
            <strong>Customer:</strong>
          </div>
          <div class="col-6">
            {{ $booking->customer_name ?? 'N/A' }}
          </div>
        </div>
        
        <div class="row mb-3">
          <div class="col-6">
            <strong>Room:</strong>
          </div>
          <div class="col-6">
            {{ $booking->room_name ?? 'N/A' }}
          </div>
        </div>
        
        <div class="row mb-3">
          <div class="col-6">
            <strong>Check-in:</strong>
          </div>
          <div class="col-6">
            @if($booking->check_in_date)
              {{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}
            @else
              N/A
            @endif
          </div>
        </div>
        
        <div class="row mb-3">
          <div class="col-6">
            <strong>Check-out:</strong>
          </div>
          <div class="col-6">
            @if($booking->check_out_date)
              {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}
            @else
              N/A
            @endif
          </div>
        </div>
        
        <hr>
        
        <div class="row mb-3">
          <div class="col-6">
            <strong>Total Amount:</strong>
          </div>
          <div class="col-6">
            <span class="text-success">PKR {{ number_format($booking->total_amount ?? 0, 2) }}</span>
          </div>
        </div>
        
        <div class="row mb-3">
          <div class="col-6">
            <strong>Advance Paid:</strong>
          </div>
          <div class="col-6">
            <span class="text-info">PKR {{ number_format($booking->advance_amount ?? 0, 2) }}</span>
          </div>
        </div>
        
        <div class="row mb-3">
          <div class="col-6">
            <strong>Outstanding:</strong>
          </div>
          <div class="col-6">
            <span class="text-danger">PKR {{ number_format($booking->outstanding_balance ?? 0, 2) }}</span>
          </div>
        </div>
        
        <div class="row mb-3">
          <div class="col-6">
            <strong>Payment Status:</strong>
          </div>
          <div class="col-6">
            @php
              $paymentStatus = $booking->payment_status ?? 'pending';
              $statusColors = [
                'pending' => 'secondary',
                'advance' => 'warning',
                'partial' => 'info',
                'full' => 'success'
              ];
            @endphp
            <span class="badge badge-{{ $statusColors[$paymentStatus] }}">
              {{ ucfirst($paymentStatus) }}
            </span>
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
  const amountInput = document.querySelector('input[name="amount"]');
  const paymentTypeSelect = document.querySelector('select[name="payment_type"]');
  const outstandingBalance = {{ $booking->outstanding_balance ?? $booking->total_amount }};
  
  // Auto-calculate payment type based on amount
  amountInput.addEventListener('input', function() {
    const amount = parseFloat(this.value) || 0;
    
    if (amount >= outstandingBalance) {
      paymentTypeSelect.value = 'full';
    } else if (amount > 0) {
      paymentTypeSelect.value = 'partial';
    } else {
      paymentTypeSelect.value = '';
    }
  });
  
  // Validate amount against outstanding balance
  document.getElementById('paymentForm').addEventListener('submit', function(e) {
    const amount = parseFloat(amountInput.value) || 0;
    
    if (amount <= 0) {
      e.preventDefault();
      alert('Amount must be greater than 0.');
      return;
    }
    
    if (amount > outstandingBalance) {
      e.preventDefault();
      alert('Amount cannot exceed the outstanding balance of PKR ' + outstandingBalance.toFixed(2));
      return;
    }
  });
});
</script>
@endpush
