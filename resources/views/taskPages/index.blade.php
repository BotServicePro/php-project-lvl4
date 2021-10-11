@extends('layouts.app')

@section('title', 'Задачи')

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
        <h2>Задачи</h2>
        <br>
        @if(Auth::check())
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">Создать задачу</a>
        @endif
        <table class="table mt-2">
            <thead>
            <tr>
                <th>ID</th>
                <th>Статус</th>
                <th>Имя</th>
                <th>Автор</th>
                <th>Исполнитель</th>
                <th>Дата создания</th>
                @if(Auth::check())
                    <th>Действия</th>
                @endif
            </tr>
            </thead>

            <tbody>
            @foreach ($data as $task)
                <tr>
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->status_name }}</td>
                    <td><a href="/tasks/{{$task->id }}">{{ $task->name }}</a></td>
                    <td>{{ $task->task_author_name }}</td>
                    <td>{{ $task->executor_name }}</td>
                    <td>{{ $task->created_at }}</td>
                    @if(Auth::check())
                        <td>
                            @if($task->created_by_id === Auth::user()->id)
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" data-confirm="Точно удалить?" rel="nofollow">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-outline-danger" data-confirm="Точно удалить?" rel="nofollow">Delete</button>
                                </form> |
                            @endif
                            <a href="/tasks/{{ $task->id }}/edit">Изменить</a></td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $data->links() }}
    </main>
@endsection
