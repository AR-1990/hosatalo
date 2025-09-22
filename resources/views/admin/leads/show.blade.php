@extends('admin.layout.app')

@section('title', 'Lead Details - Hostalo Admin Panel')

@section('content')
<div class="section-header">
  <h1>Lead Details</h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
    <div class="breadcrumb-item"><a href="{{ route('admin.leads.index') }}">Leads</a></div>
    <div class="breadcrumb-item active">Lead #{{ $contact->id }}</div>
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

<div class="row">
  <div class="col-lg-8">
    <!-- Lead Information -->
    <div class="card">
      <div class="card-header">
        <h4><i class="fas fa-user"></i> Lead Information</h4>
        <div class="card-header-action">
          <span class="badge badge-{{ $contact->status === 'converted' ? 'success' : ($contact->status === 'contacted' ? 'info' : 'warning') }}">
            {{ ucfirst($contact->status ?? 'New') }}
          </span>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label><strong>Name:</strong></label>
              <p>{{ $contact->name ?? 'N/A' }}</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label><strong>Email:</strong></label>
              <p>{{ $contact->email ?? 'N/A' }}</p>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label><strong>Phone:</strong></label>
              <p>{{ $contact->phone ?? 'N/A' }}</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label><strong>Subject:</strong></label>
              <p>{{ $contact->subject ?? 'N/A' }}</p>
            </div>
          </div>
        </div>
        
        <div class="form-group">
          <label><strong>Message:</strong></label>
          <p>{{ $contact->message ?? 'N/A' }}</p>
        </div>
        
        @if($contact->additional_data)
          <div class="form-group">
            <label><strong>Additional Information:</strong></label>
            <div class="table-responsive">
              <table class="table table-sm">
                <tbody>
                  @if(isset($contact->additional_data['room_id']))
                    <tr>
                      <td><strong>Specific Room ID:</strong></td>
                      <td>
                        <span class="badge badge-primary">Room #{{ $contact->additional_data['room_id'] }}</span>
                        @php
                          $specificRoom = \App\Models\Room::find($contact->additional_data['room_id']);
                        @endphp
                        @if($specificRoom)
                          <br><small class="text-muted">{{ $specificRoom->name }} - PKR {{ number_format($specificRoom->price_per_night, 2) }}/night</small>
                        @endif
                      </td>
                    </tr>
                  @endif
                  @if(isset($contact->additional_data['room_type']))
                    <tr>
                      <td><strong>Room Type:</strong></td>
                      <td>
                        <span class="badge badge-info">{{ ucfirst($contact->additional_data['room_type']) }}</span>
                        @php
                          $roomTypeCount = \App\Models\Room::where('room_type', $contact->additional_data['room_type'])->count();
                        @endphp
                        <br><small class="text-muted">{{ $roomTypeCount }} rooms of this type available</small>
                      </td>
                    </tr>
                  @endif
                  @if(isset($contact->additional_data['check_in_date']))
                    <tr>
                      <td><strong>Check-in Date:</strong></td>
                      <td>
                        <span class="text-primary">{{ \Carbon\Carbon::parse($contact->additional_data['check_in_date'])->format('M d, Y') }}</span>
                        <br><small class="text-muted">{{ \Carbon\Carbon::parse($contact->additional_data['check_in_date'])->diffForHumans() }}</small>
                      </td>
                    </tr>
                  @endif
                  @if(isset($contact->additional_data['check_out_date']))
                    <tr>
                      <td><strong>Check-out Date:</strong></td>
                      <td>
                        <span class="text-primary">{{ \Carbon\Carbon::parse($contact->additional_data['check_out_date'])->format('M d, Y') }}</span>
                        @if(isset($contact->additional_data['check_in_date']))
                          @php
                            $nights = \Carbon\Carbon::parse($contact->additional_data['check_in_date'])->diffInDays(\Carbon\Carbon::parse($contact->additional_data['check_out_date']));
                          @endphp
                          <br><small class="text-muted">{{ $nights }} nights requested</small>
                        @endif
                      </td>
                    </tr>
                  @endif
                  @if(isset($contact->additional_data['booking_type']))
                    <tr>
                      <td><strong>Booking Type:</strong></td>
                      <td>
                        <span class="badge badge-warning">{{ ucfirst($contact->additional_data['booking_type']) }}</span>
                        @if($contact->additional_data['booking_type'] === 'monthly')
                          <br><small class="text-muted">Monthly rental preferred</small>
                        @elseif($contact->additional_data['booking_type'] === 'yearly')
                          <br><small class="text-muted">Long-term yearly contract</small>
                        @else
                          <br><small class="text-muted">Daily/nightly booking</small>
                        @endif
                      </td>
                    </tr>
                  @endif
                  @if(isset($contact->additional_data['number_of_guests']))
                    <tr>
                      <td><strong>Number of Guests:</strong></td>
                      <td>
                        <span class="badge badge-secondary">{{ $contact->additional_data['number_of_guests'] }} person(s)</span>
                      </td>
                    </tr>
                  @endif
                  @if(isset($contact->additional_data['budget']))
                    <tr>
                      <td><strong>Budget Range:</strong></td>
                      <td>
                        <span class="text-success">PKR {{ number_format($contact->additional_data['budget'], 2) }}</span>
                        <br><small class="text-muted">Customer's budget preference</small>
                      </td>
                    </tr>
                  @endif
                  @if(isset($contact->additional_data['source']))
                    <tr>
                      <td><strong>Lead Source:</strong></td>
                      <td>
                        <span class="badge badge-dark">{{ ucfirst($contact->additional_data['source']) }}</span>
                        @if($contact->additional_data['source'] === 'website')
                          <br><small class="text-muted">From website contact form</small>
                        @elseif($contact->additional_data['source'] === 'phone_call')
                          <br><small class="text-muted">Direct phone call</small>
                        @elseif($contact->additional_data['source'] === 'admin_created')
                          <br><small class="text-muted">Created by admin staff</small>
                        @endif
                      </td>
                    </tr>
                  @endif
                  @if(isset($contact->additional_data['admin_created']))
                    <tr>
                      <td><strong>Created By:</strong></td>
                      <td>
                        <span class="badge badge-info">Admin Staff</span>
                        @if(isset($contact->additional_data['created_by']))
                          @php
                            $adminUser = \App\Models\User::find($contact->additional_data['created_by']);
                          @endphp
                          <br><small class="text-muted">{{ $adminUser ? $adminUser->name : 'Unknown' }}</small>
                        @endif
                      </td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        @endif
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label><strong>Created:</strong></label>
              <p>{{ $contact->created_at ? $contact->created_at->format('M d, Y H:i') : 'N/A' }}</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label><strong>Last Updated:</strong></label>
              <p>{{ $contact->updated_at ? $contact->updated_at->format('M d, Y H:i') : 'N/A' }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Notes Section -->
    <div class="card">
      <div class="card-header">
        <h4><i class="fas fa-sticky-note"></i> Lead Notes & Communication History</h4>
      </div>
      <div class="card-body">
        @if(isset($contact->additional_data['notes']) && count($contact->additional_data['notes']) > 0)
          <div class="notes-list mb-3">
            @foreach($contact->additional_data['notes'] as $note)
              <div class="note-item border-left border-primary pl-3 mb-2">
                <div class="d-flex justify-content-between">
                  <small class="text-muted">{{ \Carbon\Carbon::parse($note['added_at'])->format('M d, Y H:i') }}</small>
                  <span class="badge badge-info">Admin Note</span>
                </div>
                <p class="mb-1">{{ $note['note'] }}</p>
              </div>
            @endforeach
          </div>
        @else
          <div class="text-center py-3">
            <i class="fas fa-sticky-note fa-2x text-muted mb-2"></i>
            <p class="text-muted">No notes added yet</p>
          </div>
        @endif
        
        <hr>
        
        <form method="POST" action="{{ route('admin.leads.add-note', $contact) }}">
          @csrf
          <div class="form-group">
            <label>Add New Note</label>
            <textarea name="note" class="form-control" rows="3" placeholder="Add a note about this lead..." required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Save Note
          </button>
        </form>
      </div>
    </div>
    
    <!-- Room Details Section -->
    @if(isset($contact->additional_data['room_type']) || isset($contact->additional_data['room_id']))
      <div class="card">
        <div class="card-header">
          <h4><i class="fas fa-bed"></i> Room Details & Preferences</h4>
        </div>
        <div class="card-body">
          <!-- Room Request Summary -->
          <div class="alert alert-info mb-4">
            <div class="row align-items-center">
              <div class="col-md-8">
                <h6 class="mb-2"><i class="fas fa-info-circle"></i> Room Request Summary</h6>
                <div class="row">
                  @if(isset($contact->additional_data['room_type']))
                    <div class="col-md-4">
                      <small class="text-muted">Room Type:</small><br>
                      <strong class="text-primary">{{ ucfirst($contact->additional_data['room_type']) }}</strong>
                    </div>
                  @endif
                  @if(isset($contact->additional_data['room_id']))
                    <div class="col-md-4">
                      <small class="text-muted">Specific Room:</small><br>
                      <strong class="text-success">Room #{{ $contact->additional_data['room_id'] }}</strong>
                    </div>
                  @endif
                  @if(isset($contact->additional_data['booking_type']))
                    <div class="col-md-4">
                      <small class="text-muted">Booking Type:</small><br>
                      <strong class="text-warning">{{ ucfirst($contact->additional_data['booking_type']) }}</strong>
                    </div>
                  @endif
                </div>
                @if(isset($contact->additional_data['check_in_date']) && isset($contact->additional_data['check_out_date']))
                  <div class="row mt-2">
                    <div class="col-md-6">
                      <small class="text-muted">Duration:</small><br>
                      @php
                        $nights = \Carbon\Carbon::parse($contact->additional_data['check_in_date'])->diffInDays(\Carbon\Carbon::parse($contact->additional_data['check_out_date']));
                      @endphp
                      <strong class="text-info">{{ $nights }} nights</strong>
                      <small class="text-muted"> ({{ \Carbon\Carbon::parse($contact->additional_data['check_in_date'])->format('M d') }} - {{ \Carbon\Carbon::parse($contact->additional_data['check_out_date'])->format('M d, Y') }})</small>
                    </div>
                    @if(isset($contact->additional_data['number_of_guests']))
                      <div class="col-md-6">
                        <small class="text-muted">Guests:</small><br>
                        <strong class="text-secondary">{{ $contact->additional_data['number_of_guests'] }} person(s)</strong>
                      </div>
                    @endif
                  </div>
                @endif
              </div>
              <div class="col-md-4 text-center">
                @if($contact->status !== 'converted')
                  <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#approveBookingModal">
                    <i class="fas fa-check-circle"></i> Approve Booking
                  </button>
                @else
                  <div class="text-success">
                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                    <br><strong>Already Converted to Booking</strong>
                  </div>
                @endif
              </div>
            </div>
          </div>
          <div class="row">
            @if(isset($contact->additional_data['room_id']))
              <div class="col-md-6">
                <div class="form-group">
                  <label><strong>Specific Room Requested:</strong></label>
                  @php
                    $specificRoom = \App\Models\Room::find($contact->additional_data['room_id']);
                  @endphp
                  @if($specificRoom)
                    <div class="room-info p-3 border rounded bg-light">
                      <h6 class="text-primary mb-2">{{ $specificRoom->name }}</h6>
                      <div class="row">
                        <div class="col-6">
                          <small class="text-muted">Room ID:</small><br>
                          <strong>#{{ $specificRoom->id }}</strong>
                        </div>
                        <div class="col-6">
                          <small class="text-muted">Price:</small><br>
                          <strong class="text-success">PKR {{ number_format($specificRoom->price_per_night, 2) }}/night</strong>
                        </div>
                      </div>
                      <div class="row mt-2">
                        <div class="col-6">
                          <small class="text-muted">Type:</small><br>
                          <span class="badge badge-info">{{ ucfirst($specificRoom->room_type) }}</span>
                        </div>
                        <div class="col-6">
                          <small class="text-muted">Capacity:</small><br>
                          <span class="badge badge-secondary">{{ $specificRoom->capacity }} person(s)</span>
                        </div>
                      </div>
                      <div class="mt-2">
                        <small class="text-muted">Status:</small><br>
                        @if($specificRoom->is_available)
                          <span class="badge badge-success">Available</span>
                        @else
                          <span class="badge badge-danger">Not Available</span>
                        @endif
                      </div>
                    </div>
                  @else
                    <div class="alert alert-warning">
                      <i class="fas fa-exclamation-triangle"></i>
                      Requested room not found in system
                    </div>
                  @endif
                </div>
              </div>
            @endif
            
            <div class="col-md-{{ isset($contact->additional_data['room_id']) ? '6' : '12' }}">
              <div class="form-group">
                <label><strong>Room Type Preference:</strong></label>
                @if(isset($contact->additional_data['room_type']))
                  <div class="room-type-info p-3 border rounded bg-light">
                    <h6 class="text-info mb-2">{{ ucfirst($contact->additional_data['room_type']) }} Rooms</h6>
                    @php
                      $roomTypeCount = \App\Models\Room::where('room_type', $contact->additional_data['room_type'])->count();
                      $availableRoomsOfType = \App\Models\Room::where('room_type', $contact->additional_data['room_type'])->where('is_available', true)->count();
                    @endphp
                    <div class="row">
                      <div class="col-6">
                        <small class="text-muted">Total Rooms:</small><br>
                        <strong>{{ $roomTypeCount }}</strong>
                      </div>
                      <div class="col-6">
                        <small class="text-muted">Available Now:</small><br>
                        <strong class="text-success">{{ $availableRoomsOfType }}</strong>
                      </div>
                    </div>
                    
                    @if(isset($contact->additional_data['check_in_date']) && isset($contact->additional_data['check_out_date']))
                      <hr class="my-2">
                      <div class="text-center">
                        <small class="text-muted">Availability for requested dates:</small><br>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-1" onclick="checkOtherDates()">
                          <i class="fas fa-calendar-check"></i> Check Availability
                        </button>
                      </div>
                    @endif
                  </div>
                @else
                  <p class="text-muted">No specific room type preference mentioned</p>
                @endif
              </div>
            </div>
          </div>
          
          @if(isset($contact->additional_data['check_in_date']) && isset($contact->additional_data['check_out_date']))
            <hr>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label><strong>Booking Period:</strong></label>
                  <div class="booking-period p-3 border rounded bg-light">
                    <div class="row">
                      <div class="col-6">
                        <small class="text-muted">Check-in:</small><br>
                        <strong class="text-primary">{{ \Carbon\Carbon::parse($contact->additional_data['check_in_date'])->format('M d, Y') }}</strong>
                      </div>
                      <div class="col-6">
                        <small class="text-muted">Check-out:</small><br>
                        <strong class="text-primary">{{ \Carbon\Carbon::parse($contact->additional_data['check_out_date'])->format('M d, Y') }}</strong>
                      </div>
                    </div>
                    <div class="text-center mt-2">
                      @php
                        $nights = \Carbon\Carbon::parse($contact->additional_data['check_in_date'])->diffInDays(\Carbon\Carbon::parse($contact->additional_data['check_out_date']));
                      @endphp
                      <span class="badge badge-info badge-lg">{{ $nights }} nights</span>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="form-group">
                  <label><strong>Booking Type:</strong></label>
                  @if(isset($contact->additional_data['booking_type']))
                    <div class="booking-type-info p-3 border rounded bg-light">
                      <h6 class="text-warning mb-2">{{ ucfirst($contact->additional_data['booking_type']) }} Booking</h6>
                      @if($contact->additional_data['booking_type'] === 'monthly')
                        <p class="mb-1"><i class="fas fa-calendar-alt"></i> Monthly rental preferred</p>
                        <small class="text-muted">Suitable for extended stays</small>
                      @elseif($contact->additional_data['booking_type'] === 'yearly')
                        <p class="mb-1"><i class="fas fa-calendar-alt"></i> Long-term yearly contract</p>
                        <small class="text-muted">Ideal for students or long-term residents</small>
                      @else
                        <p class="mb-1"><i class="fas fa-calendar-alt"></i> Daily/nightly booking</p>
                        <small class="text-muted">Standard short-term accommodation</small>
                      @endif
                    </div>
                  @else
                    <p class="text-muted">No specific booking type mentioned</p>
                  @endif
                </div>
              </div>
            </div>
          @endif
        </div>
      </div>
    @endif
  </div>
  
  <!-- Room Availability Status Section -->
  @if(isset($contact->additional_data['room_type']) && isset($contact->additional_data['check_in_date']) && isset($contact->additional_data['check_out_date']))
    <div class="card mt-4">
      <div class="card-header bg-gradient-primary text-white">
        <h4 class="mb-0">
          <i class="fas fa-calendar-check"></i> Room Availability Status
        </h4>
      </div>
      <div class="card-body">
        @php
          $roomType = $contact->additional_data['room_type'];
          $checkIn = $contact->additional_data['check_in_date'];
          $checkOut = $contact->additional_data['check_out_date'];
          
          // Check for conflicting bookings
          $conflictingBookings = \App\Models\Booking::whereHas('room', function($query) use ($roomType) {
            $query->where('room_type', $roomType);
          })->where('status', '!=', 'cancelled')
          ->where(function ($q) use ($checkIn, $checkOut) {
            $q->whereBetween('check_in_date', [$checkIn, $checkOut])
              ->orWhereBetween('check_out_date', [$checkIn, $checkOut])
              ->orWhere(function ($query) use ($checkIn, $checkOut) {
                $query->where('check_in_date', '<=', $checkIn)
                      ->where('check_out_date', '>=', $checkOut);
              });
          })->get();
          
          $totalRoomsOfType = \App\Models\Room::where('room_type', $roomType)->count();
          $availableRoomsOfType = \App\Models\Room::where('room_type', $roomType)->where('is_available', true)->count();
          $nights = \Carbon\Carbon::parse($checkIn)->diffInDays(\Carbon\Carbon::parse($checkOut));
          
          $isAvailable = $conflictingBookings->count() === 0 && $availableRoomsOfType > 0;
          
          // Get all rooms of this type for room change options
          $allRoomsOfType = \App\Models\Room::where('room_type', $roomType)->get();
        @endphp
        
        <!-- Check-in/Check-out Dates Display -->
        <div class="dates-display mb-4">
          <div class="row">
            <div class="col-md-6">
              <div class="date-card checkin">
                <div class="date-icon">
                  <i class="fas fa-sign-in-alt fa-2x text-success"></i>
                </div>
                <div class="date-info">
                  <h6 class="date-label">Check-in Date</h6>
                  <div class="date-value">{{ \Carbon\Carbon::parse($checkIn)->format('l, M d, Y') }}</div>
                  <small class="date-time">{{ \Carbon\Carbon::parse($checkIn)->format('g:i A') }}</small>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="date-card checkout">
                <div class="date-icon">
                  <i class="fas fa-sign-out-alt fa-2x text-danger"></i>
                </div>
                <div class="date-info">
                  <h6 class="date-label">Check-out Date</h6>
                  <div class="date-value">{{ \Carbon\Carbon::parse($checkOut)->format('l, M d, Y') }}</div>
                  <small class="date-time">{{ \Carbon\Carbon::parse($checkOut)->format('g:i A') }}</small>
                </div>
              </div>
            </div>
          </div>
          <div class="text-center mt-3">
            <span class="badge badge-info badge-lg">
              <i class="fas fa-moon"></i> Total Duration: {{ $nights }} nights
            </span>
          </div>
        </div>
        
        <div class="row">
          <div class="col-lg-8">
            <div class="availability-overview">
              <div class="row">
                <div class="col-md-6">
                  <div class="availability-details-card">
                    <h6 class="text-primary mb-3">
                      <i class="fas fa-bed"></i> Requested Room Details
                    </h6>
                    <div class="detail-item">
                      <span class="label">Room Type:</span>
                      <span class="value badge badge-info">{{ ucfirst($roomType) }}</span>
                    </div>
                    <div class="detail-item">
                      <span class="label">Total Rooms:</span>
                      <span class="value">{{ $totalRoomsOfType }}</span>
                    </div>
                    <div class="detail-item">
                      <span class="label">Available Now:</span>
                      <span class="value badge badge-{{ $availableRoomsOfType > 0 ? 'success' : 'danger' }}">
                        {{ $availableRoomsOfType }}
                      </span>
                    </div>
                    <div class="detail-item">
                      <span class="label">Status:</span>
                      <span class="value badge badge-{{ $isAvailable ? 'success' : 'danger' }}">
                        {{ $isAvailable ? 'Available' : 'Not Available' }}
                      </span>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="availability-status-display text-center">
                    @if($isAvailable)
                      <div class="status-available">
                        <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                        <h5 class="text-success mb-2">Room Available!</h5>
                        <div class="availability-stats">
                          <div class="stat-item">
                            <span class="stat-number text-success">{{ $availableRoomsOfType }}</span>
                            <span class="stat-label">Available</span>
                          </div>
                          <div class="stat-divider"></div>
                          <div class="stat-item">
                            <span class="stat-number">{{ $totalRoomsOfType }}</span>
                            <span class="stat-label">Total</span>
                          </div>
                        </div>
                        <p class="text-success mt-2">
                          <i class="fas fa-thumbs-up"></i> Perfect match for your dates!
                        </p>
                      </div>
                    @else
                      <div class="status-unavailable">
                        <i class="fas fa-times-circle fa-4x text-danger mb-3"></i>
                        <h5 class="text-danger mb-2">Room Not Available</h5>
                        <div class="availability-stats">
                          <div class="stat-item">
                            <span class="stat-number text-danger">0</span>
                            <span class="stat-label">Available</span>
                          </div>
                          <div class="stat-divider"></div>
                          <div class="stat-item">
                            <span class="stat-number">{{ $totalRoomsOfType }}</span>
                            <span class="stat-label">Total</span>
                          </div>
                        </div>
                        @if($conflictingBookings->count() > 0)
                          <p class="text-danger mt-2">
                            <i class="fas fa-exclamation-triangle"></i> 
                            {{ $conflictingBookings->count() }} conflicting booking(s) found
                          </p>
                        @else
                          <p class="text-warning mt-2">
                            <i class="fas fa-info-circle"></i> 
                            No rooms available for selected dates
                          </p>
                        @endif
                      </div>
                    @endif
                  </div>
                </div>
              </div>
              
              <!-- Room Change Options -->
              <div class="room-change-options mt-4">
                <div class="section-header">
                  <h6 class="text-primary mb-3">
                    <i class="fas fa-exchange-alt"></i> Room Change Options
                  </h6>
                  <p class="text-muted mb-4">Select an alternative room from the same category</p>
                </div>
                
                <div class="room-grid">
                  @foreach($allRoomsOfType as $room)
                    @php
                      $roomAvailable = $room->is_available;
                      $roomConflicts = \App\Models\Booking::where('room_id', $room->id)
                        ->where('status', '!=', 'cancelled')
                        ->where(function ($q) use ($checkIn, $checkOut) {
                          $q->whereBetween('check_in_date', [$checkIn, $checkOut])
                            ->orWhereBetween('check_out_date', [$checkIn, $checkOut])
                            ->orWhere(function ($query) use ($checkIn, $checkOut) {
                              $query->where('check_in_date', '<=', $checkIn)
                                    ->where('check_out_date', '>=', $checkOut);
                            });
                        })->exists();
                      $roomStatus = $roomAvailable && !$roomConflicts ? 'available' : 'unavailable';
                      $isCurrentlySelected = isset($contact->additional_data['room_id']) && $contact->additional_data['room_id'] == $room->id;
                    @endphp
                    
                    <div class="room-card {{ $roomStatus }} {{ $isCurrentlySelected ? 'currently-selected' : '' }}">
                      <div class="room-card-header">
                        <div class="room-title">
                          <h6 class="room-name">{{ $room->name }}</h6>
                          @if($isCurrentlySelected)
                            <span class="current-room-badge">
                              <i class="fas fa-star"></i> Currently Selected
                            </span>
                          @endif
                        </div>
                        <div class="room-status-indicator">
                          @if($roomStatus === 'available')
                            <span class="status-badge available">
                              <i class="fas fa-check-circle"></i> Available
                            </span>
                          @else
                            <span class="status-badge unavailable">
                              <i class="fas fa-times-circle"></i> Booked
                            </span>
                          @endif
                        </div>
                      </div>
                      
                      <div class="room-card-body">
                        <div class="room-features">
                          <div class="feature-item">
                            <i class="fas fa-money-bill-wave text-success"></i>
                            <span class="feature-label">Price per Night</span>
                            <span class="feature-value">PKR {{ number_format($room->price_per_night, 2) }}</span>
                          </div>
                          
                          <div class="feature-item">
                            <i class="fas fa-users text-info"></i>
                            <span class="feature-label">Capacity</span>
                            <span class="feature-value">{{ $room->capacity }} person(s)</span>
                          </div>
                          
                          <div class="feature-item">
                            <i class="fas fa-hashtag text-warning"></i>
                            <span class="feature-label">Room ID</span>
                            <span class="feature-value">#{{ $room->id }}</span>
                          </div>
                          
                          <div class="feature-item">
                            <i class="fas fa-bed text-primary"></i>
                            <span class="feature-label">Type</span>
                            <span class="feature-value">{{ ucfirst($room->room_type) }}</span>
                          </div>
                        </div>
                        
                        @if($roomStatus === 'available')
                          <div class="room-actions">
                            <button type="button" class="btn btn-primary btn-sm" 
                                    onclick="selectRoom({{ $room->id }}, '{{ $room->name }}', {{ $room->price_per_night }})">
                              <i class="fas fa-check"></i> Select This Room
                            </button>
                            <button type="button" class="btn btn-outline-info btn-sm" 
                                    onclick="viewRoomDetails({{ $room->id }})">
                              <i class="fas fa-eye"></i> View Details
                            </button>
                          </div>
                        @else
                          <div class="room-unavailable-info">
                            <div class="unavailable-reason">
                              @if($roomConflicts)
                                <i class="fas fa-calendar-times text-danger"></i>
                                <span>Conflicting booking exists</span>
                              @else
                                <i class="fas fa-ban text-warning"></i>
                                <span>Room not available</span>
                              @endif
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm" disabled>
                              <i class="fas fa-times"></i> Not Available
                            </button>
                          </div>
                        @endif
                      </div>
                    </div>
                  @endforeach
                </div>
                
                <div class="room-selection-summary mt-4">
                  <div class="summary-card">
                    <div class="summary-header">
                      <h6><i class="fas fa-info-circle"></i> Room Selection Summary</h6>
                    </div>
                    <div class="summary-content">
                      <div class="summary-stats">
                        <div class="stat-item">
                          <span class="stat-number">{{ $allRoomsOfType->count() }}</span>
                          <span class="stat-label">Total {{ ucfirst($roomType) }} Rooms</span>
                        </div>
                        <div class="stat-item">
                          <span class="stat-number text-success">{{ $availableRoomsOfType }}</span>
                          <span class="stat-label">Available for Selected Dates</span>
                        </div>
                        <div class="stat-item">
                          <span class="stat-number text-danger">{{ $allRoomsOfType->count() - $availableRoomsOfType }}</span>
                          <span class="stat-label">Currently Booked</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              @if($conflictingBookings->count() > 0)
                <div class="conflicting-bookings mt-4">
                  <h6 class="text-warning mb-3">
                    <i class="fas fa-exclamation-triangle"></i> Conflicting Bookings
                  </h6>
                  <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                      <thead class="bg-warning text-dark">
                        <tr>
                          <th>Room</th>
                          <th>Guest</th>
                          <th>Check-in</th>
                          <th>Check-out</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($conflictingBookings->take(3) as $booking)
                          <tr>
                            <td>{{ $booking->room->name ?? 'N/A' }}</td>
                            <td>{{ $booking->customer_name ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}</td>
                            <td>
                              <span class="badge badge-{{ $booking->status === 'confirmed' ? 'success' : 'warning' }}">
                                {{ ucfirst($booking->status) }}
                              </span>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                    @if($conflictingBookings->count() > 3)
                      <p class="text-muted text-center">
                        <small>Showing first 3 conflicts. Total: {{ $conflictingBookings->count() }} conflicts</small>
                      </p>
                    @endif
                  </div>
                </div>
              @endif
            </div>
          </div>
          
          <div class="col-lg-4">
            <div class="availability-actions">
              @if($isAvailable)
                <div class="action-card success">
                  <div class="action-header">
                    <i class="fas fa-rocket"></i>
                    <h6>Ready to Book!</h6>
                  </div>
                  <p class="text-success">This room is available for your requested dates.</p>
                  <button type="button" class="btn btn-success btn-lg btn-block mb-3" data-toggle="modal" data-target="#approveBookingModal">
                    <i class="fas fa-check-circle"></i> Approve Booking
                  </button>
                </div>
              @else
                <div class="action-card warning">
                  <div class="action-header">
                    <i class="fas fa-clock"></i>
                    <h6>Alternative Options</h6>
                  </div>
                  <p class="text-warning">This room is not available. Consider alternatives:</p>
                  <ul class="alternative-options">
                    <li>Different dates</li>
                    <li>Other room types</li>
                    <li>Similar rooms</li>
                  </ul>
                </div>
              @endif
              
              <div class="action-buttons mt-3">
                <button type="button" class="btn btn-info btn-block mb-2" onclick="showAlternativeDates()">
                  <i class="fas fa-calendar-alt"></i> Check Other Dates
                </button>
                <button type="button" class="btn btn-secondary btn-block mb-2" onclick="showAllRooms()">
                  <i class="fas fa-list"></i> View All Rooms
                </button>
                <button type="button" class="btn btn-outline-primary btn-block" onclick="contactCustomer()">
                  <i class="fas fa-phone"></i> Contact Customer
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif
  
  <div class="col-lg-4">
    <!-- Status Updates -->
    <div class="card">
      <div class="card-header">
        <h4><i class="fas fa-history"></i> Status History</h4>
      </div>
      <div class="card-body">
        <div class="timeline">
          <div class="timeline-item">
            <div class="timeline-marker bg-primary"></div>
            <div class="timeline-content">
              <h6 class="timeline-title">Lead Created</h6>
              <p class="timeline-text">{{ $contact->created_at ? $contact->created_at->format('M d, Y H:i') : 'N/A' }}</p>
            </div>
          </div>
          
          @if($contact->status === 'contacted')
            <div class="timeline-item">
              <div class="timeline-marker bg-info"></div>
              <div class="timeline-content">
                <h6 class="timeline-title">Contacted</h6>
                <p class="timeline-text">Lead has been contacted</p>
              </div>
            </div>
          @endif
          
          @if($contact->status === 'converted')
            <div class="timeline-item">
              <div class="timeline-marker bg-success"></div>
              <div class="timeline-content">
                <h6 class="timeline-title">Converted to Booking</h6>
                <p class="timeline-text">Lead successfully converted to booking</p>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
    
    <!-- Add Note -->
    <div class="card">
      <div class="card-header">
        <h4><i class="fas fa-sticky-note"></i> Add Note</h4>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.leads.add-note', $contact) }}">
          @csrf
          <div class="form-group">
            <textarea name="note" class="form-control" rows="3" placeholder="Add a note about this lead..." required></textarea>
          </div>
          <button type="submit" class="btn btn-primary btn-block">
            <i class="fas fa-save"></i> Save Note
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Approve Booking Modal -->
@if($contact->status !== 'converted')
  <div class="modal fade" id="approveBookingModal" tabindex="-1" role="dialog" aria-labelledby="approveBookingModalLabel" aria-hidden="true" style="z-index: 99999 !important;">
    <div class="modal-dialog modal-lg" role="document" style="z-index: 100000 !important;">
      <div class="modal-content" style="z-index: 100001 !important; position: relative;">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="approveBookingModalLabel">
            <i class="fas fa-check-circle me-2"></i>
            Approve Booking & Convert to Customer
          </h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="{{ route('admin.leads.approve-booking', $contact) }}" id="approveBookingForm">
          @csrf
          <div class="modal-body">
            <!-- Customer Information Summary -->
            <div class="alert alert-info">
              <h6 class="mb-2"><i class="fas fa-user me-2"></i>Customer Information</h6>
              <div class="row">
                <div class="col-md-6">
                  <strong>Name:</strong> {{ $contact->name }}<br>
                  <strong>Email:</strong> {{ $contact->email }}
                </div>
                <div class="col-md-6">
                  <strong>Phone:</strong> {{ $contact->phone }}<br>
                  <strong>Source:</strong> {{ $contact->source ?? 'Website' }}
                </div>
              </div>
            </div>
            
            <!-- Room Assignment -->
            <div class="row mb-3">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="fw-bold">Assign Room <span class="text-danger">*</span></label>
                  <select name="assigned_room_id" class="form-control" id="roomSelect" required>
                    <option value="">Select Room</option>
                    @foreach($availableRooms ?? [] as $room)
                      <option value="{{ $room->id }}" data-price="{{ $room->price_per_night }}" data-capacity="{{ $room->capacity }}">
                        {{ $room->name }} - PKR {{ number_format($room->price_per_night, 2) }}/night
                      </option>
                    @endforeach
                  </select>
                  <small class="text-muted">Select an available room for this customer</small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="fw-bold">Room Details</label>
                  <div id="roomDetails" class="p-2 bg-light rounded">
                    <small class="text-muted">Select a room to see details</small>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Booking Details -->
            <div class="row mb-3">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="fw-bold">Check-in Date <span class="text-danger">*</span></label>
                  <input type="date" name="check_in_date" class="form-control" value="{{ $contact->getCheckInDate() }}" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="fw-bold">Check-out Date <span class="text-danger">*</span></label>
                  <input type="date" name="check_out_date" class="form-control" value="{{ $contact->getCheckOutDate() }}" required>
                </div>
              </div>
            </div>
            
            <!-- Financial Details -->
            <div class="row mb-3">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="fw-bold">Price per Night</label>
                  <input type="text" id="pricePerNight" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="fw-bold">Total Amount <span class="text-danger">*</span></label>
                  <input type="number" name="total_amount" id="totalAmount" class="form-control" step="0.01" min="0.01" required>
                  <small class="text-muted">Calculated automatically based on dates and room price</small>
                </div>
              </div>
            </div>
            
            <!-- Additional Information -->
            <div class="form-group">
              <label class="fw-bold">Admin Notes</label>
              <textarea name="admin_notes" class="form-control" rows="3" placeholder="Any additional notes for this booking, special requests, or customer preferences"></textarea>
            </div>
            
            <!-- Confirmation Checkbox -->
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" id="confirmApproval" required>
              <label class="form-check-label" for="confirmApproval">
                I confirm that this customer has been verified and the room is available for the selected dates
              </label>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
              <i class="fas fa-times me-1"></i>Cancel
            </button>
            <button type="submit" class="btn btn-success" id="approveBtn" disabled>
              <i class="fas fa-check me-1"></i>Approve & Convert to Booking
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endif

<!-- Add Note Modal -->
<div class="modal fade" id="addNoteModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Note</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{ route('admin.leads.add-note', $contact) }}">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label>Note</label>
            <textarea name="note" class="form-control" rows="4" placeholder="Add a note about this lead..." required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Note</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Room Availability Check Modal -->
<!-- REMOVED: No more popup modal -->
@endsection

@push('styles')
<style>
/* Complete Modal Fix - Remove all previous modal CSS */
.modal {
  z-index: 99999 !important;
}

.modal-backdrop {
  z-index: 99998 !important;
  opacity: 0.5 !important;
}

.modal-dialog {
  z-index: 100000 !important;
  position: relative;
}

.modal-content {
  z-index: 100001 !important;
  position: relative;
  pointer-events: auto !important;
}

/* Force modal above everything */
#approveBookingModal {
  z-index: 99999 !important;
}

#approveBookingModal .modal-dialog {
  z-index: 100000 !important;
}

#approveBookingModal .modal-content {
  z-index: 100001 !important;
}

/* Ensure form elements are clickable */
#approveBookingForm {
  pointer-events: auto !important;
}

#approveBookingForm * {
  pointer-events: auto !important;
}

/* Fix modal backdrop */
.modal-backdrop.show {
  opacity: 0.5 !important;
  z-index: 99998 !important;
}

/* Force modal visibility */
.modal.show {
  display: block !important;
  z-index: 99999 !important;
}

/* Remove any conflicting styles */
.modal.fade {
  z-index: 99999 !important;
}

.modal.fade.show {
  z-index: 99999 !important;
}

/* Professional Room Availability Styling */
.bg-gradient-primary {
  background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
}

.availability-overview {
  background: #ffffff;
  border-radius: 12px;
  padding: 20px;
}

.availability-details-card {
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  border: 2px solid #dee2e6;
  border-radius: 12px;
  padding: 25px;
  height: 100%;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.availability-details-card h6 {
  color: #495057;
  font-weight: 600;
  margin-bottom: 20px;
  border-bottom: 2px solid #007bff;
  padding-bottom: 10px;
}

.detail-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
  padding: 10px;
  background: #ffffff;
  border-radius: 8px;
  border-left: 4px solid #007bff;
}

.detail-item .label {
  font-weight: 600;
  color: #495057;
  font-size: 0.9em;
}

