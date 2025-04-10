@include('frontend.header')

<!--Page Title-->
<section class="page-title" style="background-image: url(images/background/8.jpg); heigth:520px;">
    <div class="auto-container">
        <div class="title-outer">
            <h1>Contact Us</h1>
            <ul class="page-breadcrumb">
                <li><a href="#">Home</a></li>
                <li>info</li>
            </ul>
        </div>
    </div>
</section>
<!--End Page Title-->

<!--Sidebar Page Container-->
<div class="sidebar-page-container">
    <div class="auto-container">
        <div class="row clearfix">
            <!--Content Side / Our Blog-->
            <div class="content-side col-xl-12 col-lg-12 col-md-12 col-sm-12 order-2">
                <div class="help-box">
                    <div class="content-box">
                        <div class="title-box">
                            <center>
                                <i class='icon flaticon-email' style='font-size:25px'></i>
                                <h3 style="display: inline;">APPLY NOW</h3>
                            </center>
                        </div>
                        <form action="{{ route('applicationform') }}" class="form" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="row col-xl-12">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            {{ $error }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>                        
                                    @endforeach
                                    @if(session('success_message'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success_message') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="content-side col-xl-6 col-lg-6 col-md-12 col-sm-12 order-2">
                                    <div class="col form-group">
                                        Name: <input type="text" class="form-control w-200" placeholder="Enter your Name"  name="ApplicantName"><br>
                                        Sex:<select name="Gender" id="Gender" class="form-control w-200" >
                                            <option value="">Select</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                        <br>
                                        Marital Status:<select name="MaritalStatus" id="MaritalStatus" class="form-control w-200" >
                                            <option value="">Select</option>
                                            <option value="Single">Single</option>
                                            <option value="Maried">Maried</option>
                                            <option value="Divorced">Divorced</option>
                                            <option value="Widowed">Widowed</option>
                                            <option value="Separated">Separated</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        <br>
                                        Nida: <input type="text" class="form-control w-200 mb-4" placeholder="Nitional ID Number"  name="Nida"> 

                                        Birth Certificate: <input type="file" class="form-control w-200 mb-4"   name="birthCert">  

                                        Four Four Certificate: <input type="file" class="form-control w-200 mb-4"   name="fourFourCert">
                                        Collage certiface: <input type="file" class="form-control w-200 mb-4"   name="collageCert">
                                        
                                        Internship Certificate: <input type="file" class="form-control w-200 mb-4"   name="internshipCert">
                                        
                                        Job Application Letter: <input type="file" class="form-control w-200 mb-4"   name="applicationLetter">
                                        
                                        
                                    </div>
                                </div>
                                <div class="content-side col-xl-6 col-lg-6 col-md-12 col-sm-12 order-2">
                                    <div class="col form-group">
                                        Date Of Birth: <input type="date" class="form-control w-200" placeholder="Enter your Date of Birth"  name="dob">
                                        <br>
                                        Phone Number: <input type="tel" class="form-control w-200 mb-4" placeholder="Enter your Phone number"  name="phone">
                                        Email: <input type="email" class="form-control w-200 mb-4" placeholder="Enter your Email"  name="ApplicantEmail">
                                        Location: <input type="text" class="form-control w-200 mb-4" placeholder="Enter your Location"  name="Location">
                                        
                                        Form Six Certificate: <input type="file" class="form-control w-200 mb-4"   name="sixCertificate">
                                        License: <input type="file" class="form-control w-200 mb-4"   name="license">
                                        
                                        MCT/TNMC Certificate: <input type="file" class="form-control w-200 mb-4"   name="mctCertificate">
                                        Cariculum Vitae: <input type="file" class="form-control w-200 mb-4"   name="CariculumVitae">
                                    </div>
                                </div>  
                                <div class="col-offset-6 col-xl-3 col-lg-3 col-md-12 col-sm-12 order-2">
                                    <button type="submit" name="filepost" class="theme-btn btn-style-one">SUBMIT APPLICATION</button>
                                </div>                              
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Sidebar Page Container -->
@include('frontend.footer')