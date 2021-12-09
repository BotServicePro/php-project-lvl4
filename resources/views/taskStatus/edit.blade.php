@extends('layouts.app')

@section('title', __('interface.editStatus'))

@section('content')
    <main class="container py-4">
        <h2>{{ __('interface.editStatus') }}</h2>
        {{ Form::token() }}
        {{ Form::model($taskStatus, ['url' => route('task_statuses.update', $taskStatus), 'method' => 'PATCH']) }}

        {{ Form::component('labelName', 'components.form.name', ['name']) }}
        {{ Form::labelName($taskStatus->name) }}

        {{ Form::submit(__('interface.update'), ['class' => 'btn btn-outline-primary mr-2']) }}<br>
    </main>
@endsection
