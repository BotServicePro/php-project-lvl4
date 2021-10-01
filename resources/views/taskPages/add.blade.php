@extends('layouts.app')

@section('title', 'Создать задачу')

{{--@include('flash::message')--}}

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
        <h2>Создать задачу</h2>
        {{ Form::token() }}
        {{ Form::model($task, ['url' => route('tasks.store'), 'method' => 'POST']) }}
        {{ Form::label('name', 'Имя') }}<font style="color: #e3342f">*</font><br>
        {{ Form::text('name') }}<br><br>

        {{ Form::label('description', 'Описание') }}<br>
        {{ Form::textarea('description') }}<br>

        {{ Form::label('status_id', 'Статус') }}<font style="color: #e3342f">*</font><br>
        {{  Form::select('status_id', $taskStatusesList, null, ['placeholder' => '---']) }}<br><br>

        {{ Form::label('assigned_to_id', 'Исполнитель') }}<br>
        {{ Form::select('assigned_to_id', $usersList, null, ['placeholder' => '---']) }}<br><br>

{{--        {{ Form::label('labels', 'Метки') }}<br>--}}
{{--        {{  Form::select('labels', ['label1' => 'метка1', 'label2' => 'метка2']) }}<br><br>--}}

        {{ Form::submit('Создать') }}<br>
    </main>
@endsection
