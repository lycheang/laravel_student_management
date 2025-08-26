<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
// Authentication routes
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Registration routes
Route::get('/register', [App\Http\Controllers\AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register.submit');

// Dashboard route (protected)
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

// Your existing resource routes
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::Resource('/students', StudentController::class)->middleware('auth');
Route::Resource('/teachers', TeacherController::class)->middleware('auth');
Route::Resource('/subjects', SubjectController::class)->middleware('auth');
Route::Resource('/attendances', AttendanceController::class)->middleware('auth');

// Home route redirects to dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

