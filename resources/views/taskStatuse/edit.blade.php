@extends('layouts.app')

@section('title', __('interface.editStatus'))

@section('content')
    <main class="container py-4">
        <h2>{{ __('interface.editStatus') }}</h2>
        {{ Form::token() }}
        {{ Form::model($taskStatus, ['url' => "task_statuses/{$taskStatus['id']}", 'method' => 'PATCH']) }}
        {{ Form::label('name', __('interface.name')) }}<font style="color: #e3342f">*</font><br>
        {{ Form::text('name', $taskStatus['name']) }}<br><br>
        {{ Form::submit(__('interface.update'), ['class' => 'btn btn-outline-primary mr-2']) }}<br>
    </main>
@endsection
