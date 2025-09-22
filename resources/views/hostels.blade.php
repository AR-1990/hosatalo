<!DOCTYPE html>
<html lang=en>
<head>
    <meta charset=UTF-8>
    <meta name=viewport content="width=device-width,initial-scale=1,minimum-scale=1">
    <meta http-equiv=X-UA-Compatible content="ie=edge">
    <title>Hostels | Hosteller</title>
    <script id=www-widgetapi-script src=../../s.ytimg.com/yts/jsbin/www-widgetapi-vflS50iB-/www-widgetapi.js
        async=""></script>
    <script src=https://www.youtube.com/player_api></script>
    <link rel="stylesheet preload" as=style href={{ asset('css/preload.min.css') }}>
    <link rel="stylesheet preload" as=style href={{ asset('css/icomoon.css') }}>
    <link rel="stylesheet preload" as=style href={{ asset('css/libs.min.css') }}>
    <link rel=stylesheet href={{ asset('css/about.min.css') }}>
    <link rel=stylesheet href={{ asset('css/floatbutton.min.css') }}>
    <style>
        .search-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 0;
            margin-bottom: 40px;
        }
        .search-box {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .search-input {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 15px 20px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        .search-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .search-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 15px 30px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .filter-buttons {
            margin: 20px 0;
        }
        .filter-btn {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 25px;
            padding: 8px 20px;
            margin: 5px;
            color: #6c757d;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .filter-btn:hover, .filter-btn.active {
            background: #667eea;
            border-color: #667eea;
            color: white;
        }
        .hostel-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }
        .hostel-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        .hostel-image {
            height: 250px;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .hostel-type-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(102, 126, 234, 0.9);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .hostel-content {
            padding: 25px;
        }
        .hostel-title {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 22px;
            font-weight: 700;
        }
        .hostel-location {
            color: #7f8c8d;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .hostel-description {
            color: #6c757d;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        .hostel-features {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        .feature-item {
            background: #f8f9fa;
            color: #6c757d;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
        }
        .view-details-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        .view-details-btn:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .no-hostels {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        .no-hostels i {
            font-size: 60px;
            color: #dee2e6;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    @include('layout.header')

    <header class=page>
        <div class=container>
            <ul class="breadcrumbs d-flex flex-wrap align-content-center">
                <li class=list-item><a class=link href={{ route('index') }}>Home</a></li>
                <li class=list-item><a class=link href=#>Hostels</a></li>
            </ul>
            <h1 class=page_title>Hostels</h1>
        </div>
    </header>

    <!-- Search Section -->
    <section class="search-section section">
        <div class="container">
            <div class="search-box">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" id="searchInput" class="form-control search-input" placeholder="Search hostels by name, city, or description...">
                    </div>
                    <div class="col-md-3">
                        <select id="cityFilter" class="form-control search-input">
                            <option value="">All Cities</option>
                            @foreach($hostels->pluck('city')->unique()->sort() as $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="typeFilter" class="form-control search-input">
                            <option value="">All Types</option>
                            <option value="budget">Budget</option>
                            <option value="mid-range">Mid-Range</option>
                            <option value="luxury">Luxury</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" id="searchBtn" class="btn search-btn w-100">
                            <i class="icon-search"></i> Search
                        </button>
                    </div>
                </div>
                
                <div class="filter-buttons text-center">
                    <button class="filter-btn active" data-filter="all">All</button>
                    <button class="filter-btn" data-filter="budget">Budget</button>
                    <button class="filter-btn" data-filter="mid-range">Mid-Range</button>
                    <button class="filter-btn" data-filter="luxury">Luxury</button>
                </div>
            </div>
        </div>
    </section>

    <main>
        <section class="hostels section">
            <div class="container">
                @if($hostels->count() > 0)
                    <div class="row" id="hostelsContainer">
                        @foreach($hostels as $hostel)
                            <div class="col-lg-4 col-md-6 hostel-item" 
                                 data-name="{{ strtolower($hostel->hostel_name) }}"
                                 data-city="{{ strtolower($hostel->city) }}"
                                 data-type="{{ $hostel->hostel_type }}"
                                 data-description="{{ strtolower($hostel->hostel_description) }}">
                                <div class="hostel-card">
                                    <div class="hostel-image" style="background-image: url('{{ $hostel->hostel_banner ? asset($hostel->hostel_banner) : asset('img/room/01.jpg') }}')">
                                        <div class="hostel-type-badge">{{ ucfirst($hostel->hostel_type) }}</div>
                                    </div>
                                    <div class="hostel-content">
                                        <h3 class="hostel-title">{{ $hostel->hostel_name }}</h3>
                                        <div class="hostel-location">
                                            <i class="icon-location"></i> {{ $hostel->city }}, {{ $hostel->state }}, {{ $hostel->country }}
                                        </div>
                                        <p class="hostel-description">
                                            {{ Str::limit($hostel->hostel_description, 120) }}
                                        </p>
                                        
                                        <div class="hostel-features">
                                            <span class="feature-item">
                                                <i class="icon-phone"></i> {{ $hostel->hostel_phone }}
                                            </span>
                                            <span class="feature-item">
                                                <i class="icon-email"></i> {{ $hostel->hostel_email }}
                                            </span>
                                            @if($hostel->total_rooms)
                                                <span class="feature-item">
                                                    <i class="icon-home"></i> {{ $hostel->total_rooms }} Rooms
                                                </span>
                                            @endif
                                            @if($hostel->check_in_time)
                                                <span class="feature-item">
                                                    <i class="icon-clock"></i> Check-in: {{ \Carbon\Carbon::parse($hostel->check_in_time)->format('H:i') }}
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <a href="{{ route('hostels.detail', $hostel->id) }}" class="view-details-btn">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="no-hostels">
                        <i class="icon-home"></i>
                        <h3>No Hostels Available</h3>
                        <p>Currently there are no verified hostels in our system. Please check back later!</p>
                    </div>
                @endif
            </div>
        </section>
    </main>

    @include('layout.footer')

    <!-- Scripts -->
    <script src={{ asset('js/common.min.js') }}></script>
    <script src={{ asset('js/demo.js') }}></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-FC3KYV46D4"></script>
    
    <!-- Search and Filter Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const cityFilter = document.getElementById('cityFilter');
            const typeFilter = document.getElementById('typeFilter');
            const searchBtn = document.getElementById('searchBtn');
            const filterBtns = document.querySelectorAll('.filter-btn');
            const hostelsContainer = document.getElementById('hostelsContainer');
            const hostelItems = document.querySelectorAll('.hostel-item');

            function filterHostels() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedCity = cityFilter.value.toLowerCase();
                const selectedType = typeFilter.value.toLowerCase();

                hostelItems.forEach(item => {
                    const name = item.dataset.name;
                    const city = item.dataset.city;
                    const type = item.dataset.type;
                    const description = item.dataset.description;

                    const matchesSearch = !searchTerm || 
                        name.includes(searchTerm) || 
                        city.includes(searchTerm) || 
                        description.includes(searchTerm);
                    
                    const matchesCity = !selectedCity || city === selectedCity;
                    const matchesType = !selectedType || type === selectedType;

                    if (matchesSearch && matchesCity && matchesType) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Update active filter button
                filterBtns.forEach(btn => {
                    btn.classList.remove('active');
                    if (btn.dataset.filter === selectedType || (!selectedType && btn.dataset.filter === 'all')) {
                        btn.classList.add('active');
                    }
                });
            }

            // Event listeners
            searchInput.addEventListener('input', filterHostels);
            cityFilter.addEventListener('change', filterHostels);
            typeFilter.addEventListener('change', filterHostels);
            searchBtn.addEventListener('click', filterHostels);

            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const filter = this.dataset.filter;
                    if (filter === 'all') {
                        typeFilter.value = '';
                    } else {
                        typeFilter.value = filter;
                    }
                    filterHostels();
                });
            });

            // Enter key support for search
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    filterHostels();
                }
            });
        });
    </script>
</body>
</html>

