<!DOCTYPE html>
<html lang=en>
<head>
    <meta charset=UTF-8>
    <meta name=viewport content="width=device-width,initial-scale=1,minimum-scale=1">
    <meta http-equiv=X-UA-Compatible content="ie=edge">
    <title>{{ $hostel->hostel_name }} | Hosteller</title>
    <script id=www-widgetapi-script src=../../s.ytimg.com/yts/jsbin/www-widgetapi-vflS50iB-/www-widgetapi.js
        async=""></script>
    <script src=https://www.youtube.com/player_api></script>
    <link rel="stylesheet preload" as=style href={{ asset('css/preload.min.css') }}>
    <link rel="stylesheet preload" as=style href={{ asset('css/icomoon.css') }}>
    <link rel="stylesheet preload" as=style href={{ asset('css/libs.min.css') }}>
    <link rel=stylesheet href={{ asset('css/about.min.css') }}>
    <link rel=stylesheet href={{ asset('css/floatbutton.min.css') }}>
    <style>
        .hostel-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 80px 0;
            color: white;
            margin-bottom: 40px;
        }
        .hostel-hero h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .hostel-hero .location {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        .hostel-info {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .hostel-gallery {
            margin-bottom: 40px;
        }
        .gallery-image {
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .gallery-image img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        .hostel-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        .detail-item {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .detail-item i {
            font-size: 2rem;
            color: #667eea;
            margin-bottom: 10px;
        }
        .detail-item h4 {
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .detail-item p {
            color: #6c757d;
            margin: 0;
        }
        .hostel-description {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .hostel-description h3 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }
        .hostel-description p {
            color: #6c757d;
            line-height: 1.8;
            font-size: 1.1rem;
        }
        .back-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }
        .back-btn:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .amenities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        .amenity-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .amenity-item i {
            color: #667eea;
            font-size: 1.2rem;
        }
        .amenity-item span {
            color: #2c3e50;
            font-weight: 500;
        }
    </style>
</head>

<body>
    @include('layout.header')

    <header class=page>
        <div class=container>
            <ul class="breadcrumbs d-flex flex-wrap align-content-center">
                <li class=list-item><a class=link href={{ route('index') }}>Home</a></li>
                <li class=list-item><a class=link href={{ route('hostels') }}>Hostels</a></li>
                <li class=list-item><a class=link href=#>{{ $hostel->hostel_name }}</a></li>
            </ul>
            <h1 class=page_title>{{ $hostel->hostel_name }}</h1>
        </div>
    </header>

    <main>
        <!-- Hostel Hero Section -->
        <section class="hostel-hero">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h1>{{ $hostel->hostel_name }}</h1>
                        <div class="location">
                            <i class="icon-location"></i> 
                            {{ $hostel->city }}, {{ $hostel->state }}, {{ $hostel->country }}
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="{{ route('hostels') }}" class="back-btn">
                            <i class="icon-arrow_left"></i> Back to Hostels
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <div class="container">
            <!-- Hostel Gallery -->
            <section class="hostel-gallery">
                <div class="row">
                    @if($hostel->hostel_banner)
                        <div class="col-lg-6">
                            <div class="gallery-image">
                                <img src="{{ asset($hostel->hostel_banner) }}" alt="{{ $hostel->hostel_name }} Banner">
                            </div>
                        </div>
                    @endif
                    @if($hostel->hostel_logo)
                        <div class="col-lg-6">
                            <div class="gallery-image">
                                <img src="{{ asset($hostel->hostel_logo) }}" alt="{{ $hostel->hostel_name }} Logo">
                            </div>
                        </div>
                    @endif
                </div>
            </section>

            <!-- Hostel Information -->
            <section class="hostel-info">
                <h3>Hostel Information</h3>
                <div class="hostel-details">
                    @if($hostel->hostel_phone)
                        <div class="detail-item">
                            <i class="icon-phone"></i>
                            <h4>Phone</h4>
                            <p>{{ $hostel->hostel_phone }}</p>
                        </div>
                    @endif
                    @if($hostel->hostel_email)
                        <div class="detail-item">
                            <i class="icon-email"></i>
                            <h4>Email</h4>
                            <p>{{ $hostel->hostel_email }}</p>
                        </div>
                    @endif
                    @if($hostel->total_rooms)
                        <div class="detail-item">
                            <i class="icon-home"></i>
                            <h4>Total Rooms</h4>
                            <p>{{ $hostel->total_rooms }}</p>
                        </div>
                    @endif
                    @if($hostel->check_in_time)
                        <div class="detail-item">
                            <i class="icon-clock"></i>
                            <h4>Check-in Time</h4>
                            <p>{{ \Carbon\Carbon::parse($hostel->check_in_time)->format('H:i') }}</p>
                        </div>
                    @endif
                    @if($hostel->check_out_time)
                        <div class="detail-item">
                            <i class="icon-clock"></i>
                            <h4>Check-out Time</h4>
                            <p>{{ \Carbon\Carbon::parse($hostel->check_out_time)->format('H:i') }}</p>
                        </div>
                    @endif
                    @if($hostel->hostel_type)
                        <div class="detail-item">
                            <i class="icon-star"></i>
                            <h4>Type</h4>
                            <p>{{ ucfirst($hostel->hostel_type) }}</p>
                        </div>
                    @endif
                </div>
            </section>

            <!-- Hostel Description -->
            @if($hostel->hostel_description)
                <section class="hostel-description">
                    <h3>About This Hostel</h3>
                    <p>{{ $hostel->hostel_description }}</p>
                </section>
            @endif

            <!-- Hostel Amenities -->
            <section class="hostel-info">
                <h3>Hostel Amenities</h3>
                <div class="amenities-grid">
                    @if($hostel->hostel_phone)
                        <div class="amenity-item">
                            <i class="icon-phone"></i>
                            <span>Phone Support</span>
                        </div>
                    @endif
                    @if($hostel->hostel_email)
                        <div class="amenity-item">
                            <i class="icon-email"></i>
                            <span>Email Support</span>
                        </div>
                    @endif
                    @if($hostel->total_rooms)
                        <div class="amenity-item">
                            <i class="icon-home"></i>
                            <span>{{ $hostel->total_rooms }} Rooms Available</span>
                        </div>
                    @endif
                    @if($hostel->check_in_time)
                        <div class="amenity-item">
                            <i class="icon-clock"></i>
                            <span>Flexible Check-in</span>
                        </div>
                    @endif
                    <div class="amenity-item">
                        <i class="icon-location"></i>
                        <span>Prime Location</span>
                    </div>
                    <div class="amenity-item">
                        <i class="icon-star"></i>
                        <span>Quality Service</span>
                    </div>
                </div>
            </section>
        </div>
    </main>

    @include('layout.footer')

    <!-- Scripts -->
    <script src={{ asset('js/common.min.js') }}></script>
    <script src={{ asset('js/demo.js') }}></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-FC3KYV46D4"></script>
</body>
</html>
