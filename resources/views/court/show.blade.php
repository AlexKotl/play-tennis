@extends('layouts.app')

@section('site_title')
    {{ $court->name }} - гравці, які грають на тенісному корті
@endsection

@section('breadcrumbs')
    <a href="{{ route('courts') }}">Корти</a>
    <a href="">{{ $court->name }}</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-7">
            <h1>{{ $court->name }}</h1>

            <b>Адреса</b>: {{ $court->address }} <br>
            @if ($court->phone != '')
                <b>Телефон</b>: {{ $court->phone }} <br>
            @endif
            @if ($court->url != '')
                <b>Сайт</b>: <a href="{{strpos($court->url, 'http') === false ? 'http://' : ''}}{{ $court->url }}">{{ $court->url }}</a> <br>
            @endisset
            <b>Гравців на корті</b>: {{ count($players) }} <br><br>


            @if ($court->map_lat != 0 && $court->map_lng != 0)
                <a class="btn btn-primary d-sm-none" data-toggle="collapse" href="#collapse_map">
                    <i class="fa fa-map"></i> Показати карту
                </a>
                <div id="collapse_map" class="collapse show">
                    <div id="map" class="map" style="width:100%; height:300px"></div>
                </div>

                <script type="text/javascript">
                    var map = L.map('map').setView([{{ $court->map_lat }}, {{ $court->map_lng }}], 14);
                    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution:'Map data <a target="_blank" href="http://www.openstreetmap.org">OpenStreetMap.org</a> contributors, ' +
                            '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
                        maxZoom: 18,
                    }).addTo(map);
                    marker = L.marker([{{ $court->map_lat }}, {{ $court->map_lng }}]).addTo(map);

                    $(function() {
                        // hide map for mobile devices
                        if ($(window).width() <= 576) {
                            $('#collapse_map').removeClass('show');
                        }
                    })
                </script>
                <br>
            @endif

            <hr>
            <h3>Відгуки про корт:</h3>
            @if (count($comments) > 0)
                <div class="messages-list court">
                    @foreach ($comments as $comment)
                        <div class="message">
                            <div class="text">
                                {{ $comment->comment }}
                            </div>
                            <div class="author">
                                <a href="{{ route('player', $comment->user->id) }}">{{ $comment->user->name }}</a>
                            </div>
                            <div class="date">
                                {{ date('d.m.Y', strtotime($comment->created_at)) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @auth
                <form action="{{ route('comment_court', $court->id) }}" method="POST" class="message-form mt-5">
                    @csrf
                    <div class="form-group">
                        <textarea name="comment" cols="40" rows="3" class="form-control" placeholder="Напишіть ваш відгук про корт..." title="" required=""></textarea>
                    </div>
                    <input type="submit" value="Відправити" class="btn btn-primary">
                </form>


            @else
                <div class="alert alert-warning">
                    <a href="{{ route('login') }}">Увійдіть</a>, щоб добавити свій відгук про корт.
                </div>
            @endauth

        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h3>Грають на цьому корті:</h3>
                    @if (count($players) > 0)
                        <div class="top-players row">
                            @foreach ($players as $player)
                                <a href="{{ route('player', $player->id) }}" class="col-4">
                                    <div class="player">
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
                    @else
                        <div class="alert alert-info">
                            На цьому корті поки ніхто не грає.
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection