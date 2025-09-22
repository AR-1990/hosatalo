<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FrontController extends Controller
{

    public function welcome() { return view('welcome'); }
    public function about() { return view('about'); }
    public function contacts() { return view('contacts'); }
    public function contacts2() { return view('contacts2'); }
    public function faq() { return view('faq'); }
    public function faq2() { return view('faq2'); }
    public function gallery() { return view('gallery'); }
    public function index() { return view('index'); }
    public function index04b9() { return view('index04b9'); }
    public function news() { return view('news'); }
    public function post() { return view('post'); }
    public function room() { return view('room'); }
    public function rooms(Request $request) { 
        // Debug: Log all request parameters
        Log::info('Rooms Filter Request:', $request->all());
        
        $query = \App\Models\Room::with(['user', 'enteredBy']);

        // Search by room name or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('hostel_name', 'like', "%{$search}%")
                               ->orWhere('city', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by room type
        if ($request->filled('room_type')) {
            $query->where('room_type', $request->room_type);
        }

        // Filter by price range
        if ($request->filled('price_min')) {
            $query->where('price_per_night', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price_per_night', '<=', $request->price_max);
        }

        // Filter by capacity
        if ($request->filled('capacity')) {
            $query->where('capacity', $request->capacity);
        }

        // Filter by availability
        if ($request->filled('availability')) {
            if ($request->availability == '1') {
                $query->where('is_available', true);
            }
        }

        // Filter by amenities - Improved JSON handling with case-insensitive search
        if ($request->filled('amenities')) {
            foreach ($request->amenities as $amenity) {
                $query->where(function($q) use ($amenity) {
                    // For JSON fields, we need to handle both string and array cases
                    // Case-insensitive search for JSON arrays
                    $q->whereRaw("LOWER(JSON_EXTRACT(amenities, '$')) LIKE ?", ["%" . strtolower($amenity) . "%"])
                      ->orWhereRaw("JSON_CONTAINS(amenities, ?)", [json_encode($amenity)])
                      ->orWhereRaw("JSON_CONTAINS(amenities, ?)", [json_encode(strtolower($amenity))])
                      ->orWhere('amenities', 'like', "%{$amenity}%")
                      ->orWhere('amenities', 'like', "%" . strtolower($amenity) . "%");
                });
            }
        }

        // Filter by location/city
        if ($request->filled('city')) {
            $query->whereHas('user', function($userQuery) use ($request) {
                $userQuery->where('city', $request->city);
            });
        }

        // Filter by hostel type
        if ($request->filled('hostel_type')) {
            $query->whereHas('user', function($userQuery) use ($request) {
                $userQuery->where('hostel_type', $request->hostel_type);
            });
        }

        // Sort options
        switch ($request->get('sort_by', 'newest')) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'price_low':
                $query->orderBy('price_per_night', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price_per_night', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $rooms = $query->paginate(12);
        
        // Debug: Log the final SQL query
        Log::info('Final SQL Query:', [
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings(),
            'total_rooms' => $rooms->total(),
            'filtered_rooms' => $rooms->perPage()
        ]);
        
        // Get unique cities and hostel types for filters
        $cities = \App\Models\User::whereNotNull('city')
                                  ->distinct()
                                  ->pluck('city');
        
        $hostelTypes = \App\Models\User::whereNotNull('hostel_type')
                                      ->distinct()
                                      ->pluck('hostel_type');
        
        return view('rooms.listing', compact('rooms', 'cities', 'hostelTypes')); 
    }

    public function searchRooms(Request $request) {
        $query = \App\Models\Room::with(['user', 'enteredBy']);

        // Search by room name or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('hostel_name', 'like', "%{$search}%")
                               ->orWhere('city', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by room type
        if ($request->filled('room_type')) {
            $query->where('room_type', $request->room_type);
        }

        // Filter by price range
        if ($request->filled('price_min')) {
            $query->where('price_per_night', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price_per_night', '<=', $request->price_max);
        }

        // Filter by capacity
        if ($request->filled('capacity')) {
            $query->where('capacity', $request->capacity);
        }

        // Filter by availability
        if ($request->filled('availability')) {
            if ($request->availability == '1') {
                $query->where('is_available', true);
            }
        }

        // Filter by amenities - Improved JSON handling
        if ($request->filled('amenities')) {
            foreach ($request->amenities as $amenity) {
                $query->where(function($q) use ($amenity) {
                    // For JSON fields, we need to handle both string and array cases
                    $q->whereRaw("JSON_EXTRACT(amenities, '$') LIKE ?", ["%{$amenity}%"])
                      ->orWhereRaw("JSON_CONTAINS(amenities, ?)", [json_encode($amenity)])
                      ->orWhere('amenities', 'like', "%{$amenity}%");
                });
            }
        }

        // Filter by location/city
        if ($request->filled('city')) {
            $query->whereHas('user', function($userQuery) use ($request) {
                $userQuery->where('city', $request->city);
            });
        }

        // Filter by hostel type
        if ($request->filled('hostel_type')) {
            $query->whereHas('user', function($userQuery) use ($request) {
                $userQuery->where('hostel_type', $request->hostel_type);
            });
        }

        // Sort options
        switch ($request->get('sort_by', 'newest')) {
            case 'price_low':
                $query->orderBy('price_per_night', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price_per_night', 'desc');
                break;
            case 'rating':
                // For now, sort by newest if rating system not implemented
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $rooms = $query->paginate(12);
        
        // Get unique cities and hostel types for filters
        $cities = \App\Models\User::whereNotNull('city')
                                  ->distinct()
                                  ->pluck('city');
        
        $hostelTypes = \App\Models\User::whereNotNull('hostel_type')
                                      ->distinct()
                                      ->pluck('hostel_type');
        
        return view('rooms.listing', compact('rooms', 'cities', 'hostelTypes'));
    }

    public function roomDetail($id) {
        $room = \App\Models\Room::with(['user', 'enteredBy'])->findOrFail($id);
        return view('rooms.detail', compact('room'));
    }

    public function getRoomApi($id) {
        try {
            $room = \App\Models\Room::with(['user', 'enteredBy'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'room' => $room
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Room not found'
            ], 404);
        }
    }

    public function debugRooms() {
        $rooms = \App\Models\Room::select('id', 'name', 'price_per_night', 'capacity', 'room_type', 'is_available', 'amenities', 'images')->get();
        
        echo "<h2>Database Rooms Debug Info:</h2>";
        echo "<p>Total Rooms: " . $rooms->count() . "</p>";
        echo "<p>Price Range: PKR " . $rooms->min('price_per_night') . " - PKR " . $rooms->max('price_per_night') . "</p>";
        
        echo "<h3>Sample Rooms:</h3>";
        foreach($rooms->take(5) as $room) {
            echo "<hr>";
            echo "<p><strong>ID:</strong> {$room->id}</p>";
            echo "<p><strong>Name:</strong> {$room->name}</p>";
            echo "<p><strong>Price:</strong> PKR {$room->price_per_night}</p>";
            echo "<p><strong>Capacity:</strong> {$room->capacity}</p>";
            echo "<p><strong>Type:</strong> {$room->room_type}</p>";
            echo "<p><strong>Available:</strong> " . ($room->is_available ? 'Yes' : 'No') . "</p>";
            echo "<p><strong>Amenities (Raw):</strong> " . json_encode($room->amenities) . "</p>";
            echo "<p><strong>Amenities (Type):</strong> " . gettype($room->amenities) . "</p>";
            echo "<p><strong>Images (Raw):</strong> " . json_encode($room->images) . "</p>";
            echo "<p><strong>Images (Type):</strong> " . gettype($room->images) . "</p>";
        }
        
        exit;
    }
    public function hostels() { 
        $hostels = \App\Models\User::orderBy('hostel_name')
                                  ->get();
        return view('hostels', compact('hostels')); 
    }
    public function hostelDetail($id) { 
        $hostel = \App\Models\User::findOrFail($id);
        return view('hostels.detail', compact('hostel')); 
    }

    // Error pages
    public function error404() { return view('404'); }
    public function error() { return view('error'); }

}
