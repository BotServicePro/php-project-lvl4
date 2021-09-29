@extends('layouts.app')

@section('title', 'Main page')

@section('content')
    <main class="container py-4">
        <h1>Main page</h1>
        @if (Auth::check())
            {{ Auth::user()->name }}
        @endif
        <br>
        <h4><b>Тестовые данные:</b> login - alex@mail.ru, password - test</h4>
        Разобраться с авторизацией на маршрутах - ГОТОВО - создана политика с соответсвующими правами <br>
        Написать тесты на CRUD статусов - ГОТОВО<br>
        Добавить флэш сообщения - ГОТОВО<br>
        Добавить флэш сообщения в lang файлы - ГОТОВО<br>
        Добавить Сидеры - ГОТОВО<br>
        ДОБАВИТЬ CRUD статусов - ГОТОВО<br>
        Разрешить удаление статусов только своих!<br>
    </main>
@endsection
