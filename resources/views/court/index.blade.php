@extends('layouts.app')

@section('site_title')
    Теннисные корты Киева - поиск партнера по корту
@endsection

@section('breadcrumbs')
    <a href="">Корты Киева на карте</a>
@endsection

@section('content')

    <h1>Корты</h1>
    <div class="d-none d-sm-block">
        <div id="map" class="map" style="width:100%; height:500px"></div>
    </div>

    <script type="text/javascript">
        var map = L.map('map').setView([50.4425, 30.5133], 12);

        L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution:'Map data <a target="_blank" href="http://www.openstreetmap.org">OpenStreetMap.org</a> contributors, ' +
                '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
            maxZoom: 18,
        }).addTo(map);

        @foreach ($courts as $court)
            @if ($court->map_lat != 0 && $court->map_lng != 0)
                var marker = L.marker([{{ $court->map_lat }}, {{ $court->map_lng }}]).addTo(map);
                marker.bindPopup("<b>{{ $court->name }}</b><br>{{ $court->address }}<br><a href='{{ route('court', $court->id) }}'>Подробнее</a>");
            @endif
        @endforeach

        $(function() {
            $(".courts-list table").tablesorter();
        });
    </script>
    <br><br>

    <div class="courts-list row">
        <table class="tablesorter-bootstrap table table-bordered ">
            <thead class="thead-dark">
                <tr>
                    <th>Корты</th>
                    <th>Адрес</th>
                    <th class="d-none d-sm-table-cell">Телефон</th>
                    <th class="d-none d-sm-table-cell">Игроки</th>
                    <th class="d-none d-sm-table-cell" data-sorter="false"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courts as $court)
                    <tr>
                        <td>
                            <a href="{{ route('court', $court->id) }}">{{ $court->name }}</a>
                        </td>
                        <td>
                            <i class="fa fa-map-marker"></i>
                            {{ $court->address }}
                        </td>
                        <td class="d-none d-sm-table-cell">
                            {{ $court->phone }}
                        </td>
                        <td class="d-none d-sm-table-cell">
                            @if ($court->users_count > 0)
                                <i class="fa fa-users"></i>
                                {{ $court->users_count }}
                            @endif
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <a href="{{ route('court', $court->id) }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-search"></i> Подробнее
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection