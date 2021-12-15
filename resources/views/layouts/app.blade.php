<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-param" content="_token">
    <title>{{ __('interface.siteName') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .resizable-content {
            min-height: 50px;
            min-width: 50px;
            resize: both;
        }
    </style>
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
<div class="container py-3 mt-5 shadow-lg rounded">
    <div class="container">
        <div class="row justify-content-center">
    @include('flash::message')
    @if ($errors->any())
        <div class="container align-content-center">
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        </div>

    @endif
    @yield('content')
    </div>
    </div>
</div>

<div class="wrapper flex-grow-1"></div>
<footer class="py-3 mt-5 shadow-lg">
    <div class="text-center container-lg">
        <a href="https://ru.hexlet.io/u/karakinalex" target="_blank">AKarakin</a>
        <br>
        2021 - {{ date('Y') }}
    </div>
</footer>

</body>
</html>
