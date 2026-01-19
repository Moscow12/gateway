<?php

namespace App\Http\Controllers;

use App\Models\HeroSection;
use App\Models\AboutContent;
use App\Models\WebsiteGallery;
use App\Models\Testimonial;
use App\Models\Partner;
use App\Models\Service;
use App\Models\Teams;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    /**
     * Display the homepage
     */
    public function home()
    {
        $heroSection = HeroSection::active()->ordered()->first();
        $aboutContents = AboutContent::active()->ordered()->get();
        $services = Service::active()->ordered()->take(6)->get();
        $galleries = WebsiteGallery::active()->ordered()->take(6)->get();
        $testimonials = Testimonial::active()->ordered()->get();
        $partners = Partner::active()->ordered()->get();

        return view('website.home', compact(
            'heroSection',
            'aboutContents',
            'services',
            'galleries',
            'testimonials',
            'partners'
        ));
    }

    /**
     * Display the about page
     */
    public function about()
    {
        $aboutContents = AboutContent::active()->ordered()->get();
        $team = Teams::all();

        return view('website.about', compact('aboutContents', 'team'));
    }

    /**
     * Display the services page
     */
    public function services()
    {
        $services = Service::active()->ordered()->get();
        $featuredServices = Service::active()->featured()->ordered()->get();

        return view('website.services', compact('services', 'featuredServices'));
    }

    /**
     * Display the portfolio/gallery page
     */
    public function portfolio()
    {
        $galleries = WebsiteGallery::active()->ordered()->paginate(12);

        // Get categories for filtering
        $categories = [
            'projects' => 'Projects',
            'team' => 'Team',
            'office' => 'Office',
            'events' => 'Events',
        ];

        return view('website.portfolio', compact('galleries', 'categories'));
    }

    /**
     * Display the contact page
     */
    public function contact()
    {
        return view('website.contact');
    }

    /**
     * Handle contact form submission
     */
    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Here you can:
        // 1. Save to database
        // 2. Send email notification
        // 3. Send to a CRM

        // For now, we'll just redirect with success message
        // You can implement email sending or database storage as needed

        return redirect()->back()->with('success', 'Thank you for your message! We will get back to you within 24 hours.');
    }
}
