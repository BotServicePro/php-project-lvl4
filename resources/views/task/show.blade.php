@extends('layouts.app')

@section('title', __('interface.showTask'))

@section('content')
    <main class="container py-4">
        <h2>{{ __('interface.showTask') }}: {{ $task->name }}
            @auth
            <a href="{{ route('tasks.edit', ['task' => $task->id]) }}" class="btn btn-primary btn-sm bg-danger rounded" role="button">{{ __('interface.edit') }}</a>
            @endauth
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
            {{ __('interface.status') }}: {{ $task->getStatus->name }}
        </div>
        <br>
        <div>
            {{ __('interface.labels') }}:
            <ul>
                @foreach($task->getLabel as $label)
                    <li>{{ $label->name }}</li>
                @endforeach
            </ul>
        </div>
    </main>
@endsection
