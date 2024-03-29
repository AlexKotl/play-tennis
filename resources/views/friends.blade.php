@extends('layouts.app')

@section('site_title')
    Ваші друзі
@endsection

@section('breadcrumbs')
    <a href="">Ваші друзі</a>
@endsection

@section('content')
    <h1>Ваші друзі</h1>

        @if (count($messages) === 0)
            <div class="alert alert-info">
                Тут буде відображатися переписки з іншими користувачами.
            </div>
        @endif

        <div class="friends-list">
            @foreach ($messages as $message)
                <div class="row">
                    <div class="col-4 col-sm-1 justify-content-center align-self-center">
                        <a href="{{ route('player', $message->friend_id) }}">
                            @if ($message->avatar)
                                <div class="background-image circle" style="background-image: url('/storage/avatars/{{ $message->avatar }}')"></div>
                            @else
                                <div class="background-image circle" style="background-image: url('/images/blank-player2.jpg')"></div>
                            @endif
                        </a>
                    </div>
                    <div class="col-8 col-sm-3 justify-content-center align-self-center">
                        <a href="{{ route('player', $message->friend_id) }}">
                            <b>{{ $message->friend_name }}</b>
                        </a>
                    </div>
                    <div class="col-12 col-sm-8 justify-content-center align-self-center @if (!$message->is_read && $message->recipient_id == Auth::id()) font-weight-bold @endif">
                        <a href="{{ route('player', $message->friend_id) }}">
                            <i class="fa fa-comment-o"></i>
                            {{ $message->text }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
@endsection