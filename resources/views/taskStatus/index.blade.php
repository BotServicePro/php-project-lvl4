@extends('layouts.app')

@section('title', __('interface.statuses'))

@section('content')
    <main class="container py-4">
        <h2>{{ __('interface.statuses') }}</h2>
        @auth
            <a href="{{ route('task_statuses.create') }}" class="btn btn-primary">{{ __('interface.createStatus') }}</a>
            <br>
        @endauth
        <br>
        <table class="table table-bordered border-radius">
            <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('interface.name') }}</th>
                <th>{{ __('interface.createDate') }}</th>
                @auth
                    <th>{{ __('interface.settings') }}</th>
                @endauth
            </tr>
            </thead>

            <tbody>
            @foreach ($taskStatus as $status)
                <tr>
                    <td><b>{{ $status->id }}</b></td>
                    <td>{{ $status->name }}</td>
                    <td>{{ $status->created_at->format('d.m.Y') }}</td>
                    @can('view', $status)
                        <td>
                            <a class="text-danger" href="{{ route('task_statuses.destroy', $status) }}" data-confirm="{{ __('interface.checkDelete') }}" data-method="delete">
                                {{ __('interface.delete') }}
                            </a> |
                            <a href="{{ route('task_statuses.edit', $status) }}">
                                {{ __('interface.edit') }}
                            </a>
                        </td>
                    @endcan
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $taskStatus->links() }}
    </main>
@endsection
