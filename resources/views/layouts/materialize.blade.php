<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"
            integrity="sha512-GY+0jBbtwVz5c1hX0tWygsJ8PT5JQt7pW1h4U1l5s1rVsL1dKTZ9XfC6oG9I+8gqO2xQnmsV1M6M4u5p2vBR9Q=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />
    </head>
    <body class="grey lighten-4">
        <nav class="indigo">
            <div class="nav-wrapper container">
                <a href="{{ url('/') }}" class="brand-logo">Semana 1</a>
                <ul class="right hide-on-med-and-down">
                    @auth
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('products.index') }}">Productos</a></li>
                        <li><a href="{{ route('users.index') }}">Usuarios</a></li>
                    @endauth
                </ul>
            </div>
        </nav>

        <main class="container section">
            @yield('content')
        </main>

        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"
            integrity="sha512-CJ7+4S4Qk6xkU4LD1s7xUvt2A/5e+da+YEX1IhE6F8p7x1z1gFR71FEy0DccEDlDwN3k+Jf4d6v2b9x3D1n5qA=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        ></script>
        @stack('scripts')
    </body>
</html>
