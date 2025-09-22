<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ClientManagementController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public routes
Route::get('/welcome', [FrontController::class, 'welcome'])->name('welcome');
Route::get('/about', [FrontController::class, 'about'])->name('about');
Route::get('/contacts', [FrontController::class, 'contacts'])->name('contacts');
Route::get('/contacts2', [FrontController::class, 'contacts2'])->name('contacts2');
Route::get('/faq', [FrontController::class, 'faq'])->name('faq');
Route::get('/faq2', [FrontController::class, 'faq2'])->name('faq2');
Route::get('/gallery', [FrontController::class, 'gallery'])->name('gallery');
Route::get('/', [FrontController::class, 'index'])->name('index');
Route::get('/index04b9', [FrontController::class, 'index04b9'])->name('index04b9');
Route::get('/news', [FrontController::class, 'news'])->name('news');
Route::get('/post', [FrontController::class, 'post'])->name('post');
Route::get('/room', [FrontController::class, 'room'])->name('room');
Route::get('/rooms', [FrontController::class, 'rooms'])->name('rooms');
Route::get('/rooms/search', [FrontController::class, 'searchRooms'])->name('rooms.search');
Route::get('/rooms/{id}', [FrontController::class, 'roomDetail'])->name('rooms.detail');
Route::get('/api/rooms/{id}', [FrontController::class, 'getRoomApi'])->name('api.rooms.show');
Route::get('/debug/rooms', [FrontController::class, 'debugRooms'])->name('debug.rooms');
Route::post('/contact', [ContactController::class, 'storeGeneral'])->name('contact.store');
Route::post('/contact/room-inquiry', [ContactController::class, 'store'])->name('contact.room-inquiry');
Route::get('/hostels', [FrontController::class, 'hostels'])->name('hostels');
Route::get('/hostels/{id}', [FrontController::class, 'hostelDetail'])->name('hostels.detail');

// Error pages
Route::get('/404', [FrontController::class, 'error404'])->name('404');
Route::get('/error', [FrontController::class, 'error'])->name('error');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // User dashboard
    Route::get('/user/dashboard', [AuthController::class, 'userDashboard'])->name('user.dashboard');
    
    // Client dashboard
    Route::get('/client/dashboard', [AuthController::class, 'clientDashboard'])->name('client.dashboard');
    
    // Admin dashboard
    Route::get('/admin/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');
    
    // Admin client management
    Route::resource('admin/clients', ClientManagementController::class)->names('admin.clients');
    Route::patch('/admin/clients/{client}/verify', [ClientManagementController::class, 'verify'])->name('admin.clients.verify');
    Route::patch('/admin/clients/{client}/unverify', [ClientManagementController::class, 'unverify'])->name('admin.clients.unverify');
    
    // Admin lead management
    Route::get('/admin/leads', [ContactController::class, 'adminIndex'])->name('admin.leads.index');
    Route::get('/admin/leads/create', [ContactController::class, 'adminCreate'])->name('admin.leads.create');
    Route::post('/admin/leads', [ContactController::class, 'adminStore'])->name('admin.leads.store');
    Route::get('/admin/leads/{contact}', [ContactController::class, 'adminShow'])->name('admin.leads.show');
    Route::get('/admin/leads/{contact}/edit', [ContactController::class, 'adminEdit'])->name('admin.leads.edit');
    Route::put('/admin/leads/{contact}', [ContactController::class, 'adminUpdate'])->name('admin.leads.update');
    Route::patch('/admin/leads/{contact}/status', [ContactController::class, 'updateStatus'])->name('admin.leads.status');
    Route::post('/admin/leads/{contact}/approve-booking', [ContactController::class, 'approveBooking'])->name('admin.leads.approve-booking');
    Route::get('/admin/leads/{contact}/test-approval', [ContactController::class, 'testApproval'])->name('admin.leads.test-approval');
    Route::post('/admin/leads/{contact}/check-availability', [ContactController::class, 'checkRoomAvailability'])->name('admin.leads.check-availability');
    Route::post('/admin/leads/{contact}/add-note', [ContactController::class, 'addNote'])->name('admin.leads.add-note');
    
    // Admin booking management
    Route::get('/admin/bookings', [App\Http\Controllers\Admin\BookingController::class, 'index'])->name('admin.bookings.index');
    Route::get('/admin/bookings/create', [App\Http\Controllers\Admin\BookingController::class, 'create'])->name('admin.bookings.create');
    Route::post('/admin/bookings', [App\Http\Controllers\Admin\BookingController::class, 'store'])->name('admin.bookings.store');
    Route::get('/admin/bookings/{booking}', [App\Http\Controllers\Admin\BookingController::class, 'show'])->name('admin.bookings.show');
    Route::get('/admin/bookings/{booking}/edit', [App\Http\Controllers\Admin\BookingController::class, 'edit'])->name('admin.bookings.edit');
    Route::put('/admin/bookings/{booking}', [App\Http\Controllers\Admin\BookingController::class, 'update'])->name('admin.bookings.update');
    Route::patch('/admin/bookings/{booking}/status', [App\Http\Controllers\Admin\BookingController::class, 'updateStatus'])->name('admin.bookings.update-status');
    Route::post('/admin/bookings/{booking}/assign-room', [App\Http\Controllers\Admin\BookingController::class, 'assignRoom'])->name('admin.bookings.assign-room');
    Route::patch('/admin/bookings/{booking}/notes', [App\Http\Controllers\Admin\BookingController::class, 'updateNotes'])->name('admin.bookings.update-notes');
    Route::post('/admin/bookings/{booking}/cancel', [App\Http\Controllers\Admin\BookingController::class, 'cancel'])->name('admin.bookings.cancel');
    Route::post('/admin/bookings/check-availability', [App\Http\Controllers\Admin\BookingController::class, 'checkAvailability'])->name('admin.bookings.check-availability');
    Route::get('/admin/bookings/report', [App\Http\Controllers\Admin\BookingController::class, 'report'])->name('admin.bookings.report');
    Route::get('/admin/bookings/export', [App\Http\Controllers\Admin\BookingController::class, 'export'])->name('admin.bookings.export');
    
    // Admin payment management
    Route::get('/admin/payments', [PaymentController::class, 'index'])->name('admin.payments.index');
    Route::get('/admin/payments/report', [PaymentController::class, 'report'])->name('admin.payments.report');
    Route::get('/admin/payments/export', [PaymentController::class, 'export'])->name('admin.payments.export');
    Route::get('/admin/payments/{payment}', [PaymentController::class, 'show'])->name('admin.payments.show');
    Route::get('/admin/payments/{payment}/edit', [PaymentController::class, 'edit'])->name('admin.payments.edit');
    Route::put('/admin/payments/{payment}', [PaymentController::class, 'update'])->name('admin.payments.update');
    Route::delete('/admin/payments/{payment}', [PaymentController::class, 'destroy'])->name('admin.payments.destroy');
    Route::post('/admin/payments/{payment}/mark-completed', [PaymentController::class, 'markAsCompleted'])->name('admin.payments.mark-completed');
    
    // Payment creation (for existing bookings)
    Route::get('/admin/bookings/{booking}/payments/create', [PaymentController::class, 'create'])->name('admin.payments.create');
    Route::post('/admin/bookings/{booking}/payments', [PaymentController::class, 'store'])->name('admin.payments.store');
    
    // Admin Room Management (Protected)
    Route::get('/admin/rooms', [RoomController::class, 'index'])->name('admin.rooms.index');
    Route::get('/admin/rooms/create', [RoomController::class, 'create'])->name('admin.rooms.create');
    Route::post('/admin/rooms', [RoomController::class, 'store'])->name('admin.rooms.store');
    Route::get('/admin/rooms/{room}', [RoomController::class, 'show'])->name('admin.rooms.show');
    Route::get('/admin/rooms/{room}/edit', [RoomController::class, 'edit'])->name('admin.rooms.edit');
    Route::put('/admin/rooms/{room}', [RoomController::class, 'update'])->name('admin.rooms.update');
    Route::delete('/admin/rooms/{room}', [RoomController::class, 'destroy'])->name('admin.rooms.destroy');
    
    // Booking routes
    Route::resource('bookings', BookingController::class);
    Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.update-status');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('/bookings/{booking}/assign-room', [BookingController::class, 'assignRoom'])->name('bookings.assign-room');
    Route::patch('/bookings/{booking}/notes', [BookingController::class, 'updateNotes'])->name('bookings.update-notes');
    Route::post('/bookings/check-availability', [BookingController::class, 'checkAvailability'])->name('bookings.check-availability');
});

// / Admin Panel Routes
Route::get('/admin', [AdminController::class, 'index'])->name('index');

