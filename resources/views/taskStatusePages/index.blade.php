@extends('layouts.app')

@section('title', 'Cтатусы')

@include('flash::message')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@section('content')
    <main class="container py-4">
        <h2>Статусы</h2>
        @if(Auth::check())
            <a href="{{ route('task_statuses.create') }}" class="btn btn-primary">Создать статус</a>
        @endif
        <table class="table mt-2">
            <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Дата создания</th>
                @if(Auth::check())
                    <th>Действия</th>
                @endif
            </tr>
            </thead>

            <tbody>
            @foreach ($taskStatus as $status)
                <tr>
                    <td>{{ $status->id }}</td>
                    <td>{{ $status->name }}</td>
                    <td>{{ $status->created_at }}</td>
                    @if(Auth::check())
                        <td><a href="">Удалить</a> | <a href="/task_statuses/{{ $status->id }}/edit">Изменить</a></td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $taskStatus->links() }}
    </main>
@endsection
