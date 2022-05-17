@extends('layouts.app')

@section('site_title')
    Гравці в теніс у Києві
@endsection

@section('breadcrumbs')
    <a href="{% url 'players' %}">Гравці</a>
@endsection

@section('content')
    <h1>Гравці</h1>

    <div class="card mt-3 mb-3">
        <div class="card-body players-filters">
            <form action="" method="get">
                <div class="row">
                    <div class="col-sm-5 text-center">
                        <span class="rank">
                            {{Form::select('rank_from', ['' => 'Рівень від'] + $ranks, app('request')->input('rank_from'), ['class' => 'form-control pull-left'])}}
                            {{Form::select('rank_to', ['' => 'Рівень до'] + $ranks, app('request')->input('rank_to'), ['class' => 'form-control pull-right'])}}
                        </span>
                    </div>
                    <div class="col-sm-4 text-center">
                        {{Form::text('name', app('request')->input('name'), ['class' => 'form-control', 'placeholder' => 'Пошук за імʼям'])}}
                    </div>
                    <div class="col-sm-3 text-center">
                        <button type="submit" class="btn btn-primary ">
                            <i class="fa fa-search"></i> Пошук
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="players-list row">
        @foreach ($players as $player)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('player', $player->id) }}" class="player card">
                    <div class="background-image card-img-top" style="background-image: url('{{ $player->avatar() }}')"></div>

                    <div class="card-body">
                        <h5 class="card-title">{{ $player->name }}</h5>
                        <p class="card-text">
                            @if ($player->rank > 0)
                                <i class="fa fa-trophy" style="margin:0 4px 0 2px"></i>
                                Рівень: <strong>{{ $player->rank }}</strong> <br>
                            @endif
                            @if ($player->courts_count > 0)
                                <i class="fa fa-map-marker" style="margin:0 5px"></i>
                                Корти: <strong>{{ $player->courts_count }}</strong>
                            @endif
                            @if ($player->friends_count > 0)
                                <i class="fa fa-handshake-o"></i>
                                Друзі: <strong>{{ $player->friends_count }}</strong>
                            @endif
                        </p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div class="text-center mt-3">
        {{ $players->onEachSide(1)->links('components/pagination') }}
    </div>

@endsection