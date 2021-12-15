@extends('layouts.app')

@section('title', __('interface.labelLink'))

@section('content')
    <main class="container py-4">
        <h2>{{ __('interface.labels') }}</h2>
        @can('view', $labels->first())
            <a href="{{ route('labels.create') }}" class="btn btn-primary">{{ __('interface.createLabel') }}</a>
            <br>
        @endauth
        <br>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('interface.name') }}</th>
                <th>{{ __('interface.description') }}</th>
                <th>{{ __('interface.createDate') }}</th>
                @can('update', $labels->first())
                    <th>{{ __('interface.settings') }}</th>
                @endauth
            </tr>
            </thead>

            <tbody>
            @foreach ($labels as $label)
                <tr>
                    <td>{{ $label['id'] }}</td>
                    <td>{{ $label['name'] }}</td>
                    <td>{{ $label['description'] }}</td>
                    <td>{{ $label['created_at']->format('d.m.Y') }}</td>
                    @can(['delete', 'update'], $label)
                        <td>
                            <a class="text-danger" href="{{ route('labels.destroy', $label) }}" data-confirm="{{ __('interface.checkDelete') }}" data-method="delete">
                                {{ __('interface.delete') }}
                            </a> |
                            <a href="{{ route('labels.edit', $label) }}">
                                {{ __('interface.edit') }}
                            </a>
                        </td>
                    @endcan
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $labels->links() }}
    </main>
@endsection
