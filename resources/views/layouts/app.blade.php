<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Rotaract Club de Tupi Paulista">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">{{ __('Home') }}</a>
                        </li> --}}
                        @if (auth()->check())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('atleta') }}">{{ __('Meu Painel') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('atleta.atvidades') }}">{{ __('Minhas Atividades') }}</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('regulamento') }}">{{ __('Regulamento') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('inscricoes') }}">{{ __('Inscrições') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contato') }}">{{ __('Contato') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            @yield('content')
        </div>
        <div id="loading" class="d-none">
            <i class="fa fa-refresh fa-spin" aria-hidden="true"></i>
        </div>
        <notifications position="bottom center"></notifications>
    </div>
    @stack('scripts')
</body>

</html>
