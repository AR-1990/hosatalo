<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rooms | Hosteller</title>
    
    <!-- Main Website CSS Files -->
    <link rel="stylesheet preload" as="style" href="{{ asset('css/preload.min.css') }}">
    <link rel="stylesheet preload" as="style" href="{{ asset('css/icomoon.css') }}">
    <link rel="stylesheet preload" as="style" href="{{ asset('css/libs.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/floatbutton.min.css') }}">
</head>
<body>
    @include('layout.header')

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header-content">
                        <h1 class="page-title">Available Rooms</h1>
                       
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Advanced Filters Section -->
    <section class="filters-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="filters-card">
                        <div class="filters-header">
                            <div class="filters-title">
                                <div class="filters-icon">
                                    <i class="fas fa-sliders-h"></i>
                                </div>
                                <div>
                                    <h3>Smart Room Finder</h3>
                                    <p class="filters-subtitle">Find your perfect accommodation with our advanced filters</p>
                                </div>
                            </div>
                            <button class="btn btn-outline-primary btn-sm toggle-filters-btn" type="button" data-bs-toggle="collapse" data-bs-target="#filtersCollapse">
                                <i class="fas fa-chevron-down me-1"></i>Toggle Filters
                            </button>
                        </div>
                        
                                                 <div class="collapse show" id="filtersCollapse">
                             <form action="{{ route('rooms') }}" method="GET" id="filtersForm">
                                <div class="row g-4">
                                    <!-- Search and Basic Filters -->
                                    <div class="col-md-6">
                                        <div class="filter-group">
                                            <label for="search" class="filter-label">
                                                <i class="fas fa-search"></i> Search Rooms
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-home"></i></span>
                                                <input type="text" class="form-control search-input" id="search" name="search" 
                                                       placeholder="Room name, description, or hostel..." 
                                                       value="{{ request('search') }}">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="filter-group">
                                            <label for="city" class="filter-label">
                                                <i class="fas fa-map-marker-alt"></i> City
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-city"></i></span>
                                                <select class="form-select" id="city" name="city">
                                                    <option value="">All Cities</option>
                                                    @foreach($cities ?? [] as $city)
                                                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                                            {{ $city }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="filter-group">
                                            <label for="hostel_type" class="filter-label">
                                                <i class="fas fa-building"></i> Hostel Type
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-hotel"></i></span>
                                                <select class="form-select" id="hostel_type" name="hostel_type">
                                                    <option value="">All Types</option>
                                                    @foreach($hostelTypes ?? [] as $type)
                                                        <option value="{{ $type }}" {{ request('hostel_type') == $type ? 'selected' : '' }}>
                                                            {{ $type }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Room Specific Filters -->
                                    <div class="col-md-3">
                                        <div class="filter-group">
                                            <label for="room_type" class="filter-label">
                                                <i class="fas fa-bed"></i> Room Type
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-door-open"></i></span>
                                                                                                 <select class="form-select" id="room_type" name="room_type">
                                                     <option value="">All Room Types</option>
                                                     <option value="single" {{ request('room_type') == 'single' ? 'selected' : '' }}>Single</option>
                                                     <option value="double" {{ request('room_type') == 'double' ? 'selected' : '' }}>Double</option>
                                                     <option value="triple" {{ request('room_type') == 'triple' ? 'selected' : '' }}>Triple</option>
                                                     <option value="quad" {{ request('room_type') == 'quad' ? 'selected' : '' }}>Quad</option>
                                                     <option value="dormitory" {{ request('room_type') == 'dormitory' ? 'selected' : '' }}>Dormitory</option>
                                                     <option value="private" {{ request('room_type') == 'private' ? 'selected' : '' }}>Private</option>
                                                 </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="filter-group">
                                            <label for="capacity" class="filter-label">
                                                <i class="fas fa-users"></i> Capacity
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                                                                                                 <select class="form-select" id="capacity" name="capacity">
                                                     <option value="">Any Capacity</option>
                                                     <option value="1" {{ request('capacity') == '1' ? 'selected' : '' }}>1 Person</option>
                                                     <option value="2" {{ request('capacity') == '2' ? 'selected' : '' }}>2 People</option>
                                                     <option value="3" {{ request('capacity') == '3' ? 'selected' : '' }}>3 People</option>
                                                     <option value="4" {{ request('capacity') == '4' ? 'selected' : '' }}>4 People</option>
                                                     <option value="5" {{ request('capacity') == '5' ? 'selected' : '' }}>5 People</option>
                                                     <option value="6" {{ request('capacity') == '6' ? 'selected' : '' }}>6 People</option>
                                                     <option value="7" {{ request('capacity') == '7' ? 'selected' : '' }}>7 People</option>
                                                     <option value="8" {{ request('capacity') == '8' ? 'selected' : '' }}>8 People</option>
                                                     <option value="9" {{ request('capacity') == '9' ? 'selected' : '' }}>9 People</option>
                                                     <option value="10" {{ request('capacity') == '10' ? 'selected' : '' }}>10 People</option>
                                                     <option value="14" {{ request('capacity') == '14' ? 'selected' : '' }}>14 People</option>
                                                 </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="filter-group">
                                            <label for="availability" class="filter-label">
                                                <i class="fas fa-check-circle"></i> Availability
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                                <select class="form-select" id="availability" name="availability">
                                                    <option value="">All Rooms</option>
                                                    <option value="1" {{ request('availability') == '1' ? 'selected' : '' }}>Available Only</option>
                                                    <option value="0" {{ request('availability') == '0' ? 'selected' : '' }}>Show All</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="filter-group">
                                            <label for="sort_by" class="filter-label">
                                                <i class="fas fa-sort"></i> Sort By
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-sort-amount-down"></i></span>
                                                <select class="form-select" id="sort_by" name="sort_by">
                                                    <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                                    <option value="oldest" {{ request('sort_by') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                                                    <option value="price_low" {{ request('sort_by') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                                    <option value="price_high" {{ request('sort_by') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                                    <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Price Range Filter -->
                                    <div class="col-md-6">
                                        <div class="filter-group">
                                            <label class="filter-label">
                                                <i class="fas fa-money-bill-wave"></i> Price Range (per night)
                                            </label>
                                            <div class="price-range-container">
                                                <div class="price-input-group">
                                                    <span class="price-label">Min</span>
                                                    <div class="input-group">
                                                        <span class="input-group-text">PKR</span>
                                                        <input type="number" class="form-control price-input" name="price_min" 
                                                               placeholder="0" value="{{ request('price_min') }}" min="0">
                                                    </div>
                                                </div>
                                                <div class="price-separator">to</div>
                                                <div class="price-input-group">
                                                    <span class="price-label">Max</span>
                                                    <div class="input-group">
                                                        <span class="input-group-text">PKR</span>
                                                        <input type="number" class="form-control price-input" name="price_max" 
                                                               placeholder="10000" value="{{ request('price_max') }}" min="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Amenities Filter -->
                                    <div class="col-md-6">
                                        <div class="filter-group">
                                            <label class="filter-label">
                                                <i class="fas fa-star"></i> Amenities
                                            </label>
                                            <div class="amenities-filters">
                                                <div class="amenity-checkbox">
                                                    <input class="form-check-input" type="checkbox" name="amenities[]" 
                                                           value="WiFi" id="wifi" {{ in_array('WiFi', request('amenities', [])) ? 'checked' : '' }}>
                                                    <label class="amenity-label" for="wifi">
                                                        <i class="fas fa-wifi"></i> WiFi
                                                    </label>
                                                </div>
                                                <div class="amenity-checkbox">
                                                    <input class="form-check-input" type="checkbox" name="amenities[]" 
                                                           value="Heater" id="heater" {{ in_array('Heater', request('amenities', [])) ? 'checked' : '' }}>
                                                    <label class="amenity-label" for="heater">
                                                        <i class="fas fa-fire"></i> Heater
                                                    </label>
                                                </div>
                                                <div class="amenity-checkbox">
                                                    <input class="form-check-input" type="checkbox" name="amenities[]" 
                                                           value="Fan" id="fan" {{ in_array('Fan', request('amenities', [])) ? 'checked' : '' }}>
                                                    <label class="amenity-label" for="fan">
                                                        <i class="fas fa-fan"></i> Fan
                                                    </label>
                                                </div>
                                                <div class="amenity-checkbox">
                                                    <input class="form-check-input" type="checkbox" name="amenities[]" 
                                                           value="Balcony" id="balcony" {{ in_array('Balcony', request('amenities', [])) ? 'checked' : '' }}>
                                                    <label class="amenity-label" for="balcony">
                                                        <i class="fas fa-door-open"></i> Balcony
                                                    </label>
                                                </div>
                                                <div class="amenity-checkbox">
                                                    <input class="form-check-input" type="checkbox" name="amenities[]" 
                                                           value="Wardrobe" id="wardrobe" {{ in_array('Wardrobe', request('amenities', [])) ? 'checked' : '' }}>
                                                    <label class="amenity-label" for="wardrobe">
                                                        <i class="fas fa-door-closed"></i> Wardrobe
                                                    </label>
                                                </div>
                                                <div class="amenity-checkbox">
                                                    <input class="form-check-input" type="checkbox" name="amenities[]" 
                                                           value="Desk" id="desk" {{ in_array('Desk', request('amenities', [])) ? 'checked' : '' }}>
                                                    <label class="amenity-label" for="desk">
                                                        <i class="fas fa-desk"></i> Desk
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Filter Actions -->
                                    <div class="col-12">
                                        <div class="filters-actions">
                                            <button type="submit" class="btn btn-primary btn-apply-filters">
                                                <i class="fas fa-search me-2"></i>Apply Filters
                                            </button>
                                            <a href="{{ route('rooms') }}" class="btn btn-outline-secondary btn-clear-filters">
                                                <i class="fas fa-times me-2"></i>Clear All
                                            </a>
                                            <button type="button" class="btn btn-outline-info btn-save-filters" id="saveFilters">
                                                <i class="fas fa-save me-2"></i>Save Filters
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Stats -->
    <section class="stats-section py-3 bg-light">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">{{ $rooms->total() }}</div>
                        <div class="stat-label">Total Rooms</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">{{ $rooms->where('is_available', true)->count() }}</div>
                        <div class="stat-label">Available</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">{{ $cities->count() ?? 0 }}</div>
                        <div class="stat-label">Cities</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">{{ $hostelTypes->count() ?? 0 }}</div>
                        <div class="stat-label">Hostel Types</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Rooms Section -->
    <section class="rooms-section py-5">
        <div class="container">
            @if($rooms->count() > 0)
                <div class="section-header text-center mb-5">
                    <h2 class="section-title">Found {{ $rooms->count() }} rooms matching your criteria</h2>
                    <p class="section-subtitle">Choose from our carefully selected accommodations</p>
                </div>
                
                <div class="row g-4">
                    @foreach($rooms as $room)
                        <div class="col-lg-4 col-md-6">
                            <div class="room-card">
                                <div class="room-image-container">
                                    @if($room->image)
                                        <img src="{{ asset($room->image) }}" alt="{{ $room->name }}" class="room-image">
                                    @else
                                        <div class="room-image-placeholder">
                                            <i class="fas fa-bed fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                    
                                    <div class="room-badge">
                                        {{ ucfirst($room->room_type) }}
                                    </div>
                                    
                                    @if(!$room->is_available)
                                        <div class="availability-badge">
                                            <i class="fas fa-times-circle"></i> Not Available
                                        </div>
                                    @endif
                                    
                                                                         <div class="price-badge">
                                         PKR {{ number_format($room->price_per_night) }}/night
                                     </div>
                                </div>
                                
                                <div class="room-card-body">
                                    <h5 class="room-title">{{ $room->name }}</h5>
                                    <p class="room-description">{{ Str::limit($room->description, 100) }}</p>
                                    
                                    <div class="room-meta">
                                        <div class="meta-item">
                                            <i class="fas fa-users text-primary"></i>
                                            <span>{{ $room->capacity }} Person{{ $room->capacity > 1 ? 's' : '' }}</span>
                                        </div>
                                        <div class="meta-item">
                                            <i class="fas fa-building text-primary"></i>
                                            <span>{{ $room->user->hostel_name ?? 'N/A' }}</span>
                                        </div>
                                        <div class="meta-item">
                                            <i class="fas fa-map-marker-alt text-primary"></i>
                                            <span>{{ $room->user->city ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                    
                                    @if($room->amenities)
                                        <div class="room-amenities">
                                            @if(is_string($room->amenities))
                                                @foreach(explode(',', $room->amenities) as $amenity)
                                                    <span class="amenity-tag">{{ trim($amenity) }}</span>
                                                @endforeach
                                            @elseif(is_array($room->amenities))
                                                @foreach($room->amenities as $amenity)
                                                    <span class="amenity-tag">{{ $amenity }}</span>
                                                @endforeach
                                            @endif
                                        </div>
                                    @endif
                                    
                                    <div class="room-actions">
                                        <button type="button" class="btn btn-outline-primary" onclick="openRoomModal({{ $room->id }})">
                                            <i class="fas fa-eye me-2"></i>View Details
                                        </button>
                                        
                                        @if($room->is_available)
                                            <a href="{{ route('rooms.detail', $room->id) }}" class="btn btn-primary">
                                                <i class="fas fa-calendar-check me-2"></i>Book Now
                                            </a>
                                        @else
                                            <button class="btn btn-secondary" disabled>
                                                <i class="fas fa-times-circle me-2"></i>Not Available
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="pagination-wrapper mt-5">
                    {{ $rooms->appends(request()->query())->links() }}
                </div>
            @else
                <div class="no-rooms text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h3>No Rooms Found</h3>
                    <p class="text-muted">Try adjusting your filters or search criteria</p>
                    <a href="{{ route('rooms') }}" class="btn btn-primary">View All Rooms</a>
                </div>
            @endif
        </div>
    </section>

    <!-- Room Detail Modal -->
    <div class="modal fade" id="roomModal" tabindex="-1" aria-labelledby="roomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="roomModalLabel">Room Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="roomModalBody">
                    <!-- Content will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="bookNowBtn">Book Now</button>
                </div>
            </div>
        </div>
    </div>

    @include('layout.footer')

    <!-- Main Website JavaScript Files -->
    <script src="{{ asset('js/common.min.js') }}"></script>
    <script src="{{ asset('js/demo.js') }}"></script>
    
    <!-- Custom CSS for rooms -->
    <style>
        /* Basic page styling */
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
        }
        
        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 1rem 0 0 0;
        }
        
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }
        
        .breadcrumb-item a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
        }
        
        .breadcrumb-item a:hover {
            color: white;
        }
        
        .breadcrumb-item.active {
            color: rgba(255,255,255,0.6);
        }
        
        /* Filters Section */
        .filters-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
        }

        .filters-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            padding: 2.5rem;
            border: 1px solid rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
        }

        .filters-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 3px solid #e9ecef;
        }

        .filters-title {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .filters-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .filters-title h3 {
            margin: 0;
            color: #2c3e50;
            font-weight: 700;
            font-size: 1.8rem;
        }

        .filters-subtitle {
            margin: 0.5rem 0 0 0;
            color: #6c757d;
            font-size: 0.95rem;
        }

        .toggle-filters-btn {
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border: 2px solid #667eea;
            color: #667eea;
            transition: all 0.3s ease;
        }

        .toggle-filters-btn:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .filter-group {
            margin-bottom: 1rem;
        }

        .filter-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }

        .filter-label i {
            color: #667eea;
            width: 16px;
        }

        .input-group {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .input-group:focus-within {
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.2);
            transform: translateY(-2px);
        }

        .input-group-text {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            color: #667eea;
            font-weight: 600;
            padding: 0.75rem 1rem;
        }

        .form-control, .form-select {
            border: 1px solid #e9ecef;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .search-input {
            border-left: none;
        }

        .price-range-container {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .price-input-group {
            flex: 1;
            min-width: 120px;
        }

        .price-label {
            display: block;
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .price-separator {
            color: #6c757d;
            font-weight: 600;
            font-size: 0.9rem;
            margin: 0 0.5rem;
        }

        .price-input {
            text-align: center;
            font-weight: 600;
        }

        .amenities-filters {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .amenity-checkbox {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 12px;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .amenity-checkbox:hover {
            background: #e9ecef;
            border-color: #667eea;
            transform: translateY(-2px);
        }

        .amenity-checkbox input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #667eea;
        }

        .amenity-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            color: #495057;
            cursor: pointer;
            margin: 0;
        }

        .amenity-label i {
            color: #667eea;
            width: 16px;
        }

        .filters-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #e9ecef;
        }

        .btn-apply-filters {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
            padding: 1rem 2rem;
            font-weight: 600;
            font-size: 1.1rem;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
        }

        .btn-apply-filters:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-clear-filters, .btn-save-filters {
            border-radius: 25px;
            padding: 1rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .btn-clear-filters:hover, .btn-save-filters:hover {
            transform: translateY(-2px);
        }

        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .stat-item {
            padding: 1rem;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: white;
        }

        .stat-label {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.9);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Room Cards */
        .room-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }
        
        .room-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }
        
        .room-image-container {
            position: relative;
            height: 250px;
            overflow: hidden;
        }
        
        .room-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .room-card:hover .room-image {
            transform: scale(1.05);
        }
        
        .room-image-placeholder {
            width: 100%;
            height: 100%;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
        }
        
        .room-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: #667eea;
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .price-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255,255,255,0.95);
            color: #28a745;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 700;
            font-size: 1.1rem;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .availability-badge {
            position: absolute;
            bottom: 15px;
            left: 15px;
            background: #dc3545;
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .room-card-body {
            padding: 1.5rem;
        }
        
        .room-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.75rem;
        }
        
        .room-description {
            color: #6c757d;
            margin-bottom: 1rem;
            line-height: 1.5;
        }
        
        .room-meta {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .meta-item {
            text-align: center;
            padding: 0.75rem;
            background: #f8f9fa;
            border-radius: 10px;
            font-size: 0.8rem;
        }
        
        .meta-item i {
            color: #667eea;
            margin-bottom: 0.5rem;
            display: block;
            font-size: 1.2rem;
        }
        
        .room-amenities {
            margin-bottom: 1rem;
        }
        
        .amenity-tag {
            display: inline-block;
            background: #e9ecef;
            color: #495057;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }
        
        .room-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        
        .room-actions .btn {
            flex: 1;
            min-width: 120px;
        }
        
        /* Modal Styles */
        .modal-xl {
            max-width: 90%;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .info-item i {
            width: 20px;
            text-align: center;
        }

        .amenities-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .hostel-info {
            border-left: 4px solid #667eea;
        }
        
        /* Pagination */
        .pagination-wrapper {
            margin-top: 3rem;
            display: flex;
            justify-content: center;
        }
        
        .no-rooms {
            padding: 4rem 2rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }
            
            .room-meta {
                grid-template-columns: 1fr;
            }
            
            .room-actions {
                flex-direction: column;
            }
            
            .filters-card {
                padding: 1.5rem;
                margin: 0 1rem;
            }
            
            .filters-title {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
            
            .filters-header {
                flex-direction: column;
                gap: 1rem;
            }
            
            .price-range-container {
                flex-direction: column;
                gap: 1rem;
            }
            
            .amenities-filters {
                grid-template-columns: 1fr;
            }
            
            .filters-actions {
                flex-direction: column;
                align-items: center;
            }
            
            .filters-actions .btn {
                width: 100%;
                max-width: 300px;
            }
        }
        
        @media (max-width: 576px) {
            .filters-card {
                padding: 1rem;
                margin: 0 0.5rem;
            }
            
            .filters-icon {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }
            
            .filters-title h3 {
                font-size: 1.5rem;
            }
        }
    </style>
    
         <script>
         // Auto-submit filters when certain fields change
         document.addEventListener('DOMContentLoaded', function() {
             // Auto-submit for select fields
             const autoSubmitFields = ['city', 'hostel_type', 'room_type', 'capacity', 'availability', 'sort_by'];
             autoSubmitFields.forEach(fieldId => {
                 const field = document.getElementById(fieldId);
                 if (field) {
                     field.addEventListener('change', function() {
                         // Don't auto-submit for search field
                         if (fieldId !== 'search') {
                             document.getElementById('filtersForm').submit();
                         }
                     });
                 }
             });

             // Auto-submit for price range with delay
             let priceTimeout;
             const priceFields = ['price_min', 'price_max'];
             priceFields.forEach(fieldId => {
                 const field = document.getElementById(fieldId);
                 if (field) {
                     field.addEventListener('input', function() {
                         clearTimeout(priceTimeout);
                         priceTimeout = setTimeout(() => {
                             document.getElementById('filtersForm').submit();
                         }, 1500);
                     });
                 }
             });

             // Auto-submit for amenities checkboxes
             const amenityCheckboxes = document.querySelectorAll('input[name="amenities[]"]');
             amenityCheckboxes.forEach(checkbox => {
                 checkbox.addEventListener('change', function() {
                     document.getElementById('filtersForm').submit();
                 });
             });

             // Manual search submit
             const searchField = document.getElementById('search');
             if (searchField) {
                 let searchTimeout;
                 searchField.addEventListener('input', function() {
                     clearTimeout(searchTimeout);
                     searchTimeout = setTimeout(() => {
                         document.getElementById('filtersForm').submit();
                     }, 1000);
                 });
             }

             // Save filters to localStorage
             const saveFiltersBtn = document.getElementById('saveFilters');
             if (saveFiltersBtn) {
                 saveFiltersBtn.addEventListener('click', function() {
                     const formData = new FormData(document.getElementById('filtersForm'));
                     const filters = {};
                     
                     for (let [key, value] of formData.entries()) {
                         if (key === 'amenities[]') {
                             if (!filters[key]) filters[key] = [];
                             filters[key].push(value);
                         } else {
                             filters[key] = value;
                         }
                     }
                     
                     localStorage.setItem('savedRoomFilters', JSON.stringify(filters));
                     alert('Filters saved successfully!');
                 });
             }

             // Load saved filters
             const savedFilters = localStorage.getItem('savedRoomFilters');
             if (savedFilters) {
                 const filters = JSON.parse(savedFilters);
                 Object.keys(filters).forEach(key => {
                     if (key === 'amenities[]') {
                         filters[key].forEach(value => {
                             const checkbox = document.querySelector(`input[name="${key}"][value="${value}"]`);
                             if (checkbox) checkbox.checked = true;
                         });
                     } else {
                         const field = document.querySelector(`[name="${key}"]`);
                         if (field) field.value = filters[key];
                     }
                 });
             }

             // Apply filters button functionality
             const applyFiltersBtn = document.querySelector('.btn-apply-filters');
             if (applyFiltersBtn) {
                 applyFiltersBtn.addEventListener('click', function(e) {
                     e.preventDefault();
                     document.getElementById('filtersForm').submit();
                 });
             }

             // Clear filters functionality
             const clearFiltersBtn = document.querySelector('.btn-clear-filters');
             if (clearFiltersBtn) {
                 clearFiltersBtn.addEventListener('click', function(e) {
                     e.preventDefault();
                     // Clear all form fields
                     const form = document.getElementById('filtersForm');
                     form.reset();
                     // Submit to refresh page
                     form.submit();
                 });
             }
         });

        // Room Modal Functions
        function openRoomModal(roomId) {
            // Show loading state
            const modalBody = document.getElementById('roomModalBody');
            if (modalBody) {
                modalBody.innerHTML = `
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-3">Loading room details...</p>
                    </div>
                `;
                
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('roomModal'));
                modal.show();
                
                // Fetch room details
                fetch(`/api/rooms/${roomId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const room = data.room;
                            modalBody.innerHTML = `
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="room-gallery">
                                            ${room.image ? 
                                                `<img src="${room.image}" alt="${room.name}" class="img-fluid rounded">` :
                                                `<div class="text-center py-5 bg-light rounded">
                                                    <i class="fas fa-bed fa-3x text-muted"></i>
                                                    <p class="mt-2 text-muted">No Image Available</p>
                                                </div>`
                                            }
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="mb-3">${room.name}</h4>
                                        <p class="text-muted">${room.description || 'No description available'}</p>
                                        
                                        <div class="room-info mb-4">
                                            <div class="info-item">
                                                <i class="fas fa-bed text-primary"></i>
                                                <strong>Room Type:</strong> ${room.room_type}
                                            </div>
                                            <div class="info-item">
                                                <i class="fas fa-users text-primary"></i>
                                                <strong>Capacity:</strong> ${room.capacity} Person${room.capacity > 1 ? 's' : ''}
                                            </div>
                                                                                         <div class="info-item">
                                                 <i class="fas fa-money-bill text-primary"></i>
                                                 <strong>Price:</strong> PKR ${room.price_per_night}/night
                                             </div>
                                            <div class="info-item">
                                                <i class="fas fa-check-circle text-${room.is_available ? 'success' : 'danger'}"></i>
                                                <strong>Status:</strong> ${room.is_available ? 'Available' : 'Not Available'}
                                            </div>
                                        </div>
                                        
                                        ${room.amenities ? `
                                            <div class="amenities-section mb-4">
                                                <h6><i class="fas fa-star text-warning me-2"></i>Amenities</h6>
                                                <div class="amenities-list">
                                                    ${Array.isArray(room.amenities) ? 
                                                        room.amenities.map(amenity => 
                                                            `<span class="badge bg-primary me-2 mb-2">${amenity}</span>`
                                                        ).join('') :
                                                        room.amenities.split(',').map(amenity => 
                                                            `<span class="badge bg-primary me-2 mb-2">${amenity.trim()}</span>`
                                                        ).join('')
                                                    }
                                                </div>
                                            </div>
                                        ` : ''}
                                        
                                        <div class="hostel-info p-3 bg-light rounded">
                                            <h6><i class="fas fa-building text-info me-2"></i>Hostel Information</h6>
                                            <div class="info-item">
                                                <i class="fas fa-building text-primary"></i>
                                                <strong>Name:</strong> ${room.user?.hostel_name || 'N/A'}
                                            </div>
                                            <div class="info-item">
                                                <i class="fas fa-map-marker-alt text-primary"></i>
                                                <strong>Location:</strong> ${room.user?.city || 'N/A'}
                                            </div>
                                            <div class="info-item">
                                                <i class="fas fa-phone text-primary"></i>
                                                <strong>Contact:</strong> ${room.user?.phone || 'N/A'}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        } else {
                            modalBody.innerHTML = `
                                <div class="text-center py-5">
                                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                                    <h5>Error Loading Room Details</h5>
                                    <p class="text-muted">${data.message || 'Unable to load room information'}</p>
                                </div>
                            `;
                        }
                    })
                    .catch(error => {
                        modalBody.innerHTML = `
                            <div class="text-center py-5">
                                <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                                <h5>Network Error</h5>
                                <p class="text-muted">Unable to connect to server. Please try again.</p>
                            </div>
                        `;
                    });
            }
        }
    </script>
</body>
</html>
