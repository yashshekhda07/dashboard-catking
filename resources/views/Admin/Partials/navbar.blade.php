<div class="navbar navbar-expand-lg navbar-static">
    <div class="container-fluid">
        <div class="d-flex d-lg-none me-2">
            <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
                <i class="ph-list"></i>
            </button>
        </div>

        <div class="navbar-collapse flex-lg-1 order-2 order-lg-1 collapse" id="navbar_search">
            <div class="navbar-search flex-fill dropdown mt-2 mt-lg-0">
                <div class="form-control-feedback form-control-feedback-start flex-grow-1">
                    <input type="text" class="form-control" placeholder="Search" data-bs-toggle="dropdown">
                    <div class="form-control-feedback-icon">
                        <i class="ph-magnifying-glass"></i>
                    </div>
                </div>
            </div>
        </div>

        <ul class="nav hstack gap-sm-1 flex-row justify-content-end order-1 order-lg-2">
            <li class="nav-item d-lg-none">
                <a href="#navbar_search" class="navbar-nav-link navbar-nav-link-icon rounded-pill"
                    data-bs-toggle="collapse">
                    <i class="ph-magnifying-glass"></i>
                </a>
            </li>

            {{--  <li class="nav-item nav-item-dropdown-lg dropdown">
                <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded-pill"
                    data-bs-toggle="dropdown">
                    <i class="ph-squares-four"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-end dropdown-menu-scrollable-sm wmin-lg-600 p-0">
                    <div class="d-flex align-items-center border-bottom p-3">
                        <h6 class="mb-0">Browse apps</h6>
                        <a href="#" class="ms-auto">
                            View all
                            <i class="ph-arrow-circle-right ms-1"></i>
                        </a>
                    </div>

                    <div class="row row-cols-1 row-cols-sm-2 g-0">
                        <div class="col">
                            <button type="button"
                                class="dropdown-item text-wrap h-100 align-items-start border-end-sm border-bottom p-3">
                                <div>
                                    <img src="../../../assets/images/demo/logos/1.svg" class="h-40px mb-2"
                                        alt="">
                                    <div class="fw-semibold my-1">Customer data platform</div>
                                    <div class="text-muted">Unify customer data from multiple sources</div>
                                </div>
                            </button>
                        </div>

                        <div class="col">
                            <button type="button"
                                class="dropdown-item text-wrap h-100 align-items-start border-bottom p-3">
                                <div>
                                    <img src="../../../assets/images/demo/logos/2.svg" class="h-40px mb-2"
                                        alt="">
                                    <div class="fw-semibold my-1">Data catalog</div>
                                    <div class="text-muted">Discover, inventory, and organize data assets</div>
                                </div>
                            </button>
                        </div>

                        <div class="col">
                            <button type="button"
                                class="dropdown-item text-wrap h-100 align-items-start border-end-sm border-bottom border-bottom-sm-0 rounded-bottom-start p-3">
                                <div>
                                    <img src="../../../assets/images/demo/logos/3.svg" class="h-40px mb-2"
                                        alt="">
                                    <div class="fw-semibold my-1">Data governance</div>
                                    <div class="text-muted">The collaboration hub and data marketplace</div>
                                </div>
                            </button>
                        </div>

                        <div class="col">
                            <button type="button"
                                class="dropdown-item text-wrap h-100 align-items-start rounded-bottom-end p-3">
                                <div>
                                    <img src="../../../assets/images/demo/logos/4.svg" class="h-40px mb-2"
                                        alt="">
                                    <div class="fw-semibold my-1">Data privacy</div>
                                    <div class="text-muted">Automated provisioning of non-production datasets</div>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </li>  --}}

            {{--  <li class="nav-item">
                <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded-pill"
                    data-bs-toggle="offcanvas" data-bs-target="#notifications">
                    <i class="ph-bell"></i>
                    <span
                        class="badge bg-yellow text-black position-absolute top-0 end-0 translate-middle-top zindex-1 rounded-pill mt-1 me-1">2</span>
                </a>
            </li>  --}}

            <li class="nav-item nav-item-dropdown-lg dropdown">
                {{--  <a href="#" class="navbar-nav-link align-items-center rounded-pill p-1"
                    data-bs-toggle="dropdown">
                    <div class="status-indicator-container">
                        <img src="../../../assets/images/demo/users/face11.jpg" class="w-32px h-32px rounded-pill"
                            alt="">
                        <span class="status-indicator bg-success"></span>
                    </div>
                    <span class="d-none d-lg-inline-block mx-lg-2">Victoria</span>
                </a>  --}}
                <a href="#" class="navbar-nav-link align-items-center rounded-pill p-1" data-bs-toggle="dropdown">
                    {{-- <img src="{{ asset('assets/images/demo/users/face11.jpg') }}" class="w-32px h-32px rounded-pill"
                        alt=""> --}}
                    <img src="https://ui-avatars.com/api/?background=random&color=random&name={{ auth()->user()->name}}&size=512&rounded=true&format=svg" class="w-32px h-32px rounded-pill"
                        alt="">
                    <span class="d-none d-lg-inline-block mx-lg-2">{{auth()->user()->name}}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-end">
                    {{--  <a href="#" class="dropdown-item">
                        <i class="ph-user-circle me-2"></i>
                        My profile
                    </a>  --}}
                    {{--  <a href="#" class="dropdown-item">
                        <i class="ph-currency-circle-dollar me-2"></i>
                        My subscription
                    </a>  --}}
                    {{--  <a href="#" class="dropdown-item">
                        <i class="ph-shopping-cart me-2"></i>
                        My orders
                    </a>  --}}
                    {{--  <a href="#" class="dropdown-item">
                        <i class="ph-envelope-open me-2"></i>
                        My inbox
                        <span class="badge bg-primary rounded-pill ms-auto">26</span>
                    </a>  --}}
                    {{--  <div class="dropdown-divider"></div>  --}}
                    {{--  <a href="#" class="dropdown-item">
                        <i class="ph-gear me-2"></i>
                        Account settings
                    </a>  --}}
                    <a href="{{ route('logout') }}" class="dropdown-item"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ph-sign-out me-2"></i>
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
</div>
