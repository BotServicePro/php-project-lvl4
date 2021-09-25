@extends('layouts.app')

@section('title', 'Создать статус')

@include('flash::message')

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
        <h2>Создать статус</h2>
        {{ Form::token() }}
        {{ Form::model($taskStatus, ['url' => route('task_statuses.store'), 'method' => 'POST']) }}
        {{ Form::label('name', 'Имя') }}<br>
        {{ Form::text('name') }}<br><br>
        {{ Form::submit('Создать') }}<br>
    </main>
@endsection
