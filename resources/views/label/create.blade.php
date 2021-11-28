@extends('layouts.app')

@section('title', __('interface.createLabel'))

@section('content')
    <main class="container py-4">
        <h2>{{ __('interface.createLabel') }}</h2>
        {{ Form::token() }}
        {{ Form::model($label, ['url' => route('labels.store'), 'method' => 'POST']) }}

        {{ Form::component('labelName', 'components.form.name', ['name']) }}
        {{ Form::labelName('name') }}

        {{ Form::component('labelDescription', 'components.form.description', ['description']) }}
        {{ Form::labelDescription('description') }}<br>

        {{ Form::submit(__('interface.create'), ['class' => 'btn btn-outline-primary mr-2']) }}<br>
    </main>
@endsection
