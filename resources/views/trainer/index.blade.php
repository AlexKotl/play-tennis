@extends('layouts.app')

@section('site_title')
    Тренери з тенісу Києва
@endsection

@section('breadcrumbs')
    <a href="{% url 'players' %}">Тренери</a>
@endsection

@section('content')
    <h1>Тренери з тенісу</h1>

    <div class="players-list row">
        @foreach ($trainers as $trainer)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('player', $trainer->id) }}" class="player card">
                    <div class="background-image card-img-top" style="background-image: url('{{ $trainer->avatar() }}')"></div>

                    <div class="card-body">
                        <h5 class="card-title">{{ $trainer->name }}</h5>
                        <p class="card-text">
                            <p>
                                {{ $trainer->about }}
                            </p>
                            @if ($trainer->trainer_price > 0)
                                <i class="fa fa-dollar" style="margin:0 5px"></i>
                                Година заняття: <strong>{{ $trainer->trainer_price }}</strong> грн <br>
                            @endif
                            @if ($trainer->courts_count > 0)
                                <i class="fa fa-map-marker" style="margin:0 5px"></i>
                                Корти: <strong>{{ $trainer->courts_count }}</strong>
                            @endif
                            @if ($trainer->friends_count > 0)
                                <i class="fa fa-handshake-o"></i>
                                Друзі: <strong>{{ $trainer->friends_count }}</strong>
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