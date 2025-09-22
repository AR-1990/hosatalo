<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Booking #{{ $booking->id }} | Hosteller</title>
    
    <!-- Main Website CSS Files -->
    <link rel="stylesheet preload" as="style" href="{{ asset('css/preload.min.css') }}">
    <link rel="stylesheet preload" as="style" href="{{ asset('css/icomoon.css') }}">
    <link rel="stylesheet preload" as="style" href="{{ asset('css/libs.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bookings.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/floatbutton.min.css') }}">
    
    <!-- Custom CSS for booking show -->
    <style>
        .booking-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem 0 2rem;
            position: relative;
            overflow: hidden;
        }
        .booking-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        .breadcrumbs {
            list-style: none;
            padding: 0;
            margin: 0 0 2rem 0;
        }
        .breadcrumbs li {
            display: inline;
            color: rgba(255,255,255,0.8);
        }
        .breadcrumbs li:not(:last-child)::after {
            content: " > ";
            margin: 0 0.5rem;
            color: rgba(255,255,255,0.6);
        }
        .breadcrumbs .link {
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .breadcrumbs .link:hover {
            color: white;
        }
        .page_title {
            font-size: 2.5rem;
            font-weight: 800;
            margin: 0 0 1rem 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .page_subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .main-content {
            padding: 3rem 0;
        }
        .booking-detail-section {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        .section-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 3px solid #667eea;
            display: inline-block;
        }
        
        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #e9ecef;
        }
        .booking-id {
            font-size: 1.5rem;
            font-weight: 700;
            color: #667eea;
        }
        .booking-status {
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        .status-confirmed {
            background: #d1ecf1;
            color: #0c5460;
        }
        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }
        .status-completed {
            background: #d4edda;
            color: #155724;
        }
        
        .booking-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        .info-card {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 15px;
            border-left: 4px solid #667eea;
        }
        .info-label {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            font-weight: 600;
        }
        .info-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
        }
        
        .room-details {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
        }
        .room-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .room-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            margin-right: 1.5rem;
        }
        .room-info h3 {
            margin: 0 0 0.5rem 0;
            color: #333;
        }
        .room-info p {
            margin: 0;
            color: #6c757d;
        }
        
        .room-assignment-section {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        .room-assignment-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #333;
        }
        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }
        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .form-control.is-invalid {
            border-color: #dc3545;
        }
        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875rem;
            color: #dc3545;
        }
        
        .special-requests {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        .special-requests h4 {
            color: #856404;
            margin-bottom: 1rem;
        }
        .special-requests p {
            color: #856404;
            margin: 0;
        }
        
        .admin-notes-section {
            background: #e3f2fd;
            border: 1px solid #bbdefb;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        .admin-notes-section h4 {
            color: #1976d2;
            margin-bottom: 1rem;
        }
        .admin-notes-form {
            margin-top: 1rem;
        }
        
        .booking-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
            padding-top: 2rem;
            border-top: 1px solid #e9ecef;
        }
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        .btn-success {
            background: #28a745;
            color: white;
        }
        .btn-success:hover {
            background: #218838;
            transform: translateY(-2px);
        }
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
        }
        .btn-outline-primary {
            background: transparent;
            color: #667eea;
            border: 2px solid #667eea;
        }
        .btn-outline-primary:hover {
            background: #667eea;
            color: white;
        }
        .btn-warning {
            background: #ffc107;
            color: #212529;
        }
        .btn-warning:hover {
            background: #e0a800;
            transform: translateY(-2px);
        }
        
        .timeline {
            position: relative;
            padding-left: 2rem;
            margin: 2rem 0;
        }
        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #667eea;
        }
        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -2.5rem;
            top: 0.5rem;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #667eea;
            border: 3px solid white;
        }
        .timeline-date {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }
        .timeline-content {
            background: white;
            padding: 1rem;
            border-radius: 10px;
            border: 1px solid #e9ecef;
        }
        
        .available-rooms {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 15px;
            margin-top: 1rem;
        }
        .available-rooms h5 {
            color: #333;
            margin-bottom: 1rem;
        }
        .room-option {
            background: white;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            border: 2px solid #e9ecef;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .room-option:hover {
            border-color: #667eea;
            box-shadow: 0 2px 10px rgba(102, 126, 234, 0.1);
        }
        .room-option.selected {
            border-color: #28a745;
            background: #f8fff9;
        }
        
        @media (max-width: 768px) {
            .page_title {
                font-size: 2rem;
            }
            .booking-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            .booking-info-grid {
                grid-template-columns: 1fr;
            }
            .booking-actions {
                flex-direction: column;
            }
            .room-assignment-form {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    @include('layout.header')

    <!-- Booking Hero Section -->
    <header class="booking-hero">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a class="link" href="{{ route('index') }}">Home</a></li>
                <li><a class="link" href="{{ route('bookings.index') }}">Bookings</a></li>
                <li><span>Booking #{{ $booking->id }}</span></li>
            </ul>
            
            <h1 class="page_title">Booking #{{ $booking->id }}</h1>
            <p class="page_subtitle">
                @if(auth()->user()->role === 'admin')
                    Manage this booking
                @elseif(auth()->user()->role === 'client')
                    Hostel booking details
                @else
                    Your booking details
                @endif
            </p>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <!-- Booking Details -->
            <div class="booking-detail-section">
                <div class="booking-header">
                    <div class="booking-id">Booking #{{ $booking->id }}</div>
                    <div class="booking-status status-{{ $booking->status }}">
                        {{ ucfirst($booking->status) }}
                    </div>
                </div>

                <div class="booking-info-grid">
                    <div class="info-card">
                        <div class="info-label">Guest</div>
                        <div class="info-value">
                            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'client')
                                {{ $booking->user->name }}
                            @else
                                You
                            @endif
                        </div>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-label">Requested Room</div>
                        <div class="info-value">{{ $booking->room->name }}</div>
                    </div>
                    
                    @if($booking->assignedRoom)
                        <div class="info-card">
                            <div class="info-label">Assigned Room</div>
                            <div class="info-value">{{ $booking->assignedRoom->name }}</div>
                        </div>
                    @endif
                    
                    <div class="info-card">
                        <div class="info-label">Check-in Date</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}</div>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-label">Check-out Date</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}</div>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-label">Number of Nights</div>
                        <div class="info-value">{{ $booking->number_of_nights }}</div>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-label">Total Amount</div>
                        <div class="info-value">${{ number_format($booking->total_amount, 2) }}</div>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-label">Booking Date</div>
                        <div class="info-value">{{ $booking->created_at->format('M d, Y H:i') }}</div>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-label">Last Updated</div>
                        <div class="info-value">{{ $booking->updated_at->format('M d, Y H:i') }}</div>
                    </div>
                </div>

                <!-- Room Details -->
                <div class="room-details">
                    <h3 class="section-title">Requested Room Information</h3>
                    <div class="room-header">
                        @if($booking->room->image)
                            <img src="{{ asset($booking->room->image) }}" alt="{{ $booking->room->name }}" class="room-image">
                        @else
                            <div class="room-image bg-light d-flex align-items-center justify-content-center">
                                <i class="icon-bed icon fa-2x text-muted"></i>
                            </div>
                        @endif
                        <div class="room-info">
                            <h3>{{ $booking->room->name }}</h3>
                            <p>{{ $booking->room->description }}</p>
                            <p><strong>Type:</strong> {{ ucfirst($booking->room->room_type) }} | <strong>Capacity:</strong> {{ $booking->room->capacity }} Person</p>
                        </div>
                    </div>
                </div>

                <!-- Special Requests -->
                @if($booking->special_requests)
                    <div class="special-requests">
                        <h4><i class="icon-info icon me-2"></i>Special Requests</h4>
                        <p>{{ $booking->special_requests }}</p>
                    </div>
                @endif

                <!-- Admin Notes -->
                @if(auth()->user()->role === 'admin')
                    <div class="admin-notes-section">
                        <h4><i class="icon-edit icon me-2"></i>Admin Notes</h4>
                        @if($booking->admin_notes)
                            <p><strong>Current Notes:</strong> {{ $booking->admin_notes }}</p>
                        @else
                            <p><em>No admin notes yet.</em></p>
                        @endif
                        
                        <form action="{{ route('bookings.update-notes', $booking) }}" method="POST" class="admin-notes-form">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="admin_notes">Update Notes</label>
                                <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3" 
                                          placeholder="Add or update admin notes...">{{ $booking->admin_notes }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="icon-save icon me-2"></i>Update Notes
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Booking Timeline -->
                <div class="timeline">
                    <h3 class="section-title">Booking Timeline</h3>
                    
                    <div class="timeline-item">
                        <div class="timeline-date">{{ $booking->created_at->format('M d, Y H:i') }}</div>
                        <div class="timeline-content">
                            <strong>Booking Created</strong><br>
                            Booking was submitted and is pending confirmation.
                        </div>
                    </div>
                    
                    @if($booking->status !== 'pending')
                        <div class="timeline-item">
                            <div class="timeline-date">{{ $booking->updated_at->format('M d, Y H:i') }}</div>
                            <div class="timeline-content">
                                <strong>Status Updated</strong><br>
                                Booking status changed to {{ ucfirst($booking->status) }}.
                            </div>
                        </div>
                    @endif
                    
                    @if($booking->assignedRoom)
                        <div class="timeline-item">
                            <div class="timeline-date">{{ $booking->updated_at->format('M d, Y H:i') }}</div>
                            <div class="timeline-content">
                                <strong>Room Assigned</strong><br>
                                Room {{ $booking->assignedRoom->name }} was assigned to this booking.
                            </div>
                        </div>
                    @endif
                    
                    @if($booking->status === 'confirmed')
                        <div class="timeline-item">
                            <div class="timeline-date">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}</div>
                            <div class="timeline-content">
                                <strong>Check-in Date</strong><br>
                                Guest is expected to check in on this date.
                            </div>
                        </div>
                    @endif
                    
                    @if($booking->status === 'completed')
                        <div class="timeline-item">
                            <div class="timeline-date">{{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}</div>
                            <div class="timeline-content">
                                <strong>Check-out Date</strong><br>
                                Guest has checked out and booking is completed.
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="booking-actions">
                    <a href="{{ route('bookings.index') }}" class="btn btn-outline-primary">
                        <i class="icon-arrow-left icon me-2"></i>Back to Bookings
                    </a>
                    
                    @if(auth()->user()->role === 'admin')
                        @if($booking->status === 'pending')
                            <form action="{{ route('bookings.update-status', $booking) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit" class="btn btn-success">
                                    <i class="icon-check icon me-2"></i>Confirm Booking
                                </button>
                            </form>
                        @endif
                        
                        @if($booking->status === 'confirmed')
                            <form action="{{ route('bookings.update-status', $booking) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="btn btn-primary">
                                    <i class="icon-check icon me-2"></i>Mark as Completed
                                </button>
                            </form>
                        @endif
                        
                        @if(in_array($booking->status, ['pending', 'confirmed']))
                            <form action="{{ route('bookings.cancel', $booking) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this booking?')">
                                    <i class="icon-close icon me-2"></i>Cancel Booking
                                </button>
                            </form>
                        @endif
                    @elseif(auth()->user()->role === 'client')
                        @if($booking->status === 'pending')
                            <form action="{{ route('bookings.update-status', $booking) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit" class="btn btn-success">
                                    <i class="icon-check icon me-2"></i>Confirm Booking
                                </button>
                            </form>
                        @endif
                        
                        @if($booking->status === 'confirmed')
                            <form action="{{ route('bookings.update-status', $booking) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="btn btn-primary">
                                    <i class="icon-check icon me-2"></i>Mark as Completed
                                </button>
                            </form>
                        @endif
                        
                        @if(in_array($booking->status, ['pending', 'confirmed']))
                            <form action="{{ route('bookings.cancel', $booking) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this booking?')">
                                    <i class="icon-close icon me-2"></i>Cancel Booking
                                </button>
                            </form>
                        @endif
                    @else
                        @if($booking->status === 'pending')
                            <form action="{{ route('bookings.cancel', $booking) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this booking?')">
                                    <i class="icon-close icon me-2"></i>Cancel My Booking
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Room Assignment Section (Admin Only) -->
            @if(auth()->user()->role === 'admin')
                <div class="room-assignment-section">
                    <h2 class="section-title">
                        @if($booking->assignedRoom)
                            Room Assignment Management
                        @else
                            Assign Room to Booking
                        @endif
                    </h2>

                    @if($booking->assignedRoom)
                        <div class="room-assignment">
                            <h5><i class="icon-check icon me-2"></i>Currently Assigned Room</h5>
                            <p><strong>Room:</strong> {{ $booking->assignedRoom->name }} | <strong>Type:</strong> {{ ucfirst($booking->assignedRoom->room_type) }} | <strong>Capacity:</strong> {{ $booking->assignedRoom->capacity }} Person</p>
                            <p><strong>Description:</strong> {{ $booking->assignedRoom->description }}</p>
                        </div>
                    @endif

                    <form action="{{ route('bookings.assign-room', $booking) }}" method="POST" id="roomAssignmentForm">
                        @csrf
                        <div class="room-assignment-form">
                            <div class="form-group">
                                <label for="assigned_room_id">Select Room to Assign *</label>
                                <select class="form-control @error('assigned_room_id') is-invalid @enderror" 
                                        id="assigned_room_id" name="assigned_room_id" required>
                                    <option value="">Choose a room...</option>
                                    @foreach($availableRooms as $room)
                                        <option value="{{ $room->id }}" 
                                                {{ $booking->assigned_room_id == $room->id ? 'selected' : '' }}>
                                            {{ $room->name }} - {{ ucfirst($room->room_type) }} ({{ $room->capacity }} Person) - ${{ number_format($room->price_per_night, 2) }}/night
                                        </option>
                                    @endforeach
                                </select>
                                @error('assigned_room_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="admin_notes">Assignment Notes</label>
                                <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3" 
                                          placeholder="Add notes about this room assignment...">{{ $booking->admin_notes }}</textarea>
                            </div>
                        </div>

                        <div class="available-rooms">
                            <h5><i class="icon-info icon me-2"></i>Available Rooms for {{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}</h5>
                            <p><strong>Total Available:</strong> {{ $availableRooms->count() }} rooms</p>
                            <p><em>These rooms are available for the selected dates and won't conflict with other bookings.</em></p>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-warning">
                                <i class="icon-bed icon me-2"></i>
                                @if($booking->assignedRoom)
                                    Reassign Room
                                @else
                                    Assign Room
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </main>

    @include('layout.footer')
    
    <script>
        // Room selection highlighting
        document.getElementById('assigned_room_id').addEventListener('change', function() {
            const selectedRoomId = this.value;
            if (selectedRoomId) {
                // You can add additional logic here for room selection
                console.log('Selected room ID:', selectedRoomId);
            }
        });

        // Form validation
        document.getElementById('roomAssignmentForm').addEventListener('submit', function(e) {
            const assignedRoomId = document.getElementById('assigned_room_id').value;
            
            if (!assignedRoomId) {
                e.preventDefault();
                alert('Please select a room to assign.');
                return;
            }
        });
    </script>
</body>
</html>
