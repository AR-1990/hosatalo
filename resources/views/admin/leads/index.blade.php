@extends('admin.layout.app')

@section('title', 'Manage Leads - Hostalo Admin Panel')

@section('content')
<div class="section-header">
  <h1>Lead Management</h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
    <div class="breadcrumb-item active">Manage Leads</div>
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

@if(session('error'))
  <div class="alert alert-danger alert-dismissible show fade">
    <div class="alert-body">
      <button class="close" data-dismiss="alert">
        <span>&times;</span>
      </button>
      {{ session('error') }}
    </div>
  </div>
@endif

<!-- Statistics Cards -->
<div class="row">
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-primary">
        <i class="fas fa-user-plus"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Total Leads</h4>
        </div>
        <div class="card-body">
          {{ $leads->total() }}
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
          <h4>New Leads</h4>
        </div>
        <div class="card-body">
          {{ $leads->where('status', 'new')->count() }}
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-info">
        <i class="fas fa-phone"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Contacted</h4>
        </div>
        <div class="card-body">
          {{ $leads->where('status', 'contacted')->count() }}
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
          <h4>Converted</h4>
        </div>
        <div class="card-body">
          {{ $leads->where('status', 'converted')->count() }}
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
        <h4><i class="fas fa-filter"></i> Quick Filters</h4>
      </div>
      <div class="card-body">
        <div class="btn-group" role="group">
          <button type="button" class="btn btn-outline-primary" onclick="filterLeads('all')">All Leads</button>
          <button type="button" class="btn btn-outline-warning" onclick="filterLeads('new')">New</button>
          <button type="button" class="btn btn-outline-info" onclick="filterLeads('contacted')">Contacted</button>
          <button type="button" class="btn btn-outline-success" onclick="filterLeads('converted')">Converted</button>
          <button type="button" class="btn btn-outline-secondary" onclick="filterLeads('closed')">Closed</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Leads Table -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4><i class="fas fa-list"></i> All Leads</h4>
        <div class="card-header-action">
          <a href="{{ route('admin.leads.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Lead
          </a>
        </div>
      </div>
      <div class="card-body">
        @if($leads->count() > 0)
          <div class="table-responsive">
            <table class="table table-striped table-hover" id="leads-table">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Name</th>
                  <th>Contact Info</th>
                  <th>Source</th>
                  <th>Subject</th>
                  <th>Status</th>
                  <th>Room Details</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($leads as $lead)
                  <tr data-status="{{ $lead->status }}">
                    <td>
                      <div class="text-sm">
                        <div class="font-weight-bold">{{ $lead->created_at->format('M d, Y') }}</div>
                        <small class="text-muted">{{ $lead->created_at->format('H:i') }}</small>
                      </div>
                    </td>
                    <td>
                      <div class="font-weight-bold">{{ $lead->name }}</div>
                      <small class="text-muted">ID: #{{ $lead->id }}</small>
                    </td>
                    <td>
                      <div class="d-flex flex-column">
                        <span><i class="fas fa-envelope text-primary me-1"></i>{{ $lead->email }}</span>
                        <span><i class="fas fa-phone text-success me-1"></i>{{ $lead->phone }}</span>
                      </div>
                    </td>
                    <td>
                      <span class="badge badge-info">{{ ucfirst($lead->source) }}</span>
                    </td>
                    <td>
                      <div class="text-sm">
                        <div class="font-weight-bold">{{ Str::limit($lead->subject, 30) }}</div>
                        @if($lead->message)
                          <small class="text-muted">{{ Str::limit($lead->message, 50) }}</small>
                        @endif
                      </div>
                    </td>
                    <td>
                      @php
                        $statusColors = [
                          'new' => 'warning',
                          'contacted' => 'info',
                          'converted' => 'success',
                          'closed' => 'secondary'
                        ];
                      @endphp
                      <span class="badge badge-{{ $statusColors[$lead->status] ?? 'secondary' }}">
                        {{ ucfirst($lead->status) }}
                      </span>
                    </td>
                    <td>
                      @if(isset($lead->additional_data['room_id']) || isset($lead->additional_data['room_type']))
                        <div class="text-sm">
                          @if(isset($lead->additional_data['room_type']))
                            <div class="font-weight-bold">{{ ucfirst($lead->additional_data['room_type']) }}</div>
                          @endif
                          @if(isset($lead->additional_data['check_in_date']))
                            <small class="text-muted">
                              {{ \Carbon\Carbon::parse($lead->additional_data['check_in_date'])->format('M d, Y') }}
                            </small>
                          @endif
                        </div>
                      @else
                        <span class="text-muted">General inquiry</span>
                      @endif
                    </td>
                    <td>
                      <div class="btn-group" role="group">
                        <a href="{{ route('admin.leads.show', $lead) }}" class="btn btn-sm btn-outline-primary" title="View Details">
                          <i class="fas fa-eye"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-warning" 
                                onclick="editLead({{ $lead->id }})" title="Edit">
                          <i class="fas fa-edit"></i>
                        </button>
                        @if($lead->status !== 'converted' && $lead->status !== 'closed')
                          <button type="button" class="btn btn-sm btn-outline-info" 
                                  onclick="contactLead({{ $lead->id }})" title="Mark as Contacted">
                            <i class="fas fa-phone"></i>
                          </button>
                        @endif
                        @if($lead->status === 'new' && isset($lead->additional_data['room_type']))
                          <button type="button" class="btn btn-sm btn-outline-success" 
                                  onclick="convertToBooking({{ $lead->id }})" title="Convert to Booking">
                            <i class="fas fa-check-circle"></i>
                          </button>
                        @endif
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          
          <!-- Pagination -->
          <div class="d-flex justify-content-center">
            {{ $leads->links() }}
          </div>
        @else
          <div class="text-center py-4">
            <i class="fas fa-user-plus fa-3x text-muted mb-3"></i>
            <h5>No Leads Found</h5>
            <p class="text-muted">No leads have been submitted yet.</p>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Edit Lead Modal -->
<div class="modal fade" id="editLeadModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Lead</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editLeadForm">
          <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="name" id="editName" required>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email" id="editEmail" required>
          </div>
          <div class="form-group">
            <label>Phone</label>
            <input type="tel" class="form-control" name="phone" id="editPhone" required>
          </div>
          <div class="form-group">
            <label>Status</label>
            <select class="form-control" name="status" id="editStatus" required>
              <option value="new">New</option>
              <option value="contacted">Contacted</option>
              <option value="converted">Converted</option>
              <option value="closed">Closed</option>
            </select>
          </div>
          <div class="form-group">
            <label>Notes</label>
            <textarea class="form-control" name="notes" id="editNotes" rows="3"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveLead()">Save Changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Convert to Booking Modal -->
<div class="modal fade" id="convertToBookingModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Convert Lead to Booking</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="convertToBookingForm">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Assign Room <span class="text-danger">*</span></label>
                <select name="room_id" class="form-control" required>
                  <option value="">Select Room</option>
                  @foreach($availableRooms ?? [] as $room)
                    <option value="{{ $room->id }}" data-price="{{ $room->price_per_night }}">
                      {{ $room->name }} - PKR {{ number_format($room->price_per_night, 2) }}/night
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Total Amount <span class="text-danger">*</span></label>
                <input type="number" name="total_amount" class="form-control" step="0.01" min="0.01" required>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Check-in Date <span class="text-danger">*</span></label>
                <input type="date" name="check_in_date" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Check-out Date <span class="text-danger">*</span></label>
                <input type="date" name="check_out_date" class="form-control" required>
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label>Admin Notes</label>
            <textarea name="admin_notes" class="form-control" rows="3" placeholder="Any additional notes for this booking"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" onclick="approveBooking()">
          <i class="fas fa-check"></i> Convert to Booking
        </button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
let currentLeadId = null;

function filterLeads(status) {
  const rows = document.querySelectorAll('#leads-table tbody tr');
  
  rows.forEach(row => {
    if (status === 'all' || row.dataset.status === status) {
      row.style.display = '';
    } else {
      row.style.display = 'none';
    }
  });
}

function updateStatus(leadId, status) {
  fetch(`/admin/leads/${leadId}/status`, {
    method: 'PATCH',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({ status: status })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Update the row's data-status attribute
      const row = document.querySelector(`tr[data-lead-id="${leadId}"]`);
      if (row) {
        row.dataset.status = status;
      }
      
      // Show success message
      Swal.fire({
        icon: 'success',
        title: 'Status Updated',
        text: 'Lead status has been updated successfully!'
      });
    }
  })
  .catch(error => {
    console.error('Error:', error);
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Failed to update lead status. Please try again.'
    });
  });
}

function editLead(leadId) {
  currentLeadId = leadId;
  
  // Fetch lead data and populate form
  fetch(`/admin/leads/${leadId}/edit`)
    .then(response => response.json())
    .then(data => {
      document.getElementById('editName').value = data.name;
      document.getElementById('editEmail').value = data.email;
      document.getElementById('editPhone').value = data.phone;
      document.getElementById('editStatus').value = data.status;
      document.getElementById('editNotes').value = data.notes || '';
      
      $('#editLeadModal').modal('show');
    });
}

function saveLead() {
  const formData = new FormData(document.getElementById('editLeadForm'));
  
  fetch(`/admin/leads/${currentLeadId}`, {
    method: 'PUT',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      $('#editLeadModal').modal('hide');
      Swal.fire({
        icon: 'success',
        title: 'Lead Updated',
        text: 'Lead information has been updated successfully!'
      }).then(() => {
        location.reload();
      });
    }
  });
}

function contactLead(leadId) {
  Swal.fire({
    title: 'Mark as Contacted?',
    text: 'This will update the lead status to "Contacted"',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes, Mark as Contacted',
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if (result.isConfirmed) {
      updateStatus(leadId, 'contacted');
    }
  });
}

function convertToBooking(leadId) {
  currentLeadId = leadId;
  
  // Fetch lead data to populate dates if available
  fetch(`/admin/leads/${leadId}`)
    .then(response => response.text())
    .then(html => {
      // Extract dates from the lead data if available
      // This would need to be implemented based on your data structure
      $('#convertToBookingModal').modal('show');
    });
}

function approveBooking() {
  const formData = new FormData(document.getElementById('convertToBookingForm'));
  formData.append('assigned_room_id', formData.get('room_id'));
  
  fetch(`/admin/leads/${currentLeadId}/approve-booking`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      $('#convertToBookingModal').modal('hide');
      Swal.fire({
        icon: 'success',
        title: 'Booking Approved!',
        text: 'Lead has been successfully converted to a booking.'
      }).then(() => {
        location.reload();
      });
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: data.message || 'Failed to convert lead to booking.'
      });
    }
  })
  .catch(error => {
    console.error('Error:', error);
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'An error occurred while converting the lead to a booking.'
    });
  });
}

// Initialize DataTable
$(document).ready(function() {
  $('#leads-table').DataTable({
    "pageLength": 25,
    "order": [[ 0, "desc" ]],
    "responsive": true
  });
});
</script>
@endpush
