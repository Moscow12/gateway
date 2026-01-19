@extends('website.layouts.app')

@section('title', 'Our Services')
@section('meta_description', 'Explore our comprehensive software development services including web development, mobile apps, cloud solutions, and IT consulting.')

@section('content')
    <!-- Page Header -->
    <section class="py-5" style="padding-top: 150px !important; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3" data-aos="fade-up">Our Services</span>
                    <h1 class="display-4 fw-bold mb-3" data-aos="fade-up" data-aos-delay="100">
                        Solutions That <span class="text-gradient">Drive Growth</span>
                    </h1>
                    <p class="lead text-muted" data-aos="fade-up" data-aos-delay="200">
                        Comprehensive software development services tailored to your business needs
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Services -->
    @if($featuredServices->count() > 0)
    <section class="section">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill mb-3" data-aos="fade-up">
                    <i class="bx bx-star me-1"></i> Featured
                </span>
                <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">Our Top Services</h2>
            </div>
            <div class="row g-4">
                @foreach($featuredServices as $service)
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="card border-0 shadow-lg h-100 radius-10 overflow-hidden" id="{{ $service->slug }}">
                        @if($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $service->name }}">
                        @else
                            <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 200px; background: var(--gradient);">
                                <i class="bx {{ $service->icon ?? 'bx-code-alt' }} text-white" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="service-icon me-3">
                                    <i class="bx {{ $service->icon ?? 'bx-code-alt' }}"></i>
                                </div>
                                <h4 class="mb-0">{{ $service->name }}</h4>
                            </div>
                            <p class="text-muted">{{ $service->short_description }}</p>
                            @if($service->features && count($service->features) > 0)
                                <ul class="feature-list mb-3">
                                    @foreach(array_slice($service->features, 0, 4) as $feature)
                                        <li><i class="bx bx-check-circle"></i> {{ $feature }}</li>
                                    @endforeach
                                </ul>
                            @endif
                            @if($service->price_from || $service->price_to)
                                <div class="mb-3">
                                    <span class="text-primary fw-bold">{{ $service->price_range }}</span>
                                    <small class="text-muted">{{ $service->price_unit_label }}</small>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer bg-transparent border-0 p-4 pt-0">
                            <a href="{{ url('/contact-us') }}?service={{ $service->slug }}" class="btn-primary-custom w-100 justify-content-center">
                                Get Started <i class="bx bx-right-arrow-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- All Services -->
    <section class="section {{ $featuredServices->count() > 0 ? 'section-gray' : '' }}">
        <div class="container">
            @if($services->count() > 0)
                <div class="text-center mb-5">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3" data-aos="fade-up">Complete Solutions</span>
                    <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">All Our Services</h2>
                </div>

                @foreach($services as $service)
                <div class="row g-5 align-items-center mb-5 pb-5 {{ !$loop->last ? 'border-bottom' : '' }}" id="{{ $service->slug }}">
                    @if($loop->even)
                        <div class="col-lg-6 order-lg-2" data-aos="fade-left">
                    @else
                        <div class="col-lg-6" data-aos="fade-right">
                    @endif
                        @if($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="img-fluid rounded-4 shadow-lg">
                        @else
                            <div class="code-block">
                                <div class="code-dots">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <div class="code-content">
                                    <div class="code-line"><span class="code-comment">// {{ $service->name }}</span></div>
                                    <div class="code-line"><span class="code-keyword">const</span> service = {</div>
                                    <div class="code-line">&nbsp;&nbsp;name: <span class="code-string">'{{ $service->name }}'</span>,</div>
                                    <div class="code-line">&nbsp;&nbsp;quality: <span class="code-string">'excellent'</span></div>
                                    <div class="code-line">};</div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if($loop->even)
                        <div class="col-lg-6 order-lg-1" data-aos="fade-right">
                    @else
                        <div class="col-lg-6" data-aos="fade-left">
                    @endif
                        <div class="service-icon mb-4">
                            <i class="bx {{ $service->icon ?? 'bx-code-alt' }}"></i>
                        </div>
                        <h2>{{ $service->name }}</h2>
                        <p class="text-muted mb-4">
                            {{ $service->description ?? $service->short_description }}
                        </p>
                        @if($service->features && count($service->features) > 0)
                            <ul class="feature-list mb-4">
                                @foreach($service->features as $feature)
                                    <li><i class="bx bx-check-circle"></i> {{ $feature }}</li>
                                @endforeach
                            </ul>
                        @endif
                        @if($service->price_from || $service->price_to)
                            <p class="mb-4">
                                <span class="h5 text-primary">{{ $service->price_range }}</span>
                                <span class="text-muted">{{ $service->price_unit_label }}</span>
                            </p>
                        @endif
                        <a href="{{ url('/contact-us') }}?service={{ $service->slug }}" class="btn-primary-custom">
                            Request Quote <i class="bx bx-right-arrow-alt"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            @else
                <!-- Default Static Services -->
                <div class="row g-5 align-items-center mb-5 pb-5 border-bottom">
                    <div class="col-lg-6" data-aos="fade-right">
                        <div class="code-block">
                            <div class="code-dots"><span></span><span></span><span></span></div>
                            <div class="code-content">
                                <div class="code-line"><span class="code-comment">// Custom Software Development</span></div>
                                <div class="code-line"><span class="code-keyword">class</span> <span class="code-function">Solution</span> {</div>
                                <div class="code-line">&nbsp;&nbsp;build(requirements) {</div>
                                <div class="code-line">&nbsp;&nbsp;&nbsp;&nbsp;<span class="code-keyword">return</span> <span class="code-string">'success'</span>;</div>
                                <div class="code-line">&nbsp;&nbsp;}</div>
                                <div class="code-line">}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" data-aos="fade-left">
                        <div class="service-icon mb-4"><i class="bx bx-code-alt"></i></div>
                        <h2>Custom Software Development</h2>
                        <p class="text-muted mb-4">We build tailored software solutions designed specifically for your business needs. Our experienced team works closely with you to understand your requirements and deliver software that streamlines your operations and drives efficiency.</p>
                        <ul class="feature-list">
                            <li><i class="bx bx-check-circle"></i> Enterprise Applications</li>
                            <li><i class="bx bx-check-circle"></i> Business Process Automation</li>
                            <li><i class="bx bx-check-circle"></i> Database Design & Development</li>
                            <li><i class="bx bx-check-circle"></i> API Development & Integration</li>
                        </ul>
                    </div>
                </div>

                <div class="row g-5 align-items-center mb-5 pb-5 border-bottom">
                    <div class="col-lg-6 order-lg-2" data-aos="fade-left">
                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600&h=400&fit=crop" alt="Web Development" class="img-fluid rounded-4 shadow-lg">
                    </div>
                    <div class="col-lg-6 order-lg-1" data-aos="fade-right">
                        <div class="service-icon mb-4"><i class="bx bx-globe"></i></div>
                        <h2>Web Application Development</h2>
                        <p class="text-muted mb-4">Create powerful, responsive web applications that engage your users and grow your business. We use the latest technologies and frameworks to build fast, secure, and scalable web solutions.</p>
                        <ul class="feature-list">
                            <li><i class="bx bx-check-circle"></i> Progressive Web Apps (PWA)</li>
                            <li><i class="bx bx-check-circle"></i> E-commerce Platforms</li>
                            <li><i class="bx bx-check-circle"></i> Content Management Systems</li>
                            <li><i class="bx bx-check-circle"></i> Web Portals & Dashboards</li>
                        </ul>
                    </div>
                </div>

                <div class="row g-5 align-items-center mb-5 pb-5 border-bottom">
                    <div class="col-lg-6" data-aos="fade-right">
                        <img src="https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=600&h=400&fit=crop" alt="Mobile Development" class="img-fluid rounded-4 shadow-lg">
                    </div>
                    <div class="col-lg-6" data-aos="fade-left">
                        <div class="service-icon mb-4"><i class="bx bx-mobile-alt"></i></div>
                        <h2>Mobile App Development</h2>
                        <p class="text-muted mb-4">Reach your customers wherever they are with native and cross-platform mobile applications. We develop intuitive, high-performance apps for iOS and Android that deliver exceptional user experiences.</p>
                        <ul class="feature-list">
                            <li><i class="bx bx-check-circle"></i> iOS & Android Development</li>
                            <li><i class="bx bx-check-circle"></i> Cross-Platform Solutions</li>
                            <li><i class="bx bx-check-circle"></i> App Store Optimization</li>
                            <li><i class="bx bx-check-circle"></i> Mobile Backend Services</li>
                        </ul>
                    </div>
                </div>

                <div class="row g-5 align-items-center">
                    <div class="col-lg-6 order-lg-2" data-aos="fade-left">
                        <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=600&h=400&fit=crop" alt="Cloud Solutions" class="img-fluid rounded-4 shadow-lg">
                    </div>
                    <div class="col-lg-6 order-lg-1" data-aos="fade-right">
                        <div class="service-icon mb-4"><i class="bx bx-cloud"></i></div>
                        <h2>Cloud Solutions</h2>
                        <p class="text-muted mb-4">Leverage the power of cloud computing to scale your business efficiently. We help you migrate to the cloud, optimize your infrastructure, and build cloud-native applications.</p>
                        <ul class="feature-list">
                            <li><i class="bx bx-check-circle"></i> Cloud Migration Services</li>
                            <li><i class="bx bx-check-circle"></i> Infrastructure as Code</li>
                            <li><i class="bx bx-check-circle"></i> DevOps Implementation</li>
                            <li><i class="bx bx-check-circle"></i> Cloud Security & Compliance</li>
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Process Section -->
    <section class="section {{ $services->count() > 0 ? '' : 'section-gray' }}">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3" data-aos="fade-up">Our Process</span>
                <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">How We Work</h2>
                <p class="section-subtitle mx-auto" data-aos="fade-up" data-aos-delay="200">
                    A proven methodology that ensures project success
                </p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-center p-4">
                        <div class="service-icon mx-auto mb-4 position-relative">
                            <i class="bx bx-conversation"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">1</span>
                        </div>
                        <h5>Discovery</h5>
                        <p class="text-muted small">Understanding your business goals, requirements, and challenges</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-center p-4">
                        <div class="service-icon mx-auto mb-4 position-relative">
                            <i class="bx bx-pencil"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">2</span>
                        </div>
                        <h5>Design</h5>
                        <p class="text-muted small">Creating detailed specifications and user-centered designs</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-center p-4">
                        <div class="service-icon mx-auto mb-4 position-relative">
                            <i class="bx bx-code-block"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">3</span>
                        </div>
                        <h5>Development</h5>
                        <p class="text-muted small">Building your solution with agile methodology and best practices</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="text-center p-4">
                        <div class="service-icon mx-auto mb-4 position-relative">
                            <i class="bx bx-rocket"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">4</span>
                        </div>
                        <h5>Delivery</h5>
                        <p class="text-muted small">Deploying, training, and providing ongoing support</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container text-center position-relative" style="z-index: 10;">
            <h2 data-aos="fade-up">Ready to Get Started?</h2>
            <p class="mx-auto" style="max-width: 600px;" data-aos="fade-up" data-aos-delay="100">
                Let's discuss your project requirements and find the perfect solution for your business.
            </p>
            <a href="{{ url('/contact-us') }}" class="btn-white" data-aos="fade-up" data-aos-delay="200">
                Request a Quote <i class="bx bx-right-arrow-alt"></i>
            </a>
        </div>
    </section>
@endsection
