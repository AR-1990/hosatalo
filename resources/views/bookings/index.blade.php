<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bookings | Hosteller</title>
    
    <!-- Main Website CSS Files -->
    <link rel="stylesheet preload" as="style" href="{{ asset('css/preload.min.css') }}">
    <link rel="stylesheet preload" as="style" href="{{ asset('css/icomoon.css') }}">
    <link rel="stylesheet preload" as="style" href="{{ asset('css/libs.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bookings.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/floatbutton.min.css') }}">
    
    <!-- Custom CSS for bookings -->
    <style>
        .bookings-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem 0 2rem;
            position: relative;
            overflow: hidden;
        }
        .bookings-hero::before {
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
            font-size: 3rem;
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
        .bookings-section {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
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
        
        .booking-card {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        .booking-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e9ecef;
        }
        .booking-id {
            font-weight: 600;
            color: #667eea;
            font-size: 1.1rem;
        }
        .booking-status {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.9rem;
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
        
        .booking-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .detail-item {
            display: flex;
            flex-direction: column;
        }
        .detail-label {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 0.25rem;
        }
        .detail-value {
            font-weight: 600;
            color: #333;
        }
        
        .room-assignment {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            border-left: 4px solid #28a745;
        }
        .room-assignment h5 {
            color: #28a745;
            margin-bottom: 0.5rem;
            font-size: 1rem;
        }
        .room-assignment p {
            margin: 0;
            color: #6c757d;
            font-size: 0.9rem;
        }
        .no-assignment {
            background: #fff3cd;
            border-left-color: #ffc107;
        }
        .no-assignment h5 {
            color: #856404;
        }
        
        .booking-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .btn-success {
            background: #28a745;
            color: white;
        }
        .btn-success:hover {
            background: #218838;
            transform: translateY(-1px);
        }
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-1px);
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
            transform: translateY(-1px);
        }
        
        .no-bookings {
            text-align: center;
            padding: 3rem 1rem;
        }
        .no-bookings i {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }
        .no-bookings h3 {
            color: #6c757d;
            margin-bottom: 1rem;
        }
        .no-bookings p {
            color: #6c757d;
            margin-bottom: 2rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 1.5rem;
            border-radius: 15px;
            text-align: center;
            border: 2px solid #667eea;
        }
        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            color: #667eea;
            margin-bottom: 0.5rem;
        }
        .stat-label {
            color: #6c757d;
            font-weight: 600;
        }
        
        @media (max-width: 768px) {
            .page_title {
                font-size: 2.5rem;
            }
            .booking-details {
                grid-template-columns: 1fr;
            }
            .booking-actions {
                flex-direction: column;
            }
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    @include('layout.header')

    <!-- Bookings Hero Section -->
    <header class="bookings-hero">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a class="link" href="{{ route('index') }}">Home</a></li>
                <li><span>Bookings</span></li>
            </ul>
            
            <h1 class="page_title">
                @if(auth()->user()->role === 'admin')
                    All Bookings
                @elseif(auth()->user()->role === 'client')
                    My Hostel Bookings
                @else
                    My Bookings
                @endif
            </h1>
            <p class="page_subtitle">
                @if(auth()->user()->role === 'admin')
                    Manage all bookings across the platform
                @elseif(auth()->user()->role === 'client')
                    View and manage bookings for your hostel rooms
                @else
                    Track your room bookings and reservations
                @endif
            </p>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <!-- Statistics -->
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'client')
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number">{{ $bookings->where('status', 'pending')->count() }}</div>
                        <div class="stat-label">Pending</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $bookings->where('status', 'confirmed')->count() }}</div>
                        <div class="stat-label">Confirmed</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $bookings->where('status', 'completed')->count() }}</div>
                        <div class="stat-label">Completed</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $bookings->where('status', 'cancelled')->count() }}</div>
                        <div class="stat-label">Cancelled</div>
                    </div>
                    @if(auth()->user()->role === 'admin')
                        <div class="stat-card">
                            <div class="stat-number">{{ $bookings->whereNotNull('assigned_room_id')->count() }}</div>
                            <div class="stat-label">Assigned</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">{{ $bookings->whereNull('assigned_room_id')->count() }}</div>
                            <div class="stat-label">Unassigned</div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Bookings List -->
            <div class="bookings-section">
                <h2 class="section-title">
                    @if(auth()->user()->role === 'admin')
                        All Bookings ({{ $bookings->count() }})
                    @elseif(auth()->user()->role === 'client')
                        My Hostel Bookings ({{ $bookings->count() }})
                    @else
                        My Bookings ({{ $bookings->count() }})
                    @endif
                </h2>

                @if($bookings->count() > 0)
                    @foreach($bookings as $booking)
                        <div class="booking-card">
                            <div class="booking-header">
                                <div class="booking-id">Booking #{{ $booking->id }}</div>
                                <div class="booking-status status-{{ $booking->status }}">
                                    {{ ucfirst($booking->status) }}
                                </div>
                            </div>

                            <div class="booking-details">
                                <div class="detail-item">
                                    <span class="detail-label">Guest</span>
                                    <span class="detail-value">
                                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'client')
                                            {{ $booking->user->name }}
                                        @else
                                            You
                                        @endif
                                    </span>
                                </div>
                                
                                <div class="detail-item">
                                    <span class="detail-label">Requested Room</span>
                                    <span class="detail-value">{{ $booking->room->name }}</span>
                                </div>
                                
                                @if($booking->assignedRoom)
                                    <div class="detail-item">
                                        <span class="detail-label">Assigned Room</span>
                                        <span class="detail-value">{{ $booking->assignedRoom->name }}</span>
                                    </div>
                                @endif
                                
                                <div class="detail-item">
                                    <span class="detail-label">Check-in</span>
                                    <span class="detail-value">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}</span>
                                </div>
                                
                                <div class="detail-item">
                                    <span class="detail-label">Check-out</span>
                                    <span class="detail-value">{{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}</span>
                                </div>
                                
                                <div class="detail-item">
                                    <span class="detail-label">Nights</span>
                                    <span class="detail-value">{{ $booking->number_of_nights }}</span>
                                </div>
                                
                                <div class="detail-item">
                                    <span class="detail-label">Total Amount</span>
                                    <span class="detail-value">${{ number_format($booking->total_amount, 2) }}</span>
                                </div>
                                
                                @if($booking->special_requests)
                                    <div class="detail-item">
                                        <span class="detail-label">Special Requests</span>
                                        <span class="detail-value">{{ $booking->special_requests }}</span>
                                    </div>
                                @endif
                                
                                <div class="detail-item">
                                    <span class="detail-label">Booked On</span>
                                    <span class="detail-value">{{ $booking->created_at->format('M d, Y H:i') }}</span>
                                </div>
                            </div>

                            <!-- Room Assignment Status -->
                            @if(auth()->user()->role === 'admin')
                                @if($booking->assignedRoom)
                                    <div class="room-assignment">
                                        <h5><i class="icon-check icon me-2"></i>Room Assigned</h5>
                                        <p><strong>Room:</strong> {{ $booking->assignedRoom->name }} | <strong>Type:</strong> {{ ucfirst($booking->assignedRoom->room_type) }}</p>
                                        @if($booking->admin_notes)
                                            <p><strong>Notes:</strong> {{ $booking->admin_notes }}</p>
                                        @endif
                                    </div>
                                @else
                                    <div class="room-assignment no-assignment">
                                        <h5><i class="icon-warning icon me-2"></i>Room Not Assigned</h5>
                                        <p>This booking needs a room assignment. Click "Assign Room" to assign an available room.</p>
                                    </div>
                                @endif
                            @endif

                            <div class="booking-actions">
                                <a href="{{ route('bookings.show', $booking) }}" class="btn btn-outline-primary">
                                    <i class="icon-eye icon me-2"></i>View Details
                                </a>
                                
                                @if(auth()->user()->role === 'admin')
                                    @if(!$booking->assignedRoom)
                                        <a href="{{ route('bookings.show', $booking) }}" class="btn btn-warning">
                                            <i class="icon-bed icon me-2"></i>Assign Room
                                        </a>
                                    @endif
                                    
                                    @if($booking->status === 'pending')
                                        <form action="{{ route('bookings.update-status', $booking) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="btn btn-success">
                                                <i class="icon-check icon me-2"></i>Confirm
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($booking->status === 'confirmed')
                                        <form action="{{ route('bookings.update-status', $booking) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="icon-check icon me-2"></i>Mark Complete
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if(in_array($booking->status, ['pending', 'confirmed']))
                                        <form action="{{ route('bookings.cancel', $booking) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                <i class="icon-close icon me-2"></i>Cancel
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
                                                <i class="icon-check icon me-2"></i>Confirm
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($booking->status === 'confirmed')
                                        <form action="{{ route('bookings.update-status', $booking) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="icon-check icon me-2"></i>Mark Complete
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if(in_array($booking->status, ['pending', 'confirmed']))
                                        <form action="{{ route('bookings.cancel', $booking) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                <i class="icon-close icon me-2"></i>Cancel
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    @if($booking->status === 'pending')
                                        <form action="{{ route('bookings.cancel', $booking) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                <i class="icon-close icon me-2"></i>Cancel Booking
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="no-bookings">
                        <i class="icon-calendar icon"></i>
                        <h3>No Bookings Found</h3>
                        <p>
                            @if(auth()->user()->role === 'admin')
                                There are no bookings in the system yet.
                            @elseif(auth()->user()->role === 'client')
                                No one has booked your hostel rooms yet.
                            @else
                                You haven't made any bookings yet.
                            @endif
                        </p>
                        @if(auth()->user()->role !== 'admin' && auth()->user()->role !== 'client')
                            <a href="{{ route('rooms') }}" class="btn btn-primary">
                                <i class="icon-search icon me-2"></i>Browse Rooms
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </main>

    @include('layout.footer')
</body>
</html>
