<?php

use App\Http\Controllers\TemplateController;
use App\Livewire\Admin\{Addusers, Client, Clientinvoices, Clientpage, Dashboard, Fpempregistered, Jobs, Location, Products, Smscategory, Userprofile, Users, Viewclient};
use App\Livewire\Admin\Website\Addteam;
use App\Livewire\Admin\Website\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//function to login 
Route::get('/', function () {
    return redirect('/login'); // Redirect to login page
})->name('login');
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        return redirect()->intended('/dashboard');
    }
    return redirect()->back()->withInput($request->only('email', 'password'));
})->name('login');
    // Route::get('/', [TemplateController::class, 'contact'])->name('contact');
    Route::get('/applynow', [TemplateController::class, 'contact'])->name('contact');
    Route::get('/viewtem', [TemplateController::class, 'team'])->name('viewtem');
    Route::get('/about', [TemplateController::class, 'about']);
    Route::get('/events', [TemplateController::class, 'events']);
    Route::post('/applicationform', [TemplateController::class, 'applicationform'])->name('applicationform');


// Dashboard routes
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');
    Route::get('jobslist', Jobs::class)->name('jobslist');
    Route::get('applicants', Jobs::class)->name('applicants');
    Route::get('location', Location::class)->name('location');
    Route::get('addusers', Addusers::class)->name('addusers');
    Route::get('users', Users::class)->name('users');
    Route::get('smscategory', Smscategory::class)->name('smscategory');
    Route::get('addcatgory', Smscategory::class)->name('addcategory');
    Route::get('clients', Client::class)->name('clients');
    Route::get('clientform', Client::class)->name('clientform');
    Route::get('sendsms', Client::class)->name('sendsms');
    Route::get('clients/editclient/{id}', Client::class)->name('clients.editclient');
    Route::get('clientpage/{id}', Clientpage::class)->name('clientpage');
    Route::get('clientinvoice/{clientId}/{invoiceId}', Clientinvoices::class)->name('clientinvoice');
    Route::get('viewclient/{id}', Viewclient::class)->name('viewclient');
    Route::get('team', Team::class)->name('team');
    Route::get('addteam', Addteam::class)->name('addteam');
    Route::get('fpempregistered', Fpempregistered::class)->name('fpempregistered');
    Route::get('userprofile', Userprofile::class)->name('userprofile');

    Route::get('listproducts', Products::class)->name('listproducts');

    Route::view('admin/userlists', 'admin.userlists')->name('userlists');
    
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
