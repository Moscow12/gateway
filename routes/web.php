<?php

use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Location;
use App\Livewire\Admin\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

// Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');

// Dashboard routes
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('location', Location::class)->name('location');

    Route::get('users', Users::class)->name('users');
    Route::get('logout', Dashboard::class)->name('logout');
    Route::post('/logout', function (Request $request) {
        Auth::logout(); // Logout user
        $request->session()->invalidate(); // Invalidate session
        $request->session()->regenerateToken(); // Regenerate CSRF token
        return redirect('/login'); // Redirect to login page
    })->name('logout');
});


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
