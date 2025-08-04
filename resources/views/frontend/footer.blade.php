


    <!-- Clients Section -->
    <section class="clients-section">
        <div  class="sec-title text-center">
            <h2 align="center">OUR PARTNERS</h2>
            <span class="divider"></span>
        </div>
        <div class="auto-container">

            <!-- Sponsors Outer -->
            <div class="sponsors-outer">
                <!--clients carousel-->
                <ul class="clients-carousel owl-carousel owl-theme">
                    @foreach($teams as $team)
                    <li class="slide-item"> <a href="#"><img src="{{ asset('storage/' . $team->photo) }}" alt=""></a> </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
    <!--End Clients Section -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!--Widgets Section-->
        <div class="widgets-section" style="background-image: url(images/background/7.jpg);">
            <div class="auto-container">
                <div class="row">
                    <!--Big Column-->
                    <div class="big-column col-xl-6 col-lg-12 col-md-12 col-sm-12">
                        <div class="row">
                            <!--Footer Column-->
                            <div class="footer-column col-xl-7 col-lg-6 col-md-6 col-sm-12">
                                <div class="footer-widget about-widget">
                                    <div class="logo">
                                        <a href="#"><img src="images/logo.png" alt="" /></a>
                                    </div>
                                    <div class="text">
                                        <p>Our Hospital has grown to provide a world class facility for the clinic advanced restorative. </p>
                                        <p>We are among the most qualified implant providers in the Kilimanjaro with over 10 years of quality treatment and patient care.</p>
                                    </div>
                                    <ul class="social-icon-three">
                                        <li><a href="https://web.facebook.com/St-Joseph-Council-Disignated-Hospital-Moshi-104618398893272" target='_bank'><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="#" target='_bank'><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="https://www.instagram.com/p/Cb-YXeSoyXR/?utm_source=ig_web_copy_link" target='_bank'><i class="fab fa-instagram"></i></a></li>
                                        <li><a href="#" target='_bank'><i class="fab fa-linkedin-in"></i></a></li>
                                        <li><a href="/login" target='_blank'><i class="fab fa-browser"></i></a></li>
                                    </ul>
                                </div>
                            </div>

                            <!--Footer Column-->
                            <div class="footer-column col-xl-5 col-lg-6 col-md-6 col-sm-12">
                                <div class="footer-widget">
                                    <h2 class="widget-title">Departments</h2>
                                    <ul class="user-links">
                                       
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Big Column-->
                    <div class="big-column col-xl-6 col-lg-12 col-md-12 col-sm-12">
                        <div class="row">
                            <!--Footer Column-->
                            <div class="footer-column col-lg-6 col-md-6 col-sm-12">
                                <!--Footer Column-->
                                <div class="footer-widget recent-posts">
                                    <h2 class="widget-title">Latest News</h2>
                                     <!--Footer Column-->
                                    <div class="widget-content">
                                        <div class="post">
                                            <div class="thumb"><a href=""><img src="images/resource/post-thumb-1.jpg" alt=""></a></div>
                                            <h4><a href="#">Integrative Medicine <Br>& Cancer Treatment.</a></h4>
                                            <span class="date">July 11, 2020</span>
                                        </div>

                                        <div class="post">
                                            <div class="thumb"><a href="#"><img src="images/resource/post-thumb-2.jpg" alt=""></a></div>
                                            <h4><a href="#">Achieving Better <br>Health Care Time.</a></h4>
                                            <span class="date">August 1, 2020</span>
                                        </div>

                                        <div class="post">
                                            <div class="thumb"><a href="#"><img src="images/resource/post-thumb-3.jpg" alt=""></a></div>
                                            <h4><a href="#">Great Health Care <br>For Patients.</a></h4>
                                            <span class="date">August 1, 2020</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--Footer Column-->
                            <div class="footer-column col-lg-6 col-md-6 col-sm-12">
                                <!--Footer Column-->
                                <div class="footer-widget contact-widget">
                                    <h2 class="widget-title">Contact Us</h2>
                                     <!--Footer Column-->
                                    <div class="widget-content">
                                        <ul class="contact-list">
                                            <li>
                                                <span class="icon flaticon-placeholder"></span>
                                                <div class="text">P.O Box 330 Moshi, Soweto <Br>Kilimanjaro, Tanzania</div>
                                            </li>

                                            <li>
                                                <span class="icon flaticon-call-1"></span>
                                                <div class="text">Mon to Fri : 08:30 - 18:00</div>
                                                <a href="tel:+89868679575"><strong>+255762367977</strong></a>
                                            </li>

                                            <li>
                                                <span class="icon flaticon-email"></span>
                                                <div class="text">Do you have a Question?<br>
                                                <a href="mailto:hro@stjosephhospitalmoshi.or.tz"><strong>hro@stjosephhospitalmoshi.or.tz</strong></a></div>
                                            </li>

                                            <li>
                                                <span class="icon flaticon-back-in-time"></span>
                                                <div class="text">Mon - Sunday 24/7
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Footer Bottom-->
        <div class="footer-bottom">
            <!-- Scroll To Top -->
            <div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-angle-up"></span></div>
            
            <div class="auto-container">
                <div class="inner-container clearfix">
                    <div class="footer-nav">
                        <ul class="clearfix">
                           <li><a href="#">Privacy Policy</a></li> 
                           <li><a href="#">Contact</a></li> 
                           <li><a href="#">Developer</a></li>  
                        </ul>
                    </div>
                    
                    <div class="copyright-text">
                        <p>Copyright ©  {{ date('Y') }} <a href="#">ICT Department STJH</a> All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--End Main Footer -->

