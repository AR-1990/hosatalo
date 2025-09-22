@extends('admin.layout.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Room</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('index') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.rooms.index') }}">Rooms</a></div>
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Room: {{ $room->name }}</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="user_id">Client/Hostel Owner <span class="text-danger">*</span></label>
                                            <select id="user_id" name="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                                                <option value="">Select Client</option>
                                                @foreach(\App\Models\User::where('role', 'client')->get() as $client)
                                                    <option value="{{ $client->id }}" {{ (old('user_id', $room->user_id) == $client->id) ? 'selected' : '' }}>
                                                        {{ $client->hostel_name ?: $client->name }} ({{ $client->email }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('user_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Select the client who will own this room.</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Room Name <span class="text-danger">*</span></label>
                                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" 
                                                   value="{{ old('name', $room->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="room_type">Room Type <span class="text-danger">*</span></label>
                                            <select id="room_type" name="room_type" class="form-control @error('room_type') is-invalid @enderror" required>
                                                <option value="">Select Room Type</option>
                                                <option value="single" {{ (old('room_type', $room->room_type) == 'single') ? 'selected' : '' }}>Single</option>
                                                <option value="double" {{ (old('room_type', $room->room_type) == 'double') ? 'selected' : '' }}>Double</option>
                                                <option value="triple" {{ (old('room_type', $room->room_type) == 'triple') ? 'selected' : '' }}>Triple</option>
                                                <option value="quad" {{ (old('room_type', $room->room_type) == 'quad') ? 'selected' : '' }}>Quad</option>
                                                <option value="dormitory" {{ (old('room_type', $room->room_type) == 'dormitory') ? 'selected' : '' }}>Dormitory</option>
                                                <option value="suite" {{ (old('room_type', $room->room_type) == 'suite') ? 'selected' : '' }}>Suite</option>
                                                <option value="private" {{ (old('room_type', $room->room_type) == 'private') ? 'selected' : '' }}>Private</option>
                                                <option value="shared" {{ (old('room_type', $room->room_type) == 'shared') ? 'selected' : '' }}>Shared</option>
                                            </select>
                                            @error('room_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="capacity">Capacity (Number of People) <span class="text-danger">*</span></label>
                                            <input type="number" id="capacity" name="capacity" class="form-control @error('capacity') is-invalid @enderror" 
                                                   value="{{ old('capacity', $room->capacity) }}" min="1" max="20" required>
                                            @error('capacity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="price_per_night">Price per Night ($) <span class="text-danger">*</span></label>
                                            <input type="number" id="price_per_night" name="price_per_night" class="form-control @error('price_per_night') is-invalid @enderror" 
                                                   value="{{ old('price_per_night', $room->price_per_night) }}" min="0" step="0.01" required>
                                            @error('price_per_night')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="is_available">Room Status</label>
                                            <select id="is_available" name="is_available" class="form-control">
                                                <option value="1" {{ (old('is_available', $room->is_available) == '1') ? 'selected' : '' }}>Available</option>
                                                <option value="0" {{ (old('is_available', $room->is_available) == '0') ? 'selected' : '' }}>Unavailable</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description">Room Description <span class="text-danger">*</span></label>
                                    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" 
                                              rows="4" required>{{ old('description', $room->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Describe the room features, size, and any special characteristics.</small>
                                </div>

                                <div class="form-group">
                                    <label for="image">Room Image</label>
                                    @if($room->image)
                                        <div class="mb-3">
                                            <img src="{{ asset($room->image) }}" alt="Current Room Image" class="img-thumbnail" style="max-width: 200px;">
                                            <br>
                                            <small class="text-muted">Current image</small>
                                        </div>
                                    @endif
                                    <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror" 
                                           accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Upload a new image to replace the current one (JPEG, PNG, GIF, max 2MB).</small>
                                </div>

                                <div class="form-group">
                                    <label for="images">Additional Room Images</label>
                                    @if($room->images && is_array($room->images) && count($room->images) > 0)
                                        @php
                                            // Filter out empty or invalid image entries
                                            $validImages = array_filter($room->images, function($image) {
                                                return is_string($image) && !empty($image) && $image !== '{}';
                                            });
                                        @endphp
                                        @if(count($validImages) > 0)
                                        <div class="mb-3">
                                            <div class="row">
                                                @foreach($validImages as $index => $image)
                                                    <div class="col-md-3 mb-2">
                                                        <img src="{{ asset($image) }}" alt="Additional Image {{ $index + 1 }}" class="img-thumbnail" style="max-width: 100%;">
                                                        <br>
                                                        <small class="text-muted">Image {{ $index + 1 }}</small>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <small class="text-muted">Current additional images</small>
                                        </div>
                                        @endif
                                    @endif
                                    <input type="file" id="images" name="images[]" class="form-control @error('images.*') is-invalid @enderror" 
                                           accept="image/*" multiple>
                                    @error('images.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Upload new additional images to replace the current ones (JPEG, PNG, GIF, max 2MB each). You can select multiple images.</small>
                                </div>

                                <div class="form-group">
                                    <label for="rules">Room Rules & Policies</label>
                                    <textarea id="rules" name="rules" class="form-control @error('rules') is-invalid @enderror" 
                                              rows="4">{{ old('rules', $room->rules) }}</textarea>
                                    @error('rules')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Specify any rules, policies, or important information for guests staying in this room.</small>
                                </div>

                                <div class="form-group">
                                    <label>Amenities</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="amenity_ac" name="amenities[]" value="Air Conditioning"
                                                       {{ in_array('Air Conditioning', old('amenities', $room->amenities ?? [])) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="amenity_ac">Air Conditioning</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="amenity_wifi" name="amenities[]" value="WiFi"
                                                       {{ in_array('WiFi', old('amenities', $room->amenities ?? [])) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="amenity_wifi">WiFi</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="amenity_tv" name="amenities[]" value="TV"
                                                       {{ in_array('TV', old('amenities', $room->amenities ?? [])) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="amenity_tv">TV</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="amenity_heater" name="amenities[]" value="Heater"
                                                       {{ in_array('Heater', old('amenities', $room->amenities ?? [])) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="amenity_heater">Heater</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="amenity_fan" name="amenities[]" value="Fan"
                                                       {{ in_array('Fan', old('amenities', $room->amenities ?? [])) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="amenity_fan">Fan</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="amenity_balcony" name="amenities[]" value="Balcony"
                                                       {{ in_array('Balcony', old('amenities', $room->amenities ?? [])) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="amenity_balcony">Balcony</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="amenity_wardrobe" name="amenities[]" value="Wardrobe"
                                                       {{ in_array('Wardrobe', old('amenities', $room->amenities ?? [])) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="amenity_wardrobe">Wardrobe</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="amenity_desk" name="amenities[]" value="Desk"
                                                       {{ in_array('Desk', old('amenities', $room->amenities ?? [])) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="amenity_desk">Desk</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="amenity_private_bathroom" name="amenities[]" value="Private Bathroom"
                                                       {{ in_array('Private Bathroom', old('amenities', $room->amenities ?? [])) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="amenity_private_bathroom">Private Bathroom</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="amenity_shared_bathroom" name="amenities[]" value="Shared Bathroom"
                                                       {{ in_array('Shared Bathroom', old('amenities', $room->amenities ?? [])) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="amenity_shared_bathroom">Shared Bathroom</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="amenity_kitchen" name="amenities[]" value="Kitchen Access"
                                                       {{ in_array('Kitchen Access', old('amenities', $room->amenities ?? [])) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="amenity_kitchen">Kitchen Access</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="amenity_laundry" name="amenities[]" value="Laundry"
                                                       {{ in_array('Laundry', old('amenities', $room->amenities ?? [])) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="amenity_laundry">Laundry</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Room
                                    </button>
                                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Back to Rooms
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
