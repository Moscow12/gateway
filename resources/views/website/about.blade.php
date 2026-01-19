@extends('website.layouts.app')

@section('title', 'About Us')
@section('meta_description', 'Learn more about TechSolutions - your trusted partner for software development and digital transformation.')

@section('content')
    <!-- Page Header -->
    <section class="py-5" style="padding-top: 150px !important; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3" data-aos="fade-up">About Us</span>
                    <h1 class="display-4 fw-bold mb-3" data-aos="fade-up" data-aos-delay="100">
                        We Are <span class="text-gradient">TechSolutions</span>
                    </h1>
                    <p class="lead text-muted" data-aos="fade-up" data-aos-delay="200">
                        Transforming businesses through innovative software solutions since 2014
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="section">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=600&h=500&fit=crop" alt="Our Team" class="img-fluid rounded-4 shadow-lg">
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    @php $mission = $aboutContents->where('section_type', 'mission')->first(); @endphp
                    <div class="mb-5">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="service-icon">
                                <i class="bx {{ $mission->icon ?? 'bx-target-lock' }}"></i>
                            </div>
                            <h3 class="mb-0">{{ $mission->title ?? 'Our Mission' }}</h3>
                        </div>
                        <p class="text-muted">
                            {{ $mission->content ?? 'To deliver innovative software solutions that empower businesses to achieve their full potential. We are committed to excellence, integrity, and customer satisfaction in every project we undertake.' }}
                        </p>
                    </div>
                    @php $vision = $aboutContents->where('section_type', 'vision')->first(); @endphp
                    <div>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="service-icon">
                                <i class="bx {{ $vision->icon ?? 'bx-bullseye' }}"></i>
                            </div>
                            <h3 class="mb-0">{{ $vision->title ?? 'Our Vision' }}</h3>
                        </div>
                        <p class="text-muted">
                            {{ $vision->content ?? 'To be the leading technology partner for businesses across Africa, known for our innovative solutions, exceptional service, and commitment to driving digital transformation.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story -->
    <section class="section section-gray">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 order-lg-2" data-aos="fade-left">
                    <img src="https://images.unsplash.com/photo-1553877522-43269d4ea984?w=600&h=500&fit=crop" alt="Our Story" class="img-fluid rounded-4 shadow-lg">
                </div>
                <div class="col-lg-6 order-lg-1" data-aos="fade-right">
                    @php $history = $aboutContents->where('section_type', 'history')->first(); @endphp
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3">Our Story</span>
                    <h2 class="section-title">{{ $history->title ?? 'A Decade of Innovation' }}</h2>
                    <p class="text-muted mb-4">
                        {{ $history->content ?? 'Founded in 2014, TechSolutions started with a simple vision: to make technology accessible and beneficial for businesses of all sizes. What began as a small team of passionate developers has grown into a full-service software development company serving clients across multiple industries.' }}
                    </p>
                    <p class="text-muted">
                        Over the years, we have successfully delivered hundreds of projects, from custom enterprise software to mobile applications and cloud solutions. Our commitment to quality and customer satisfaction has earned us the trust of businesses ranging from startups to established corporations.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Values -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3" data-aos="fade-up">Our Values</span>
                <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">What Drives Us</h2>
                <p class="section-subtitle mx-auto" data-aos="fade-up" data-aos-delay="200">
                    The core principles that guide everything we do
                </p>
            </div>
            <div class="row g-4">
                @php $values = $aboutContents->where('section_type', 'values'); @endphp
                @if($values->count() > 0)
                    @foreach($values as $value)
                    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="service-card text-center">
                            <div class="service-icon mx-auto">
                                <i class="bx {{ $value->icon ?? 'bx-star' }}"></i>
                            </div>
                            <h4>{{ $value->title }}</h4>
                            <p>{{ Str::limit($value->content, 100) }}</p>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-card text-center">
                            <div class="service-icon mx-auto">
                                <i class="bx bx-bulb"></i>
                            </div>
                            <h4>Innovation</h4>
                            <p>We constantly explore new technologies and approaches to deliver cutting-edge solutions.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-card text-center">
                            <div class="service-icon mx-auto">
                                <i class="bx bx-check-shield"></i>
                            </div>
                            <h4>Integrity</h4>
                            <p>We maintain the highest ethical standards in all our business dealings and relationships.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                        <div class="service-card text-center">
                            <div class="service-icon mx-auto">
                                <i class="bx bx-group"></i>
                            </div>
                            <h4>Collaboration</h4>
                            <p>We believe in working closely with our clients as partners in their digital journey.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                        <div class="service-card text-center">
                            <div class="service-icon mx-auto">
                                <i class="bx bx-trophy"></i>
                            </div>
                            <h4>Excellence</h4>
                            <p>We strive for excellence in every project, ensuring the highest quality deliverables.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="section section-dark">
        <div class="container">
            <div class="row g-4">
                <div class="col-6 col-md-3" data-aos="fade-up">
                    <div class="stat-item">
                        <div class="stat-number">150+</div>
                        <div class="stat-label text-light">Projects Delivered</div>
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-item">
                        <div class="stat-number">50+</div>
                        <div class="stat-label text-light">Happy Clients</div>
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-item">
                        <div class="stat-number">25+</div>
                        <div class="stat-label text-light">Team Members</div>
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-item">
                        <div class="stat-number">10+</div>
                        <div class="stat-label text-light">Years Experience</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    @if($team->count() > 0)
    <section class="section section-gray">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3" data-aos="fade-up">Our Team</span>
                <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">Meet The Experts</h2>
                <p class="section-subtitle mx-auto" data-aos="fade-up" data-aos-delay="200">
                    The talented people behind our success
                </p>
            </div>
            <div class="row g-4 justify-content-center">
                @foreach($team->take(4) as $member)
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="service-card text-center">
                        @if($member->photo)
                            <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="bg-primary bg-opacity-10 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                <span class="text-primary fw-bold fs-2">{{ strtoupper(substr($member->name, 0, 2)) }}</span>
                            </div>
                        @endif
                        <h5 class="mb-1">{{ $member->name }}</h5>
                        <p class="text-primary mb-2">{{ $member->title }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container text-center position-relative" style="z-index: 10;">
            <h2 data-aos="fade-up">Want to Join Our Team?</h2>
            <p class="mx-auto" style="max-width: 600px;" data-aos="fade-up" data-aos-delay="100">
                We're always looking for talented individuals to join our growing team. Check out our open positions.
            </p>
            <a href="{{ url('/contact-us') }}" class="btn-white" data-aos="fade-up" data-aos-delay="200">
                View Careers <i class="bx bx-right-arrow-alt"></i>
            </a>
        </div>
    </section>
@endsection
