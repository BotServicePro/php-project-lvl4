@extends('layouts.app')

@section('title', __('interface.tasks'))

@section('content')
    <main class="container py-4">
        <h1>{{ __('interface.tasks') }}</h1>
        <br>
        <div class="d-flex">
            <div>
                {!! Form::open(['url' => route('tasks.index'), 'method' => 'get']) !!}
                    {{ Form::select('filter[status_id]', $taskStatusesList, null, ['placeholder' => __('interface.status')]) }}
                    {{ Form::select('filter[created_by_id]', $usersList, null, ['placeholder' => __('interface.author')]) }}
                    {{ Form::select('filter[assigned_to_id]', $usersList, null, ['placeholder' => __('interface.employee')]) }}
                    {{ Form::submit(__('interface.apply'), ['class' => 'btn btn-outline-primary mr-2']) }}
                {!! Form::close() !!}
            </div>
            @can('create', \App\Models\Task::class)
                <a href="{{ route('tasks.create') }}" class="btn btn-primary ml-auto">{{ __('interface.createTask') }}</a>
            @endcan
        </div>
        <br>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('interface.status') }}</th>
                <th>{{ __('interface.name') }}</th>
                <th>{{ __('interface.author') }}</th>
                <th>{{ __('interface.employee') }}</th>
                <th>{{ __('interface.createDate') }}</th>
                @can('create', \App\Models\Task::class)
                    <th>{{ __('interface.settings') }}</th>
                @endcan
            </tr>
            </thead>

            <tbody>
            @foreach ($tasks as $task)
                <tr>
                    <td><b>{{ $task->id }}</b></td>
                    <td>{{ $task->status_name }}</td>
                    <td><a href="{{ route('tasks.show', $task) }}">{{ $task->name }}</a></td>
                    <td>{{ $task->task_author_name }}</td>
                    <td>{{ $task->executor_name }}</td>
                    <td>{{ $task->created_at->format('d.m.Y') }}</td>
                    @can('create', \App\Models\Task::class)
                        <td>
                            @can(['update', 'delete'], $task)
                                <a class="text-danger" href="{{ route('tasks.destroy', $task) }}" data-confirm="{{ __('interface.checkDelete') }}" data-method="delete">
                                    {{ __('interface.delete') }}
                                </a> |
                            @endcan
                            <a href="{{ route('tasks.edit', $task) }}">{{ __('interface.edit') }}</a>
                        </td>
                    @endcan
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $tasks->links() }}
    </main>
@endsection
