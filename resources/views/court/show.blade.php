@extends('layouts.app')

@section('site_title')
    {{ $court->name }} - игроки которые играют на теннисном корте
@endsection

@section('breadcrumbs')
    <a href="{{ route('courts') }}">Корты</a>
    <a href="">{{ $court->name }}</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-7">
            <h1>{{ $court->name }}</h1>

            <b>Адрес</b>: {{ $court->address }} <br>
            @if ($court->phone != '')
                <b>Телефон</b>: {{ $court->phone }} <br>
            @endif
            @if ($court->url != '')
                <b>Сайт</b>: <a href="{{ $court->url }}">{{ $court->url }}</a> <br>
            @endisset
            <b>Игроков на корте</b>: {{ $court->players_count }} <br><br>


            @if ($court->map_lat != 0 && $court->map_lng != 0)
                <a class="btn btn-primary d-sm-none" data-toggle="collapse" href="#collapse_map">
                    <i class="fa fa-map"></i> Показать карту
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
                <br><br>
            @endif

        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h3>Играют на этом корте:</h3>
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
                                            Уровень: <b>{{ $player->rank ?? '-' }}</b>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">
                            На этом корте пока никто не играет.
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection