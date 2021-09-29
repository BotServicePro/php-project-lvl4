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
{{--            @foreach ($tasks as $tasks)--}}
{{--                <tr>--}}
{{--                    <td>{{ $tasks->id }}</td>--}}
{{--                    <td>{{ $tasks->name }}</td>--}}
{{--                    <td>{{ $tasks->created_at }}</td>--}}
{{--                    @if(Auth::check())--}}
{{--                        <td>--}}
{{--                            <form action="{{ route('task_statuses.destroy', $tasks->id) }}" method="POST" data-confirm="Точно удалить?" rel="nofollow">--}}
{{--                                @csrf--}}
{{--                                @method('delete')--}}
{{--                                <button type="submit" class="btn btn-outline-danger" data-confirm="Точно удалить?" rel="nofollow">Delete</button>--}}
{{--                            </form>--}}
{{--                            | <a href="/task_statuses/{{ $tasks->id }}/edit">Изменить</a></td>--}}
{{--                    @endif--}}
{{--                </tr>--}}
{{--            @endforeach--}}
            </tbody>
        </table>
{{--        {{ $taskStatus->links() }}--}}
    </main>
@endsection
