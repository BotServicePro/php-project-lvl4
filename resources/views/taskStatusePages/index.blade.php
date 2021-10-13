@extends('layouts.app')

@section('title', __('interface.statuses'))

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
        <h2>{{ __('interface.statuses') }}</h2>
        <br>
        @if(Auth::check())
            <a href="{{ route('task_statuses.create') }}" class="btn btn-primary">{{ __('interface.createStatus') }}</a>
        @endif
        <table class="table mt-2">
            <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('interface.name') }}</th>
                <th>{{ __('interface.createDate') }}</th>
                @if(Auth::check())
                    <th>{{ __('interface.settings') }}</th>
                @endif
            </tr>
            </thead>

            <tbody>
            @foreach ($taskStatus as $status)
                <tr>
                    <td>{{ $status->id }}</td>
                    <td>{{ $status->name }}</td>
                    <td>{{ $status->created_at }}</td>
                    @if(Auth::check())
                        <td>
                            <form action="{{ route('task_statuses.destroy', $status->id) }}" method="POST" data-confirm="Точно удалить?" rel="nofollow">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-outline-danger" data-confirm="Точно удалить?" rel="nofollow">{{ __('interface.delete') }}</button>
                            </form>
                            | <a href="/task_statuses/{{ $status->id }}/edit">{{ __('interface.edit') }}</a></td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $taskStatus->links() }}
    </main>
@endsection
