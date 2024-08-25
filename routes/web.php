<?php

use App\Http\Controllers\ContactController;
use App\Livewire\ChatController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Aquí defines la ruta que deseas redirigir después del login
    Route::get('/dashboard', function () {
        return redirect()->route('contacts.index');
    });

    Route::resource('/contacts',ContactController::class)->except(['show'])->middleware('auth');

    Route::get('/chat',ChatController::class)->name('chat');
});
