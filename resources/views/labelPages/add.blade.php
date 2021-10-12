@extends('layouts.app')

@section('title', 'Создать метку')

{{--@include('flash::message')--}}

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
        <h2>Создать метку</h2>
        {{ Form::token() }}
        {{ Form::model($label, ['url' => route('labels.store'), 'method' => 'POST']) }}
        {{ Form::label('name', 'Имя') }}<font style="color: #e3342f">*</font><br>
        {{ Form::text('name') }}<br><br>

        {{ Form::label('description', 'Описание') }}<br>
        {{ Form::textarea('description') }}<br><br>

        {{ Form::submit('Создать', ['class' => 'btn btn-outline-primary mr-2']) }}<br>
    </main>
@endsection
