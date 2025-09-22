@extends('admin.layout.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Room Details</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('index') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.rooms.index') }}">Rooms</a></div>
                <div class="breadcrumb-item">{{ $room->name }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Room Information: {{ $room->name }}</h4>
                            <div class="card-header-action">
                                <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit Room
                                </a>
                                <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to Rooms
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    @if($room->image)
                                        <img src="{{ asset($room->image) }}" alt="{{ $room->name }}" class="img-fluid rounded" style="max-width: 100%;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 300px;">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Room Name:</strong></td>
                                            <td>{{ $room->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Owner:</strong></td>
                                            <td>{{ $room->user->hostel_name ?: $room->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Owner Email:</strong></td>
                                            <td>{{ $room->user->email }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Room Type:</strong></td>
                                            <td><span class="badge badge-info">{{ ucfirst($room->room_type) }}</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Capacity:</strong></td>
                                            <td><span class="badge badge-secondary">{{ $room->capacity }} Person(s)</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Price per Night:</strong></td>
                                            <td><strong class="text-success">PKR {{ number_format($room->price_per_night, 2) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                @if($room->is_available)
                                                    <span class="badge badge-success">Available</span>
                                                @else
                                                    <span class="badge badge-danger">Unavailable</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Entered By:</strong></td>
                                            <td>
                                                @if($room->enteredBy)
                                                    {{ $room->enteredBy->name }} ({{ $room->enteredBy->email }})
                                                @else
                                                    <span class="text-muted">Unknown</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Created:</strong></td>
                                            <td>{{ $room->created_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Last Updated:</strong></td>
                                            <td>{{ $room->updated_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <h5>Room Description</h5>
                                    <p class="text-muted">{{ $room->description }}</p>
                                </div>
                            </div>

                            @if($room->amenities && count($room->amenities) > 0)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h5>Amenities</h5>
                                    <div class="d-flex flex-wrap">
                                        @foreach($room->amenities as $amenity)
                                            <span class="badge badge-light mr-2 mb-2">{{ $amenity }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($room->rules)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h5>Room Rules & Policies</h5>
                                    <div class="card">
                                        <div class="card-body">
                                            <p class="text-muted">{{ $room->rules }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($room->images && is_array($room->images) && count($room->images) > 0)
                            @php
                                // Filter out empty or invalid image entries
                                $validImages = array_filter($room->images, function($image) {
                                    return is_string($image) && !empty($image) && $image !== '{}';
                                });
                            @endphp
                            @if(count($validImages) > 0)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h5>Additional Room Images</h5>
                                    <div class="row">
                                        @foreach($validImages as $index => $image)
                                            <div class="col-md-3 mb-3">
                                                <img src="{{ asset($image) }}" alt="Room Image {{ $index + 1 }}" 
                                                     class="img-fluid rounded" style="width: 100%; height: 200px; object-fit: cover;">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endif

                            <div class="row mt-4">
                                <div class="col-12">
                                    <h5>Owner Information</h5>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>Name:</strong> {{ $room->user->name }}</p>
                                                    <p><strong>Email:</strong> {{ $room->user->email }}</p>
                                                    <p><strong>Phone:</strong> {{ $room->user->phone ?: 'Not provided' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>Hostel Name:</strong> {{ $room->user->hostel_name ?: 'Not provided' }}</p>
                                                    <p><strong>City:</strong> {{ $room->user->city ?: 'Not provided' }}</p>
                                                    <p><strong>Country:</strong> {{ $room->user->country ?: 'Not provided' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
