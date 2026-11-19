<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'createLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1')->name('login.store');
    Route::get('/register', [AuthController::class, 'createRegistration'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [EventController::class, 'index'])->name('home');
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/attendees', [EventController::class, 'attendees'])->name('attendees.index');
    Route::get('/attendees/create', [EventController::class, 'createAttendee'])->name('attendees.create');
    Route::post('/attendees', [EventController::class, 'storeAttendee'])->name('attendees.store');
    Route::get('/tickets', [EventController::class, 'tickets'])->name('tickets.index');
    Route::get('/tickets/create', [EventController::class, 'createTicket'])->name('tickets.create');
    Route::post('/tickets', [EventController::class, 'storeTicket'])->name('tickets.store');
});
