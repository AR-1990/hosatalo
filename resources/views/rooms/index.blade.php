@extends('admin.layout.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>All Hostel Rooms</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('index') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Rooms</div>
            </div>
        </div>

        <div class="section-body">
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Room Management</h4>
                            <div class="card-header-action">
                                <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add New Room
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($rooms->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped" id="rooms-table">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Owner</th>
                                                <th>Type</th>
                                                <th>Capacity</th>
                                                <th>Price/Night</th>
                                                <th>Status</th>
                                                <th>Entered By</th>
                                                <th>Amenities</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($rooms as $room)
                                                <tr>
                                                    <td>
                                                        @if($room->image)
                                                            <img src="{{ asset($room->image) }}" alt="{{ $room->name }}" 
                                                                 class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                                        @else
                                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                                 style="width: 60px; height: 60px;">
                                                                <i class="fas fa-image text-muted"></i>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <strong>{{ $room->name }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ Str::limit($room->description, 50) }}</small>
                                                    </td>
                                                    <td>
                                                        <strong>{{ $room->user->hostel_name ?: $room->user->name }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $room->user->email }}</small>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-info">{{ ucfirst($room->room_type) }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-secondary">{{ $room->capacity }} Person(s)</span>
                                                    </td>
                                                    <td>
                                                        <strong class="text-success">${{ number_format($room->price_per_night, 2) }}</strong>
                                                    </td>
                                                    <td>
                                                        @if($room->is_available)
                                                            <span class="badge badge-success">Available</span>
                                                        @else
                                                            <span class="badge badge-danger">Unavailable</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($room->enteredBy)
                                                            <strong>{{ $room->enteredBy->name }}</strong>
                                                            <br>
                                                            <small class="text-muted">{{ $room->enteredBy->email }}</small>
                                                        @else
                                                            <span class="text-muted">Unknown</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($room->amenities && count($room->amenities) > 0)
                                                            @foreach(array_slice($room->amenities, 0, 3) as $amenity)
                                                                <span class="badge badge-light mr-1">{{ $amenity }}</span>
                                                            @endforeach
                                                            @if(count($room->amenities) > 3)
                                                                <span class="badge badge-light">+{{ count($room->amenities) - 3 }} more</span>
                                                            @endif
                                                        @else
                                                            <span class="text-muted">No amenities</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('admin.rooms.show', $room->id) }}" 
                                                               class="btn btn-sm btn-info" title="View">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            
                                                            <a href="{{ route('admin.rooms.edit', $room->id) }}" 
                                                               class="btn btn-sm btn-warning" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            
                                                            <form action="{{ route('admin.rooms.destroy', $room->id) }}" 
                                                                  method="POST" class="d-inline delete-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete"
                                                                        onclick="return confirm('Are you sure you want to delete this room?')">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-bed fa-3x text-muted mb-3"></i>
                                    <h5>No Rooms Found</h5>
                                    <p class="text-muted">There are no rooms in the system yet. Start by adding the first room!</p>
                                    <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Add First Room
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#rooms-table').DataTable({
            "pageLength": 10,
            "order": [[ 0, "desc" ]],
            "responsive": true
        });
    });
</script>
@endpush
@endsection
