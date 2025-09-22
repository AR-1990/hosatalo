<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function advanceTable() { return view('admin.advance-table'); }
    public function alert() { return view('admin.alert'); }
    public function authForgotPassword() { return view('admin.auth-forgot-password'); }
    public function authLogin() { return view('admin.auth-login'); }
    public function authRegister() { return view('admin.auth-register'); }
    public function authResetPassword() { return view('admin.auth-reset-password'); }
    public function avatar() { return view('admin.avatar'); }
    public function badge() { return view('admin.badge'); }
    public function basicForm() { return view('admin.basic-form'); }
    public function basicTable() { return view('admin.basic-table'); }
    public function blank() { return view('admin.blank'); }
    public function blog() { return view('admin.blog'); }
    public function breadcrumb() { return view('admin.breadcrumb'); }
    public function buttons() { return view('admin.buttons'); }
    public function calendar() { return view('admin.calendar'); }
    public function card() { return view('admin.card'); }
    public function carousel() { return view('admin.carousel'); }
    public function chartAmchart() { return view('admin.chart-amchart'); }
    public function chartApex() { return view('admin.chart-apex'); }
    public function chartChartjs() { return view('admin.chart-chartjs'); }
    public function chartEchart() { return view('admin.chart-echart'); }
    public function chartMorris() { return view('admin.chart-morris'); }
    public function chartSparkline() { return view('admin.chart-sparkline'); }
    public function checkboxRadio() { return view('admin.checkbox-radio'); }
    public function collapse() { return view('admin.collapse'); }
    public function contact() { return view('admin.contact'); }
    public function createPost() { return view('admin.create-post'); }
    public function datatables() { return view('admin.datatables'); }
    public function dropdown() { return view('admin.dropdown'); }
    public function editableTable() { return view('admin.editable-table'); }
    public function emailCompose() { return view('admin.email-compose'); }
    public function emailInbox() { return view('admin.email-inbox'); }
    public function emailRead() { return view('admin.email-read'); }
    public function emptyState() { return view('admin.empty-state'); }
    public function errors403() { return view('admin.errors-403'); }
    public function errors404() { return view('admin.errors-404'); }
    public function errors500() { return view('admin.errors-500'); }
    public function errors503() { return view('admin.errors-503'); }
    public function exportTable() { return view('admin.export-table'); }
    public function flags() { return view('admin.flags'); }
    public function formsAdvanced() { return view('admin.forms-advanced'); }
    public function formsEditor() { return view('admin.forms-editor'); }
    public function formsValidation() { return view('admin.forms-validation'); }
    public function formWizard() { return view('admin.form-wizard'); }
    public function gallery1() { return view('admin.gallery1'); }
    public function gmapsAdvanced() { return view('admin.gmaps-advanced'); }
    public function gmapsDraggable() { return view('admin.gmaps-draggable'); }
    public function gmapsGeocoding() { return view('admin.gmaps-geocoding'); }
    public function gmapsGeolocation() { return view('admin.gmaps-geolocation'); }
    public function gmapsMarker() { return view('admin.gmaps-marker'); }
    public function gmapsMultipleMarker() { return view('admin.gmaps-multiple-marker'); }
    public function gmapsRoute() { return view('admin.gmaps-route'); }
    public function gmapsSimple() { return view('admin.gmaps-simple'); }
    public function iconFeather() { return view('admin.icon-feather'); }
    public function iconFontAwesome() { return view('admin.icon-font-awesome'); }
    public function iconIonicons() { return view('admin.icon-ionicons'); }
    public function iconMaterial() { return view('admin.icon-material'); }
    public function iconWeather() { return view('admin.icon-weather'); }
    public function index() { return view('admin.index'); }
    public function invoice() { return view('admin.invoice'); }
    public function lightGallery() { return view('admin.light-gallery'); }
    public function listGroup() { return view('admin.list-group'); }
    public function mailInbox() { return view('admin.mail-inbox'); }
    public function mediaObject() { return view('admin.media-object'); }
    public function modal() { return view('admin.modal'); }
    public function multipleUpload() { return view('admin.multiple-upload'); }
    public function navbar() { return view('admin.navbar'); }
    public function owlCarousel() { return view('admin.owl-carousel'); }
    public function pagination() { return view('admin.pagination'); }
    public function popover() { return view('admin.popover'); }
    public function portfolio() { return view('admin.portfolio'); }
    public function posts() { return view('admin.posts'); }
    public function pricing() { return view('admin.pricing'); }
    public function profile() { return view('admin.profile'); }
    public function progress() { return view('admin.progress'); }
    public function subscribe() { return view('admin.subscribe'); }
    public function sweetAlert() { return view('admin.sweet-alert'); }
    public function tabs() { return view('admin.tabs'); }
    public function timeline() { return view('admin.timeline'); }
    public function toastr() { return view('admin.toastr'); }
    public function tooltip() { return view('admin.tooltip'); }
    public function typography() { return view('admin.typography'); }
    public function vectorMap() { return view('admin.vector-map'); }
    public function widgetChart() { return view('admin.widget-chart'); }
    public function widgetData() { return view('admin.widget-data'); }

    // Room Management Methods for Clients
    public function clientRooms()
    {
        // Check if user is authenticated and is a client
        if (!Auth::check() || Auth::user()->role !== 'client') {
            return redirect()->route('login')->with('error', 'Access denied. Only clients can manage rooms.');
        }

        $rooms = Room::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('admin.client.rooms.index', compact('rooms'));
    }

    public function createRoom()
    {
        // Check if user is authenticated and is a client
        if (!Auth::check() || Auth::user()->role !== 'client') {
            return redirect()->route('login')->with('error', 'Access denied. Only clients can create rooms.');
        }

        return view('admin.client.rooms.create');
    }

    public function storeRoom(Request $request)
    {
        // Check if user is authenticated and is a client
        if (!Auth::check() || Auth::user()->role !== 'client') {
            return redirect()->back()->with('error', 'Access denied. Only clients can create rooms.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'room_type' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'amenities' => 'nullable|array',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/rooms'), $imageName);
            $data['image'] = 'uploads/rooms/' . $imageName;
        }

        $data['user_id'] = Auth::id();
        $data['entered_by'] = Auth::id();
        $data['amenities'] = $request->amenities ?? [];

        Room::create($data);

        return redirect()->route('admin.client.rooms')->with('success', 'Room created successfully!');
    }

    public function editRoom($id)
    {
        // Check if user is authenticated and is a client
        if (!Auth::check() || Auth::user()->role !== 'client') {
            return redirect()->route('login')->with('error', 'Access denied. Only clients can edit rooms.');
        }

        $room = Room::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('admin.client.rooms.edit', compact('room'));
    }

    public function updateRoom(Request $request, $id)
    {
        // Check if user is authenticated and is a client
        if (!Auth::check() || Auth::user()->role !== 'client') {
            return redirect()->back()->with('error', 'Access denied. Only clients can update rooms.');
        }

        $room = Room::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'room_type' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'amenities' => 'nullable|array',
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

        $data['entered_by'] = Auth::id();
        $data['amenities'] = $request->amenities ?? [];

        $room->update($data);

        return redirect()->route('admin.client.rooms')->with('success', 'Room updated successfully!');
    }

    public function deleteRoom($id)
    {
        // Check if user is authenticated and is a client
        if (!Auth::check() || Auth::user()->role !== 'client') {
            return redirect()->back()->with('error', 'Access denied. Only clients can delete rooms.');
        }

        $room = Room::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($room->image && file_exists(public_path($room->image))) {
            unlink(public_path($room->image));
        }
        
        $room->delete();

        return redirect()->route('admin.client.rooms')->with('success', 'Room deleted successfully!');
    }

    public function toggleRoomAvailability($id)
    {
        // Check if user is authenticated and is a client
        if (!Auth::check() || Auth::user()->role !== 'client') {
            return redirect()->back()->with('error', 'Access denied. Only clients can manage room availability.');
        }

        $room = Room::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $room->is_available = !$room->is_available;
        $room->save();

        $status = $room->is_available ? 'available' : 'unavailable';
        return redirect()->route('admin.client.rooms')->with('success', "Room marked as {$status}!");
    }
}
