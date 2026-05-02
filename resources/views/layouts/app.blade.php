<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Inter', sans-serif !important;
        background-color: #ffffff;
        color: #000000;
    }

    /* Черный навбар */
    .navbar-vds {
        background-color: #000000 !important;
        height: 70px;
        border-bottom: 1px solid #333;
    }

    /* Центрирование логотипа */
    .navbar-center {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        align-items: center;
    }

    .navbar-brand-text {
        color: #ffffff !important;
        font-weight: 800;
        margin-left: 15px;
        letter-spacing: -0.5px; /* Для Inter лучше чуть уменьшить трекинг в заголовках */
        text-transform: uppercase;
        font-size: 1.2rem;
    }

    /* Кнопки: строго черные */
    .btn {
        border-radius: 0 !important;
        text-transform: uppercase;
        font-weight: 600;
        font-size: 12px;
    }

    .btn-primary {
        background-color: #000000 !important;
        border-color: #000000 !important;
        color: #ffffff !important;
    }

    .btn-primary:hover {
        background-color: #333333 !important;
        border-color: #333333 !important;
    }

    .card, .form-control, .list-group-item {
        border-radius: 0 !important;
        border: 1px solid #000;
    }
</style>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="{{ asset('js/dx.all.js') }}" defer></script>
    <script src="{{ asset('js/dx.messages.ru.js') }}" defer></script>
    @stack('scripts')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dx.common.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dx.light.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark navbar-vds shadow-sm">
            <div class="container-fluid position-relative d-flex align-items-center">
                <div class="navbar-nav mr-auto"></div>

                <a class="navbar-center" href="{{ url('/') }}" style="text-decoration: none;">
                    <img src="{{ asset('img/vds-logo-bw.png') }}" height="45" alt="VDS">
                </a>

                <div class="navbar-nav ml-auto">
                    @auth
                        <div class="dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" style="border-radius: 0; border: 1px solid #000;">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Выйти
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
