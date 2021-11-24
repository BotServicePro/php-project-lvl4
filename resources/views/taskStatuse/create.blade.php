@extends('layouts.app')

@section('title', __('interface.createStatus'))

@section('content')
    <main class="container py-4">
        <h2>{{ __('interface.createStatus') }}</h2>
        {{ Form::token() }}
        {{ Form::model($taskStatus, ['url' => route('task_statuses.store'), 'method' => 'POST']) }}
        {{ Form::label('name', __('interface.name')) }}<font style="color: #e3342f">*</font><br>
        {{ Form::text('name') }}
        <br>
        <br>
        {{ Form::submit(__('interface.create'), ['class' => 'btn btn-outline-primary mr-2']) }}<br>
    </main>
@endsection

