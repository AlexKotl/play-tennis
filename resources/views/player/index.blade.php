@extends('layouts.app')

@section('site_title')
    Игроки в теннис в Киеве
@endsection

@section('breadcrumbs')
    <a href="{% url 'players' %}">Игроки</a>
@endsection

@section('content')
    <h1>Игроки</h1>

    {{-- <div class="card mt-3 mb-3">
        <div class="card-body players-filters">
            <form action="" method="get">
                <div class="row">
                    <div class="col-sm-5 text-center">
                        <span class="rank">
                            {% render_field filter.form.rank__gt class="form-control pull-left" %}
                            {% render_field filter.form.rank__lt class="form-control pull-right" %}
                        </span>
                    </div>
                    <div class="col-sm-4 text-center">
                        {% render_field filter.form.first_name class="form-control" placeholder="Поиск по имени" %}
                    </div>
                    <div class="col-sm-3 text-center">
                        <button type="submit" class="btn btn-primary ">
                            <i class="fa fa-search"></i> Поиск
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}

    <div class="players-list row">
        @foreach ($players as $player)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('player', $player->id) }}" class="player card">

                    <div class="background-image card-img-top" style="background-image: url('images/blank-player2.jpg')"></div>

                    <div class="card-body">
                        <h5 class="card-title">{{ $player->name }}</h5>
                        <p class="card-text">
                            @if ($player->rank > 0)
                                <i class="fa fa-trophy"></i>
                                Уровень: <strong>{{ $player->rank }}</strong> <br>
                            @endif
                            @if ($player->courts_count > 0)
                                <i class="fa fa-map-marker" style="margin:0 2px"></i>
                                Корты: <strong>{{ $player->courts_count }}</strong>
                            @endif
                        </p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    {{-- <div class="pagination mt-4">
        <span class="step-links">
            {% if players.has_previous %}
                <a href="?rank__gt={{ request.GET.rank__gt }}&rank__lt={{ request.GET.rank__lt }}&first_name={{ request.GET.first_name }}&page={{ players.previous_page_number }}" class="btn btn-light font-weight-bold mr-2">&laquo; Назад</a>
            {% endif %}

            {% if players.has_next %}
                <a href="?rank__gt={{ request.GET.rank__gt }}&rank__lt={{ request.GET.rank__lt }}&first_name={{ request.GET.first_name }}&page={{ players.next_page_number }}" class="btn btn-light font-weight-bold">Вперед &raquo;</a>
            {% endif %}

            {% if players.has_next or players.has_previous %}
            <small class="current ml-3">
                Страница {{ players.number }} из {{ players.paginator.num_pages }}
            </small>
            {% endif %}
        </span>
    </div> --}}

@endsection