.detail-item .value {
  font-weight: 600;
  color: #212529;
}

.availability-status-display {
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  border: 2px solid #dee2e6;
  border-radius: 12px;
  padding: 25px;
  height: 100%;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.status-available, .status-unavailable {
  padding: 20px;
  border-radius: 10px;
}

.status-available {
  background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
  border: 2px solid #28a745;
}

.status-unavailable {
  background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
  border: 2px solid #dc3545;
}

.availability-stats {
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 20px 0;
  background: rgba(255,255,255,0.8);
  border-radius: 10px;
  padding: 15px;
}

.stat-item {
  text-align: center;
  flex: 1;
}

.stat-number {
  display: block;
  font-size: 2em;
  font-weight: 700;
  margin-bottom: 5px;
}

.stat-label {
  font-size: 0.9em;
  color: #6c757d;
  font-weight: 500;
}

.stat-divider {
  width: 2px;
  height: 40px;
  background: #dee2e6;
  margin: 0 20px;
}

.conflicting-bookings {
  background: #fff3cd;
  border: 2px solid #ffeaa7;
  border-radius: 10px;
  padding: 20px;
  margin-top: 20px;
}

.conflicting-bookings h6 {
  color: #856404;
  font-weight: 600;
  margin-bottom: 15px;
}

.conflicting-bookings .table {
  background: #ffffff;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.conflicting-bookings .table thead {
  background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%) !important;
}

.conflicting-bookings .table th {
  border: none;
  color: #212529 !important;
  font-weight: 600;
  padding: 12px 8px;
}

.conflicting-bookings .table td {
  padding: 10px 8px;
  vertical-align: middle;
}

.availability-actions {
  background: #ffffff;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.action-card {
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  border: 2px solid;
  border-radius: 10px;
  padding: 20px;
  margin-bottom: 20px;
  text-align: center;
}

.action-card.success {
  border-color: #28a745;
  background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
}

.action-card.warning {
  border-color: #ffc107;
  background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
}

.action-header {
  margin-bottom: 15px;
}

.action-header i {
  font-size: 2em;
  margin-bottom: 10px;
  display: block;
}

.action-header h6 {
  margin: 0;
  font-weight: 600;
  color: #212529;
}

.alternative-options {
  list-style: none;
  padding: 0;
  margin: 15px 0;
  text-align: left;
}

.alternative-options li {
  padding: 8px 0;
  border-bottom: 1px solid rgba(0,0,0,0.1);
  color: #856404;
  font-weight: 500;
}

.alternative-options li:last-child {
  border-bottom: none;
}

.alternative-options li:before {
  content: "•";
  color: #ffc107;
  font-weight: bold;
  margin-right: 10px;
}

.action-buttons .btn {
  border-radius: 8px;
  font-weight: 500;
  padding: 10px 15px;
  transition: all 0.3s ease;
}

