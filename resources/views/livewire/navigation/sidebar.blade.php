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
            <ul>
                <li> <a href="index.html"><i class='bx bx-radio-circle'></i>Default</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{ route('dashboard') }}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">JOBS</div>
            </a>
            <ul>
                <li> <a href="{{ route('applicants') }}"><i class='bx bx-radio-circle'></i>Applicant List</a>
                </li>
                <li> <a href="{{ route('jobslist') }}"><i class='bx bx-radio-circle'></i>Vacancy Available</a>
                </li>
            </ul>
        </li>
        <li> 
            <a href="{{ route('users') }}"  >
                <div class="parent-icon"><i class="bx bx-user-circle"></i>
                </div>
                <div class="menu-title">Users</div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-cog fs-5"></i>
                </div>
                <div class="menu-title">Settings</div>
            </a>
            <ul>
                <li> <a href="{{ route('location') }}" wire:navigate><i class='bx bx-radio-circle'></i>Location</a>
                </li>
                <li> <a href="ecommerce-products-details.html"><i class='bx bx-radio-circle'></i>Product
                        Details</a>
                </li>
                <li> <a href="ecommerce-add-new-products.html"><i class='bx bx-radio-circle'></i>Add New
                        Products</a>
                </li>
                <li> <a href="ecommerce-orders.html"><i class='bx bx-radio-circle'></i>Orders</a>
                </li>
                <li><a class="has-arrow" href="javascript:;"><i class='bx bx-radio-circle'></i>Cover</a>
                    <ul>
                        <li><a href="auth-cover-signin.html" target="_blank"><i
                                    class='bx bx-radio-circle'></i>Sign In</a></li>
                        <li><a href="auth-cover-signup.html" target="_blank"><i
                                    class='bx bx-radio-circle'></i>Sign Up</a></li>
                        <li><a href="auth-cover-forgot-password.html" target="_blank"><i
                                    class='bx bx-radio-circle'></i>Forgot Password</a></li>
                        <li><a href="auth-cover-reset-password.html" target="_blank"><i
                                    class='bx bx-radio-circle'></i>Reset Password</a></li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
    <!--end navigation-->
</div>
<!--end sidebar wrapper -->