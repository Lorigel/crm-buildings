    <!-- Begin page -->
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="{{route('dashboard')}}" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{{ asset('images/logo-dark.jpg') }}" alt="" height="50">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('images/logo-dark.jpg') }}" alt="" height="40">
                            </span>
                        </a>
                        <a href="{{route('dashboard')}}" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ asset('images/logo-dark.jpg') }}" alt="" height="50">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('images/logo-dark.jpg') }}" alt="" height="40">
                            </span>
                        </a>
                    </div>
                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                    </button>
                    <!-- App Search-->
                    {{-- <form class="app-search d-none d-lg-block">
                        <div class="position-relative">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="ri-search-line"></span>
                        </div>
                    </form> --}}

                </div>
                <div class="d-flex">
                   



                    {{-- <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-notification-3-line"></i>
                            <span class="noti-dot"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0" aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0"> Notifications </h6>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#!" class="small"> View All</a>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 230px;">
                                <a href="" class="text-reset notification-item">
                                    <div class="media">
                                        <div class="avatar-xs mr-3">
                                            <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                <i class="ri-shopping-cart-line"></i>
                                            </span>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mt-0 mb-1">Your order is placed</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">If several languages coalesce the grammar</p>
                                                <p class="mb-0">
                                                    <i class="mdi mdi-clock-outline"></i> 3 min ago
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="" class="text-reset notification-item">
                                    <div class="media">
                                        <img src="images/users/avatar-3.jpg" class="mr-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="media-body">
                                            <h6 class="mt-0 mb-1">James Lemire</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">It will seem like simplified English.</p>
                                                <p class="mb-0">
                                                    <i class="mdi mdi-clock-outline"></i> 1 hours ago
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="" class="text-reset notification-item">
                                    <div class="media">
                                        <div class="avatar-xs mr-3">
                                            <span class="avatar-title bg-success rounded-circle font-size-16">
                                                <i class="ri-checkbox-circle-line"></i>
                                            </span>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mt-0 mb-1">Your item is shipped</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">If several languages coalesce the grammar</p>
                                                <p class="mb-0">
                                                    <i class="mdi mdi-clock-outline"></i> 3 min ago
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="" class="text-reset notification-item">
                                    <div class="media">
                                        <img src="images/users/avatar-4.jpg" class="mr-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="media-body">
                                            <h6 class="mt-0 mb-1">Salena Layfield</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">As a skeptical Cambridge friend of mine occidental.</p>
                                                <p class="mb-0">
                                                    <i class="mdi mdi-clock-outline"></i> 1 hours ago
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2 border-top">
                                <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="javascript:void(0)">
                                    <i class="mdi mdi-arrow-right-circle mr-1"></i> View More.. </a>
                            </div>
                        </div>
                    </div> --}}
                    <div class="dropdown d-inline-block user-dropdown">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="{{ asset('images/users/avatar-2.jpg') }}" alt="Header Avatar">
                            <span class="d-none d-xl-inline-block ml-1">{{ Auth::user()->name }}</span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <div class="show-mobile-only" style="display:none;">
                                
                                                    <ul class="metismenu list-unstyled" id="mobile-menu">
                                        <li class="menu-title">Menu</li>
                                        <li>
                                            <a href="{{route('dashboard')}}" class="waves-effect">
                                                <i class="ri-dashboard-line"></i>

                                                <span>Pannello</span>
                                            </a>
                                        </li>

                                        @if(Auth::user()->canEditUser())

                                        <li>
                                            <x-nav-link class="waves-effect" :href="route('users')" :active="request()->routeIs('users')"><i class="ri-user-line"></i>
                                                {{ __('Utenti') }}
                                            </x-nav-link>
                                        </li>
                                        @endif


                                        @if(Auth::user()->canEditUser())

                                        <li>
                                            <x-nav-link class="waves-effect" :href="route('user.listing')" :active="request()->routeIs('users')"><i class="ri-stack-line"></i>

                                                {{ __('Organigramma') }}
                                            </x-nav-link>
                                        </li>
                                        @endif

                                        @if((Auth::user())->canAddUser())
                                            <li>
                                                <a stlye="float:right;" href="{{route('user.new')}}"><i class="ri-user-add-line"></i>{{__(' Aggiungi nuovo utente')}}</a>
                                            </li>
                                        @endif

                                        <li>
                                            <x-nav-link :href="route('contract.list')" :active="request()->routeIs('contract.list')"> <i class="ri-file-fill"></i>
                                                {{ __('Pratiche ') }}
                                            </x-nav-link>
                                        </li>
                                            @if(Auth::user()->canCreateContract())
                                        <li>
                                            <x-nav-link :href="route('contract.new')" :active="request()->routeIs('contract.new')"> <i class="ri-file-edit-fill"></i>
                                                {{ __('Nuova pratica') }}
                                            </x-nav-link>
                                        </li>
                                            @endif

                                        

                                    </ul>

                            </div>

                            <x-nav-link class="dropdown-item" :href="route('user.edit')" :active="request()->routeIs('user.edit')"><i class="ri-user-line align-middle mr-1"></i>
                                {{ __('Edit profile') }}
                            </x-nav-link>
                            {{-- <a class="dropdown-item" href="#"><i class="ri-wallet-2-line align-middle mr-1"></i> My Wallet</a>
                            <a class="dropdown-item d-block" href="#"><span class="badge badge-success float-right mt-1">11</span><i class="ri-settings-2-line align-middle mr-1"></i> Settings</a>
                            <a class="dropdown-item" href="#"><i class="ri-lock-unlock-line align-middle mr-1"></i> Lock screen</a> --}}
                            <div class="dropdown-divider"></div>
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">

                                <form method="POST" action="{{ route('logout') }}"> @csrf <button style="margin:0.35rem 1.5rem;" class="btn btn-primary" :href="route('logout')" onclick="event.preventDefault();this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </button>
                                </form>

                            </div>



                            


                        </div>
                    </div>

                </div>
            </div>


    </div>
    </div>
    </header>
    <!-- ========== Left Sidebar Start ========== -->
    <div class="vertical-menu">
        <div data-simplebar class="h-100">
            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title">Menu</li>
                    <li>
                        <a href="{{route('dashboard')}}" class="waves-effect">
                            <i class="ri-dashboard-line"></i>

                            <span>Pannello</span>
                        </a>
                    </li>

                    @if(Auth::user()->canEditUser())

                    <li>
                        <x-nav-link class="waves-effect" :href="route('users')" :active="request()->routeIs('users')"><i class="ri-user-line"></i>
                            {{ __('Utenti') }}
                        </x-nav-link>
                    </li>
                    @endif


                    @if(Auth::user()->canEditUser())

                    <li>
                        <x-nav-link class="waves-effect" :href="route('user.listing')" :active="request()->routeIs('users')"><i class="ri-stack-line"></i>

                            {{ __('Organigramma') }}
                        </x-nav-link>
                    </li>
                    @endif

                    @if((Auth::user())->canAddUser())
                        <li>
                            <a stlye="float:right;" href="{{route('user.new')}}"><i class="ri-user-add-line"></i>{{__('Aggiungi nuovo utente')}}</a>
                        </li>
                    @endif

                    <li>
                        <x-nav-link :href="route('contract.list')" :active="request()->routeIs('contract.list')"> <i class="ri-file-fill"></i>
                            {{ __('Pratiche') }}
                        </x-nav-link>
                    </li>
                        @if(Auth::user()->canCreateContract())
                    <li>
                        <x-nav-link :href="route('contract.new')" :active="request()->routeIs('contract.new')"> <i class="ri-file-edit-fill"></i>
                            {{ __('Nuova pratica') }}
                        </x-nav-link>
                    </li>
                        @endif

                    

                </ul>
            </div>
            <!-- Sidebar -->
        </div>
    </div>
    <!-- Left Sidebar End -->
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                {{$slot}}
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        </footer>
    </div>
    <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->


