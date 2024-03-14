<!-- Main sidebar -->
<div class="sidebar sidebar-main sidebar-expand-lg border-0">

    <!-- Sidebar header -->
    <div class="sidebar-section  bg-opacity-10 border-bottom border-bottom-white border-opacity-10">
        <div class="sidebar-logo d-flex justify-content-center align-items-center">
            <a href="#" class="d-inline-flex align-items-center py-2">
                <img src="{{ asset('assets/images/icons/catking.png') }}" class="sidebar-logo-icon" alt="">
            </a>

            {{--  <div class="sidebar-resize-hide ms-auto">
                <button type="button"
                    class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex bg-primary">
                    <i class="ph-arrows-left-right"></i>
                </button>

                <button type="button"
                    class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none bg-black">
                    <i class="ph-x"></i>
                </button>
            </div>  --}}
        </div>
    </div>
    <!-- /sidebar header -->


    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <li class="nav-item py-2">
                    <a href="{{ route('ceo-revenue') }}"
                        class="nav-link {{ Route::currentRouteName() == 'ceo-revenue' ? 'active' : '' }}">
                        <i class="fas fa-money-bill-alt"></i>
                        <span>CEO Revenue</span>
                    </a>
                </li>
                <li class="nav-item py-2">
                    <a href="{{ route('student-profile') }}"
                        class="nav-link {{ Route::currentRouteName() == 'student-profile' ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Student Profile</span>
                    </a>
                </li>
                <li class="nav-item py-2">
                    <a href="{{ route('exam-toppers') }}"
                        class="nav-link {{ Route::currentRouteName() == 'exam-toppers' ? 'active' : '' }}">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Exam Toppers</span>
                    </a>
                </li>
                <li class="nav-item py-2">
                    <a href="{{ route('mentors-interView') }}"
                        class="nav-link {{ Route::currentRouteName() == 'mentors-interView' ? 'active' : '' }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Mentors/ Interview</span>
                    </a>
                </li>
                <li class="nav-item py-2">
                    <a href="{{ route('faculty-session') }}"
                        class="nav-link {{ Route::currentRouteName() == 'faculty-session' ? 'active' : '' }}">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>Faculty & Session</span>
                    </a>
                </li>
                <li class="nav-item py-2">
                    <a href="{{ route('finance') }}"
                        class="nav-link {{ Route::currentRouteName() == 'finance' ? 'active' : '' }}">
                        <i class="fas fa-coins"></i>
                        <span>Finance</span>
                    </a>
                </li>
                <li class="nav-item py-2">
                    <a href="{{ route('marketing') }}"
                        class="nav-link {{ Route::currentRouteName() == 'marketing' ? 'active' : '' }}">
                        {{--  <i class="ph-rows"></i>  --}}
                        <i class="ph-megaphone "></i>
                        <span>Marketing</span>
                    </a>
                </li>
                <li class="nav-item py-2">
                    <a href="{{ route('forum') }}"
                        class="nav-link {{ Route::currentRouteName() == 'forum' ? 'active' : '' }}">
                        <i class="fab fa-forumbee"></i>
                        <span>Forum</span>
                    </a>
                </li>
                <li class="nav-item py-2">
                    <a href="{{ route('CATKingOne') }}"
                        class="nav-link {{ Route::currentRouteName() == 'CATKingOne' ? 'active' : '' }}">
                        <i class="fas fa-clone"></i>
                        <span>CATKing One</span>
                    </a>
                </li>
                <li class="nav-item py-2">
                    <a href="{{ route('CATKingSupport') }}"
                        class="nav-link {{ Route::currentRouteName() == 'CATKingSupport' ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Support</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->
</div>
<!-- /main sidebar -->
