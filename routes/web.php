<?php

use App\Http\Controllers\TemplateController;
use App\Http\Controllers\WebsiteController;
use App\Livewire\Admin\{Addusers, Applicantdetails, Client, ClientServices, Clientinvoices, Clientpage, Companydetails, Dashboard, Fpempregistered, Jobs, Location, Products, ServiceTypes, Smscategory, Userprofile, Users, Viewclient};
use App\Livewire\Admin\{HeroSectionManager, AboutContentManager, GalleryManager, TestimonialManager, PartnerManager, ServiceManager};
use App\Livewire\Admin\Website\Addteam;
use App\Livewire\Admin\Website\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public Website Routes
Route::get('/', [WebsiteController::class, 'home'])->name('home');
Route::get('/about-us', [WebsiteController::class, 'about'])->name('about-us');
Route::get('/services', [WebsiteController::class, 'services'])->name('services');
Route::get('/portfolio', [WebsiteController::class, 'portfolio'])->name('portfolio');
Route::get('/contact-us', [WebsiteController::class, 'contact'])->name('contact-us');
Route::post('/contact-submit', [WebsiteController::class, 'contactSubmit'])->name('contact-submit');

// Legacy routes (old template)
Route::get('/applynow', [TemplateController::class, 'contact'])->name('contact');
Route::get('/viewtem', [TemplateController::class, 'team'])->name('viewtem');
Route::get('/about', [TemplateController::class, 'about']);
Route::get('/events', [TemplateController::class, 'events']);
Route::post('/applicationform', [TemplateController::class, 'applicationform'])->name('applicationform');

// Authentication
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        return redirect()->intended('/dashboard');
    }
    return redirect()->back()->withInput($request->only('email', 'password'));
})->name('login');


// Dashboard routes
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');
    Route::get('jobslist', Jobs::class)->name('jobslist');
    Route::get('applicants', Jobs::class)->name('applicants');
    Route::get('applicantdetails/{id}', Applicantdetails::class)->name('applicantdetails');
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
    Route::get('userprofile', Userprofile::class)->name('userprofile');

    Route::get('listproducts', Products::class)->name('listproducts');
    Route::get('service-types', ServiceTypes::class)->name('service-types');
    Route::get('client-services', ClientServices::class)->name('client-services');
    Route::get('companydetails', Companydetails::class)->name('companydetails');

    // Website Content Management Routes
    Route::get('hero-sections', HeroSectionManager::class)->name('hero-sections');
    Route::get('about-content', AboutContentManager::class)->name('about-content');
    Route::get('gallery', GalleryManager::class)->name('gallery');
    Route::get('testimonials', TestimonialManager::class)->name('testimonials');
    Route::get('partners', PartnerManager::class)->name('partners');
    Route::get('website-services', ServiceManager::class)->name('website-services');

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
