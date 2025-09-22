<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Book Room | Hosteller</title>
    
    <!-- Main Website CSS Files -->
    <link rel="stylesheet preload" as="style" href="{{ asset('css/preload.min.css') }}">
    <link rel="stylesheet preload" as="style" href="{{ asset('css/icomoon.css') }}">
    <link rel="stylesheet preload" as="style" href="{{ asset('css/libs.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bookings.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/floatbutton.min.css') }}">
    
    <!-- Flatpickr CSS for date picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <!-- Custom CSS for booking create -->
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
        .booking-form-section {
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
        
        .room-summary {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            border: 2px solid #667eea;
        }
        .room-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .room-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 15px;
            margin-right: 1.5rem;
        }
        .room-info h3 {
            margin: 0 0 0.5rem 0;
            color: #333;
            font-size: 1.5rem;
        }
        .room-info p {
            margin: 0 0 0.5rem 0;
            color: #6c757d;
        }
        .room-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #28a745;
        }
        
        .booking-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
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
        
        .price-summary {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 1.5rem;
            border-radius: 15px;
            border: 2px solid #667eea;
            margin-bottom: 2rem;
        }
        .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid #dee2e6;
        }
        .price-row:last-child {
            border-bottom: none;
            font-weight: bold;
            font-size: 1.2rem;
            color: #667eea;
        }
        
        .booking-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            padding-top: 2rem;
            border-top: 1px solid #e9ecef;
        }
        .btn {
            padding: 1rem 2rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
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
        
        @media (max-width: 768px) {
            .page_title {
                font-size: 2rem;
            }
            .booking-form {
                grid-template-columns: 1fr;
            }
            .room-header {
                flex-direction: column;
                text-align: center;
            }
            .room-image {
                margin-right: 0;
                margin-bottom: 1rem;
            }
            .booking-actions {
                flex-direction: column;
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
                <li><a class="link" href="{{ route('rooms') }}">Rooms</a></li>
                <li><a class="link" href="{{ route('rooms.detail', $room->id) }}">{{ $room->name }}</a></li>
                <li><span>Book Room</span></li>
            </ul>
            
            <h1 class="page_title">Book This Room</h1>
            <p class="page_subtitle">Complete your booking for {{ $room->name }}</p>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Booking Form -->
                    <div class="booking-form-section">
                        <h2 class="section-title">Booking Details</h2>
                        
                        <form action="{{ route('bookings.store', $room) }}" method="POST" id="bookingForm">
                            @csrf
                            
                            <div class="booking-form">
                                <div class="form-group">
                                    <label for="check_in_date">Check-in Date *</label>
                                    <input type="text" class="form-control @error('check_in_date') is-invalid @enderror" 
                                           id="check_in_date" name="check_in_date" 
                                           placeholder="Select check-in date" required>
                                    @error('check_in_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="check_out_date">Check-out Date *</label>
                                    <input type="text" class="form-control @error('check_out_date') is-invalid @enderror" 
                                           id="check_out_date" name="check_out_date" 
                                           placeholder="Select check-out date" required>
                                    @error('check_out_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="special_requests">Special Requests</label>
                                    <textarea class="form-control @error('special_requests') is-invalid @enderror" 
                                              id="special_requests" name="special_requests" rows="4" 
                                              placeholder="Any special requests or requirements..."></textarea>
                                    @error('special_requests')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="price-summary">
                                <h4 style="margin-bottom: 1rem; color: #333;">Price Summary</h4>
                                <div class="price-row">
                                    <span>Price per night:</span>
                                    <span>${{ number_format($room->price_per_night, 2) }}</span>
                                </div>
                                <div class="price-row">
                                    <span>Number of nights:</span>
                                    <span id="nightCount">0</span>
                                </div>
                                <div class="price-row">
                                    <span>Total amount:</span>
                                    <span id="totalAmount">$0.00</span>
                                </div>
                            </div>
                            
                            <div class="booking-actions">
                                <a href="{{ route('rooms.detail', $room->id) }}" class="btn btn-outline-primary">
                                    <i class="icon-arrow-left icon me-2"></i>Back to Room
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="icon-check icon me-2"></i>Confirm Booking
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <!-- Room Summary -->
                    <div class="room-summary">
                        <h3 class="section-title">Room Summary</h3>
                        
                        <div class="room-header">
                            @if($room->image)
                                <img src="{{ asset($room->image) }}" alt="{{ $room->name }}" class="room-image">
                            @else
                                <div class="room-image bg-light d-flex align-items-center justify-content-center">
                                    <i class="icon-bed icon fa-2x text-muted"></i>
                                </div>
                            @endif
                            <div class="room-info">
                                <h3>{{ $room->name }}</h3>
                                <p>{{ Str::limit($room->description, 100) }}</p>
                                <p><strong>Type:</strong> {{ ucfirst($room->room_type) }}</p>
                                <p><strong>Capacity:</strong> {{ $room->capacity }} Person</p>
                                <div class="room-price">${{ number_format($room->price_per_night, 2) }} / night</div>
                            </div>
                        </div>
                        
                        @if($room->amenities && is_array($room->amenities) && count($room->amenities) > 0)
                            <h4 style="margin-bottom: 1rem; color: #333;">Amenities</h4>
                            <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                @foreach(array_slice($room->amenities, 0, 6) as $amenity)
                                    <span style="background: #667eea; color: white; padding: 0.25rem 0.5rem; border-radius: 15px; font-size: 0.8rem;">
                                        {{ $amenity }}
                                    </span>
                                @endforeach
                                @if(count($room->amenities) > 6)
                                    <span style="background: #6c757d; color: white; padding: 0.25rem 0.5rem; border-radius: 15px; font-size: 0.8rem;">
                                        +{{ count($room->amenities) - 6 }} more
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('layout.footer')
    
    <!-- Flatpickr JS for date picker -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    <script>
        // Initialize date pickers
        flatpickr("#check_in_date", {
            minDate: "today",
            onChange: function(selectedDates, dateStr) {
                calculatePrice();
            }
        });
        
        flatpickr("#check_out_date", {
            minDate: "today",
            onChange: function(selectedDates, dateStr) {
                calculatePrice();
            }
        });
        
        // Calculate price based on dates
        function calculatePrice() {
            const checkIn = document.getElementById('check_in_date').value;
            const checkOut = document.getElementById('check_out_date').value;
            
            if (checkIn && checkOut) {
                const checkInDate = new Date(checkIn);
                const checkOutDate = new Date(checkOut);
                const nights = Math.ceil((checkOutDate - checkInDate) / (1000 * 60 * 60 * 24));
                
                if (nights > 0) {
                    const totalAmount = nights * {{ $room->price_per_night }};
                    document.getElementById('nightCount').textContent = nights;
                    document.getElementById('totalAmount').textContent = '$' + totalAmount.toFixed(2);
                } else {
                    document.getElementById('nightCount').textContent = '0';
                    document.getElementById('totalAmount').textContent = '$0.00';
                }
            }
        }
        
        // Form validation
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            const checkIn = document.getElementById('check_in_date').value;
            const checkOut = document.getElementById('check_out_date').value;
            
            if (!checkIn || !checkOut) {
                e.preventDefault();
                alert('Please select both check-in and check-out dates.');
                return;
            }
            
            const checkInDate = new Date(checkIn);
            const checkOutDate = new Date(checkOut);
            const nights = Math.ceil((checkOutDate - checkInDate) / (1000 * 60 * 60 * 24));
            
            if (nights <= 0) {
                e.preventDefault();
                alert('Check-out date must be after check-in date.');
                return;
            }
        });
    </script>
</body>
</html>
