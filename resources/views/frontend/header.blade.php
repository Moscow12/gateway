
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Saint Joseph | CDH :  </title>

<!-- Stylesheets -->
<link href="{{ asset('web/css/bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('web/plugins/revolution/css/settings.css') }}" rel="stylesheet" type="text/css"><!-- REVOLUTION SETTINGS STYLES -->
<link href="{{ asset('web/plugins/revolution/css/layers.css') }}" rel="stylesheet" type="text/css"><!-- REVOLUTION LAYERS STYLES -->
<link href="{{ asset('web/plugins/revolution/css/navigation.css') }}" rel="stylesheet" type="text/css"><!-- REVOLUTION NAVIGATION STYLES -->
<link href="{{ asset('web/plugins/revolution/css/navigation.css') }}" rel="stylesheet" type="text/css"><!-- REVOLUTION NAVIGATION STYLES -->
<link href="{{ asset('web/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('web/css/responsive.css') }}" rel="stylesheet">
<link href="{{ asset('web/css/responsive.css') }}" rel="stylesheet">

<!--Color Themes-->
<link id="theme-color-file" href="{{ asset('web/css/color-themes/default-theme.css') }}" rel="stylesheet">

<link rel="shortcut icon" href="{{ asset('web/images/favicon.png') }}" type="image/x-icon">
<link rel="icon" href="{{ asset('web/images/favicon.png') }}" type="image/x-icon">
<link rel="icon" href="{{ asset('web/images/favicon.png') }}" type="image/x-icon">

<!-- Responsive -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script><![endif]-->
<!--[if lt IE 9]><script src="js/respond.js"></script><![endif]-->
</head>

<body>

<div class="page-wrapper">

    <!-- Preloader -->
    <div class="preloader"></div>
    
    <!-- Main Header-->
    <header class="main-header header-style-one">

        <!-- Header top -->
        <div class="header-top">
            <div class="auto-container">
                <div class="inner-container">
                    <div class="top-left">
                        <ul class="contact-list clearfix">
                            <li><i class="flaticon-hospital-1"></i>233 Soweto, Moshi, Kilimanjaro, TZ </li>
                            <li><i class="flaticon-back-in-time"></i>Mon - Sunday 24/7</li>
                        </ul>
                    </div>
                    <div class="top-right">
                        <ul class="social-icon-one">
                            <li><a href="#" ><span class="fab fa-facebook-f"></span></a></li>
                            <li><a href="#" ><span class="fab fa-twitter" ></span></a></li>
                            <li><a href="#" ><span class="fab fa-instagram"></span></a></li>
                            <li><a href="#" ><span class="fab fa-linkedin-in"></span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Header Top -->
        
        <!-- Header Lower -->
        <div class="header-lower">
            <div class="auto-container">    
                <!-- Main box -->
                <div class="main-box">
                    <div class="logo-box">
                        <div class="logo"><a href="#"><img src="{{ asset('web/images/logo.png') }}" alt="" title=""></a></div>
                    </div>

                    <!--Nav Box-->
                    <div class="nav-outer">
                        <nav class="nav main-menu">
                            <ul class="navigation" id="navbar">
                                <li class="current">
                                <a href="https://stjosephhospitalmoshi.or.tz/index.php?q=home"> Home</a>
                                   
                                </li>

                                <li >
                                   <a href="https://stjosephhospitalmoshi.or.tz/index.php?q=abt">About Us</a>
                                </li>
                                 <li >
                                   <a href="{{ route('viewtem') }}">Team</a>
                                </li>
                                <li class="dropdown">
                                    <span>Departments</span>
                                    <ul>
                                        <li><a href="https://stjosephhospitalmoshi.or.tz/index.php?q=deps">Departments</a></li>
                                    </ul>
                                </li>
                                <li><a href="https://stjosephhospitalmoshi.or.tz/index.php?q=serv">SERVICES</a></li>
                                <li><a href="https://stjosephhospitalmoshi.or.tz/index.php?q=galler">FACILITIES</a></li>
                                <li><a href="https://stjosephhospitalmoshi.or.tz/index.php?q=contacts">Contact</a></li>
                            </ul>
                        </nav>
                        <!-- Main Menu End-->

                        <div class="outer-box">
                            <button class="search-btn"><span class="fa fa-search"></span></button>
                             <a href="/applynow"  class="theme-btn btn-style-one"><span class="btn-title">APPLY NOW</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Header  -->
        <div class="sticky-header">
            <div class="auto-container">            

                <div class="main-box">
                    <div class="logo-box">
                        <div class="logo"><a href="#"><img src="{{ asset('web/images/logo.png') }}" alt="" title=""></a></div>
                    </div>
                    
                    <!--Keep This Empty / Menu will come through Javascript-->
                </div>
            </div>
        </div><!-- End Sticky Menu -->

        <!-- Mobile Header -->
        <div class="mobile-header">
            <div class="logo"><a href="#"><img src="{{ asset('web/images/logo.png') }}" alt="" title=""></a></div>

            <!--Nav Box-->
            <div class="nav-outer clearfix">

                <div class="outer-box">
                    <!-- Search Btn -->
                    <div class="search-box">
                        <button class="search-btn mobile-search-btn"><i class="flaticon-magnifying-glass"></i></button>
                    </div>

                    <a href="#nav-mobile" class="mobile-nav-toggler navbar-trigger"><span class="fa fa-bars"></span></a>
                </div>
            </div>
        </div>

        <!-- Mobile Nav -->
        <div id="nav-mobile"></div>

        <!-- Header Search -->
        <div class="search-popup">
            <span class="search-back-drop"></span>
            <button class="close-search"><span class="fa fa-times"></span></button>
            
            <div class="search-inner">
                <form method="post" action="blog-showcase.html">
                    <div class="form-group">
                        <input type="search" name="search-field" value="" placeholder="Search..." required="">
                        <button type="submit"><i class="flaticon-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Header Search -->
    </header>
    <!--End Main Header -->

    <!-- Start main section -->
    <div class="main-section">
        
    </div>