.action-buttons .btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

/* Room Details Section Styling */
.room-info, .room-type-info, .booking-period, .booking-type-info, .guest-info, .budget-info, .source-info, .creator-info {
  background: #ffffff !important;
  border: 2px solid #e9ecef !important;
  border-radius: 12px;
  padding: 25px;
  margin-bottom: 20px;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
  transition: all 0.3s ease;
}

.room-info:hover, .room-type-info:hover, .booking-period:hover, .booking-type-info:hover, .guest-info:hover, .budget-info:hover, .source-info:hover, .creator-info:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

.room-info h6, .room-type-info h6, .booking-period h6, .booking-type-info h6, .guest-info h6, .budget-info h6, .source-info h6, .creator-info h6 {
  color: #212529 !important;
  font-weight: 600;
  margin-bottom: 20px;
  border-bottom: 2px solid #007bff;
  padding-bottom: 10px;
}

.room-info small, .room-type-info small, .booking-period small, .booking-type-info small, .guest-info small, .budget-info small, .source-info small, .creator-info small {
  color: #6c757d !important;
  font-weight: 500;
}

.room-info strong, .room-type-info strong, .booking-period strong, .booking-type-info strong, .guest-info strong, .budget-info strong, .source-info strong, .creator-info strong {
  color: #212529 !important;
  font-weight: 600;
}

