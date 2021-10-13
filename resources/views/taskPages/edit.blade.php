@extends('layouts.app')

@section('title', 'Редактировать задачу')

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
        <h2>Редактировать задачу</h2>
        {{ Form::token() }}
        {{ Form::model($task, ['url' => "tasks/{$task['id']}", 'method' => 'PATCH']) }}
        {{ Form::label('name', 'Имя') }}<font style="color: #e3342f">*</font><br>
        {{ Form::text('name', $task['name']) }}<br><br>

        {{ Form::hidden('created_by_id', $task['created_by_id']) }}

        {{ Form::label('description', 'Описание') }}<br>
        {{ Form::textarea('description', $task['description']) }}<br><br>

        {{ Form::label('status_id', 'Статус') }}<font style="color: #e3342f">*</font><br>
        {{  Form::select('status_id', $taskStatusesList, null, ['placeholder' => '---']) }}<br><br>


        {{ Form::label('assigned_to_id', 'Исполнитель') }}<br>
        {{  Form::select('assigned_to_id', $usersList, null, ['placeholder' => '---']) }}<br><br>

        <script>
            $(document).ready(function() {
                $('.js-example-basic-multiple').select2();
            });
        </script>
        <select class="js-example-basic-multiple" name="labels[]" multiple="multiple">
            @foreach ($labels as $label)
                <option value="{{ $label->id }}">{{ $label->name }}</option>
            @endforeach
        </select>
        <br><br>
        {{ Form::submit('Обновить', ['class' => 'btn btn-outline-primary mr-2']) }}<br>
    </main>
@endsection
