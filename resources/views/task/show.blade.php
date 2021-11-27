@extends('layouts.app')

@section('title', __('interface.showTask'))

@section('content')
    <main class="container py-4">
        <h2>{{ __('interface.showTask') }}: {{ $task->name }}
            @if(Auth::check())
            [<a href="/tasks/{{ $task->id }}/edit"><font style="color: #e3342f">{{ __('interface.edit') }}</font></a>]
            @endif
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
            {{ __('interface.status') }}: {{ $task->getStatusData->name }}
        </div>
        <br>
        <div>
            {{ __('interface.labels') }}:
            <ul>
                @foreach($task->getLabelData as $label)
                    <li>{{ $label->name }}</li>
                @endforeach
            </ul>
        </div>
    </main>
@endsection
