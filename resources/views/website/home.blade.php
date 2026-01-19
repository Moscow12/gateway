@extends('website.layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-6">
                    <div class="hero-content" data-aos="fade-right">
                        @if($heroSection)
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3">
                                {{ $heroSection->subtitle ?? 'Welcome to TechSolutions' }}
                            </span>
                            <h1 class="hero-title">
                                {!! nl2br(e($heroSection->title)) !!}
                            </h1>
                            <p class="hero-subtitle">
                                {{ $heroSection->description ?? 'We build cutting-edge software solutions that transform businesses and drive innovation.' }}
                            </p>
                            <div class="hero-buttons d-flex flex-wrap gap-3">
                                @if($heroSection->button_text)
                                    <a href="{{ $heroSection->button_link ?? '#contact' }}" class="btn-primary-custom">
                                        {{ $heroSection->button_text }} <i class="bx bx-right-arrow-alt"></i>
                                    </a>
                                @endif
                                @if($heroSection->button2_text)
                                    <a href="{{ $heroSection->button2_link ?? '#about' }}" class="btn-outline-custom">
                                        {{ $heroSection->button2_text }} <i class="bx bx-play-circle"></i>
                                    </a>
                                @endif
                            </div>
                        @else
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3">
                                Software Development Company
                            </span>
                            <h1 class="hero-title">
                                Building <span class="text-gradient">Digital Solutions</span> for Tomorrow
                            </h1>
                            <p class="hero-subtitle">
                                We build cutting-edge software solutions that transform businesses and drive innovation. Let us turn your ideas into reality.
                            </p>
                            <div class="hero-buttons d-flex flex-wrap gap-3">
                                <a href="#contact" class="btn-primary-custom">
                                    Get Started <i class="bx bx-right-arrow-alt"></i>
                                </a>
                                <a href="#about" class="btn-outline-custom">
                                    Learn More <i class="bx bx-play-circle"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image" data-aos="fade-left" data-aos-delay="200">
                        @if($heroSection && $heroSection->image)
                            <img src="{{ asset('storage/' . $heroSection->image) }}" alt="Hero Image" class="img-fluid">
                        @else
                            <!-- Code Block Animation -->
                            <div class="code-block">
                                <div class="code-dots">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <div class="code-content">
                                    <div class="code-line"><span class="code-comment">// Building your digital future</span></div>
                                    <div class="code-line"><span class="code-keyword">const</span> <span class="code-function">solution</span> = <span class="code-keyword">await</span> TechSolutions.<span class="code-function">create</span>({</div>
                                    <div class="code-line">&nbsp;&nbsp;innovation: <span class="code-string">'unlimited'</span>,</div>
                                    <div class="code-line">&nbsp;&nbsp;quality: <span class="code-string">'exceptional'</span>,</div>
                                    <div class="code-line">});</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row g-4">
                <div class="col-6 col-md-3" data-aos="fade-up">
                    <div class="stat-item">
                        <div class="stat-number">150+</div>
                        <div class="stat-label">Projects Completed</div>
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-item">
                        <div class="stat-number">50+</div>
                        <div class="stat-label">Happy Clients</div>
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-item">
                        <div class="stat-number">10+</div>
                        <div class="stat-label">Years Experience</div>
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Support Available</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="section section-gray" id="services">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3" data-aos="fade-up">Our Services</span>
                <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">What We Offer</h2>
                <p class="section-subtitle mx-auto" data-aos="fade-up" data-aos-delay="200">
                    We provide comprehensive software solutions tailored to your business needs
                </p>
            </div>
            <div class="row g-4">
                @forelse($services as $service)
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3 + 1) * 100 }}">
                        <div class="service-card">
                            <div class="service-icon">
                                <i class="bx {{ $service->icon ?? 'bx-code-alt' }}"></i>
                            </div>
                            <h4>{{ $service->name }}</h4>
                            <p>{{ $service->short_description ?? Str::limit($service->description, 120) }}</p>
                            <a href="{{ url('/services#' . $service->slug) }}" class="service-link">Learn More <i class="bx bx-right-arrow-alt"></i></a>
                        </div>
                    </div>
                @empty
                    <!-- Default services when none in database -->
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-card">
                            <div class="service-icon"><i class="bx bx-code-alt"></i></div>
                            <h4>Custom Software Development</h4>
                            <p>Tailored software solutions designed to meet your specific business requirements and workflows.</p>
                            <a href="{{ url('/services') }}" class="service-link">Learn More <i class="bx bx-right-arrow-alt"></i></a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-card">
                            <div class="service-icon"><i class="bx bx-globe"></i></div>
                            <h4>Web Application Development</h4>
                            <p>Modern, responsive web applications built with the latest technologies and best practices.</p>
                            <a href="{{ url('/services') }}" class="service-link">Learn More <i class="bx bx-right-arrow-alt"></i></a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="service-card">
                            <div class="service-icon"><i class="bx bx-mobile-alt"></i></div>
                            <h4>Mobile App Development</h4>
                            <p>Native and cross-platform mobile applications for iOS and Android devices.</p>
                            <a href="{{ url('/services') }}" class="service-link">Learn More <i class="bx bx-right-arrow-alt"></i></a>
                        </div>
                    </div>
                @endforelse
            </div>
            @if($services->count() > 0)
                <div class="text-center mt-5" data-aos="fade-up">
                    <a href="{{ url('/services') }}" class="btn-outline-custom">
                        View All Services <i class="bx bx-right-arrow-alt"></i>
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- About Section -->
    <section class="section" id="about">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="about-image">
                        @if($aboutContents->where('section_type', 'mission')->first()?->image)
                            <img src="{{ asset('storage/' . $aboutContents->where('section_type', 'mission')->first()->image) }}" alt="About Us" class="img-fluid">
                        @else
                            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=600&h=500&fit=crop" alt="About Us" class="img-fluid">
                        @endif
                        <div class="about-badge">
                            <h3>10+</h3>
                            <p>Years of Excellence</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3">About Us</span>
                    <h2 class="section-title">
                        @if($aboutContents->where('section_type', 'mission')->first())
                            {{ $aboutContents->where('section_type', 'mission')->first()->title }}
                        @else
                            We Build Technology That Empowers Businesses
                        @endif
                    </h2>
                    <p class="text-muted mb-4">
                        @if($aboutContents->where('section_type', 'mission')->first())
                            {{ $aboutContents->where('section_type', 'mission')->first()->content }}
                        @else
                            With over a decade of experience, we've been at the forefront of digital transformation, helping businesses leverage technology to achieve their goals. Our team of skilled developers, designers, and consultants work together to deliver solutions that make a real impact.
                        @endif
                    </p>
                    <ul class="feature-list mb-4">
                        <li><i class="bx bx-check-circle"></i> Expert Development Team</li>
                        <li><i class="bx bx-check-circle"></i> Agile Development Process</li>
                        <li><i class="bx bx-check-circle"></i> 24/7 Technical Support</li>
                        <li><i class="bx bx-check-circle"></i> Transparent Communication</li>
                    </ul>
                    <a href="{{ url('/about-us') }}" class="btn-primary-custom">
                        Learn More About Us <i class="bx bx-right-arrow-alt"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="section section-dark">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-primary px-3 py-2 rounded-pill mb-3" data-aos="fade-up">Why Choose Us</span>
                <h2 class="section-title text-white" data-aos="fade-up" data-aos-delay="100">
                    @if($aboutContents->where('section_type', 'why_choose_us')->first())
                        {{ $aboutContents->where('section_type', 'why_choose_us')->first()->title }}
                    @else
                        What Makes Us Different
                    @endif
                </h2>
                <p class="section-subtitle mx-auto" data-aos="fade-up" data-aos-delay="200">
                    @if($aboutContents->where('section_type', 'why_choose_us')->first())
                        {{ Str::limit($aboutContents->where('section_type', 'why_choose_us')->first()->content, 150) }}
                    @else
                        We combine technical expertise with business understanding to deliver exceptional results
                    @endif
                </p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-center p-4">
                        <div class="service-icon mx-auto mb-4">
                            <i class="bx bx-rocket"></i>
                        </div>
                        <h5 class="text-white mb-3">Fast Delivery</h5>
                        <p class="text-muted mb-0">Quick turnaround without compromising on quality</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-center p-4">
                        <div class="service-icon mx-auto mb-4">
                            <i class="bx bx-shield-quarter"></i>
                        </div>
                        <h5 class="text-white mb-3">Secure Solutions</h5>
                        <p class="text-muted mb-0">Security-first approach in all our developments</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-center p-4">
                        <div class="service-icon mx-auto mb-4">
                            <i class="bx bx-trending-up"></i>
                        </div>
                        <h5 class="text-white mb-3">Scalable Systems</h5>
                        <p class="text-muted mb-0">Solutions that grow with your business</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="text-center p-4">
                        <div class="service-icon mx-auto mb-4">
                            <i class="bx bx-headphone"></i>
                        </div>
                        <h5 class="text-white mb-3">Dedicated Support</h5>
                        <p class="text-muted mb-0">Round-the-clock assistance for all your needs</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio/Gallery Section -->
    @if($galleries->count() > 0)
    <section class="section section-gray" id="portfolio">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3" data-aos="fade-up">Our Work</span>
                <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">Featured Projects</h2>
                <p class="section-subtitle mx-auto" data-aos="fade-up" data-aos-delay="200">
                    Take a look at some of our recent work and successful projects
                </p>
            </div>
            <div class="row g-4">
                @foreach($galleries->take(6) as $gallery)
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="portfolio-item">
                        <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h4>{{ $gallery->title }}</h4>
                                <span>{{ $gallery->category ?? 'Project' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-5" data-aos="fade-up">
                <a href="{{ url('/portfolio') }}" class="btn-outline-custom">
                    View All Projects <i class="bx bx-right-arrow-alt"></i>
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Testimonials Section -->
    @if($testimonials->count() > 0)
    <section class="section" id="testimonials">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3" data-aos="fade-up">Testimonials</span>
                <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">What Our Clients Say</h2>
                <p class="section-subtitle mx-auto" data-aos="fade-up" data-aos-delay="200">
                    Don't just take our word for it - hear from our satisfied customers
                </p>
            </div>
            <div class="row g-4">
                @foreach($testimonials->take(3) as $testimonial)
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="testimonial-card">
                        <div class="testimonial-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bx {{ $i <= $testimonial->rating ? 'bxs-star' : 'bx-star' }}"></i>
                            @endfor
                        </div>
                        <p class="testimonial-text">"{{ Str::limit($testimonial->testimonial, 200) }}"</p>
                        <div class="testimonial-author">
                            @if($testimonial->client_image)
                                <img src="{{ asset('storage/' . $testimonial->client_image) }}" alt="{{ $testimonial->client_name }}">
                            @else
                                <div class="testimonial-author-placeholder">
                                    {{ strtoupper(substr($testimonial->client_name, 0, 2)) }}
                                </div>
                            @endif
                            <div>
                                <h5>{{ $testimonial->client_name }}</h5>
                                <span>{{ $testimonial->client_position }}{{ $testimonial->client_company ? ' @ ' . $testimonial->client_company : '' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Partners Section -->
    @if($partners->count() > 0)
    <section class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-4">
                <span class="text-muted">Trusted by leading companies</span>
            </div>
            <div class="row align-items-center justify-content-center g-4">
                @foreach($partners->take(6) as $partner)
                <div class="col-6 col-md-4 col-lg-2 text-center" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="partner-logo">
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container text-center position-relative" style="z-index: 10;">
            <h2 data-aos="fade-up">Ready to Start Your Project?</h2>
            <p class="mx-auto" style="max-width: 600px;" data-aos="fade-up" data-aos-delay="100">
                Let's discuss how we can help you achieve your business goals with our innovative software solutions.
            </p>
            <a href="{{ url('/contact-us') }}" class="btn-white" data-aos="fade-up" data-aos-delay="200">
                Get in Touch <i class="bx bx-right-arrow-alt"></i>
            </a>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section" id="contact">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3">Contact Us</span>
                    <h2 class="section-title">Let's Work Together</h2>
                    <p class="text-muted mb-4">
                        Have a project in mind? Fill out the form below and we'll get back to you within 24 hours.
                    </p>
                    <form class="contact-form">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Your Name" required>
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control" placeholder="Your Email" required>
                            </div>
                            <div class="col-12">
                                <input type="text" class="form-control" placeholder="Subject">
                            </div>
                            <div class="col-12">
                                <textarea class="form-control" rows="5" placeholder="Your Message" required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn-primary-custom">
                                    Send Message <i class="bx bx-send"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="contact-info-card">
                        <h4 class="mb-4">Contact Information</h4>
                        <div class="contact-info-item">
                            <i class="bx bx-map"></i>
                            <div>
                                <h5>Our Location</h5>
                                <p>Dar es Salaam, Tanzania</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <i class="bx bx-phone"></i>
                            <div>
                                <h5>Phone Number</h5>
                                <p>+255 123 456 789</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <i class="bx bx-envelope"></i>
                            <div>
                                <h5>Email Address</h5>
                                <p>info@techsolutions.co.tz</p>
                            </div>
                        </div>
                        <div class="contact-info-item mb-0">
                            <i class="bx bx-time"></i>
                            <div>
                                <h5>Working Hours</h5>
                                <p>Mon - Fri: 8:00 AM - 6:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
