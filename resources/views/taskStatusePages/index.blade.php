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
                        <td>
                            <form action="{{ route('task_statuses.destroy', $status->id) }}" method="POST" data-confirm="Точно удалить?" rel="nofollow">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-outline-danger" data-confirm="Точно удалить?" rel="nofollow">Delete</button>
                            </form>
                            | <a href="/task_statuses/{{ $status->id }}/edit">Изменить</a></td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $taskStatus->links() }}
    </main>
@endsection
