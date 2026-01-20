@extends('website.layouts.app')

@section('title', 'Contact Us')
@section('meta_description', 'Get in touch with TechSolutions. We are here to help you with your software development needs.')

@section('content')
    <!-- Page Header -->
    <section class="py-5" style="padding-top: 150px !important; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3" data-aos="fade-up">Contact Us</span>
                    <h1 class="display-4 fw-bold mb-3" data-aos="fade-up" data-aos-delay="100">
                        Let's <span class="text-gradient">Talk</span>
                    </h1>
                    <p class="lead text-muted" data-aos="fade-up" data-aos-delay="200">
                        Have a project in mind? We'd love to hear from you.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-7" data-aos="fade-right">
                    <div class="bg-white rounded-4 p-4 p-md-5 shadow-sm">
                        <h3 class="mb-4">Send Us a Message</h3>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bx bx-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ url('/contact-submit') }}" method="POST" class="contact-form">
                            @csrf
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Your full name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="your@email.com" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Phone Number</label>
                                    <input type="tel" name="phone" class="form-control" placeholder="+255 XXX XXX XXX" value="{{ old('phone') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Company</label>
                                    <input type="text" name="company" class="form-control" placeholder="Your company name" value="{{ old('company') }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Subject <span class="text-danger">*</span></label>
                                    <select name="subject" class="form-select @error('subject') is-invalid @enderror" required>
                                        <option value="">Select a subject...</option>
                                        <option value="general" {{ old('subject') == 'general' ? 'selected' : '' }}>General Inquiry</option>
                                        <option value="project" {{ old('subject') == 'project' ? 'selected' : '' }}>Project Discussion</option>
                                        <option value="support" {{ old('subject') == 'support' ? 'selected' : '' }}>Technical Support</option>
                                        <option value="partnership" {{ old('subject') == 'partnership' ? 'selected' : '' }}>Partnership Opportunity</option>
                                        <option value="careers" {{ old('subject') == 'careers' ? 'selected' : '' }}>Career Inquiry</option>
                                        <option value="other" {{ old('subject') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Message <span class="text-danger">*</span></label>
                                    <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="5" placeholder="Tell us about your project or inquiry..." required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn-primary-custom">
                                        Send Message <i class="bx bx-send ms-1"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5" data-aos="fade-left">
                    <div class="contact-info-card mb-4">
                        <h4 class="mb-4">Contact Information</h4>
                        <div class="contact-info-item">
                            <i class="bx bx-map"></i>
                            <div>
                                <h5>Our Office</h5>
                                <p>{{ $companyDetails->address ?? 'Dar es Salaam, Tanzania' }}</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <i class="bx bx-phone"></i>
                            <div>
                                <h5>Phone</h5>
                                <p>{{ $companyDetails->phone ?? '+255 123 456 789' }}@if($companyDetails && $companyDetails->fax)<br>Fax: {{ $companyDetails->fax }}@endif</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <i class="bx bx-envelope"></i>
                            <div>
                                <h5>Email</h5>
                                <p>{{ $companyDetails->email ?? 'info@example.com' }}</p>
                            </div>
                        </div>
                        
                        <div class="contact-info-item mb-0">
                            <i class="bx bx-time"></i>
                            <div>
                                <h5>Working Hours</h5>
                                <p>
                                    @if($companyDetails && ($companyDetails->working_hours_weekdays || $companyDetails->working_hours_saturday || $companyDetails->working_hours_sunday))
                                        @if($companyDetails->working_hours_weekdays)
                                            Monday - Friday: {{ $companyDetails->working_hours_weekdays }}<br>
                                        @endif
                                        @if($companyDetails->working_hours_saturday)
                                            Saturday: {{ $companyDetails->working_hours_saturday }}<br>
                                        @endif
                                        @if($companyDetails->working_hours_sunday)
                                            Sunday: {{ $companyDetails->working_hours_sunday }}
                                        @endif
                                    @else
                                        Monday - Friday: 8:00 AM - 6:00 PM<br>Saturday: 9:00 AM - 1:00 PM
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Links -->
                    @if($companyDetails && ($companyDetails->facebook || $companyDetails->twitter || $companyDetails->linkedin || $companyDetails->instagram || $companyDetails->youtube || $companyDetails->tiktok || $companyDetails->github))
                    <div class="bg-white rounded-4 p-4 shadow-sm">
                        <h5 class="mb-3">Follow Us</h5>
                        <div class="d-flex gap-2 flex-wrap">
                            @if($companyDetails->facebook)
                            <a href="{{ $companyDetails->facebook }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary rounded-circle" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                <i class="bx bxl-facebook fs-5"></i>
                            </a>
                            @endif
                            @if($companyDetails->twitter)
                            <a href="{{ $companyDetails->twitter }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary rounded-circle" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                <i class="bx bxl-twitter fs-5"></i>
                            </a>
                            @endif
                            @if($companyDetails->linkedin)
                            <a href="{{ $companyDetails->linkedin }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary rounded-circle" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                <i class="bx bxl-linkedin fs-5"></i>
                            </a>
                            @endif
                            @if($companyDetails->instagram)
                            <a href="{{ $companyDetails->instagram }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary rounded-circle" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                <i class="bx bxl-instagram fs-5"></i>
                            </a>
                            @endif
                            @if($companyDetails->youtube)
                            <a href="{{ $companyDetails->youtube }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary rounded-circle" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                <i class="bx bxl-youtube fs-5"></i>
                            </a>
                            @endif
                            @if($companyDetails->tiktok)
                            <a href="{{ $companyDetails->tiktok }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary rounded-circle" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                <i class="bx bxl-tiktok fs-5"></i>
                            </a>
                            @endif
                            @if($companyDetails->github)
                            <a href="{{ $companyDetails->github }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary rounded-circle" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                <i class="bx bxl-github fs-5"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                    @else
                    <div class="bg-white rounded-4 p-4 shadow-sm">
                        <h5 class="mb-3">Follow Us</h5>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-outline-primary rounded-circle" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                <i class="bx bxl-facebook fs-5"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary rounded-circle" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                <i class="bx bxl-twitter fs-5"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary rounded-circle" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                <i class="bx bxl-linkedin fs-5"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary rounded-circle" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                <i class="bx bxl-instagram fs-5"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary rounded-circle" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                <i class="bx bxl-github fs-5"></i>
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-0">
        <div class="container-fluid px-0">
            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                <div class="text-center">
                    <i class="bx bx-map-alt fs-1 text-primary mb-3 d-block"></i>
                    <h5 class="text-muted">Map Integration Available</h5>
                    <p class="text-muted small">Google Maps or OpenStreetMap can be embedded here</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section section-gray">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3" data-aos="fade-up">FAQ</span>
                <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">Frequently Asked Questions</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item border-0 mb-3 rounded-4 overflow-hidden shadow-sm" data-aos="fade-up" data-aos-delay="100">
                            <h2 class="accordion-header">
                                <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    What services do you offer?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    We offer a comprehensive range of software development services including custom software development, web application development, mobile app development, cloud solutions, IT consulting, system integration, and ongoing maintenance and support.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 mb-3 rounded-4 overflow-hidden shadow-sm" data-aos="fade-up" data-aos-delay="200">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    How long does a typical project take?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    Project timelines vary based on complexity and scope. A simple website might take 4-6 weeks, while a complex enterprise application could take several months. We'll provide a detailed timeline estimate during the discovery phase.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 mb-3 rounded-4 overflow-hidden shadow-sm" data-aos="fade-up" data-aos-delay="300">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Do you provide ongoing support after project completion?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    Yes, we offer comprehensive maintenance and support packages to ensure your software continues to run smoothly. This includes bug fixes, security updates, performance optimization, and feature enhancements.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 mb-3 rounded-4 overflow-hidden shadow-sm" data-aos="fade-up" data-aos-delay="400">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    What technologies do you work with?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    We work with a wide range of modern technologies including PHP/Laravel, Python, JavaScript/React/Vue, Node.js, Flutter, React Native, AWS, Azure, and more. We select the best technology stack based on your specific requirements.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
