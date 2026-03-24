<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;

// Dashboard as first page
Route::get('/', [BookingController::class, 'dashboard']);

// Booking Form
Route::get('/book', [BookingController::class, 'index']); // show form
Route::post('/book', [BookingController::class, 'book']); // submit form

// Other pages
Route::get('/appointments', [BookingController::class, 'appointments']);
Route::get('/cancel/{id}', [BookingController::class, 'cancel']);
Route::get('/doctors', [BookingController::class, 'doctors']);
Route::get('/patients', [BookingController::class, 'patients']);