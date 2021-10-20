@extends('layouts.app')

@section('title', __('interface.showTask'))

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
        <h2>{{ __('interface.showTask') }}: {{ $taskData->name }}
            @if(Auth::check())
            [<a href="/tasks/{{ $taskData->id }}/edit"><font style="color: #e3342f">{{ __('interface.edit') }}</font></a>]
            @endif
        </h2>
        <br>
        <div>
            {{ __('interface.name') }}: {{ $taskData->name }}
        </div>
        <br>
        <div>
            {{ __('interface.description') }}: {{ $taskData->description }}
        </div>
        <br>
        <div>
            {{ __('interface.status') }}: {{ $statusData->name }}
        </div>
        <br>
        <div>
            {{ __('interface.labels') }}:
            <ul>
                @foreach($labelsData as $label)
                    <li>{{ $label->label_name }}</li>
                @endforeach
{{--            @foreach($labelsData as $label)--}}
{{--                <li>{{ dump($label->getLabelName) }}</li>--}}
{{--            @endforeach--}}
            </ul>
        </div>
    </main>
@endsection
