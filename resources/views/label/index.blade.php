@extends('layouts.app')

@section('title', __('interface.labelLink'))

@section('content')
    <main class="container py-4">
        <h2>{{ __('interface.labels') }}</h2>
        @if(Auth::check())
            <a href="{{ route('labels.create') }}" class="btn btn-primary">{{ __('interface.createLabel') }}</a>
            <br>
        @endif
        <br>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('interface.name') }}</th>
                <th>{{ __('interface.description') }}</th>
                <th>{{ __('interface.createDate') }}</th>
                @if(Auth::check())
                    <th>{{ __('interface.settings') }}</th>
                @endif
            </tr>
            </thead>

            <tbody>
            @foreach ($labels as $label)
                <tr>
                    <td>{{ $label['id'] }}</td>
                    <td>{{ $label['name'] }}</td>
                    <td>{{ $label['description'] }}</td>
                    <td>{{ $label['created_at']->format('d.m.Y') }}</td>
                    @can('view', $label)
                        <td>
                            <a class="text-danger" href="{{ route('labels.destroy', $label['id']) }}" data-confirm="{{ __('interface.checkDelete') }}" data-method="delete">
                                {{ __('interface.delete') }}
                            </a> |
                            <a href="{{ route('labels.edit', $label['id']) }}">
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
