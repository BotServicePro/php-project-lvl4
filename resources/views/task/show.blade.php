@extends('layouts.app')

@section('title', __('interface.showTask'))

@section('content')
    <main class="container py-4">
        <h2>{{ __('interface.showTask') }}: {{ $task->name }}
            @can('update', $task)
            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary btn-sm bg-danger rounded" role="button">{{ __('interface.edit') }}</a>
            @endcan
        </h2>
        <br>
        <div>
            {{ __('interface.name') }}: {{ $task->name }}
        </div>
        <br>
        <div>
            {{ __('interface.description') }}: {{ $task->description }}
        </div>
        <br>
        <div>
            {{ __('interface.status') }}: {{ $task->status->name }}
        </div>
        <br>
        <div>
            {{ __('interface.labels') }}:
            <ul>
                @foreach($task->label as $label)
                    <li>{{ $label->name }}</li>
                @endforeach
            </ul>
        </div>
    </main>
@endsection
