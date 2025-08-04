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
        <li><a class="has-arrow" href="#"><div class="parent-icon"><i class='bx bx-comment-dots'></i>
                </div>
                <div class="menu-title">BULK SMS</div>
              </a>
            <ul>
                <li><a href="{{ route('clients') }} " target="_blank"><i class='bx bx-radio-circle'></i>Clients</a></li>
                <li><a href="#" target="_blank"><i class='bx bx-radio-circle'></i>Sign Up</a></li>
                <li><a href="#" target="_blank"><i class='bx bx-radio-circle'></i>Forgot Password</a></li>
                <li><a href="#" target="_blank"><i class='bx bx-radio-circle'></i>Reset Password</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-cog fs-5"></i>
                </div>
                <div class="menu-title">Settings</div>
            </a>
            <ul>
                <li> <a href="{{ route('location') }}" wire:navigate><i class='bx bx-radio-circle'></i>Address</a>
                </li>
                <li><a class="has-arrow" href="#"><i class='bx bx-radio-circle'></i>Website Settings</a>
                    <ul>
                        <li><a href="#" target="_blank"><i
                                    class='bx bx-radio-circle'></i>Contacts</a></li>
                        <li><a href="{{ route('team') }}" ><i
                                    class='bx bx-radio-circle'></i>Team</a></li>
                        <li><a href="#" target="_blank"><i
                                    class='bx bx-radio-circle'></i>Gallery</a></li>
                        <li><a href="#" target="_blank"><i
                                    class='bx bx-radio-circle'></i>FAQ</a></li>
                        <li><a href="#" target="_blank"><i
                                    class='bx bx-radio-circle'></i>Terms & Conditions</a></li>
                        <li><a href="#" target="_blank"><i
                                    class='bx bx-radio-circle'></i>Reset Password</a></li>
                    </ul>
                </li>
                <li><a class="has-arrow" href="#"><i class='bx bx-radio-circle'></i>SMS Settings</a>
                    <ul>
                        <li><a href="{{ route('smscategory') }}">
                            <i class='bx bx-radio-circle'></i>SMS Category</a>
                        </li>
                    </ul>
                </li>
                <li> <a href="#"><i class='bx bx-radio-circle'></i>Vacancy Registry</a>
                </li>
                <li> <a href="#"><i class='bx bx-radio-circle'></i>Updates</a>
                </li>
                <li><a class="has-arrow" href="#"><i class='bx bx-radio-circle'></i>Cover</a>
                    <ul>
                        <li><a href="#" target="_blank"><i
                                    class='bx bx-radio-circle'></i>Sign In</a></li>
                        <li><a href="#" target="_blank"><i
                                    class='bx bx-radio-circle'></i>Sign Up</a></li>
                        <li><a href="#" target="_blank"><i
                                    class='bx bx-radio-circle'></i>Forgot Password</a></li>
                        <li><a href="#" target="_blank"><i
                                    class='bx bx-radio-circle'></i>Reset Password</a></li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
    <!--end navigation-->
</div>
<!--end sidebar wrapper -->