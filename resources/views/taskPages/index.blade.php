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



{{--        <div class="d-flex">--}}
{{--            <div>--}}
{{--                <form method="GET" action="https://php-l4-task-manager.herokuapp.com/tasks" accept-charset="UTF-8">--}}
{{--                    <select class="form-control mr-2" name="filter[status_id]">--}}
{{--                        <option value="">Статус</option>--}}
{{--                        <option value="10">kookok</option>--}}
{{--                        <option value="126">status777</option>--}}
{{--                    </select>--}}
{{--                    <select class="form-control mr-2" name="filter[created_by_id]">--}}
{{--                        <option value="">Автор</option>--}}

{{--                        <option value="1">Alex</option><option value="2">feycot</option>--}}
{{--                        <option value="133">Виталий Кудрявцев</option>--}}
{{--                        <option value="135">Иван Князев</option>--}}
{{--                        <option value="134">Виталий Кудрявцев</option>--}}
{{--                    </select>--}}
{{--                    <select class="form-control mr-2" name="filter[assigned_to_id]">--}}
{{--                        <option selected="selected" value="">Исполнитель</option>--}}

{{--                        <option value="1">Alex</option><option value="2">feycot</option>--}}
{{--                        <option value="152">ddf</option><option value="151">Sem</option>--}}
{{--                        <option value="150">testerSuper</option>--}}
{{--                    </select>--}}
{{--                    <input class="btn btn-outline-primary mr-2" type="submit" value="Применить">--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}




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