/* Badge styling */
.badge {
  font-size: 0.9em;
  padding: 8px 12px;
  border-radius: 6px;
}

.badge-lg {
  font-size: 1em;
  padding: 10px 15px;
}

/* Text color fixes */
.text-primary {
  color: #007bff !important;
}

.text-success {
  color: #28a745 !important;
}

.text-warning {
  color: #ffc107 !important;
}

.text-info {
  color: #17a2b8 !important;
}

.text-secondary {
  color: #6c757d !important;
}

.text-danger {
  color: #dc3545 !important;
}

/* Card styling improvements */
.card {
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
  border: 1px solid #e9ecef;
  border-radius: 12px;
  overflow: hidden;
}

.card-header {
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  border-bottom: 2px solid #e9ecef;
  padding: 20px;
}

.card-header h4 {
  color: #212529 !important;
  font-weight: 600;
  margin: 0;
}

.card-body {
  padding: 25px;
}

/* Form styling */
.form-control {
  border: 2px solid #e9ecef;
  border-radius: 8px;
  padding: 12px 15px;
  transition: all 0.3s ease;
}

.form-control:focus {
  border-color: #007bff;
  box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
  transform: translateY(-1px);
}

/* Button styling */
.btn {
  border-radius: 8px;
  font-weight: 500;
  padding: 10px 20px;
  transition: all 0.3s ease;
}

.btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.btn-lg {
  padding: 15px 30px;
  font-size: 1.1em;
}

/* Ensure proper contrast */
.alert {
  border: 2px solid;
  border-radius: 10px;
  padding: 20px;
}

.alert-info {
  background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%) !important;
  border-color: #17a2b8 !important;
  color: #0c5460 !important;
}

.alert-success {
  background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%) !important;
  border-color: #28a745 !important;
  color: #155724 !important;
}

.alert-warning {
  background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%) !important;
  border-color: #ffc107 !important;
  color: #856404 !important;
}

.alert-danger {
  background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%) !important;
  border-color: #dc3545 !important;
  color: #721c24 !important;
}

/* Timeline styling */
.timeline {
  position: relative;
  padding-left: 30px;
}

.timeline-item {
  position: relative;
  margin-bottom: 20px;
}

.timeline-marker {
  position: absolute;
  left: -35px;
  top: 5px;
  width: 12px;
  height: 12px;
  border-radius: 50%;
  border: 3px solid #ffffff;
  box-shadow: 0 0 0 3px #007bff;
}

.timeline-content {
  background: #f8f9fa;
  border: 1px solid #e9ecef;
  border-radius: 8px;
  padding: 15px;
  margin-left: 10px;
}

.timeline-title {
  font-weight: 600;
  color: #212529;
  margin-bottom: 5px;
}

.timeline-text {
  color: #6c757d;
  margin: 0;
  font-size: 0.9em;
}

/* Dates Display Styling */
.dates-display {
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  border: 2px solid #dee2e6;
  border-radius: 15px;
  padding: 25px;
  margin-bottom: 30px;
}

.date-card {
  background: #ffffff;
  border: 2px solid #e9ecef;
  border-radius: 12px;
  padding: 20px;
  text-align: center;
  height: 100%;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
  transition: all 0.3s ease;
}

.date-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

.date-card.checkin {
  border-left: 5px solid #28a745;
}

.date-card.checkout {
  border-left: 5px solid #dc3545;
}

.date-icon {
  margin-bottom: 15px;
}

.date-label {
  color: #495057;
  font-weight: 600;
  margin-bottom: 10px;
  font-size: 0.9em;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.date-value {
  font-size: 1.3em;
  font-weight: 700;
  color: #212529;
  margin-bottom: 5px;
}

.date-time {
  color: #6c757d;
  font-size: 0.85em;
}

/* Room Change Options Styling */
.room-change-options {
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  border: 2px solid #dee2e6;
  border-radius: 15px;
  padding: 25px;
  margin-top: 30px;
}

.room-change-options h6 {
  color: #495057;
  font-weight: 600;
  margin-bottom: 20px;
  border-bottom: 2px solid #007bff;
  padding-bottom: 10px;
}

.room-option-card {
  background: #ffffff;
  border: 2px solid #e9ecef;
  border-radius: 12px;
  padding: 20px;
  height: 100%;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.room-option-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

.room-option-card.available {
  border-left: 5px solid #28a745;
}

.room-option-card.unavailable {
  border-left: 5px solid #dc3545;
  opacity: 0.7;
}

.room-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
  padding-bottom: 10px;
  border-bottom: 1px solid #e9ecef;
}

.room-name {
  font-weight: 600;
  color: #212529;
  margin: 0;
  font-size: 1.1em;
}

.room-status {
  font-size: 0.8em;
  padding: 5px 10px;
}

.room-details {
  margin-bottom: 15px;
}

.room-info-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 8px;
  padding: 5px 0;
}

.room-info-item .label {
  font-weight: 500;
  color: #6c757d;
  font-size: 0.85em;
}

.room-info-item .value {
  font-weight: 600;
  color: #212529;
  font-size: 0.9em;
}

.room-option-card .btn {
  border-radius: 8px;
  font-weight: 500;
  padding: 8px 12px;
  font-size: 0.9em;
  transition: all 0.3s ease;
}

.room-option-card .btn:hover:not(:disabled) {
  transform: translateY(-1px);
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.room-option-card .btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* Responsive improvements */
@media (max-width: 768px) {
  .availability-stats {
    flex-direction: column;
  }
  
  .stat-divider {
    width: 80%;
    height: 2px;
    margin: 15px 0;
  }
  
  .detail-item {
    flex-direction: column;
    align-items: flex-start;
  }
  
  .detail-item .value {
    margin-top: 5px;
  }
}

/* Business Room Analysis Styling */
.metric-card {
  transition: all 0.3s ease;
  border: none;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.metric-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.metric-icon {
  opacity: 0.8;
}

.bg-gradient-primary {
  background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
}

.bg-gradient-success {
  background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%) !important;
}

.bg-gradient-info {
  background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
}

.bg-gradient-warning {
  background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%) !important;
}

.timeline-card {
  border: 1px solid #e9ecef;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.timeline-item {
  transition: all 0.3s ease;
  border: 1px solid #e9ecef !important;
}

.timeline-item:hover {
  transform: translateX(5px);
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  border-color: #007bff !important;
}

.timeline-marker {
  min-width: 12px;
  min-height: 12px;
}

