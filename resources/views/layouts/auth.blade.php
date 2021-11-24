<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-param" content="_token">
    <title>{{ __('interface.siteName') }} - @yield('title')</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    {{--Специально для библиотеки select2--}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body class="min-vh-100 d-flex flex-column">
<header class="flex-shrink-0">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow p-3">
        <div class="container">
            <a class="navbar-brand" href="{{ route('index') }}">{{ __('interface.siteName') }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('tasks.index') }}">{{ __('interface.tasks') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('task_statuses.index') }}">{{ __('interface.statuses') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('labels.index') }}">{{ __('interface.labels') }}</a>
                    </li>
                </ul>

                @if (Auth::check())
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre="">
                                {{ Auth::user()->name }}<span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">{{ __('interface.logout') }}</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </form>
                            </div>
                        </li>
                    </ul>
                @elseif(!Auth::check())
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('interface.login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('interface.register') }}</a>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    </nav>
</header>

<center>
<div class="py-12 col-md-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 col-md-8">
        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg col-md-8">
            <div class="p-6 bg-white border-gray-200">
                @include('flash::message')
                @if ($errors->any())
                    <div class="container">
                        <div style="Color: red">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                @yield('content')
            </div>
        </div>
    </div>
</div>
</center>


<div class="wrapper flex-grow-1"></div>
<footer class="py-3 mt-5 shadow-lg">
    <div class="text-center container-lg">
        <a href="https://ru.hexlet.io/u/karakinalex" target="_blank">{{ 'AKarakin - ' . date('Y') }}</a>
    </div>
</footer>

</body>
</html>
