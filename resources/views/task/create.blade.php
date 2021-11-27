@extends('layouts.app')

@section('title', __('interface.createTask') )

@section('content')
    <main class="container py-4">
        <h2>{{ __('interface.createTask') }}</h2>
        {{ Form::token() }}
        {{ Form::model($task, ['url' => route('tasks.store'), 'method' => 'POST']) }}
        {{ Form::label('name', __('interface.name')) }}<font style="color: #e3342f">*</font><br>
        {{ Form::text('name') }}<br><br>

        {{ Form::label('description', __('interface.description')) }}<br>
        {{ Form::textarea('description') }}<br>

        {{ Form::label('status_id', __('interface.status')) }}<font style="color: #e3342f">*</font><br>
        {{  Form::select('status_id', $taskStatusesList, null, ['placeholder' => '---']) }}<br><br>

        {{ Form::label('assigned_to_id', __('interface.employee')) }}<br>
        {{ Form::select('assigned_to_id', $usersList, null, ['placeholder' => '---']) }}<br><br>

        {{ Form::label('labels', __('interface.labels')) }}<br>
        <select class="js-example-basic-multiple" name="labels[]" multiple="multiple">
            @foreach ($labels as $label)
                <option value=" {{ $label->id }}">{{ $label->name }}</option>
            @endforeach
        </select>
        <br><br>

        {{ Form::submit(__('interface.create'), ['class' => 'btn btn-outline-primary mr-2']) }}<br>
    </main>
@endsection