.availability-analysis {
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.alert {
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.stat-box {
  transition: all 0.3s ease;
  border: 1px solid #e9ecef !important;
}

.stat-box:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 20px rgba(0,0,0,0.1);
  border-color: #007bff !important;
}

.quick-actions {
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.quick-actions .btn {
  border-radius: 8px;
  font-weight: 600;
  transition: all 0.3s ease;
}

.quick-actions .btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 15px rgba(0,0,0,0.2);
}

.inventory-management {
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.table {
  border-radius: 8px;
  overflow: hidden;
}

.table thead th {
  background: #f8f9fa !important;
  border: none;
  padding: 15px 12px;
  font-weight: 700;
  color: #495057;
  text-transform: uppercase;
  font-size: 0.85em;
  letter-spacing: 0.5px;
}

.table tbody tr {
  transition: all 0.3s ease;
}

.table tbody tr:hover {
  background-color: #f8f9fa;
  transform: scale(1.01);
}

.table tbody td {
  padding: 15px 12px;
  vertical-align: middle;
  border: none;
  border-bottom: 1px solid #f1f3f4;
}

.table-warning {
  background-color: #fff3cd !important;
}

.table-warning:hover {
  background-color: #ffeaa7 !important;
}

.badge {
  font-weight: 600;
  padding: 8px 12px;
  border-radius: 20px;
  font-size: 0.8em;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.bg-primary {
  background-color: #007bff !important;
}

.bg-success {
  background-color: #28a745 !important;
}

.bg-danger {
  background-color: #dc3545 !important;
}

.bg-info {
  background-color: #17a2b8 !important;
}

.bg-warning {
  background-color: #ffc107 !important;
}

.bg-secondary {
  background-color: #6c757d !important;
}

.btn {
  border-radius: 8px;
  font-weight: 600;
  transition: all 0.3s ease;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  font-size: 0.85em;
}

.btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 15px rgba(0,0,0,0.2);
}

.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
}

.btn-success {
  background-color: #28a745;
  border-color: #28a745;
}

.btn-outline-primary {
  color: #007bff;
  border-color: #007bff;
}

.btn-outline-primary:hover {
  background-color: #007bff;
  border-color: #007bff;
}

.btn-outline-info {
  color: #17a2b8;
  border-color: #17a2b8;
}

.btn-outline-info:hover {
  background-color: #17a2b8;
  border-color: #17a2b8;
}

.btn-outline-secondary {
  color: #6c757d;
  border-color: #6c757d;
}

.btn-outline-secondary:hover {
  background-color: #6c757d;
  border-color: #6c757d;
}

/* Responsive Design */
@media (max-width: 768px) {
  .metric-card {
    margin-bottom: 15px;
  }
  
  .timeline-item {
    margin-bottom: 15px;
  }
  
  .quick-actions {
    margin-top: 20px;
  }
  
  .table-responsive {
    font-size: 0.9em;
  }
  
  .btn {
    font-size: 0.8em;
    padding: 8px 16px;
  }
}

@media (max-width: 480px) {
  .card-body {
    padding: 20px 15px;
  }
  
  .metric-card {
    padding: 20px 15px;
  }
  
  .timeline-card {
    padding: 20px 15px;
  }
  
  .availability-analysis {
    padding: 20px 15px;
  }
  
  .quick-actions {
    padding: 20px 15px;
  }
  
  .inventory-management {
    padding: 20px 15px;
  }
}
</style>
@endpush

@push('scripts')
<script>
// Complete Modal Fix - Consolidated JavaScript
$(document).ready(function() {
  console.log('Document ready - Starting modal fix...');
  
  // Force modal initialization
  initializeModalSystem();
  
  // Initialize form handlers
  initializeFormHandlers();
  
  // Test modal functionality
  testModalFunctionality();
});

// Modal System Initialization
function initializeModalSystem() {
  console.log('Initializing modal system...');
  
  // Force modal z-index
  $('#approveBookingModal').css({
    'z-index': '99999',
    'position': 'relative'
  });
  
  // Force modal dialog z-index
  $('#approveBookingModal .modal-dialog').css({
    'z-index': '100000',
    'position': 'relative'
  });
  
  // Force modal content z-index
  $('#approveBookingModal .modal-content').css({
    'z-index': '100001',
    'position': 'relative'
  });
  
  // Remove any existing event handlers
  $('#approveBookingModal').off();
  
  // Add proper modal event handlers
  $('#approveBookingModal').on('show.bs.modal', function(e) {
    console.log('Modal show event triggered');
    e.stopPropagation();
    
    // Force z-index again
    $(this).css('z-index', '99999');
    $(this).find('.modal-dialog').css('z-index', '100000');
    $(this).find('.modal-content').css('z-index', '100001');
    
    // Remove backdrop if exists
    $('.modal-backdrop').remove();
    
    // Force modal above everything
    setTimeout(() => {
      $(this).css('z-index', '99999');
      $(this).find('.modal-dialog').css('z-index', '100000');
      $(this).find('.modal-content').css('z-index', '100001');
    }, 100);
  });
  
  $('#approveBookingModal').on('shown.bs.modal', function(e) {
    console.log('Modal shown event triggered');
    
    // Force focus on first input
    $(this).find('input:first').focus();
    
    // Ensure modal is clickable
    $(this).css('pointer-events', 'auto');
    $(this).find('.modal-content').css('pointer-events', 'auto');
    
    console.log('Modal fully initialized and clickable');
  });
  
  $('#approveBookingModal').on('hide.bs.modal', function(e) {
    console.log('Modal hide event triggered');
  });
  
  $('#approveBookingModal').on('hidden.bs.modal', function(e) {
    console.log('Modal hidden event triggered');
  });
}

// Form Handlers Initialization
function initializeFormHandlers() {
  console.log('Initializing form handlers...');
  
  // Remove existing handlers
  $('#roomSelect').off();
  $('input[name="check_in_date"], input[name="check_out_date"]').off();
  $('#confirmApproval').off();
  $('#approveBookingForm').off();
  
  // Room selection change handler
  $('#roomSelect').on('change', function() {
    console.log('Room selection changed:', $(this).val());
    const selectedOption = $(this).find('option:selected');
    const price = selectedOption.data('price');
    const capacity = selectedOption.data('capacity');
    
    if (price) {
      $('#pricePerNight').val(`PKR ${parseFloat(price).toFixed(2)}`);
      calculateTotalAmount();
      
      // Show room details
      $('#roomDetails').html(`
        <strong>Room:</strong> ${selectedOption.text()}<br>
        <strong>Capacity:</strong> ${capacity} person(s)<br>
        <strong>Price:</strong> PKR ${parseFloat(price).toFixed(2)}/night
      `);
    } else {
      $('#pricePerNight').val('');
      $('#totalAmount').val('');
      $('#roomDetails').html('<small class="text-muted">Select a room to see details</small>');
    }
  });
  
  // Date change handlers
  $('input[name="check_in_date"], input[name="check_out_date"]').on('change', function() {
    console.log('Date changed:', $(this).val());
    calculateTotalAmount();
  });
  
  // Confirmation checkbox handler
  $('#confirmApproval').on('change', function() {
    console.log('Confirmation checkbox changed:', this.checked);
    $('#approveBtn').prop('disabled', !this.checked);
  });
  
  // Form submission handler - COMPLETE PREVENTION
  $('#approveBookingForm').on('submit', function(e) {
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    console.log('Form submission intercepted and prevented');
    
    // Show loading state
    const submitBtn = $('#approveBtn');
    const originalText = submitBtn.html();
    submitBtn.html('<i class="fas fa-spinner fa-spin me-1"></i>Processing...');
    submitBtn.prop('disabled', true);
    
    // Submit form via AJAX
    $.ajax({
      url: $(this).attr('action'),
      type: 'POST',
      data: $(this).serialize(),
      success: function(response) {
        console.log('AJAX success:', response);
        if (response.success) {
          // Show success message
          Swal.fire({
            title: '🎉 Booking Approved Successfully!',
            text: response.message,
            icon: 'success',
            confirmButtonText: 'View Booking',
            showCancelButton: true,
            cancelButtonText: 'Stay Here'
          }).then((result) => {
            if (result.isConfirmed) {
              // Redirect to booking details
              redirectToBooking(response.booking_id);
            } else {
              // Refresh the page to show updated status
              stayOnPage();
            }
          });
          
          // Close modal
          $('#approveBookingModal').modal('hide');
        } else {
          Swal.fire('Error', response.message || 'Failed to approve booking', 'error');
        }
      },
      error: function(xhr) {
        console.log('AJAX error:', xhr);
        let errorMessage = 'Failed to approve booking. Please try again.';
        
        if (xhr.responseJSON && xhr.responseJSON.message) {
          errorMessage = xhr.responseJSON.message;
        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
          const errors = xhr.responseJSON.errors;
          errorMessage = Object.values(errors).flat().join('\n');
        }
        
        Swal.fire('Error', errorMessage, 'error');
      },
      complete: function() {
        // Reset button state
        submitBtn.html(originalText);
        submitBtn.prop('disabled', false);
      }
    });
    
    return false; // Prevent form submission
  });
}

// Test Modal Functionality
function testModalFunctionality() {
  console.log('Testing modal functionality...');
  
  // Test button click
  $('button[data-target="#approveBookingModal"]').on('click', function(e) {
    console.log('Modal button clicked');
    
    // Force modal open
    setTimeout(() => {
      $('#approveBookingModal').modal('show');
    }, 100);
  });
}

// Calculate total amount
function calculateTotalAmount() {
  console.log('Calculating total amount...');
  const checkIn = $('input[name="check_in_date"]').val();
  const checkOut = $('input[name="check_out_date"]').val();
  const pricePerNight = parseFloat($('#roomSelect option:selected').data('price'));
  
  console.log('Check-in:', checkIn, 'Check-out:', checkOut, 'Price:', pricePerNight);
  
  if (checkIn && checkOut && pricePerNight) {
    const startDate = new Date(checkIn);
    const endDate = new Date(checkOut);
    const nights = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
    
    if (nights > 0) {
      const totalAmount = nights * pricePerNight;
      $('#totalAmount').val(totalAmount.toFixed(2));
      console.log('Total calculated:', totalAmount, 'for', nights, 'nights');
    }
  }
}

function sendEmail() {
  alert('Email functionality will be implemented here.');
}

function sendSMS() {
  alert('SMS functionality will be implemented here.');
}

function checkOtherDates() {
  // Show a simple alert with instructions instead of popup
  alert('To check other dates:\n1. Go to the booking approval form\n2. Change the dates\n3. The system will automatically check availability');
  
  // Optionally open the approve booking modal
  $('#approveBookingModal').modal('show');
}

function showRoomOptions() {
  // Show all available rooms in a simple way
  const roomType = '{{ $contact->additional_data["room_type"] ?? "" }}';
  if (roomType) {
    alert(`Available ${roomType} rooms:\n\nCheck the "Approve Booking" form to see all available rooms of this type.`);
    $('#approveBookingModal').modal('show');
  } else {
    alert('No specific room type requested. Check the "Approve Booking" form to see all available rooms.');
    $('#approveBookingModal').modal('show');
  }
}

function updateStatus(status) {
  if (confirm('Are you sure you want to mark this lead as ' + status + '?')) {
    $.ajax({
      url: "{{ route('admin.leads.status', $contact) }}",
      type: 'PATCH',
      data: {
        _token: "{{ csrf_token() }}",
        status: status
      },
      success: function(response) {
        if (response.success) {
          alert(response.message);
          location.reload();
        } else {
          alert(response.message || 'Failed to update status.');
        }
      },
      error: function(xhr, status, error) {
        alert('Error updating status: ' + error);
      }
    });
  }
}

function showAlternativeDates() {
  alert('To check alternative dates, please go to the "Approve Booking" form and change the dates.');
  $('#approveBookingModal').modal('show');
}

function showAllRooms() {
  alert('To view all available rooms, please go to the "Approve Booking" form and select a different date range.');
  $('#approveBookingModal').modal('show');
}

function showAllRoomOptions() {
  const roomType = '{{ $contact->additional_data["room_type"] ?? "" }}';
  if (roomType) {
    Swal.fire({
      title: `${ucfirst(roomType)} Rooms`,
      text: `Showing all available ${roomType} rooms. Scroll through the room options below to see all rooms.`,
      icon: 'info',
      confirmButtonText: 'Got it!'
    });
  } else {
    Swal.fire({
      title: 'All Rooms',
      text: 'Showing all available rooms. Scroll through the room options below to see all rooms.',
      icon: 'info',
      confirmButtonText: 'Got it!'
    });
  }
}

// Test function to verify approval process
function testApproval() {
  console.log('Testing approval process...');
  
  $.ajax({
    url: "{{ route('admin.leads.test-approval', $contact) }}",
    type: 'GET',
    success: function(response) {
      console.log('Test response:', response);
      Swal.fire({
        title: 'Test Successful!',
        text: response.message,
        icon: 'success',
        confirmButtonText: 'OK'
      });
    },
    error: function(xhr, status, error) {
      console.log('Test error:', {xhr, status, error});
      Swal.fire({
        title: 'Test Failed!',
        text: 'Error: ' + error,
        icon: 'error',
        confirmButtonText: 'OK'
      });
    }
  });
}

// Redirect functions for approval success
function redirectToBooking(bookingId) {
  console.log('Redirecting to booking:', bookingId);
  window.location.href = `/admin/bookings/${bookingId}`;
}

function stayOnPage() {
  Swal.close();
  location.reload();
}

// Enhanced selectRoom function
function selectRoom(roomId, roomName, roomPrice) {
  Swal.fire({
    title: 'Room Selected!',
    text: `${roomName} has been selected for this booking.`,
    icon: 'success',
    confirmButtonText: 'Proceed to Approval',
    showCancelButton: true,
    cancelButtonText: 'Select Another Room'
  }).then((result) => {
    if (result.isConfirmed) {
      // Store selected room info
      sessionStorage.setItem('selectedRoomId', roomId);
      sessionStorage.setItem('selectedRoomName', roomName);
      sessionStorage.setItem('selectedRoomPrice', roomPrice);
      
      // Open the approve booking modal
      $('#approveBookingModal').modal('show');
      
      // Pre-select the room
      setTimeout(() => {
        $('#roomSelect').val(roomId).trigger('change');
      }, 500);
    }
  });
}

function viewRoomDetails(roomId) {
  // Show loading
  Swal.fire({
    title: 'Loading Room Details...',
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    }
  });
  
  // Fetch room details via AJAX
  $.ajax({
    url: `/admin/rooms/${roomId}/details`,
    type: 'GET',
    success: function(response) {
      if (response.success) {
        const room = response.room;
        
        Swal.fire({
          title: room.name,
          html: `
            <div class="room-details-modal">
              <div class="detail-row">
                <strong>Room Type:</strong> ${room.room_type}
              </div>
              <div class="detail-row">
                <strong>Capacity:</strong> ${room.capacity} person(s)
              </div>
              <div class="detail-row">
                <strong>Price per Night:</strong> PKR ${parseFloat(room.price_per_night).toFixed(2)}
              </div>
              <div class="detail-row">
                <strong>Status:</strong> 
                <span class="badge badge-${room.is_available ? 'success' : 'danger'}">
                  ${room.is_available ? 'Available' : 'Not Available'}
                </span>
              </div>
              <div class="detail-row">
                <strong>Description:</strong> ${room.description || 'No description available'}
              </div>
            </div>
          `,
          confirmButtonText: 'Select This Room',
          showCancelButton: true,
          cancelButtonText: 'Close',
          width: '500px'
        }).then((result) => {
          if (result.isConfirmed) {
            selectRoom(room.id, room.name, room.price_per_night);
          }
        });
      } else {
        Swal.fire('Error', 'Failed to load room details.', 'error');
      }
    },
    error: function() {
      Swal.fire('Error', 'Failed to load room details. Please try again.', 'error');
    }
  });
}

