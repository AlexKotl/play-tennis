@extends('layouts.app')

@section('site_title')
    {{ court.name }} - игроки которые играют на теннисном корте
@endsection

@section('breadcrumbs')
    <a href="{% url 'courts' %}">Корты</a>
    <a href="">{{ court.name }}</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-7">
            <h1>{{ court.name }}</h1>

            <b>Адрес</b>: {{ court.address }} <br>
            {% if court.phone %}
                <b>Телефон</b>: {{ court.phone }} <br>
            {% endif %}
            {% if court.url %}
                <b>Сайт</b>: <a href="{{ court.url }}">{{ court.url }}</a> <br>
            {% endif %}
            <b>Игроков на корте</b>: {{ court.players_count }} <br><br>


            {% if court.map_lat != 0 and court.map_lng != 0 %}
                <a class="btn btn-primary d-sm-none" data-toggle="collapse" href="#collapse_map">
                    <i class="fa fa-map"></i> Показать карту
                </a>
                <div id="collapse_map" class="collapse show">
                    <div id="map" class="map" style="width:100%; height:300px"></div>
                </div>

                <script type="text/javascript">
                    var map = L.map('map').setView([{{ court.map_lat }}, {{ court.map_lng }}], 14);
                    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution:'Map data <a target="_blank" href="http://www.openstreetmap.org">OpenStreetMap.org</a> contributors, ' +
                            '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
                        maxZoom: 18,
                    }).addTo(map);
                    marker = L.marker([{{ court.map_lat }}, {{ court.map_lng }}]).addTo(map);

                    $(function() {
                        // hide map for mobile devices
                        if ($(window).width() <= 576) {
                            $('#collapse_map').removeClass('show');
                        }
                    })
                </script>
                <br><br>
            {% endif %}

        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h3>Играют на этом корте:</h3>
                    {% if court.players_count > 0 %}
                        <div class="top-players row">
                            {% for player in players %}
                                <a href="{% url 'player' player.id %}" class="col-4">
                                    <div class="player ">
                                        <div class="background-image circle square" style="background-image: url('{% if player.image != '' %}/media/{{ player.image }}{% else %}{% static 'images/blank-player2.jpg' %}{% endif %}')"></div>
                                        <div class="title">
                                            {{ player.first_name }}
                                        </div>
                                        <div class="description">
                                            Уровень: <b>{% firstof player.rank '-' %}</b>
                                        </div>
                                    </div>
                                </a>
                            {% endfor %}
                        </div>
                    {% else %}
                        <div class="alert alert-info">
                            На этом корте пока никто не играет.
                        </div>
                    {% endif %}
                </div>
            </div>

        </div>
    </div>
@endsection