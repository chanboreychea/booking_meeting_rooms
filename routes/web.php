<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingMeetingRoomController;

Route::get('/', [BookingMeetingRoomController::class, 'showBookingMeetingRooms'])->name('homepage');

Route::get('/admins', function () {
    return view('adminLogin');
})->name('admin-login');
Route::post('/admins/login', [authController::class, 'login']);
Route::get('/admins/logout', [authController::class, 'logout']);

Route::middleware(['admin'])->group(function () {

    Route::get('/booking', [BookingMeetingRoomController::class, 'index']);
    Route::post('/booking/approve/{bookingId}', [BookingMeetingRoomController::class, 'adminApprove']);
    Route::get('/booking/export/excel', [BookingMeetingRoomController::class, 'exportBookingMeetingRoom']);

    Route::resource('/users', UserController::class);
});


Route::get('/login', function () {
    return view('userLogin');
})->name('user-login');
Route::post('/users/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout']);
Route::middleware(['user'])->group(function () {

    Route::get('/calendar', [BookingMeetingRoomController::class, 'calendar'])->name('calendar');
    Route::get('/days/{day}/{month}', [BookingMeetingRoomController::class, 'showRoomAndTime']);
    Route::post('/booking', [BookingMeetingRoomController::class, 'bookingRoom']);
    Route::delete('/booking/{userId}', [BookingMeetingRoomController::class, 'userDestroy']);
});
