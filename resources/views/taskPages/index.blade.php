@extends('layouts.app')

@section('title', __('interface.tasks'))

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
        <h2>{{ __('interface.tasks') }}</h2>
        <br>
        <div class="d-flex">
            <div>
                <form method="GET" action="{{ route('tasks.index') }}" accept-charset="UTF-8">
                    <select class="mr-2" name="filter[status_id]">
                        <option value="">{{ __('interface.status') }}</option>
                        @foreach($taskStatusesList as $status)
                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                        @endforeach
                    </select>
                    <select name="filter[created_by_id]">
                        <option value="">{{ __('interface.author') }}</option>
                        @foreach($usersList as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <select  name="filter[assigned_to_id]">
                        <option selected="selected" value="">{{ __('interface.employee') }}</option>
                        @foreach($usersList as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <input class="btn btn-outline-primary mr-2" type="submit" value="{{ __('interface.apply') }}">
                </form>
            </div>
            @if(Auth::check())
                <a href="{{ route('tasks.create') }}" class="btn btn-primary ml-auto">{{ __('interface.createTask') }}</a>
            @endif
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
                @if(Auth::check())
                    <th>{{ __('interface.settings') }}</th>
                @endif
            </tr>
            </thead>

            <tbody>
            @foreach ($data as $task)
                <tr>
                    <td><b>{{ $task->id }}</b></td>
                    <td>{{ $task->status_name }}</td>
                    <td><a href="{{ route('tasks.show', ['task' => $task->id]) }}">{{ $task->name }}</a></td>
                    <td>{{ $task->task_author_name }}</td>
                    <td>{{ $task->executor_name }}</td>
                    <td>{{ $task->created_at }}</td>
                    @if(Auth::check())
                        <td>
                            @if($task->created_by_id === Auth::user()->id)
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" data-confirm="{{ __('interface.checkDelete') }}" rel="nofollow" style="display: inline;">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="text-danger" rel="nofollow">{{ __('interface.delete') }}</button>
                                </form> |
                            @endif
                            <a href="{{ route('tasks.edit', ['task' => $task->id]) }}">{{ __('interface.edit') }}</a>
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $data->links() }}
    </main>
@endsection