function contactCustomer() {
  alert('To contact the customer, please use the communication history section.');
  // Optionally open the add note modal or a dedicated communication history modal
  $('#addNoteModal').modal('show');
}

document.addEventListener('DOMContentLoaded', function() {
  const roomSelect = document.querySelector('select[name="room_id"]');
  const checkInInput = document.querySelector('input[name="check_in_date"]');
  const checkOutInput = document.querySelector('input[name="check_out_date"]');
  const totalAmountInput = document.querySelector('input[name="total_amount"]');
  
  function calculateTotal() {
    if (roomSelect.value && checkInInput.value && checkOutInput.value) {
      const selectedOption = roomSelect.options[roomSelect.selectedIndex];
      const pricePerNight = parseFloat(selectedOption.dataset.price) || 0;
      
      const checkIn = new Date(checkInInput.value);
      const checkOut = new Date(checkOutInput.value);
      const nights = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));
      
      if (nights > 0) {
        totalAmountInput.value = (pricePerNight * nights).toFixed(2);
      }
    }
  }
  
  if (roomSelect) roomSelect.addEventListener('change', calculateTotal);
  if (checkInInput) checkInInput.addEventListener('change', calculateTotal);
  if (checkOutInput) checkOutInput.addEventListener('change', calculateTotal);
});

// Test function to force open modal
function testModal() {
  console.log('Testing modal...');
  console.log('Modal element:', $('#approveBookingModal'));
  console.log('Modal length:', $('#approveBookingModal').length);
  
  // Force open modal
  $('#approveBookingModal').modal('show');
  
  // Check if modal is visible
  setTimeout(() => {
    if ($('#approveBookingModal').hasClass('show')) {
      console.log('Modal opened successfully');
    } else {
      console.log('Modal failed to open');
    }
  }, 500);
}

// Test function to verify approval process
</script>
@endpush
