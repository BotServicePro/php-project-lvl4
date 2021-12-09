@extends('layouts.app')

@section('title', __('interface.editLabel'))

@section('content')
    <main class="container py-4">
        <h2>{{ __('interface.editLabel') }}</h2>
        {{ Form::token() }}
        {{ Form::model($label, ['url' => route('labels.update', $label), 'method' => 'PATCH']) }}


        {{ Form::component('labelName', 'components.form.name', ['name']) }}
        {{ Form::labelName($label->name) }}

        {{ Form::component('labelDescription', 'components.form.description', ['description']) }}
        {{ Form::labelDescription($label->description) }}<br>

        {{ Form::submit(__('interface.update'), ['class' => 'btn btn-outline-primary mr-2']) }}<br>
    </main>
@endsection
