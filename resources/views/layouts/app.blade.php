<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head xmlns:fb="http://ogp.me/ns/fb#">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('site_title')</title>
    <meta name="Language" content="ru"/>
    <meta name="country" content="UA"/>
    <meta property="og:image" content="/images/stuff/handshake.jpg" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/theme.bootstrap_4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <link href="{{ asset('images/favicon.png') }}" rel="shortcut icon" type="image/png">

    <script src="{{ asset('js/app.js') }}"></script>

    {{-- <script src="/js/jquery.slim.min.js"></script>
    <script src="/js/bootstrap.bundle.min.js"></script> --}}
    <script src="{{ asset('js/jquery.tablesorter.min.js') }}" defer></script>
    <script src="{{ asset('js/jquery.mask.min.js') }}" defer></script>
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>

    @yield('scripts')

</head>
<body>
    <div class="top-menu">
        <div class="top-menu-container clearfix">
            <div class="title float-left">
                <a href="/">
                    <img src="/images/tennis-ball.png" alt="">
                    <span>Play</span>
                    <span class='highlight'>Tennis</span>
                </a>
            </div>

            <div class="menu user-block float-right">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-primary">
                        <i class="fa fa-sign-in"></i>
                        Увійти
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        <i class="fa fa-user-plus"></i>
                        Реєстрація
                    </a>

                @else
                    <span class="profile-actions">
                        Привет,
                        <a href='{{ route('profile') }}'>
                            <i class="fa fa-user"></i>
                            {{ Auth::user()->name }}
                        </a>
                    </span>
                    <a href="{{ route('logout') }}"
                        class="btn btn-outline-primary" style="margin-left: 10px"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out"></i>
                        Вийти
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endguest
            </div>

            <div class="menu main-chapters float-right">
                <a href="{{ route('players') }}" class="menu-item">
                    <img src="/images/icons/racket-white.png" class="icon" alt="">
                    Гравці
                </a>
                <a href="{{ route('trainers') }}" class="menu-item">
                    <img src="/images/icons/whistle-white.png" class="icon" alt="">
                    Тренери
                </a>
                <a href="{{ route('courts') }}" class="menu-item">
                    <img src="/images/icons/court-white.png" class="icon" alt="">
                    Корти
                </a>
                <a href="{{ route('friends') }}" class="menu-item" style="margin-right: 30px">
                    <img src="/images/icons/handshake-white.png" class="icon" alt="">
                    Друзі
                    <span class="badge badge-danger">{{ $menu_friends_count ?? '' }}</span>
                </a>
            </div>

        </div>
    </div>

    <div class="breadcrumbs-block">
        <nav class="breadcrumbs clearfix">
            <a href="/" class="">Play Tennis</a>
            @yield('breadcrumbs')
        </nav>
    </div>

    <div class="main-container site-width">
        @include('inc.messages')
        @yield('content')
    </div>

    <div class="site-footer">
        <div class="top-menu-container clearfix text-center justify-content-center align-self-center">
            PlayTennis.com.ua - Пошук партнерів з тенісу в Києві &copy; 2020-{{ date('Y') }}
            <br>Розробка: <a href="https://www.facebook.com/kotl.alex">Олександр Котляров</a>
        </div>
    </div>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-9891041-13"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-9891041-13');
    </script>
</body>
</html>
