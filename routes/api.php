<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SpecialistController;
use App\Http\Controllers\AppointmentController;

Route::controller(ClientController::class)->group(function(){

    Route::post('register', 'register');

    Route::post('login', 'login');

});

Route::resource('clients', ClientController::class);
Route::resource('specialists', SpecialistController::class);
Route::resource('appointments', AppointmentController::class);
Route::get('appointments-by-client-id/{id}', [AppointmentController::class,'appointmentsByClientId']);
