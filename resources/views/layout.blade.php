<!DOCTYPE HTML>
<html>
<head xmlns:fb="http://ogp.me/ns/fb#">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>TITLE</title>
    <meta name="Language" content="ru"/>
    <meta name="country" content="UA"/>
    <meta property="og:image" content="/images/stuff/handshake.jpg" />


    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/styles.css">
    <link rel="stylesheet" href="/css/theme.bootstrap_4.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <link rel="shortcut icon" type="image/png" href="/images/favicon.png"/>
    <script src="/js/jquery.slim.min.js"></script>
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/jquery.tablesorter.min.js"></script>
    <script src="js/jquery.mask.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>

    {{ 'block scripts' }}

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
                @if (false)
                    <span class="profile-actions">
                        Привет,
                        <a href='{% url 'profile'>
                            <i class="fa fa-user"></i>
                            {{ user.first_name }}
                        </a>
                    </span>
                    <a href="{% url 'logout" class="btn btn-outline-primary" style="margin-left: 10px">
                        <i class="fa fa-sign-out"></i>
                        Выйти
                    </a>
                @else
                    <a href="{% url 'login" class="btn btn-outline-primary">
                        <i class="fa fa-sign-in"></i>
                        Войти
                    </a>
                    <a href="{% url 'register" class="btn btn-primary">
                        <i class="fa fa-user-plus"></i>
                        Регистрация
                    </a>
                @endif
            </div>

            <div class="menu main-chapters float-right">
                <a href="{% url 'players" class="menu-item">
                    <img src="/images/icons/racket-white.png" class="icon" alt="">
                    Игроки
                </a>
                <a href="{% url 'courts" class="menu-item">
                    <img src="/images/icons/court-white.png" class="icon" alt="">
                    Корты
                </a>
                <a href="{% url 'friends" class="menu-item" style="margin-right: 30px">
                    <img src="/images/icons/handshake-white.png" class="icon" alt="">
                    Друзья
                    <span class="badge badge-danger">{{ 'menu_friends_count' }}</span>
                </a>
            </div>

        </div>
    </div>

    <div class="breadcrumbs-block">
        <nav class="breadcrumbs clearfix">
            <a href="/" class="">Play Tennis</a>
            {% block breadcrumbs %}{% endblock %}
        </nav>
    </div>

    <div class="main-container site-width">
        {% block content %}
            Hello Tennis
        {% endblock %}
    </div>

    <div class="site-footer">
        <div class="top-menu-container clearfix text-center justify-content-center align-self-center">
            PlayTennis.com.ua - Поиск партнеров по теннису в Киеве &copy; {{ date('Y') }}
            <br>Разработка: <a href="https://www.facebook.com/kotl.alex">Александр Котляров</a>
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
