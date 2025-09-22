<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ClientApiController extends Controller
{
    /**
     * Get all verified clients/hostels
     */
    public function getHostels(Request $request): JsonResponse
    {
        $query = User::where('role', 'client')->where('is_verified', true);

        // Filter by city
        if ($request->has('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        // Filter by hostel type
        if ($request->has('hostel_type')) {
            $query->where('hostel_type', $request->hostel_type);
        }

        // Filter by amenities
        if ($request->has('amenities')) {
            $amenities = explode(',', $request->amenities);
            foreach ($amenities as $amenity) {
                $query->whereJsonContains('amenities', $amenity);
            }
        }

        // Filter by price range
        if ($request->has('min_price') || $request->has('max_price')) {
            $query->whereHas('rooms', function ($q) use ($request) {
                if ($request->has('min_price')) {
                    $q->where('price_per_night', '>=', $request->min_price);
                }
                if ($request->has('max_price')) {
                    $q->where('price_per_night', '<=', $request->max_price);
                }
            });
        }

        $hostels = $query->with(['rooms' => function ($q) {
            $q->where('is_available', true);
        }])->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $hostels,
            'message' => 'Hostels retrieved successfully'
        ]);
    }

    /**
     * Get specific hostel details
     */
    public function getHostel($id): JsonResponse
    {
        $hostel = User::where('role', 'client')
            ->where('is_verified', true)
            ->where('id', $id)
            ->with(['rooms' => function ($q) {
                $q->where('is_available', true);
            }])
            ->first();

        if (!$hostel) {
            return response()->json([
                'success' => false,
                'message' => 'Hostel not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $hostel,
            'message' => 'Hostel details retrieved successfully'
        ]);
    }

    /**
     * Get hostel rooms
     */
    public function getHostelRooms($hostelId): JsonResponse
    {
        $rooms = Room::where('user_id', $hostelId)
            ->where('is_available', true)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $rooms,
            'message' => 'Rooms retrieved successfully'
        ]);
    }

    /**
     * Search hostels
     */
    public function searchHostels(Request $request): JsonResponse
    {
        $query = User::where('role', 'client')->where('is_verified', true);

        // Search by hostel name
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('hostel_name', 'like', '%' . $search . '%')
                  ->orWhere('hostel_description', 'like', '%' . $search . '%')
                  ->orWhere('city', 'like', '%' . $search . '%')
                  ->orWhere('state', 'like', '%' . $search . '%');
            });
        }

        // Filter by location
        if ($request->has('latitude') && $request->has('longitude')) {
            $lat = $request->latitude;
            $lng = $request->longitude;
            $radius = $request->get('radius', 10); // Default 10km

            $query->whereRaw("
                (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * 
                cos(radians(longitude) - radians(?)) + sin(radians(?)) * 
                sin(radians(latitude)))) <= ?
            ", [$lat, $lng, $lat, $radius]);
        }

        // Filter by check-in and check-out dates
        if ($request->has('check_in') && $request->has('check_out')) {
            $checkIn = $request->check_in;
            $checkOut = $request->check_out;

            $query->whereHas('rooms', function ($q) use ($checkIn, $checkOut) {
                $q->where('is_available', true)
                  ->whereDoesntHave('bookings', function ($bookingQ) use ($checkIn, $checkOut) {
                      $bookingQ->where('status', '!=', 'cancelled')
                               ->where(function ($dateQ) use ($checkIn, $checkOut) {
                                   $dateQ->whereBetween('check_in_date', [$checkIn, $checkOut])
                                         ->orWhereBetween('check_out_date', [$checkIn, $checkOut])
                                         ->orWhere(function ($overlapQ) use ($checkIn, $checkOut) {
                                             $overlapQ->where('check_in_date', '<=', $checkIn)
                                                      ->where('check_out_date', '>=', $checkOut);
                                         });
                               });
                  });
            });
        }

        $hostels = $query->with(['rooms' => function ($q) {
            $q->where('is_available', true);
        }])->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $hostels,
            'message' => 'Search results retrieved successfully'
        ]);
    }

    /**
     * Get popular hostels
     */
    public function getPopularHostels(): JsonResponse
    {
        $hostels = User::where('role', 'client')
            ->where('is_verified', true)
            ->withCount(['rooms', 'bookings'])
            ->orderBy('bookings_count', 'desc')
            ->take(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $hostels,
            'message' => 'Popular hostels retrieved successfully'
        ]);
    }

    /**
     * Get hostels by category
     */
    public function getHostelsByCategory($category): JsonResponse
    {
        $hostels = User::where('role', 'client')
            ->where('is_verified', true)
            ->where('hostel_type', $category)
            ->with(['rooms' => function ($q) {
                $q->where('is_available', true);
            }])
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $hostels,
            'message' => 'Hostels by category retrieved successfully'
        ]);
    }

    /**
     * Get nearby hostels
     */
    public function getNearbyHostels(Request $request): JsonResponse
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius' => 'numeric|min:1|max:100'
        ]);

        $lat = $request->latitude;
        $lng = $request->longitude;
        $radius = $request->get('radius', 10); // Default 10km

        $hostels = User::where('role', 'client')
            ->where('is_verified', true)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->whereRaw("
                (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * 
                cos(radians(longitude) - radians(?)) + sin(radians(?)) * 
                sin(radians(latitude)))) <= ?
            ", [$lat, $lng, $lat, $radius])
            ->with(['rooms' => function ($q) {
                $q->where('is_available', true);
            }])
            ->get();

        // Calculate distance for each hostel
        foreach ($hostels as $hostel) {
            $hostel->distance = $this->calculateDistance($lat, $lng, $hostel->latitude, $hostel->longitude);
        }

        // Sort by distance
        $hostels = $hostels->sortBy('distance')->values();

        return response()->json([
            'success' => true,
            'data' => $hostels,
            'message' => 'Nearby hostels retrieved successfully'
        ]);
    }

    /**
     * Get hostel amenities
     */
    public function getHostelAmenities($hostelId): JsonResponse
    {
        $hostel = User::where('role', 'client')
            ->where('id', $hostelId)
            ->select('amenities', 'policies')
            ->first();

        if (!$hostel) {
            return response()->json([
                'success' => false,
                'message' => 'Hostel not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'amenities' => $hostel->amenities ?? [],
                'policies' => $hostel->policies ?? []
            ],
            'message' => 'Hostel amenities retrieved successfully'
        ]);
    }

    /**
     * Calculate distance between two points
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2): float
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + 
                cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        return round($miles * 1.609344, 2); // Convert to kilometers
    }
}
