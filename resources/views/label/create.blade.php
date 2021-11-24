@extends('layouts.app')

@section('title', __('interface.createLabel'))

@section('content')
    <main class="container py-4">
        <h2>{{ __('interface.createLabel') }}</h2>
        {{ Form::token() }}
        {{ Form::model($label, ['url' => route('labels.store'), 'method' => 'POST']) }}
        {{ Form::label('name', __('interface.name')) }}<font style="color: #e3342f">*</font><br>
        {{ Form::text('name') }}<br><br>

        {{ Form::label('description', __('interface.description')) }}<br>
        {{ Form::textarea('description') }}<br><br>

        {{ Form::submit(__('interface.create'), ['class' => 'btn btn-outline-primary mr-2']) }}<br>
    </main>
@endsection
