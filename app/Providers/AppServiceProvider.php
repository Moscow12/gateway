<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            view()->share('teams', \App\Models\Teams::all());
        } catch (\Exception $e) {
            view()->share('teams', collect());
        }

        // Share company details with all views (for website footer and contact page)
        try {
            view()->share('companyDetails', \App\Models\companydetail::first());
        } catch (\Exception $e) {
            view()->share('companyDetails', null);
        }
    }
}
