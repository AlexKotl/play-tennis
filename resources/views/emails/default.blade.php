@extends('emails.layout')

@section('content')
    <p>
    Привет, {{ $user->name }}!
    </p>
    <p>
        Вам новое сообщение от пользователя: {{ $sender->name }}.
    </p>
    <p>
        Прочитать сообщение: <br>
        {{ route('player', $sender->id) }}
    </p>
@endsection

