@extends('layouts.app')

@section('title', 'Редактировать статус')

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
        <h2>Редактировать статус</h2>
        {{ Form::token() }}
        {{ Form::model($taskStatus, ['url' => "task_statuses/{$taskStatus['id']}", 'method' => 'PATCH']) }}
        {{ Form::label('name', 'Имя') }}<br>
        {{ Form::text('name', $taskStatus['name']) }}<br><br>
        {{ Form::submit('Обновить') }}<br>
    </main>
@endsection
