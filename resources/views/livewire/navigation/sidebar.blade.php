<!--sidebar wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="admin/images/logo-icon.png" class="logo-icon" alt="logo">
        </div>
        <div>
            <h4 class="logo-text">STJH</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('dashboard') }}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>           
        </li>
        <li>
            <a href="{{ route('applicants') }}">
                <div class="parent-icon"><i class='bx bx-analyse'></i>
                </div>
                <div class="menu-title">Applications</div>
            </a>
            <ul>
                <li> <a href="{{ route('applicants') }}"><i class='bx bx-radio-circle'></i>Applicant List</a>
                </li>
                <li> <a href="{{ route('jobslist') }}"><i class='bx bx-radio-circle'></i>Vacancy Available</a>
                </li>
            </ul>
        </li>
       
        <li><a class="has-arrow" href="#"><div class="parent-icon"><i class='bx bx-comment-dots'></i>
                </div>
                <div class="menu-title">Registered Clients</div>
              </a>
            <ul>
                <li><a href="{{ route('clients') }} " ><i class='bx bx-radio-circle'></i>Clients</a></li>
            </ul>
        </li>
        <li><a class="has-arrow" href="#"><div class="parent-icon"><i class='bx bx-briefcase'></i>
                </div>
                <div class="menu-title">Services</div>
              </a>
            <ul>
                <li><a href="{{ route('client-services') }}"><i class='bx bx-radio-circle'></i>Client Services</a></li>
                <li><a href="{{ route('service-types') }}"><i class='bx bx-radio-circle'></i>Service Types</a></li>
            </ul>
        </li>
        <li>
            <a href="{{ route('contact-requests') }}">
                <div class="parent-icon"><i class='bx bx-envelope'></i>
                </div>
                <div class="menu-title">Contact Requests</div>
            </a>
        </li>
       
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-cog fs-5"></i>
                </div>
                <div class="menu-title">Settings</div>
            </a>
            <ul>
                <li><a class="has-arrow" href="#"><i class='bx bx-radio-circle'></i>Website Content</a>
                    <ul>
                        <li><a href="{{ route('hero-sections') }}"><i class='bx bx-radio-circle'></i>Hero Sections</a></li>
                        <li><a href="{{ route('website-services') }}"><i class='bx bx-radio-circle'></i>Services</a></li>
                        <li><a href="{{ route('about-content') }}"><i class='bx bx-radio-circle'></i>About Company</a></li>
                        <li><a href="{{ route('gallery') }}"><i class='bx bx-radio-circle'></i>Gallery</a></li>
                        <li><a href="{{ route('testimonials') }}"><i class='bx bx-radio-circle'></i>Testimonials</a></li>
                        <li><a href="{{ route('partners') }}"><i class='bx bx-radio-circle'></i>Partners</a></li>
                        <li><a href="{{ route('team') }}"><i class='bx bx-radio-circle'></i>Team</a></li>
                    </ul>
                </li>
                <li><a class="has-arrow" href="#"><i class='bx bx-radio-circle'></i>SMS Settings</a>
                    <ul>
                        <li><a href="{{ route('smscategory') }}">
                            <i class='bx bx-radio-circle'></i>SMS Category</a>
                        </li>
                    </ul>
                </li>
                 <li><a class="has-arrow" href="#"><i class='bx bx-radio-circle'></i>Products</a>
                    <ul>
                        <li><a href="{{ route('listproducts') }}">
                            <i class='bx bx-radio-circle'></i>list products</a>
                        </li>
                    </ul>
                </li>
                <li> <a href="#"><i class='bx bx-radio-circle'></i>Vacancy Registry</a>
                </li>
                <li><a class="has-arrow" href="#"><i class='bx bx-radio-circle'></i>User Management</a>
                    <ul>
                        <li><a href="{{ route('users') }}"><i class='bx bx-radio-circle'></i>Users</a></li>
                        @can('view roles')
                        <li><a href="{{ route('roles') }}"><i class='bx bx-radio-circle'></i>Roles</a></li>
                        @endcan
                        @can('view permissions')
                        <li><a href="{{ route('permissions') }}"><i class='bx bx-radio-circle'></i>Permissions</a></li>
                        @endcan
                    </ul>
                </li>
                <li>
                    <a href="{{ route('companydetails') }}"  >
                         <i class='bx bx-radio-circle'></i>Company Details</a>
                    </a>
                </li>
                
            </ul>
        </li>
    </ul>
    <!--end navigation-->
</div>
<!--end sidebar wrapper -->