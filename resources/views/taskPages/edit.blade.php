@extends('layouts.app')

@section('title', __('interface.editTask'))

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
        <h2>{{ __('interface.editTask') }}</h2>
        {{ Form::token() }}
        {{ Form::model($task, ['url' => "tasks/{$task['id']}", 'method' => 'PATCH']) }}
        {{ Form::label('name', __('interface.name')) }}<font style="color: #e3342f">*</font><br>
        {{ Form::text('name', $task['name']) }}<br><br>

        {{ Form::hidden('created_by_id', $task['created_by_id']) }}

        {{ Form::label('description', __('interface.description')) }}<br>
        {{ Form::textarea('description', $task['description']) }}<br><br>

        {{ Form::label('status_id', __('interface.status')) }}<font style="color: #e3342f">*</font><br>
        {{  Form::select('status_id', $taskStatusesList, null, ['placeholder' => '---']) }}<br><br>

        {{ Form::label('assigned_to_id', __('interface.employee')) }}<br>
        {{  Form::select('assigned_to_id', $usersList, null, ['placeholder' => '---']) }}<br><br>

        <script>
            $(document).ready(function() {
                $('.js-example-basic-multiple').select2();
            });
        </script>
        <label>{{ __('interface.labels') }}</label><br>
        <select class="js-example-basic-multiple" name="labels[]" multiple="multiple">
            @foreach ($labels as $label)
                <option value="{{ $label->id }}">{{ $label->name }}</option>
            @endforeach
        </select>
        <br><br>
        {{ Form::submit(__('interface.update'), ['class' => 'btn btn-outline-primary mr-2']) }}<br>
    </main>
@endsection
