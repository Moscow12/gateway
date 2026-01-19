@extends('website.layouts.app')

@section('title', 'Portfolio')
@section('meta_description', 'Explore our portfolio of successful software development projects and case studies.')

@section('content')
    <!-- Page Header -->
    <section class="py-5" style="padding-top: 150px !important; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3" data-aos="fade-up">Our Work</span>
                    <h1 class="display-4 fw-bold mb-3" data-aos="fade-up" data-aos-delay="100">
                        Our <span class="text-gradient">Portfolio</span>
                    </h1>
                    <p class="lead text-muted" data-aos="fade-up" data-aos-delay="200">
                        Explore our successful projects and see how we've helped businesses transform digitally
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Filter -->
    <section class="py-4 bg-white sticky-top" style="z-index: 100;">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-center gap-2" data-aos="fade-up">
                <button class="btn btn-primary rounded-pill px-4 filter-btn active" data-filter="all">All Projects</button>
                @foreach($categories as $key => $label)
                    <button class="btn btn-outline-primary rounded-pill px-4 filter-btn" data-filter="{{ $key }}">{{ $label }}</button>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Portfolio Grid -->
    <section class="section">
        <div class="container">
            @if($galleries->count() > 0)
                <div class="row g-4" id="portfolioGrid">
                    @foreach($galleries as $gallery)
                    <div class="col-md-6 col-lg-4 portfolio-card" data-category="{{ $gallery->category }}" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 6) * 100 }}">
                        <div class="portfolio-item">
                            <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}">
                            <div class="portfolio-overlay">
                                <div class="portfolio-content">
                                    <h4>{{ $gallery->title }}</h4>
                                    <span>{{ $categories[$gallery->category] ?? 'Project' }}</span>
                                    @if($gallery->description)
                                        <p class="text-white-50 small mt-2 mb-0">{{ Str::limit($gallery->description, 80) }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $galleries->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="bx bx-folder-open" style="font-size: 5rem; color: #cbd5e1;"></i>
                    </div>
                    <h3 class="text-muted">No Projects Yet</h3>
                    <p class="text-muted">Our portfolio is being updated. Check back soon to see our amazing work!</p>
                    <a href="{{ url('/contact-us') }}" class="btn-primary-custom mt-3">
                        Get in Touch <i class="bx bx-right-arrow-alt"></i>
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Stats Section -->
    <section class="section section-dark">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-6 col-md-3" data-aos="fade-up">
                    <div class="stat-number">150+</div>
                    <div class="stat-label text-light">Projects Delivered</div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-number">50+</div>
                    <div class="stat-label text-light">Happy Clients</div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-number">98%</div>
                    <div class="stat-label text-light">Client Satisfaction</div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-number">15+</div>
                    <div class="stat-label text-light">Industries Served</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Industries -->
    <section class="section section-gray">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3" data-aos="fade-up">Industries</span>
                <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">Industries We Serve</h2>
                <p class="section-subtitle mx-auto" data-aos="fade-up" data-aos-delay="200">
                    We have experience working with diverse industries
                </p>
            </div>
            <div class="row g-4">
                <div class="col-6 col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-card text-center py-4">
                        <i class="bx bx-building-house text-primary fs-1 mb-3"></i>
                        <h6 class="mb-0">Real Estate</h6>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="150">
                    <div class="service-card text-center py-4">
                        <i class="bx bx-health text-primary fs-1 mb-3"></i>
                        <h6 class="mb-0">Healthcare</h6>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-card text-center py-4">
                        <i class="bx bx-book-reader text-primary fs-1 mb-3"></i>
                        <h6 class="mb-0">Education</h6>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="250">
                    <div class="service-card text-center py-4">
                        <i class="bx bx-store text-primary fs-1 mb-3"></i>
                        <h6 class="mb-0">Retail</h6>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-card text-center py-4">
                        <i class="bx bx-wallet text-primary fs-1 mb-3"></i>
                        <h6 class="mb-0">Finance</h6>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="350">
                    <div class="service-card text-center py-4">
                        <i class="bx bx-truck text-primary fs-1 mb-3"></i>
                        <h6 class="mb-0">Logistics</h6>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container text-center position-relative" style="z-index: 10;">
            <h2 data-aos="fade-up">Have a Project in Mind?</h2>
            <p class="mx-auto" style="max-width: 600px;" data-aos="fade-up" data-aos-delay="100">
                Let's discuss how we can help bring your vision to life with our expertise.
            </p>
            <a href="{{ url('/contact-us') }}" class="btn-white" data-aos="fade-up" data-aos-delay="200">
                Start a Project <i class="bx bx-right-arrow-alt"></i>
            </a>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Portfolio Filter
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Update active button
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active', 'btn-primary'));
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.add('btn-outline-primary'));
            this.classList.add('active', 'btn-primary');
            this.classList.remove('btn-outline-primary');

            // Filter items
            const filter = this.dataset.filter;
            document.querySelectorAll('.portfolio-card').forEach(card => {
                if (filter === 'all' || card.dataset.category === filter) {
                    card.style.display = 'block';
                    setTimeout(() => card.style.opacity = '1', 10);
                } else {
                    card.style.opacity = '0';
                    setTimeout(() => card.style.display = 'none', 300);
                }
            });
        });
    });
</script>
@endpush

@push('styles')
<style>
    .portfolio-card {
        transition: opacity 0.3s ease;
    }

    .filter-btn.active {
        background: var(--gradient) !important;
        border-color: transparent !important;
    }
</style>
@endpush
