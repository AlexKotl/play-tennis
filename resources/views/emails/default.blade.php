@extends('emails.layout')

@section('content')
    <p>
    Привіт, {{ $user->name }}!
    </p>
    <p>
        Вам нове повідомлення від користувача: {{ $sender->name }}.
    </p>
    <p>
        Прочитати повідомлення: <br>
        {{ route('player', $sender->id) }}
    </p>
@endsection

