@extends('layouts.app')

@section('title', __('interface.createStatus'))

{{--@include('flash::message')--}}

{{--@if ($errors->any())--}}
{{--    <div class="alert alert-danger">--}}
{{--        <ul>--}}
{{--            @foreach ($errors->all() as $error)--}}
{{--                <li>{{ $error }}</li>--}}
{{--            @endforeach--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--@endif--}}

@section('content')
    <main class="container py-4">
        <h2>{{ __('interface.createStatus') }}</h2>
        {{ Form::token() }}
        {{ Form::model($taskStatus, ['url' => route('task_statuses.store'), 'method' => 'POST']) }}
        {{ Form::label('name', __('interface.name')) }}<font style="color: #e3342f">*</font><br>
        {{ Form::text('name') }}
        @if ($errors->any())
            <div>
                @foreach ($errors->all() as $error)
                    <b>{{ $error }}</b>
                @endforeach
            </div>
        @endif
        <br>
        <br>
        {{ Form::submit(__('interface.create'), ['class' => 'btn btn-outline-primary mr-2']) }}<br>
    </main>
@endsection

