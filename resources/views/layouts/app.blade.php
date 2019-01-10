<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/nhien.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body data-page="{{ \Request::route()->getName() }}">
    <div id="app" >
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto" style="display:none;">
                        <!-- Authentication Links -->
                        @if(!Auth::check())
                            <li><a class="nav-link" href="{{ url('/login') }}">Login</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin'))
                                    <a class="dropdown-item" href="{{ url('/admin') }}">
                                        Quản lý
                                    </a>
                                    @endif
                                    <a class="dropdown-item" href="{{ url('/') }}">
                                        Tài liệu
                                    </a>
                                    <a class="dropdown-item" href="{{ url('/upload-avatar') }}">
                                        Avatar
                                    </a>
                                    <a class="dropdown-item" href="{{ url('/logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        
        <main class="py-4">
            <nav class="role-navigation">
                <ul class="navigation-dboard">
                    <li class="">
                        <a href="/home">
                            <div class="dbmn-icon">
                                <i class="material-icons"> monetization_on </i>
                            </div>
                            <span>Bảng lương</span>
                        </a>
                    </li>
                    
                    <li class="active">
                        <a href="/my-report">
                            <div class="dbmn-icon">
                                <i class="material-icons"> folder_shared </i>
                            </div>
                            <span>Tài liệu</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="/upload-avatar">
                            <div class="dbmn-icon">
                                <i class="material-icons"> settings </i>
                            </div>
                            <span>Tài khoản</span>
                        </a>
                    </li>
                    
                    <li class="">
                        <a href="{{ url('/logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <div class="dbmn-icon">
                                <i class="material-icons"> power_settings_new </i>
                            </div>
                            <span>Đăng xuất</span>
                        </a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                    </li>
                </ul>
            </nav>
            <div class="content-dboard">
                <div class="block-informations">
                    <div class="infos-school">
                        <div class="cover-bg">
                           <img src="/img/holder.jpg" alt="">
                        </div>
                        <div class="logo-center">
                           <img src="/avatar/{{ Auth::user()->id }}" alt="">
                        </div>
                        <div class="infos-center">
                            <h2 class="heading-name">{{ Auth::user()->name }}</h2>
                            <div class="info">
                                <p class="sp-value" data-toggle="tooltip" data-placement="top" title="" data-original-title="Type d'établissement">Phòng {{ Auth::user()->department }}</p>
                        
                                <p class="sp-value" data-toggle="tooltip" data-placement="top" title="" data-original-title="Nom du responsable">Chức vụ <br> -- {{ Auth::user()->roles[0]->label }} --</p>
                            </div>
                        </div>
                    </div>
                   
                </div>
                <div class="bo-main-content">
                @yield('content')
                </div>
            </div>
            
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
