@extends('layouts.app')

@section('title', 'Метки')

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
        <h2>Метки</h2>
        <br>
        @if(Auth::check())
            <a href="{{ route('labels.create') }}" class="btn btn-primary">Создать метку</a>
        @endif
        <table class="table mt-2">
            <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Описание</th>
                <th>Дата создания</th>
                @if(Auth::check())
                    <th>Действия</th>
                @endif
            </tr>
            </thead>

            <tbody>
            @foreach ($labels as $label)
                <tr>
                    <td>{{ $label['id'] }}</td>
                    <td>{{ $label['name'] }}</td>
                    <td>{{ $label['description'] }}</td>
                    <td>{{ $label['created_at'] }}</td>
                    @if(Auth::check())
                        <td>
                            <form action="{{ route('labels.destroy', $label['id']) }}" method="POST" data-confirm="Точно удалить?" rel="nofollow">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-outline-danger" data-confirm="Точно удалить?" rel="nofollow">Delete</button>
                            </form> |
                            <a href="/labels/{{ $label['id'] }}/edit">Изменить</a></td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $labels->links() }}
    </main>
@endsection
