@extends('layouts.app')

@section('site_title')
    Play Tennis - {{ $player->name }} - уровень {{ $player->rank }}
@endsection

@section('breadcrumbs')
    <a href="{{ route('players') }}">Игроки</a>
    <a href="">{{ $player->name }}</a>
@endsection

@section('scripts')
    <script src="{% static 'js/jquery.magnific-popup.min.js' %}"></script>
    <link rel="stylesheet" href="{% static 'css/magnific-popup.css' %}">
@endsection

@section('content')
    <script>
        $(document).ready(function() {
            $('.image-gallery').magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                mainClass: 'mfp-img-mobile',
                image: {
                    verticalFit: true
                }
            });
        });
    </script>

    <div class="row">
        <div class="col-xs-12 col-md-7 pb-4">
            <div class="row">
                <div class="col-md-3">
                    @if (false)
                        <a href="/media/{{ player.image }}" class="image-gallery">
                            <div class="background-image circle" style="background-image: url('/media/{{ player.image }}')"></div>
                        </a>
                    @else
                        <div class="background-image circle" style="background-image: url('/images/blank-player2.jpg')"></div>
                    @endif

                </div>
                <div class="col-md-9">
                    <h1>
                        {{ $player->name }}
                        <small class="ml-2">({{ $player->nickname }})</small>
                    </h1>
                    <i class="fa fa-trophy"></i>
                    Уровень: <b>{{ $player->rank }}</b><br>
                    @if ($player->player_since > 0)
                        <i class="fa fa-calendar"></i>
                        Игровой опыт: <b>с {{ $player->player_since }}</b> года <br>
                    @endif
                    @if (false && $player->phone != '')
                        <i class="fa fa-phone"></i>
                        Телефон: <b>{{ $player->phone }}</b> <br>
                    @endif
                </div>
            </div>

            @if ($player->about != '')
                <br><br><b>О себе:</b><br>
                {!! nl2br(e($player->about)) !!}
            @endif

            <br><br>
            <h3>Играет на кортах:</h3>
            @if (count($player_courts) > 0)
                @foreach ($player_courts as $court)
                    <li><a href="{{ route('court', $court->id) }}">{{ $court->name }}</a></li>
                @endforeach
            @else
                <div class="alert alert-primary">
                    Этот игрок не выбрал корты, на которых играет.
                </div>
            @endif

        </div>
        <div class="col-xs-12 col-md-5">
            <div class="card">
                <div class="card-body">
                    <h3>Связаться с игроком</h3>
                    @auth
                        <form action="{{ route('message_player', $player->id) }}" method="POST" class="message-form">
                            @csrf
                            <div class="form-group">
                                <textarea name="text" cols="40" rows="3" class="form-control" placeholder="Введите ваше сообщение..." title="" required=""></textarea>
                            </div>
                            <input type="submit" value="Отправить" class="btn btn-primary">
                        </form>


                    @else
                        <div class="alert alert-warning">
                            <a href="{{ route('login') }}">Войдите</a>, чтобы отправить игроку сообщение.
                        </div>
                    @endauth
                </div>
            </div>

            <div class="messages-list">
                @foreach ($messages as $message)
                    <div class="message @if ($message->author_id == Auth::User()->id) self @endif">
                        <div class="text">
                            {!! nl2br(e($message->text)) !!}
                        </div>
                        <div class="author">
                            {{ $message->author_name }}
                        </div>
                        <div class="date">
                            {{ date('d.m.Y', strtotime($message->created_at)) }}
                            @if ($message->is_read)
                                <i class="fa fa-check text-success" title="Сообщение прочитано"></i>
                            @else
                                <i class="fa fa-clock-o" title="Сообщение не прочитано"></i>
                            @endif

                        </div>
                    </div>
                @endforeach

                {{-- {% if request.GET.all_messages == null and messages.length >= 20 %}
                    ...<br>
                    <a href="?all_messages">Показать все сообщения</a>
                {% endif %} --}}
            </div>

        </div>
    </div>

@endsection