</div><!-- End Page Wrapper -->

<script src="{{ asset('web/js/jquery.js') }}"></script> 
<script src="{{ asset('web/js/popper.min.js') }}"></script>
<!--Revolution Slider-->
<script src="{{ asset('web/plugins/revolution/js/jquery.themepunch.revolution.min.js') }}"></script>
<script src="{{ asset('web/plugins/revolution/js/jquery.themepunch.tools.min.js') }}"></script>
<script src="{{ asset('web/plugins/revolution/js/extensions/revolution.extension.actions.min.js') }}"></script>
<script src="{{ asset('web/plugins/revolution/js/extensions/revolution.extension.carousel.min.js') }}"></script>
<script src="{{ asset('web/plugins/revolution/js/extensions/revolution.extension.kenburn.min.js') }}"></script>
<script src="{{ asset('web/plugins/revolution/js/extensions/revolution.extension.layeranimation.min.js') }}"></script>
<script src="{{ asset('web/plugins/revolution/js/extensions/revolution.extension.migration.min.js') }}"></script>
<script src="{{ asset('web/plugins/revolution/js/extensions/revolution.extension.navigation.min.js') }}"></script>
<script src="{{ asset('web/plugins/revolution/js/extensions/revolution.extension.parallax.min.js') }}"></script>
<script src="{{ asset('web/plugins/revolution/js/extensions/revolution.extension.slideanims.min.js') }}"></script>
<script src="{{ asset('web/plugins/revolution/js/extensions/revolution.extension.video.min.js') }}"></script>
<script src="{{ asset('web/js/main-slider-script.js') }}"></script>
<!--Revolution Slider-->
<script src="{{ asset('web/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('web/js/jquery.fancybox.js') }}"></script>
<script src="{{ asset('web/js/mmenu.polyfills.js') }}"></script>
<script src="{{ asset('web/js/jquery.modal.min.js') }}"></script>
<script src="{{ asset('web/js/mmenu.js') }}"></script>
<script src="{{ asset('web/js/appear.js') }}"></script>
<script src="{{ asset('web/js/owl.js') }}"></script>
<script src="{{ asset('web/js/wow.js') }}"></script>
<script src="{{ asset('web/js/script.js') }}"></script>
<script src="{{ asset('web/js/custom.js') }}"></script>
</body>
</html>


