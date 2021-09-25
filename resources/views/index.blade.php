@extends('layouts.app')

@section('title', 'Main page')

@section('content')
    <main class="container py-4">
        <h1>Main page</h1>
        @if (Auth::check())
            {{ Auth::user()->name }}
        @endif
        <br>
        Разобраться с авторизацией на маршрутах - ГОТОВО - создана политика с соответсвующими правами <br>
        Написать тесты на CRUD статусов<br>
        Разрешить удаление статусов только своих!<br>
    </main>
@endsection
