@extends('layouts.app')

@section('title', __('interface.editLabel'))

@section('content')
    <main class="container py-4">
        <h2>{{ __('interface.editLabel') }}</h2>
        {{ Form::token() }}
        {{ Form::model($label, ['url' => "labels/{$label['id']}", 'method' => 'PATCH']) }}
        {{ Form::label('name', __('interface.name')) }}<font style="color: #e3342f">*</font><br>
        {{ Form::text('name', $label['name']) }}<br><br>

        {{ Form::label('description', __('interface.description')) }}<br>
        {{ Form::textarea('description', $label['description']) }}<br><br>
        {{ Form::submit(__('interface.update'), ['class' => 'btn btn-outline-primary mr-2']) }}<br>
    </main>
@endsection
