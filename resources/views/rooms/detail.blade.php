<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $room->name }} | Hosteller</title>
    
    <!-- Main Website CSS Files -->
    <link rel="stylesheet preload" as="style" href="{{ asset('css/preload.min.css') }}">
    <link rel="stylesheet preload" as="style" href="{{ asset('css/icomoon.css') }}">
    <link rel="stylesheet preload" as="style" href="{{ asset('css/libs.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/room.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/floatbutton.min.css') }}">
    
    <!-- Flatpickr CSS for date picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <!-- Custom CSS for redesigned room detail -->
    <style>
        /* Hero Section with Animations */
        .room-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 6rem 0 3rem;
            position: relative;
            overflow: hidden;
            margin-top: 0;
        }
        .room-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
            animation: float 20s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            25% { transform: translateY(-10px) rotate(1deg); }
            50% { transform: translateY(5px) rotate(-1deg); }
            75% { transform: translateY(-5px) rotate(0.5deg); }
        }
        
        .room-hero::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            right: -50%;
            bottom: -50%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.1; }
            50% { transform: scale(1.1); opacity: 0.2; }
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
            font-size: 3.5rem;
            font-weight: 800;
            margin: 0 0 1rem 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            animation: slideInDown 1s ease-out;
        }
        
        @keyframes slideInDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        .room-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            animation: slideInUp 1s ease-out 0.3s both;
        }
        
        @keyframes slideInUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        .room-meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        .meta-item {
            text-align: center;
            background: rgba(255,255,255,0.15);
            padding: 1.5rem 1rem;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            animation: fadeInScale 0.8s ease-out both;
            transition: all 0.3s ease;
        }
        
        .meta-item:nth-child(1) { animation-delay: 0.5s; }
        .meta-item:nth-child(2) { animation-delay: 0.7s; }
        .meta-item:nth-child(3) { animation-delay: 0.9s; }
        .meta-item:nth-child(4) { animation-delay: 1.1s; }
        
        .meta-item:hover {
            transform: translateY(-5px);
            background: rgba(255,255,255,0.25);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        @keyframes fadeInScale {
            from {
                transform: scale(0.8);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }
        .meta-item i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            display: block;
        }
        .meta-item .value {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0.25rem;
        }
        .meta-item .label {
            font-size: 0.9rem;
            opacity: 0.8;
        }
        
        .main-content {
            padding: 3rem 0;
        }
        .image-gallery {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            animation: fadeInUp 1s ease-out 0.5s both;
        }
        
        @keyframes fadeInUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        .main-image-container {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }
        .main-image {
            width: 100%;
            height: 500px;
            object-fit: cover;
            transition: transform 0.3s ease;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .main-image:hover {
            transform: scale(1.02);
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
        }

        .thumbnail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
        }
        .thumbnail-image {
            width: 100%;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 3px solid transparent;
        }
        .thumbnail-image:hover {
            transform: scale(1.05);
            border-color: #667eea;
        }
        .thumbnail-image.active {
            border-color: #667eea;
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.5);
        }
        
        .room-info-section {
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
            animation: slideInLeft 0.8s ease-out;
        }
        
        @keyframes slideInLeft {
            from {
                transform: translateX(-30px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        .room-description {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
            margin-bottom: 2rem;
        }
        .amenities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin: 1.5rem 0;
        }
        .amenity-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #667eea;
            animation: fadeInRight 0.6s ease-out both;
            transition: all 0.3s ease;
        }
        
        .amenity-item:nth-child(1) { animation-delay: 0.2s; }
        .amenity-item:nth-child(2) { animation-delay: 0.4s; }
        .amenity-item:nth-child(3) { animation-delay: 0.6s; }
        .amenity-item:nth-child(4) { animation-delay: 0.8s; }
        .amenity-item:nth-child(5) { animation-delay: 1.0s; }
        .amenity-item:nth-child(6) { animation-delay: 1.2s; }
        
        .amenity-item:hover {
            transform: translateX(10px);
            background: #e9ecef;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        @keyframes fadeInRight {
            from {
                transform: translateX(30px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        .amenity-item i {
            color: #667eea;
            margin-right: 0.75rem;
            font-size: 1.2rem;
        }
        .rules-box {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 1.5rem;
            border-radius: 15px;
            border-left: 4px solid #28a745;
        }
        
        .hostel-profile-section {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .hostel-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .hostel-logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 1.5rem;
            border: 3px solid rgba(255,255,255,0.2);
        }
        .hostel-info h3 {
            margin: 0 0 0.5rem 0;
            font-size: 1.5rem;
        }
        .hostel-info p {
            margin: 0;
            opacity: 0.8;
        }
        .verification-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.9rem;
            margin-top: 1rem;
        }
        .verification-badge.verified {
            background: rgba(40, 167, 69, 0.8);
        }
        .verification-badge.unverified {
            background: rgba(220, 53, 69, 0.8);
        }
        .hostel-contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }
        .contact-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
        }
        .contact-item i {
            margin-right: 0.75rem;
            font-size: 1.2rem;
        }
        
        .booking-section {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        .booking-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .booking-form .row {
            margin: 0;
        }
        
        .booking-form .col-md-6 {
            padding: 0 0.75rem;
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
        
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
            display: block;
        }
        .price-summary {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.1);
            margin-top: 1.5rem;
            border: 2px solid #667eea;
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
            color: #28a745;
        }
        
        .contact-form-section {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        .contact-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        .contact-form .form-group:last-child {
            grid-column: 1 / -1;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        .similar-rooms-section {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .similar-room-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .similar-room-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }
        .similar-room-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .similar-room-content {
            padding: 1.5rem;
        }
        .similar-room-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #333;
        }
        .similar-room-price {
            color: #28a745;
            font-weight: bold;
            font-size: 1.1rem;
        }
        
        @media (max-width: 768px) {
            .page_title {
                font-size: 2.5rem;
            }
            .room-meta-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .booking-form, .contact-form {
                grid-template-columns: 1fr;
            }
            .room-hero {
                padding: 4rem 0 2rem;
            }
        }
        
        /* Additional Enhancements */
        .room-info-section {
            animation: fadeInUp 1s ease-out 0.8s both;
        }
        
        .hostel-profile-section {
            animation: fadeInUp 1s ease-out 1s both;
        }
        
        .booking-section {
            animation: fadeInUp 1s ease-out 1.2s both;
        }
        
        .contact-form-section {
            animation: fadeInUp 1s ease-out 1.4s both;
        }
        
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Loading animation for images */
        .image-loading {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }
        
        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        
        /* Booking Form Styles */
        .booking-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 2rem;
            border-radius: 15px;
            margin: 2rem 0;
        }
        
        .booking-actions {
            margin-top: 1.5rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
            padding: 1rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        
        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .auth-required {
            text-align: center;
            padding: 2rem;
        }
        
        .auth-required .alert {
            border: none;
            border-radius: 15px;
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        }
        
        .auth-buttons {
            margin-top: 1rem;
        }
        
        .auth-buttons .btn {
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    @include('layout.header')

    <!-- Room Hero Section -->
    <header class="room-hero">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a class="link" href="{{ route('index') }}">Home</a></li>
                <li><a class="link" href="{{ route('rooms') }}">Rooms</a></li>
                <li><span>{{ $room->name }}</span></li>
            </ul>
            
            <h1 class="page_title">{{ $room->name }}</h1>
            <p class="room-subtitle">{{ Str::limit($room->description, 150) }}</p>
            
            <div class="room-meta-grid">
                <div class="meta-item">
                    <i class="icon-user icon"></i>
                    <div class="value">{{ $room->capacity }}</div>
                    <div class="label">Person</div>
                </div>
                <div class="meta-item">
                    <i class="icon-bed icon"></i>
                    <div class="value">{{ ucfirst($room->room_type) }}</div>
                    <div class="label">Room Type</div>
                </div>
                <div class="meta-item">
                    <i class="icon-star icon"></i>
                    <div class="value">Available</div>
                    <div class="label">Status</div>
                </div>
                <div class="meta-item">
                    <i class="icon-dollar icon"></i>
                                                    <div class="value">PKR {{ number_format($room->price_per_night, 2) }}</div>
                    <div class="label">Per Night</div>
                </div>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <div class="row">
                <!-- Left Column - Main Content -->
                <div class="col-lg-8">
                    <!-- Image Gallery -->
                    <div class="image-gallery">
                        <h2 class="section-title">Room Photos</h2>
                        
                        @if($room->image || ($room->images && is_array($room->images) && count($room->images) > 0))
                            <div class="main-image-container">
                                <img src="{{ asset($room->image) }}" alt="{{ $room->name }}" 
                                     class="main-image" id="mainImage">
                            </div>
                            
                            @if($room->images && is_array($room->images) && count($room->images) > 0)
                                @php
                                    $validImages = array_filter($room->images, function($image) {
                                        return is_string($image) && !empty($image) && $image !== '{}';
                                    });
                                @endphp
                                @if(count($validImages) > 0)
                                    <div class="thumbnail-grid">
                                        @foreach($validImages as $index => $image)
                                            <img src="{{ asset($image) }}" alt="Room Image {{ $index + 1 }}" 
                                                 class="thumbnail-image" 
                                                 onclick="changeMainImage('{{ asset($image) }}', this)"
                                                 data-original="{{ asset($room->image) }}">
                                        @endforeach
                                    </div>
                                @endif
                            @endif
                        @else
                            <div class="text-center py-5">
                                <i class="icon-image icon fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No images available for this room</p>
                            </div>
                        @endif
                    </div>

                    <!-- Room Information -->
                    <div class="room-info-section">
                        <h2 class="section-title">Room Details</h2>
                        
                        <div class="room-description">
                            {{ $room->description }}
                        </div>

                        @if($room->amenities && is_array($room->amenities) && count($room->amenities) > 0)
                            <h3 style="margin-bottom: 1rem; color: #333;">Amenities</h3>
                            <div class="amenities-grid">
                                @foreach($room->amenities as $amenity)
                                    <div class="amenity-item">
                                        <i class="icon-check icon"></i>
                                        <span>{{ $amenity }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if($room->rules)
                            <h3 style="margin: 2rem 0 1rem 0; color: #333;">Room Rules & Policies</h3>
                            <div class="rules-box">
                                {{ $room->rules }}
                            </div>
                        @endif
                    </div>

                    <!-- Similar Rooms -->
                    @if(isset($similarRooms) && $similarRooms->count() > 0)
                        <div class="similar-rooms-section">
                            <h2 class="section-title">Similar Rooms</h2>
                            <div class="row">
                                @foreach($similarRooms as $similarRoom)
                                    <div class="col-md-6 mb-4">
                                        <div class="similar-room-card">
                                            @if($similarRoom->image)
                                                <img src="{{ asset($similarRoom->image) }}" alt="{{ $similarRoom->name }}" 
                                                     class="similar-room-image">
                                            @endif
                                            <div class="similar-room-content">
                                                <h4 class="similar-room-title">{{ $similarRoom->name }}</h4>
                                                <p class="text-muted mb-2">{{ Str::limit($similarRoom->description, 80) }}</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="similar-room-price">PKR {{ number_format($similarRoom->price_per_night, 2) }}</span>
                                                    <a href="{{ route('rooms.detail', $similarRoom->id) }}" class="btn btn-primary btn-sm">
                                                        View Details
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column - Sidebar -->
                <div class="col-lg-4">
                    <!-- Hostel Profile -->
                    <div class="hostel-profile-section">
                        <div class="hostel-header">
                            @if($room->user->profile_image)
                                <img src="{{ asset($room->user->profile_image) }}" alt="Hostel Logo" class="hostel-logo">
                            @else
                                <div class="hostel-logo bg-white d-flex align-items-center justify-content-center">
                                    <i class="icon-building icon fa-2x text-dark"></i>
                                </div>
                            @endif
                            <div class="hostel-info">
                                <h3>{{ $room->user->hostel_name ?: $room->user->name }}</h3>
                                <p>{{ $room->user->bio ?: 'Professional hostel accommodation provider' }}</p>
                            </div>
                        </div>
                        
                        <div class="verification-badge {{ $room->user->is_verified ? 'verified' : 'unverified' }}">
                            <i class="icon-{{ $room->user->is_verified ? 'check' : 'close' }} icon me-2"></i>
                            {{ $room->user->is_verified ? 'Verified Hostel' : 'Unverified' }}
                        </div>
                        
                        <div class="hostel-contact-grid">
                            @if($room->user->phone)
                                <div class="contact-item">
                                    <i class="icon-call icon"></i>
                                    <span>{{ $room->user->phone }}</span>
                                </div>
                            @endif
                            
                            @if($room->user->email)
                                <div class="contact-item">
                                    <i class="icon-mail icon"></i>
                                    <span>{{ $room->user->email }}</span>
                                </div>
                            @endif
                            
                            @if($room->user->address)
                                <div class="contact-item">
                                    <i class="icon-location icon"></i>
                                    <span>{{ $room->user->address }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Booking Section -->
                    <div class="booking-section">
                        <h2 class="section-title">Book This Room</h2>
                        
                        @auth
                            <form id="bookingForm" action="{{ route('bookings.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="room_id" value="{{ $room->id }}">
                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                
                                <div class="booking-form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Check-in Date</label>
                                                <input type="text" class="form-control" id="checkInDate" name="check_in_date" 
                                                       placeholder="Select check-in date" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Check-out Date</label>
                                                <input type="text" class="form-control" id="checkOutDate" name="check_out_date" 
                                                       placeholder="Select check-out date" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Number of Guests</label>
                                                <input type="number" class="form-control" id="guestCount" name="guest_count" 
                                                       min="1" max="{{ $room->capacity }}" value="1" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Special Requests</label>
                                                <textarea class="form-control" name="special_requests" rows="3" 
                                                          placeholder="Any special requirements or requests..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="price-summary">
                                    <h4 style="margin-bottom: 1rem; color: #333;">Price Summary</h4>
                                    <div class="price-row">
                                        <span>Price per night:</span>
                                        <span>PKR {{ number_format($room->price_per_night, 2) }}</span>
                                    </div>
                                    <div class="price-row">
                                        <span>Number of nights:</span>
                                        <span id="nightCount">0</span>
                                    </div>
                                    <div class="price-row">
                                        <span>Total price:</span>
                                        <span id="totalPrice">PKR 0.00</span>
                                    </div>
                                    
                                    <div class="booking-actions mt-3">
                                        <button type="submit" class="btn btn-primary btn-lg w-100" id="bookNowBtn">
                                            <i class="fas fa-calendar-check me-2"></i>Book Now
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="auth-required">
                                <div class="alert alert-info">
                                    <h5><i class="fas fa-info-circle me-2"></i>Login Required</h5>
                                    <p>You need to be logged in to book this room. Please login or create an account to continue.</p>
                                    <div class="auth-buttons">
                                        <a href="{{ route('login') }}" class="btn btn-primary me-2">
                                            <i class="fas fa-sign-in-alt me-2"></i>Login
                                        </a>
                                        <a href="{{ route('register') }}" class="btn btn-outline-primary">
                                            <i class="fas fa-user-plus me-2"></i>Register
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endauth
                    </div>

                    <!-- Contact Form -->
                    <div class="contact-form-section">
                        <h2 class="section-title">Contact Hostel Owner</h2>
                        
                        <form id="contactForm" action="{{ route('contact.room-inquiry') }}" method="POST">
                            @csrf
                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                            <input type="hidden" name="check_in_date" id="contactCheckIn">
                            <input type="hidden" name="check_out_date" id="contactCheckOut">
                            <input type="hidden" name="booking_type" id="contactBookingType">
                            <input type="hidden" name="guest_count" id="contactGuestCount">
                            
                            <div class="contact-form">
                                <div class="form-group">
                                    <label>Your Name</label>
                                    <input type="text" class="form-control" name="name" 
                                           value="{{ auth()->user()->name ?? '' }}" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input type="email" class="form-control" name="email" 
                                           value="{{ auth()->user()->email ?? '' }}" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="tel" class="form-control" name="phone" 
                                           value="{{ auth()->user()->phone ?? '' }}" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Message</label>
                                    <textarea class="form-control" name="message" rows="4" 
                                              placeholder="Tell us about your requirements, preferred dates, or any questions you have..." required></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="icon-send icon me-2"></i>Send Inquiry
                                    </button>
                                </div>
                            </div>
                            
                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    <i class="icon-info icon me-1"></i>
                                    Your inquiry will be sent directly to the hostel owner
                                </small>
                            </div>
                        </form>
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
        flatpickr("#checkInDate", {
            minDate: "today",
            onChange: function(selectedDates, dateStr) {
                document.getElementById('contactCheckIn').value = dateStr;
                calculatePrice();
            }
        });
        
        flatpickr("#checkOutDate", {
            minDate: "today",
            onChange: function(selectedDates, dateStr) {
                document.getElementById('contactCheckOut').value = dateStr;
                calculatePrice();
            }
        });
        
        // Add event listeners for form fields
        document.getElementById('guestCount').addEventListener('change', calculatePrice);
        document.getElementById('guestCount').addEventListener('input', calculatePrice);
        
        // Initialize book button state
        document.getElementById('bookNowBtn').disabled = true;
        
        // Calculate price based on dates and guest count
        function calculatePrice() {
            const checkIn = document.getElementById('checkInDate').value;
            const checkOut = document.getElementById('checkOutDate').value;
            const guestCount = document.getElementById('guestCount').value;
            
            if (checkIn && checkOut && guestCount) {
                const checkInDate = new Date(checkIn);
                const checkOutDate = new Date(checkOut);
                const nights = Math.ceil((checkOutDate - checkInDate) / (1000 * 60 * 60 * 24));
                
                if (nights > 0) {
                    const basePrice = {{ $room->price_per_night }} * nights;
                    
                    document.getElementById('nightCount').textContent = nights;
                    document.getElementById('totalPrice').textContent = 'PKR ' + basePrice.toFixed(2);
                    
                    // Update hidden fields for contact form
                    document.getElementById('contactCheckIn').value = checkIn;
                    document.getElementById('contactCheckOut').value = checkOut;
                    document.getElementById('contactGuestCount').value = guestCount;
                    
                    // Enable/disable book button
                    const bookBtn = document.getElementById('bookNowBtn');
                    if (bookBtn) {
                        bookBtn.disabled = false;
                        bookBtn.innerHTML = '<i class="fas fa-calendar-check me-2"></i>Book Now';
                    }
                } else {
                    document.getElementById('nightCount').textContent = '0';
                    document.getElementById('totalPrice').textContent = 'PKR 0.00';
                    
                    // Disable book button for invalid dates
                    const bookBtn = document.getElementById('bookNowBtn');
                    if (bookBtn) {
                        bookBtn.disabled = true;
                        bookBtn.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Invalid Dates';
                    }
                }
            }
        }
        
        // Change main image when thumbnail is clicked
        function changeMainImage(imageSrc, thumbnailElement) {
            document.getElementById('mainImage').src = imageSrc;
            
            // Update active thumbnail
            document.querySelectorAll('.thumbnail-image').forEach(thumb => {
                thumb.classList.remove('active');
            });
            thumbnailElement.classList.add('active');
        }
        
        // Handle contact form submission
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Your inquiry has been sent successfully! The hostel owner will contact you soon.');
                    this.reset();
                } else {
                    alert('There was an error sending your inquiry. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('There was an error sending your inquiry. Please try again.');
            });
        });
        
        // Update contact form when booking details change
        document.getElementById('guestCount').addEventListener('change', function() {
            document.getElementById('contactGuestCount').value = this.value;
        });
        
        document.getElementById('bookingType').addEventListener('change', function() {
            document.getElementById('contactBookingType').value = this.value;
            calculatePrice();
        });
    </script>
</body>
</html>
