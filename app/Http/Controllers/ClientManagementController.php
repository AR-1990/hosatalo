<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ClientManagementController extends Controller
{
    /**
     * Display a listing of clients
     */
    public function index()
    {
        $clients = User::where('role', 'client')->latest()->get();
        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new client
     */
    public function create()
    {
        return view('admin.clients.create');
    }

    /**
     * Store a newly created client
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Basic User Info - Required
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            
            // NIC - Required for clients
            'nic' => 'required|string|max:20|unique:users',
            
            // Hostel Details - Required
            'hostel_name' => 'required|string|max:255',
            'hostel_description' => 'required|string',
            'hostel_address' => 'required|string',
            'hostel_phone' => 'required|string|max:20',
            'hostel_email' => 'required|email',
            'hostel_website' => 'nullable|url',
            
            // Business Details - Required
            'business_license' => 'required|string|max:100',
            'tax_number' => 'required|string|max:100',
            'hostel_type' => 'required|in:budget,mid-range,luxury',
            'total_rooms' => 'required|integer|min:1',
            'check_in_time' => 'required|date_format:H:i',
            'check_out_time' => 'required|date_format:H:i',
            
            // Location - Required
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            
            // Images
            'hostel_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hostel_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hostel_gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            
            // Optional fields
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'amenities' => 'nullable|array',
            'policies' => 'nullable|array',
            'special_offers' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        Log::info('CREATE: Request data keys: ' . implode(', ', array_keys($data)));
        Log::info('CREATE: Files in request: ' . ($request->hasFile('hostel_logo') ? 'Logo: YES' : 'Logo: NO') . ', ' . ($request->hasFile('hostel_banner') ? 'Banner: YES' : 'Banner: NO') . ', ' . ($request->hasFile('hostel_gallery') ? 'Gallery: YES' : 'Gallery: NO'));
        $data['role'] = 'client';
        $data['password'] = Hash::make($request->password);
        $data['is_verified'] = false;

        // Handle hostel logo
        if ($request->hasFile('hostel_logo')) {
            Log::info('Logo file detected: ' . $request->file('hostel_logo')->getClientOriginalName());
            $logo = $request->file('hostel_logo');
            $logoName = time() . '_logo_' . $logo->getClientOriginalName();
            $logo->move(public_path('uploads/hostels/logos'), $logoName);
            $data['hostel_logo'] = 'uploads/hostels/logos/' . $logoName;
            Log::info('Logo saved to: ' . $data['hostel_logo']);
        } else {
            Log::info('No logo file uploaded');
        }

        // Handle hostel banner
        if ($request->hasFile('hostel_banner')) {
            Log::info('CREATE: Banner file detected: ' . $request->file('hostel_banner')->getClientOriginalName());
            $banner = $request->file('hostel_banner');
            $bannerName = time() . '_banner_' . $banner->getClientOriginalName();
            $banner->move(public_path('uploads/hostels/banners'), $bannerName);
            $data['hostel_banner'] = 'uploads/hostels/banners/' . $bannerName;
            Log::info('CREATE: Banner saved to: ' . $data['hostel_banner']);
        } else {
            Log::info('CREATE: No banner file uploaded');
        }

        // Handle hostel gallery
        $galleryImages = [];
        if ($request->hasFile('hostel_gallery')) {
            Log::info('CREATE: Gallery files detected: ' . count($request->file('hostel_gallery')) . ' files');
            foreach ($request->file('hostel_gallery') as $image) {
                $imageName = time() . '_gallery_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/hostels/gallery'), $imageName);
                $galleryImages[] = 'uploads/hostels/gallery/' . $imageName;
                Log::info('CREATE: Gallery image saved: ' . $imageName);
            }
            $data['hostel_gallery'] = $galleryImages;
        } else {
            Log::info('CREATE: No gallery files uploaded');
        }

        // Convert arrays to JSON
        $data['amenities'] = $request->amenities ?? [];
        $data['policies'] = $request->policies ?? [];

        User::create($data);

        return redirect()->route('admin.clients.index')->with('success', 'Client registered successfully!');
    }

    /**
     * Display the specified client
     */
    public function show(User $client)
    {
        if ($client->role !== 'client') {
            abort(404);
        }
        return view('admin.clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified client
     */
    public function edit(User $client)
    {
        if ($client->role !== 'client') {
            abort(404);
        }
        return view('admin.clients.edit', compact('client'));
    }

    /**
     * Update the specified client
     */
    public function update(Request $request, User $client)
    {
        if ($client->role !== 'client') {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            // Basic User Info
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $client->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            
            // NIC
            'nic' => 'required|string|max:20|unique:users,nic,' . $client->id,
            
            // Password (optional for update)
            'password' => 'nullable|string|min:8|confirmed',
            
            // Hostel Details
            'hostel_name' => 'required|string|max:255',
            'hostel_description' => 'required|string',
            'hostel_address' => 'required|string',
            'hostel_phone' => 'required|string|max:20',
            'hostel_email' => 'required|email',
            'hostel_website' => 'nullable|url',
            
            // Business Details
            'business_license' => 'required|string|max:100',
            'tax_number' => 'required|string|max:100',
            'hostel_type' => 'required|in:budget,mid-range,luxury',
            'total_rooms' => 'required|integer|min:1',
            'check_in_time' => 'required|date_format:H:i',
            'check_out_time' => 'required|date_format:H:i',
            
            // Location
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            
            // Images
            'hostel_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hostel_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hostel_gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            
            // Optional fields
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'amenities' => 'nullable|array',
            'policies' => 'nullable|array',
            'special_offers' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        Log::info('UPDATE: Request data keys: ' . implode(', ', array_keys($data)));
        Log::info('UPDATE: Files in request: ' . ($request->hasFile('hostel_logo') ? 'Logo: YES' : 'Logo: NO') . ', ' . ($request->hasFile('hostel_banner') ? 'Banner: YES' : 'Banner: NO') . ', ' . ($request->hasFile('hostel_gallery') ? 'Gallery: YES' : 'Gallery: NO'));
        
        // Handle password update
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            // Remove password from data if not provided
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        // Handle hostel logo
        if ($request->hasFile('hostel_logo')) {
            // Delete old logo
            if ($client->hostel_logo && file_exists(public_path($client->hostel_logo))) {
                unlink(public_path($client->hostel_logo));
            }
            
            $logo = $request->file('hostel_logo');
            $logoName = time() . '_logo_' . $logo->getClientOriginalName();
            $logo->move(public_path('uploads/hostels/logos'), $logoName);
            $data['hostel_logo'] = 'uploads/hostels/logos/' . $logoName;
        } else {
            // Keep existing logo if no new one uploaded
            $data['hostel_logo'] = $client->hostel_logo;
        }

        // Handle hostel banner
        if ($request->hasFile('hostel_banner')) {
            Log::info('Banner file detected: ' . $request->file('hostel_banner')->getClientOriginalName());
            // Delete old banner
            if ($client->hostel_banner && file_exists(public_path($client->hostel_banner))) {
                unlink(public_path($client->hostel_banner));
            }
            
            $banner = $request->file('hostel_banner');
            $bannerName = time() . '_banner_' . $banner->getClientOriginalName();
            $banner->move(public_path('uploads/hostels/banners'), $bannerName);
            $data['hostel_banner'] = 'uploads/hostels/banners/' . $bannerName;
            Log::info('Banner saved to: ' . $data['hostel_banner']);
        } else {
            Log::info('No banner file uploaded');
            // Keep existing banner if no new one uploaded
            $data['hostel_banner'] = $client->hostel_banner;
        }

        // Handle hostel gallery
        if ($request->hasFile('hostel_gallery')) {
            Log::info('Gallery files detected: ' . count($request->file('hostel_gallery')) . ' files');
            // Delete old gallery images
            if ($client->hostel_gallery) {
                foreach ($client->hostel_gallery as $oldImage) {
                    if (file_exists(public_path($oldImage))) {
                        unlink(public_path($oldImage));
                    }
                }
            }
            
            $galleryImages = [];
            foreach ($request->file('hostel_gallery') as $image) {
                $imageName = time() . '_gallery_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/hostels/gallery'), $imageName);
                $galleryImages[] = 'uploads/hostels/gallery/' . $imageName;
                Log::info('Gallery image saved: ' . $imageName);
            }
            $data['hostel_gallery'] = $galleryImages;
        } else {
            Log::info('No gallery files uploaded');
            // Keep existing gallery if no new images uploaded
            $data['hostel_gallery'] = $client->hostel_gallery;
        }

        // Convert arrays to JSON
        $data['amenities'] = $request->amenities ?? [];
        $data['policies'] = $request->policies ?? [];

        $client->update($data);

        return redirect()->route('admin.clients.index')->with('success', 'Client updated successfully!');
    }

    /**
     * Remove the specified client
     */
    public function destroy(User $client)
    {
        if ($client->role !== 'client') {
            abort(404);
        }

        // Delete images
        if ($client->hostel_logo && file_exists(public_path($client->hostel_logo))) {
            unlink(public_path($client->hostel_logo));
        }
        if ($client->hostel_banner && file_exists(public_path($client->hostel_banner))) {
            unlink(public_path($client->hostel_banner));
        }
        if ($client->hostel_gallery) {
            foreach ($client->hostel_gallery as $image) {
                if (file_exists(public_path($image))) {
                    unlink(public_path($image));
                }
            }
        }

        $client->delete();

        return redirect()->route('admin.clients.index')->with('success', 'Client deleted successfully!');
    }

    /**
     * Verify a client
     */
    public function verify(User $client)
    {
        if ($client->role !== 'client') {
            abort(404);
        }

        $client->update([
            'is_verified' => true,
            'verified_at' => now(),
        ]);

        return redirect()->route('admin.clients.index')->with('success', 'Client verified successfully!');
    }

    /**
     * Unverify a client
     */
    public function unverify(User $client)
    {
        if ($client->role !== 'client') {
            abort(404);
        }

        $client->update([
            'is_verified' => false,
            'verified_at' => null,
        ]);

        return redirect()->route('admin.clients.index')->with('success', 'Client unverified successfully!');
    }
}