// Admin Room Management Routes for Clients
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/client/rooms', [AdminController::class, 'clientRooms'])->name('admin.client.rooms');
    Route::get('/admin/client/rooms/create', [AdminController::class, 'createRoom'])->name('admin.client.rooms.create');
    Route::post('/admin/client/rooms', [AdminController::class, 'storeRoom'])->name('admin.client.rooms.store');
    Route::get('/admin/client/rooms/{id}/edit', [AdminController::class, 'editRoom'])->name('admin.client.rooms.edit');
    Route::put('/admin/client/rooms/{id}', [AdminController::class, 'updateRoom'])->name('admin.client.rooms.update');
    Route::delete('/admin/client/rooms/{id}', [AdminController::class, 'deleteRoom'])->name('admin.client.rooms.destroy');
    Route::patch('/admin/client/rooms/{id}/toggle-availability', [AdminController::class, 'toggleRoomAvailability'])->name('admin.client.rooms.toggle-availability');
});

Route::get('/admin/advance-table', [AdminController::class, 'advanceTable'])->name('advance.table');
Route::get('/admin/alert', [AdminController::class, 'alert'])->name('alert');
Route::get('/admin/auth-forgot-password', [AdminController::class, 'authForgotPassword'])->name('auth.forgot.password');
Route::get('/admin/auth-login', [AdminController::class, 'authLogin'])->name('auth.login');
Route::get('/admin/auth-register', [AdminController::class, 'authRegister'])->name('auth.register');
Route::get('/admin/auth-reset-password', [AdminController::class, 'authResetPassword'])->name('auth.reset.password');
Route::get('/admin/avatar', [AdminController::class, 'avatar'])->name('avatar');
Route::get('/admin/badge', [AdminController::class, 'badge'])->name('badge');
Route::get('/admin/basic-form', [AdminController::class, 'basicForm'])->name('basic.form');
Route::get('/admin/basic-table', [AdminController::class, 'basicTable'])->name('basic.table');
Route::get('/admin/blank', [AdminController::class, 'blank'])->name('blank');
Route::get('/admin/blog', [AdminController::class, 'blog'])->name('blog');
Route::get('/admin/breadcrumb', [AdminController::class, 'breadcrumb'])->name('breadcrumb');
Route::get('/admin/buttons', [AdminController::class, 'buttons'])->name('buttons');
Route::get('/admin/calendar', [AdminController::class, 'calendar'])->name('calendar');
Route::get('/admin/card', [AdminController::class, 'card'])->name('card');
Route::get('/admin/carousel', [AdminController::class, 'carousel'])->name('carousel');
Route::get('/admin/chart-amchart', [AdminController::class, 'chartAmchart'])->name('chart.amchart');
Route::get('/admin/chart-apex', [AdminController::class, 'chartApex'])->name('chart.apex');
Route::get('/admin/chart-chartjs', [AdminController::class, 'chartChartjs'])->name('chart.chartjs');
Route::get('/admin/chart-echart', [AdminController::class, 'chartEchart'])->name('chart.echart');
Route::get('/admin/chart-morris', [AdminController::class, 'chartMorris'])->name('chart.morris');
Route::get('/admin/chart-sparkline', [AdminController::class, 'chartSparkline'])->name('chart.sparkline');
Route::get('/admin/checkbox-radio', [AdminController::class, 'checkboxRadio'])->name('checkbox.radio');
Route::get('/admin/collapse', [AdminController::class, 'collapse'])->name('collapse');
Route::get('/admin/contact', [AdminController::class, 'contact'])->name('contact');
Route::get('/admin/create-post', [AdminController::class, 'createPost'])->name('create.post');
Route::get('/admin/datatables', [AdminController::class, 'datatables'])->name('datatables');
Route::get('/admin/dropdown', [AdminController::class, 'dropdown'])->name('dropdown');
Route::get('/admin/editable-table', [AdminController::class, 'editableTable'])->name('editable.table');
Route::get('/admin/email-compose', [AdminController::class, 'emailCompose'])->name('email.compose');
Route::get('/admin/email-inbox', [AdminController::class, 'emailInbox'])->name('email.inbox');
Route::get('/admin/email-read', [AdminController::class, 'emailRead'])->name('email.read');
Route::get('/admin/empty-state', [AdminController::class, 'emptyState'])->name('empty.state');
Route::get('/admin/errors-403', [AdminController::class, 'errors403'])->name('errors.403');
Route::get('/admin/errors-404', [AdminController::class, 'errors404'])->name('errors.404');
Route::get('/admin/errors-500', [AdminController::class, 'errors500'])->name('errors.500');
Route::get('/admin/errors-503', [AdminController::class, 'errors503'])->name('errors.503');
Route::get('/admin/export-table', [AdminController::class, 'exportTable'])->name('export.table');
Route::get('/admin/flags', [AdminController::class, 'flags'])->name('flags');
Route::get('/admin/forms-advanced', [AdminController::class, 'formsAdvanced'])->name('forms.advanced');
Route::get('/admin/forms-editor', [AdminController::class, 'formsEditor'])->name('forms.editor');
Route::get('/admin/forms-validation', [AdminController::class, 'formsValidation'])->name('forms.validation');
Route::get('/admin/form-wizard', [AdminController::class, 'formWizard'])->name('form.wizard');
Route::get('/admin/gallery1', [AdminController::class, 'gallery1'])->name('gallery1');
Route::get('/admin/gmaps-advanced', [AdminController::class, 'gmapsAdvanced'])->name('gmaps.advanced');
Route::get('/admin/gmaps-draggable', [AdminController::class, 'gmapsDraggable'])->name('gmaps.draggable');
Route::get('/admin/gmaps-geocoding', [AdminController::class, 'gmapsGeocoding'])->name('gmaps.geocoding');
Route::get('/admin/gmaps-geolocation', [AdminController::class, 'gmapsGeolocation'])->name('gmaps.geolocation');
Route::get('/admin/gmaps-marker', [AdminController::class, 'gmapsMarker'])->name('gmaps.marker');
Route::get('/admin/gmaps-multiple-marker', [AdminController::class, 'gmapsMultipleMarker'])->name('gmaps.multiple.marker');
Route::get('/admin/gmaps-route', [AdminController::class, 'gmapsRoute'])->name('gmaps.route');
Route::get('/admin/gmaps-simple', [AdminController::class, 'gmapsSimple'])->name('gmaps.simple');
Route::get('/admin/icon-feather', [AdminController::class, 'iconFeather'])->name('icon.feather');
Route::get('/admin/icon-font-awesome', [AdminController::class, 'iconFontAwesome'])->name('icon.font.awesome');
Route::get('/admin/icon-ionicons', [AdminController::class, 'iconIonicons'])->name('icon.ionicons');
Route::get('/admin/icon-material', [AdminController::class, 'iconMaterial'])->name('icon.material');
Route::get('/admin/icon-weather', [AdminController::class, 'iconWeather'])->name('icon.weather');
Route::get('/admin/invoice', [AdminController::class, 'invoice'])->name('invoice');
Route::get('/admin/light-gallery', [AdminController::class, 'lightGallery'])->name('light.gallery');
Route::get('/admin/list-group', [AdminController::class, 'listGroup'])->name('list.group');
Route::get('/admin/mail-inbox', [AdminController::class, 'mailInbox'])->name('mail.inbox');
Route::get('/admin/media-object', [AdminController::class, 'mediaObject'])->name('media.object');
Route::get('/admin/modal', [AdminController::class, 'modal'])->name('modal');
Route::get('/admin/multiple-upload', [AdminController::class, 'multipleUpload'])->name('multiple.upload');
Route::get('/admin/navbar', [AdminController::class, 'navbar'])->name('navbar');
Route::get('/admin/owl-carousel', [AdminController::class, 'owlCarousel'])->name('owl.carousel');
Route::get('/admin/pagination', [AdminController::class, 'pagination'])->name('pagination');
Route::get('/admin/popover', [AdminController::class, 'popover'])->name('popover');
Route::get('/admin/portfolio', [AdminController::class, 'portfolio'])->name('portfolio');
Route::get('/admin/posts', [AdminController::class, 'posts'])->name('posts');
Route::get('/admin/pricing', [AdminController::class, 'pricing'])->name('pricing');
Route::get('/admin/profile', [AdminController::class, 'profile'])->name('profile');
Route::get('/admin/progress', [AdminController::class, 'progress'])->name('progress');
Route::get('/admin/subscribe', [AdminController::class, 'subscribe'])->name('subscribe');
Route::get('/admin/sweet-alert', [AdminController::class, 'sweetAlert'])->name('sweet.alert');
Route::get('/admin/tabs', [AdminController::class, 'tabs'])->name('tabs');
Route::get('/admin/timeline', [AdminController::class, 'timeline'])->name('timeline');
Route::get('/admin/toastr', [AdminController::class, 'toastr'])->name('toastr');
Route::get('/admin/tooltip', [AdminController::class, 'tooltip'])->name('tooltip');
Route::get('/admin/typography', [AdminController::class, 'typography'])->name('typography');
Route::get('/admin/vector-map', [AdminController::class, 'vectorMap'])->name('vector.map');
Route::get('/admin/widget-chart', [AdminController::class, 'widgetChart'])->name('widget.chart');
Route::get('/admin/widget-data', [AdminController::class, 'widgetData'])->name('widget.data');

