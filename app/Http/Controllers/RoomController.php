<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    /**
     * Display a listing of rooms
     */
    public function index()
    {
        // If admin, show all rooms. If client, show only their rooms
        if (Auth::check() && Auth::user()->role === 'admin') {
            $rooms = Room::with('user')->get();
        } else {
            $rooms = Room::where('user_id', Auth::id())->get();
        }
        
        return view('rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new room
     */
    public function create()
    {
        return view('rooms.create');
    }

    /**
     * Store a newly created room
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'room_type' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'amenities' => 'nullable|array',
            'user_id' => 'required|exists:users,id', // Required for admin
            'is_available' => 'boolean',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/rooms'), $imageName);
            $data['image'] = 'uploads/rooms/' . $imageName;
        }

        // Set user_id based on role
        if (Auth::check() && Auth::user()->role === 'admin') {
            $data['user_id'] = $request->user_id;
        } else {
            $data['user_id'] = Auth::id();
        }
        
        // Set entered_by to current user ID
        $data['entered_by'] = Auth::id();
        
        $data['amenities'] = $request->amenities ?? [];
        $data['is_available'] = $request->has('is_available') ? 1 : 0;

        Room::create($data);

        return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully!');
    }

    /**
     * Display the specified room
     */
    public function show(Room $room)
    {
        // Check if user can view this room
        if (Auth::check() && Auth::user()->role !== 'admin' && $room->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this room.');
        }
        
        return view('rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified room
     */
    public function edit(Room $room)
    {
        // Check if user can edit this room
        if (Auth::check() && Auth::user()->role !== 'admin' && $room->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to edit this room.');
        }
        
        return view('rooms.edit', compact('room'));
    }

    /**
     * Update the specified room
     */
    public function update(Request $request, Room $room)
    {
        // Check if user can update this room
        if (Auth::check() && Auth::user()->role !== 'admin' && $room->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to update this room.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'room_type' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'amenities' => 'nullable|array',
            'rules' => 'nullable|string',
            'user_id' => 'required|exists:users,id', // Required for admin
            'is_available' => 'boolean',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            // Delete old image
            if ($room->image && file_exists(public_path($room->image))) {
                unlink(public_path($room->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/rooms'), $imageName);
            $data['image'] = 'uploads/rooms/' . $imageName;
        }

        // Handle multiple images
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) { // Only process valid images
                    $imageName = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('uploads/rooms'), $imageName);
                    $images[] = 'uploads/rooms/' . $imageName;
                }
            }
            $data['images'] = $images;
        } else {
            $data['images'] = []; // Ensure it's an empty array, not null
        }

        // Set user_id based on role
        if (Auth::check() && Auth::user()->role === 'admin') {
            $data['user_id'] = $request->user_id;
        } else {
            $data['user_id'] = Auth::id();
        }
        
        // Set entered_by to current user ID for updates
        $data['entered_by'] = Auth::id();
        
        $data['amenities'] = $request->amenities ?? [];
        $data['is_available'] = $request->has('is_available') ? 1 : 0;

        $room->update($data);

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully!');
    }

    /**
     * Remove the specified room
     */
    public function destroy(Room $room)
    {
        // Check if user can delete this room
        if (Auth::check() && Auth::user()->role !== 'admin' && $room->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to delete this room.');
        }

        if ($room->image && file_exists(public_path($room->image))) {
            unlink(public_path($room->image));
        }
        
        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully!');
    }
}
