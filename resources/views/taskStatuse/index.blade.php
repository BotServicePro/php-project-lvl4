@extends('layouts.app')

@section('title', __('interface.statuses'))

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
        @if(Auth::check())
            <a href="{{ route('task_statuses.create') }}" class="btn btn-primary">{{ __('interface.createStatus') }}</a>
            <br>
        @endif
        <br>
        <table class="table table-bordered border-radius">
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
                    <td><b>{{ $status->id }}</b></td>
                    <td>{{ $status->name }}</td>
                    <td>{{ $status->created_at->format('d.m.Y') }}</td>
                    @auth
                        <td>
                            <a class="text-danger" href="{{ route('task_statuses.destroy', $status) }}" data-confirm="{{ __('interface.checkDelete') }}" data-method="delete">
                                {{ __('interface.delete') }}
                            </a> |
                            <a href="{{ route('task_statuses.edit', $status) }}">
                                {{ __('interface.edit') }}
                            </a>
                        </td>
                    @endauth
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $taskStatus->links() }}
    </main>
@endsection
