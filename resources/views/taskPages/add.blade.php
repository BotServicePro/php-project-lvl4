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

        <script>
            $(document).ready(function() {
                $('.js-example-basic-multiple').select2();
            });
        </script>
        {{ Form::label('labels', 'Метка') }}<br>
        <select class="js-example-basic-multiple" name="labels[]" multiple="multiple">
            @foreach ($labels as $label)
                <option value=" {{ $label->id }}">{{ $label->name }}</option>
            @endforeach
        </select>
        <br><br>

        {{ Form::submit('Создать') }}<br>
    </main>
@endsection
