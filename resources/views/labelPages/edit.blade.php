@extends('layouts.app')

@section('title', 'Изменение метки')

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
        <h2>Изменение метки</h2>
        {{ Form::token() }}
        {{ Form::model($label, ['url' => "labels/{$label['id']}", 'method' => 'PATCH']) }}
        {{ Form::label('name', 'Имя') }}<font style="color: #e3342f">*</font><br>
        {{ Form::text('name', $label['name']) }}<br><br>

        {{ Form::label('description', 'Описание') }}<br>
        {{ Form::textarea('description', $label['description']) }}<br><br>
        {{ Form::submit('Обновить') }}<br>
    </main>
@endsection
