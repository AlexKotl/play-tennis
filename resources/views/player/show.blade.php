@extends('layouts.app')

@section('site_title')
    Play Tennis - {{ $player->name }} - рівень {{ $player->rank }}
@endsection

@section('breadcrumbs')
    <a href="{{ route('players') }}">Гравці</a>
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
                <div class="col-md-3 col-5">
                    @if ($player->avatar_image)
                        <a href="{{ $player->avatar() }}" class="image-gallery" target="_blank" data-toggle="modal" data-target="#playerPicture">
                            <div class="background-image circle avatar" style="background-image: url('{{ $player->avatar() }}')"></div>
                        </a>
                    @else
                        <div class="background-image circle avatar" style="background-image: url('/images/blank-player2.jpg')"></div>
                    @endif

                </div>
                <div class="col-md-9 col-7">
                    <h1>
                        {{ $player->name }}
                        <small class="ml-2">({{ $player->nickname }})</small>
                    </h1>
                    <i class="fa fa-trophy"></i>
                    Рівень: <b>{{ $player->rank }}</b><br>
                    @if ($player->player_since > 0)
                        <i class="fa fa-calendar"></i>
                        Досвід гри: <b>з {{ $player->player_since }}</b> року <br>
                    @endif
                    @if ($player->phone != '')
                        <i class="fa fa-phone"></i>
                        Телефон:
                        @if ($show_phone)
                            <b><a href='tel:{{ $player->phone }}' class="text-dark">{{ $player->phone }}</a></b>
                        @else
                            <small title="Напишіть користувачу повідомлення і після відповіді на нього телефон буде відображатися."><i>прихований</i> </small>
                        @endif
                        <br>
                    @endif

                    <a class="btn btn-primary mt-3 d-inline-block d-sm-inline-block d-md-none" data-toggle="collapse" href="#user-info" role="button" aria-expanded="false">
                        Більше інформації про гравця
                        <i class="fa fa-chevron-down"></i>
                    </a>
                </div>
            </div>



            <div class="collapse multi-collapse d-md-block" id="user-info">
                @if ($player->about != '')
                    <br><br><b>Про себе:</b><br>
                    <div class="card card-body">
                        {!! nl2br(e($player->about)) !!}
                    </div>
                @endif

                <br><br>
                <h3>Грає на кортах:</h3>
                @if (count($player_courts) > 0)
                    @foreach ($player_courts as $court)
                        <li><a href="{{ route('court', $court->id) }}">{{ $court->name }}</a></li>
                    @endforeach
                @else
                    <div class="alert alert-primary">
                        Цей гравець не вибрав корти, на яких грає.
                    </div>
                @endif
            </div>


            <div class="more-info">

            </div>


        </div>
        <div class="col-xs-12 col-md-5">
            <div class="card">
                <div class="card-body">
                    <h3>Звʼязатися з гравцем</h3>
                    @auth
                        <form action="{{ route('message_player', $player->id) }}" method="POST" class="message-form">
                            @csrf
                            <div class="form-group">
                                <textarea name="text" cols="40" rows="3" class="form-control" placeholder="Ваше повідомлення..." title="" required=""></textarea>
                            </div>
                            <div class="d-flex">
                            <input type="submit" value="Відправити" class="btn btn-primary">
                            @if ($show_phone_warning)
                                <small class="pl-3">
                                    Після вашої відповіді цей користувач зможе <b>бачити ваш номер телефону</b>.
                                </small>
                            @endif
                            </div>
                        </form>


                    @else
                        <div class="alert alert-warning">
                            <a href="{{ route('login') }}">Увійдіть</a>, щоб відправити гравцю повідомлення.
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
                                <i class="fa fa-check text-success" title="Повідомлення прочитане"></i>
                            @else
                                <i class="fa fa-clock-o" title="Повідомлення не прочитане"></i>
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

    <div class="modal fade" id="playerPicture" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="{{ $player->avatar() }}" alt="" data-dismiss="modal" style="max-width: 100%">
                </div>
            </div>
        </div>
    </div>

@endsection
