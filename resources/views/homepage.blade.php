@extends('layouts.app')

@section('site_title')
    Play Tennis - пошук партнерів з тенісу у Києві
@endsection

@section('content')
    <style>
        .breadcrumbs-block {
            display: none;
        }
    </style>

    <div class="row home-page">
        <div class="col-md-7">
            <h2>Пошук партнерів з тенісу</h2>
            <p>Шукаєте з ким пограти у Києві? Наш сервіс допоможе знайти партнера з тенісу на вашому улюбленому корті.</p>
            <div class="row">
                <div class="col-sm-3 col-6 d-none d-sm-block">
                    <a href="{{ route('courts') }}">
                        <div class="background-image circle" style="background-image: url('/images/blank-court.jpg')"></div>
                    </a>
                </div>
                <div class="col-sm-9 justify-content-center align-self-center">
                    У розділі <a href="{{ route('courts') }}">кортів</a> можна знайти найближчий корт <b>на карті</b> та переглянути гравців, які на ньому грають.
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-9 justify-content-center align-self-center">
                    Також можете перейти до розділу <a href="{{ route('players') }}">гравців</a> та знайти партнера за рівнем гри.
                </div>
                <div class="col-sm-3 col-6 d-none d-sm-block">
                    <a href="{{ route('players') }}">
                        <div class="background-image circle" style="background-image: url('images/player-girl.jpg')"></div>
                    </a>
                </div>
            </div>
            <p></p>

            @guest
                <br/><br/>
                <div class="text-center">
                    Щоб отримати доступ до всіх функцій на сайті -
                    <p>
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            <i class="fa fa-user-plus"></i>
                            Зареєструйтесь
                        </a>
                        або
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            <i class="fa fa-sign-in"></i>
                            Увійдіть
                        </a>
                    </p>

                </div>
                <br><br>
            @endguest
        </div>
        <div class="col-md-5">
            {{--
            <!-- Game Requests -->
            <div class="card mb-4">
                <div class="card-body">
                    <h3>Запросы на игру</h3>
                    <div class="requests-list mb-2">
                        {% if requests.count == 0 %}
                            Если вы ищете партнера на определенную дату или у вас уже забронирован корт - добавьте запрос чтоб вас нашли другие игроки.
                        {% endif %}

                        {% for req in requests %}
                            <div class="request clearfix mb-1 mt-1 pb-1 pt-1 row">
                                <div class="col-3 text-center">
                                    <a href="{% url 'player' req.user.id %}">
                                        <div class="background-image circle square" style="background-image: url('{% if req.user.image != '' %}/media/{{ req.user.image }}{% else %}{% static 'images/blank-player2.jpg' %}{% endif %}')"></div>
                                    </a>
                                    <b>{{ req.user.first_name }}</b> <br>
                                    {% if req.user.rank > 0 %}
                                        <i class="fa fa-trophy"></i> {{req.user.rank}}
                                    {% endif %}
                                </div>
                                <div class="col-9">
                                    <div class="header mb-2">


                                        <b><i class="fa fa-calendar"></i> {{ req.date | date:"d/m" }}</b>

                                    </div>
                                    <div class="details">
                                        {{ req.details }}
                                    </div>
                                    {% if req.courts.count > 0 %}
                                    <div class="courts font-weight-bold">
                                        <i class="fa fa-map-marker"></i>
                                        {% for court in req.courts.all %}
                                            {{ court.name }}{% if req.courts.count > 1 %},{% endif %}
                                        {% endfor %}
                                    </div>
                                    {% endif %}

                                    {% if req.user.id == request.user.id %}
                                        <a href="{% url 'delete_request' req.id %}" onclick="return confirm('Удалить ваш запрос?')" class="text-danger">
                                            <i class="fa fa-remove"></i> Удалить запрос
                                        </a>
                                    {% else %}
                                        <a href="{% url 'player' req.user.id %}">
                                            <i class="fa fa-comment-o"></i> Связаться
                                        </a>
                                    {% endif %}
                                </div>


                            </div>
                        {% endfor %}
                    </div>

                    <div class="text-center">
                        <a href="{% url 'add_request' %}" class="btn btn-success">
                            <i class="fa fa-plus"></i>
                            Добавить запрос на игру
                        </a>
                    </div>

                </div>
            </div> --}}

            <div class="card">
                <div class="card-body">
                    <div class="top-players row">
                        @foreach ($players as $player)
                            <a href="{{ route('player', $player->id) }}" class="col-4">
                                <div class="player ">
                                    <div class="background-image circle square" style="background-image: url('{{ $player->avatar() }}')"></div>
                                    <div class="title">
                                        {{ $player->name }}
                                    </div>
                                    <div class="description">
                                        Рівень: <b>{{ $player->rank ?? '-' }}</b>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="text-center">
                        <br>
                        <a href="{{ route('players') }}">Переглянути інших гравців</a>
                    </div>
                </div>

            </div>

        </div>
    </div>

@endsection