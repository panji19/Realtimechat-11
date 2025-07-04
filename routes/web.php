<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('dashboard', function () {
    return view('dashboard', [
        'users' => \App\Models\User::where('id', '!=', auth()->id())->get(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('chat/{user}', \App\livewire\Chat::class)
    ->name('chat');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
