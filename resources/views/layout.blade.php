<!DOCTYPE html>
<!--
Template Name: Midone - HTML Admin Dashboard Template
Author: Left4code
Website: http://www.left4code.com/
Contact: muhammadrizki@left4code.com
Purchase: https://themeforest.net/user/left4code/portfolio
Renew Support: https://themeforest.net/user/left4code/portfolio
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en" class="light">
    <!-- BEGIN: Head -->
    <head>
        <meta charset="utf-8">
        <link href="{{ asset('dist/images/favicon.png')}}" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Midone admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, Midone admin template, dashboard template, flat admin template, responsive admin template, web app">
        <meta name="author" content="LEFT4CODE">
        <title>
            Aplikasi Monitoring Progres Proyek PT. PAL Indonesia (Persero)
        </title>

        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="{{asset('dist/css/app.css')}}" />
        <!-- END: CSS Assets-->
        @yield('css')

    </head>
    <!-- END: Head -->
    <body class="app">
        <!-- BEGIN: Mobile Menu -->
        <div class="mobile-menu md:hidden">
            <div class="mobile-menu-bar">
                <a href="" class="flex mr-auto">
                <img alt="Logo PT. Pal" style="width:7rem;" src="{{ asset('dist/images/logo_pt_pal_putih.png')}}">
                </a>
                <a href="javascript:;" id="mobile-menu-toggler"> <i data-feather="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
            </div>
            <ul class="border-t border-theme-24 py-5 hidden">
                <li>
                    <a href="{{url('/')}}" class="menu menu--active">
                        <div class="menu__icon"> <i data-feather="home"></i> </div>
                        <div class="menu__title"> Dashboard </div>
                    </a>
                </li>
               
                <li>
                    <a href="{{url('/proyek')}}" class="menu menu--active">
                        <div class="menu__icon"> <i data-feather="inbox"></i> </div>
                        <div class="menu__title"> Proyek </div>
                    </a>
                </li>

                <li>
                    <a href="{{url('admin/user')}}" class="menu menu--active">
                        <div class="menu__icon"> <i data-feather="inbox"></i> </div>
                        <div class="menu__title"> User </div>
                    </a>
                </li>

            </ul>
        </div>
        <!-- END: Mobile Menu -->
        <div class="flex">
            <!-- BEGIN: Side Menu -->
            <nav class="side-nav">
                <a href="" class="intro-x flex items-center pl-5 pt-4">
                    <img alt="Logo PT. Pal" style="width:7rem;" src="{{ asset('dist/images/logo_pt_pal_putih.png')}}">
                    <span class="hidden xl:block text-white text-lg ml-3"></span>
                </a>
                <div class="side-nav__devider my-6"></div>
                <ul>
                    <li>
                        <a href="{{url('/')}}" class="side-menu @if(request() -> segment(1) == '' && request()->segment(2) == '') side-menu--active @endif">
                            <div class="side-menu__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home mx-auto"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                            </div>
                            <div class="side-menu__title"> Dashboard </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('/admin/rencana')}}" class="side-menu @if(request() -> segment(1) == 'admin' && request()->segment(2) == 'rencana') side-menu--active @endif">
                            <div class="side-menu__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            </div>
                            <div class="side-menu__title"> Progress Plan </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('/admin/realisasi')}}" class="side-menu @if(request() -> segment(1) == 'admin' && request()->segment(2) == 'realisasi') side-menu--active @endif">
                            <div class="side-menu__icon">
                                <i data-feather="layers"></i>
                            </div>
                            <div class="side-menu__title"> Realisasi </div>
                        </a>
                    </li>

                    <li>
                    
                        <a href="{{ route('user.index') }}" class="side-menu @if(request() -> segment(1) == 'admin' && request()->segment(2) == 'user') side-menu--active @endif">
                            <div class="side-menu__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users mx-auto"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                            </div>
                            <div class="side-menu__title"> User </div>
                        </a>
                    </li>

                </ul>
            </nav>
            <!-- END: Side Menu -->
            <!-- BEGIN: Content -->
            <div class="content">
                <!-- BEGIN: Top Bar -->
                <div class="top-bar">
                    <!-- BEGIN: Breadcrumb -->
                    <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="" class="">Aplikasi Monitoring Progres Proyek</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">
                        @if(request()->segment(2) != '')
                        {{ ucwords(request()->segment(2)) }}
                        @else
                        Dashboard
                        @endif
                        </a> 
                    </div>
                    <!-- END: Breadcrumb -->
                    <!-- BEGIN: Account Menu -->
                    <div class="intro-x dropdown w-8 h-8">
                        <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user mx-auto"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        </div>
                        <div class="dropdown-box w-56">
                            <div class="dropdown-box__content box bg-theme-38 dark:bg-dark-6 text-white">
                                <div class="p-4 border-b border-theme-40 dark:border-dark-3">
                                    <div class="font-medium">{{ Auth::user()->NAMA_LENGKAP }}</div>
                                    <div class="text-xs text-theme-41 dark:text-gray-600">Admin</div>
                                </div>
                                <div class="p-2 border-t border-theme-40 dark:border-dark-3">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md w-full" type="submit"> 
                                            <i data-feather="toggle-right" class="w-4 h-4 mr-2"></i> Logout 
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Account Menu -->
                </div>
                <!-- END: Top Bar -->
                
                @yield('content')
            </div>
            <!-- END: Content -->
        </div>

        <!-- BEGIN: JS Assets-->
        <!-- <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script> -->
        <script src="{{asset('dist/js/app.js')}}"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <!-- END: JS Assets-->

        @yield('script')
    </body>
</html>