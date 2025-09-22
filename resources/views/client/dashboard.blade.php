<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard - Hostal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-building"></i> Client Portal
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('index') }}">Home</a>
                    </li>
                                         <li class="nav-item">
                         <a class="nav-link" href="{{ route('admin.rooms.index') }}">My Rooms</a>
                     </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('bookings.index') }}">Bookings</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user-edit"></i> Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h4><i class="fas fa-building"></i> Welcome, {{ Auth::user()->name }}!</h4>
                        <p class="mb-0">Manage your rooms and view booking requests from guests.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-bed fa-2x text-primary mb-2"></i>
                        <h5 class="card-title">{{ $rooms->count() }}</h5>
                        <p class="card-text">Total Rooms</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                        <h5 class="card-title">{{ $rooms->where('is_available', true)->count() }}</h5>
                        <p class="card-text">Available Rooms</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                        <h5 class="card-title">0</h5>
                        <p class="card-text">Pending Bookings</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-calendar-check fa-2x text-info mb-2"></i>
                        <h5 class="card-title">0</h5>
                        <p class="card-text">Confirmed Bookings</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-tools"></i> Quick Actions</h5>
                            <a href="{{ route('admin.rooms.create') }}" class="btn btn-success">
                                <i class="fas fa-plus"></i> Add New Room
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- My Rooms -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-bed"></i> My Rooms</h5>
                    </div>
                    <div class="card-body">
                        @if($rooms->count() > 0)
                            <div class="row">
                                @foreach($rooms as $room)
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="card h-100">
                                            @if($room->image)
                                                <img src="{{ asset($room->image) }}" class="card-img-top" alt="{{ $room->name }}" style="height: 200px; object-fit: cover;">
                                            @else
                                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                                    <i class="fas fa-bed fa-3x text-muted"></i>
                                                </div>
                                            @endif
                                            <div class="card-body">
                                                <h6 class="card-title">{{ $room->name }}</h6>
                                                <p class="card-text text-muted">{{ Str::limit($room->description, 100) }}</p>
                                                <div class="row text-center mb-3">
                                                    <div class="col-6">
                                                        <small class="text-muted">Type</small><br>
                                                        <strong>{{ $room->room_type }}</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <small class="text-muted">Capacity</small><br>
                                                        <strong>{{ $room->capacity }} persons</strong>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="h5 text-success mb-0">${{ number_format($room->price_per_night, 2) }}</span>
                                                    <span class="badge {{ $room->is_available ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $room->is_available ? 'Available' : 'Not Available' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="btn-group w-100" role="group">
                                                    <a href="{{ route('admin.rooms.show', $room) }}" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                    <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-outline-warning btn-sm">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this room?')">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-bed fa-3x text-muted mb-3"></i>
                                <h5>No Rooms Added Yet</h5>
                                <p class="text-muted">You haven't added any rooms to your portfolio yet.</p>
                                <a href="{{ route('admin.rooms.create') }}" class="btn btn-success">Add Your First Room</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
