<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClientApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public API routes for mobile applications
Route::prefix('v1')->group(function () {
    // Hostel endpoints
    Route::get('/hostels', [ClientApiController::class, 'getHostels']);
    Route::get('/hostels/search', [ClientApiController::class, 'searchHostels']);
    Route::get('/hostels/popular', [ClientApiController::class, 'getPopularHostels']);
    Route::get('/hostels/category/{category}', [ClientApiController::class, 'getHostelsByCategory']);
    Route::get('/hostels/nearby', [ClientApiController::class, 'getNearbyHostels']);
    
    // Specific hostel details
    Route::get('/hostels/{id}', [ClientApiController::class, 'getHostel']);
    Route::get('/hostels/{hostelId}/rooms', [ClientApiController::class, 'getHostelRooms']);
    Route::get('/hostels/{hostelId}/amenities', [ClientApiController::class, 'getHostelAmenities']);
});
