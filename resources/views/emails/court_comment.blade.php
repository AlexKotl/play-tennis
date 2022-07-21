@extends('emails.layout')

@section('content')
    <p>
    Новий коментар на корт:
    </p>
    <p>
        {{ $comment }}
    </p>
    <p>
        Прочитати коментар: <br>
        {{ route('court', $id) }}
    </p>
@endsection

