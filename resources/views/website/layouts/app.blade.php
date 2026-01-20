<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Professional software development company specializing in custom solutions, web applications, and digital transformation.')">
    <title>@yield('title', 'TechSolutions') - Software Development Company</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Box Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #0ea5e9;
            --accent: #22d3ee;
            --dark: #0f172a;
            --dark-light: #1e293b;
            --gray: #64748b;
            --light: #f8fafc;
            --gradient: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            --gradient-dark: linear-gradient(135deg, var(--dark) 0%, var(--dark-light) 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--dark);
            overflow-x: hidden;
            line-height: 1.7;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--light);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 4px;
        }

        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            font-weight: 700;
            line-height: 1.3;
        }

        .text-gradient {
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Buttons */
        .btn-primary-custom {
            background: var(--gradient);
            border: none;
            padding: 14px 32px;
            border-radius: 50px;
            color: #fff;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(99, 102, 241, 0.3);
            color: #fff;
        }

        .btn-outline-custom {
            border: 2px solid var(--primary);
            padding: 12px 30px;
            border-radius: 50px;
            color: var(--primary);
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: transparent;
        }

        .btn-outline-custom:hover {
            background: var(--primary);
            color: #fff;
            transform: translateY(-3px);
        }

        /* Navbar */
        .navbar-custom {
            padding: 20px 0;
            transition: all 0.3s ease;
            background: transparent;
        }

        .navbar-custom.scrolled {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
        }

        .navbar-custom .navbar-brand {
            font-weight: 800;
            font-size: 1.8rem;
            color: var(--dark);
        }

        .navbar-custom .nav-link {
            color: var(--dark);
            font-weight: 500;
            padding: 10px 20px !important;
            transition: all 0.3s ease;
        }

        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active {
            color: var(--primary);
        }

        /* Hero Section */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 80%;
            height: 150%;
            background: var(--gradient);
            border-radius: 50%;
            opacity: 0.1;
            animation: float 20s ease-in-out infinite;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 50%;
            height: 100%;
            background: linear-gradient(135deg, var(--secondary) 0%, var(--accent) 100%);
            border-radius: 50%;
            opacity: 0.08;
            animation: float 15s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(2%, 2%) rotate(5deg); }
            50% { transform: translate(0, 4%) rotate(0deg); }
            75% { transform: translate(-2%, 2%) rotate(-5deg); }
        }

        .hero-content {
            position: relative;
            z-index: 10;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.1;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--gray);
            margin-bottom: 2rem;
            max-width: 500px;
        }

        .hero-image {
            position: relative;
            z-index: 10;
        }

        .hero-image img {
            max-width: 100%;
            filter: drop-shadow(0 40px 80px rgba(99, 102, 241, 0.3));
            animation: heroFloat 6s ease-in-out infinite;
        }

        @keyframes heroFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        /* Code Block Animation */
        .code-block {
            background: var(--dark);
            border-radius: 16px;
            padding: 24px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.9rem;
            color: #e2e8f0;
            position: relative;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
        }

        .code-block::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 40px;
            background: var(--dark-light);
            border-radius: 16px 16px 0 0;
        }

        .code-dots {
            position: absolute;
            top: 14px;
            left: 16px;
            display: flex;
            gap: 8px;
        }

        .code-dots span {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .code-dots span:nth-child(1) { background: #ff5f56; }
        .code-dots span:nth-child(2) { background: #ffbd2e; }
        .code-dots span:nth-child(3) { background: #27ca40; }

        .code-content {
            margin-top: 30px;
        }

        .code-line {
            opacity: 0;
            animation: typeIn 0.5s ease forwards;
        }

        .code-line:nth-child(1) { animation-delay: 0.5s; }
        .code-line:nth-child(2) { animation-delay: 1s; }
        .code-line:nth-child(3) { animation-delay: 1.5s; }
        .code-line:nth-child(4) { animation-delay: 2s; }
        .code-line:nth-child(5) { animation-delay: 2.5s; }

        @keyframes typeIn {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .code-keyword { color: #c792ea; }
        .code-function { color: #82aaff; }
        .code-string { color: #c3e88d; }
        .code-comment { color: #546e7a; }

        /* Section Styles */
        .section {
            padding: 100px 0;
        }

        .section-dark {
            background: var(--dark);
            color: #fff;
        }

        .section-gray {
            background: var(--light);
        }

        .section-title {
            font-size: 2.75rem;
            margin-bottom: 1rem;
        }

        .section-subtitle {
            color: var(--gray);
            font-size: 1.1rem;
            max-width: 600px;
        }

        .section-dark .section-subtitle {
            color: #94a3b8;
        }

        /* Service Cards */
        .service-card {
            background: #fff;
            border-radius: 20px;
            padding: 40px 30px;
            transition: all 0.4s ease;
            border: 1px solid #e2e8f0;
            height: 100%;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 60px rgba(99, 102, 241, 0.15);
            border-color: transparent;
        }

        .service-icon {
            width: 70px;
            height: 70px;
            border-radius: 16px;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            color: #fff;
            margin-bottom: 24px;
        }

        .service-card h4 {
            margin-bottom: 12px;
        }

        .service-card p {
            color: var(--gray);
            margin-bottom: 20px;
        }

        .service-link {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }

        .service-link:hover {
            gap: 12px;
            color: var(--primary-dark);
        }

        /* Stats */
        .stat-item {
            text-align: center;
            padding: 30px;
        }

        .stat-number {
            font-size: 3.5rem;
            font-weight: 800;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
            margin-bottom: 10px;
        }

        .stat-label {
            color: var(--gray);
            font-weight: 500;
        }

        /* About Section */
        .about-image {
            position: relative;
        }

        .about-image img {
            border-radius: 20px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
        }

        .about-badge {
            position: absolute;
            bottom: -20px;
            right: -20px;
            background: var(--gradient);
            color: #fff;
            padding: 20px 30px;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(99, 102, 241, 0.3);
        }

        .about-badge h3 {
            font-size: 2.5rem;
            margin-bottom: 0;
        }

        .about-badge p {
            margin-bottom: 0;
            opacity: 0.9;
        }

        .feature-list {
            list-style: none;
            padding: 0;
        }

        .feature-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            font-weight: 500;
        }

        .feature-list li i {
            color: var(--primary);
            font-size: 1.25rem;
        }

        /* Portfolio */
        .portfolio-item {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 30px;
        }

        .portfolio-item img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            transition: all 0.5s ease;
        }

        .portfolio-item:hover img {
            transform: scale(1.1);
        }

        .portfolio-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to top, rgba(15, 23, 42, 0.9) 0%, transparent 100%);
            display: flex;
            align-items: flex-end;
            padding: 30px;
            opacity: 0;
            transition: all 0.4s ease;
        }

        .portfolio-item:hover .portfolio-overlay {
            opacity: 1;
        }

        .portfolio-content h4 {
            color: #fff;
            margin-bottom: 5px;
        }

        .portfolio-content span {
            color: var(--accent);
            font-size: 0.9rem;
        }

        /* Testimonials */
        .testimonial-card {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            height: 100%;
        }

        .testimonial-rating {
            color: #fbbf24;
            margin-bottom: 20px;
        }

        .testimonial-text {
            font-size: 1.1rem;
            color: var(--dark);
            margin-bottom: 24px;
            line-height: 1.8;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .testimonial-author img {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            object-fit: cover;
        }

        .testimonial-author-placeholder {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .testimonial-author h5 {
            margin-bottom: 2px;
        }

        .testimonial-author span {
            color: var(--gray);
            font-size: 0.9rem;
        }

        /* Partners */
        .partner-logo {
            height: 60px;
            opacity: 0.6;
            filter: grayscale(100%);
            transition: all 0.3s ease;
            object-fit: contain;
        }

        .partner-logo:hover {
            opacity: 1;
            filter: grayscale(0%);
        }

        /* CTA Section */
        .cta-section {
            background: var(--gradient);
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -10%;
            width: 40%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .cta-section h2 {
            color: #fff;
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .cta-section p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        .btn-white {
            background: #fff;
            color: var(--primary);
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-white:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            color: var(--primary-dark);
        }

        /* Contact Form */
        .contact-form .form-control {
            padding: 16px 20px;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .contact-form .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .contact-info-card {
            background: var(--dark);
            border-radius: 20px;
            padding: 40px;
            color: #fff;
            height: 100%;
        }

        .contact-info-item {
            display: flex;
            gap: 16px;
            margin-bottom: 30px;
        }

        .contact-info-item i {
            font-size: 1.5rem;
            color: var(--accent);
        }

        .contact-info-item h5 {
            margin-bottom: 5px;
        }

        .contact-info-item p {
            color: #94a3b8;
            margin-bottom: 0;
        }

        /* Footer */
        .footer {
            background: var(--dark);
            color: #fff;
            padding: 80px 0 30px;
        }

        .footer-brand {
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .footer-text {
            color: #94a3b8;
            margin-bottom: 24px;
        }

        .footer-social a {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--dark-light);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .footer-social a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }

        .footer-title {
            font-size: 1.1rem;
            margin-bottom: 24px;
            position: relative;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--primary);
            padding-left: 5px;
        }

        .footer-bottom {
            border-top: 1px solid var(--dark-light);
            margin-top: 50px;
            padding-top: 30px;
            text-align: center;
            color: #64748b;
        }

        /* Back to Top */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--gradient);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 999;
            cursor: pointer;
            border: none;
        }

        .back-to-top.active {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.4);
        }

        /* Responsive */
        @media (max-width: 991px) {
            .hero-title {
                font-size: 2.75rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .cta-section h2 {
                font-size: 2rem;
            }
        }

        @media (max-width: 767px) {
            .hero-section {
                padding-top: 120px;
                text-align: center;
            }

            .hero-subtitle {
                margin: 0 auto 2rem;
            }

            .hero-buttons {
                justify-content: center;
            }

            .about-badge {
                position: relative;
                bottom: auto;
                right: auto;
                margin-top: 20px;
                display: inline-block;
            }

            .navbar-custom .navbar-collapse {
                background: #fff;
                padding: 20px;
                border-radius: 16px;
                margin-top: 15px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            }
        }

        /* Animations */
        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .fade-up.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <span class="text-gradient">Tech</span>Solutions
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bx bx-menu fs-3"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('about-us') ? 'active' : '' }}" href="{{ url('/about-us') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('services') ? 'active' : '' }}" href="{{ url('/services') }}">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('portfolio') ? 'active' : '' }}" href="{{ url('/portfolio') }}">Portfolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('contact-us') ? 'active' : '' }}" href="{{ url('/contact-us') }}">Contact</a>
                    </li>
                </ul>
                <a href="{{ url('/contact-us') }}" class="btn-primary-custom ms-lg-4">
                    Get Started <i class="bx bx-right-arrow-alt"></i>
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">
                        @if($companyDetails && $companyDetails->company_name)
                            {{ $companyDetails->company_name }}
                        @else
                            <span class="text-gradient">Tech</span>Solutions
                        @endif
                    </div>
                    <p class="footer-text">
                        We transform ideas into powerful software solutions. Our team of experts is dedicated to delivering innovative technology that drives your business forward.
                    </p>
                    <div class="footer-social">
                        @if($companyDetails)
                            @if($companyDetails->facebook)
                                <a href="{{ $companyDetails->facebook }}" target="_blank" rel="noopener noreferrer"><i class="bx bxl-facebook"></i></a>
                            @endif
                            @if($companyDetails->twitter)
                                <a href="{{ $companyDetails->twitter }}" target="_blank" rel="noopener noreferrer"><i class="bx bxl-twitter"></i></a>
                            @endif
                            @if($companyDetails->linkedin)
                                <a href="{{ $companyDetails->linkedin }}" target="_blank" rel="noopener noreferrer"><i class="bx bxl-linkedin"></i></a>
                            @endif
                            @if($companyDetails->instagram)
                                <a href="{{ $companyDetails->instagram }}" target="_blank" rel="noopener noreferrer"><i class="bx bxl-instagram"></i></a>
                            @endif
                            @if($companyDetails->youtube)
                                <a href="{{ $companyDetails->youtube }}" target="_blank" rel="noopener noreferrer"><i class="bx bxl-youtube"></i></a>
                            @endif
                            @if($companyDetails->tiktok)
                                <a href="{{ $companyDetails->tiktok }}" target="_blank" rel="noopener noreferrer"><i class="bx bxl-tiktok"></i></a>
                            @endif
                            @if($companyDetails->github)
                                <a href="{{ $companyDetails->github }}" target="_blank" rel="noopener noreferrer"><i class="bx bxl-github"></i></a>
                            @endif
                        @else
                            <a href="#"><i class="bx bxl-facebook"></i></a>
                            <a href="#"><i class="bx bxl-twitter"></i></a>
                            <a href="#"><i class="bx bxl-linkedin"></i></a>
                            <a href="#"><i class="bx bxl-github"></i></a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-title">Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ url('/about-us') }}">About Us</a></li>
                        <li><a href="{{ url('/services') }}">Services</a></li>
                        <li><a href="{{ url('/portfolio') }}">Portfolio</a></li>
                        <li><a href="{{ url('/contact-us') }}">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-title">Services</h5>
                    <ul class="footer-links">
                        <li><a href="#">Web Development</a></li>
                        <li><a href="#">Mobile Apps</a></li>
                        <li><a href="#">Custom Software</a></li>
                        <li><a href="#">Cloud Solutions</a></li>
                        <li><a href="#">IT Consulting</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-title">Contact Info</h5>
                    <ul class="footer-links">
                        @if($companyDetails)
                            @if($companyDetails->address)
                                <li><i class="bx bx-map me-2"></i> {{ $companyDetails->address }}</li>
                            @endif
                            @if($companyDetails->phone)
                                <li><i class="bx bx-phone me-2"></i> {{ $companyDetails->phone }}</li>
                            @endif
                            @if($companyDetails->email)
                                <li><i class="bx bx-envelope me-2"></i> {{ $companyDetails->email }}</li>
                            @endif
                        @else
                            <li><i class="bx bx-map me-2"></i> Dar es Salaam, Tanzania</li>
                            <li><i class="bx bx-phone me-2"></i> +255 123 456 789</li>
                            <li><i class="bx bx-envelope me-2"></i> info@example.com</li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} {{ $companyDetails->company_name ?? 'TechSolutions' }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top -->
    <button class="back-to-top" id="backToTop">
        <i class="bx bx-up-arrow-alt"></i>
    </button>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-out',
            once: true
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            const backToTop = document.getElementById('backToTop');

            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }

            if (window.scrollY > 300) {
                backToTop.classList.add('active');
            } else {
                backToTop.classList.remove('active');
            }
        });

        // Back to top
        document.getElementById('backToTop').addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>

    @stack('scripts')
</body>
</html>
