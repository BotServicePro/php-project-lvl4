@extends('layouts.app')

@section('title', 'Просмотр задачи')

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
        <h2>Просмотр задачи: {{ $taskData->name }}
            @if(Auth::check())
            [<a href="/tasks/{{ $taskData->id }}/edit"><font style="color: #e3342f">Редактировать</font></a>]
            @endif
        </h2>
        <br>
        <div>
            Имя: {{ $taskData->name }}
        </div>
        <br>
        <div>
            Описание: {{ $taskData->description }}
        </div>
        <br>
        <div>
            Статус: {{ $statusData->name }}
        </div>
        <br>
        <div>
            Метки:
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
