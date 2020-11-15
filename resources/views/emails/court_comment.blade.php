@extends('emails.layout')

@section('content')
    <p>
    Новый комментарий на корт:
    </p>
    <p>
        {{ $comment }}
    </p>
    <p>
        Прочитать комментарий: <br>
        {{ route('court', $id) }}
    </p>
@endsection

