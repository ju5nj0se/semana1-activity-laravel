<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

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
                    @if (Route::has('login'))
                        @auth
                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        @else
                            <li><a href="{{ route('login') }}">Iniciar sesión</a></li>
                            @if (Route::has('register'))
                                <li><a href="{{ route('register') }}">Registrarse</a></li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </nav>

        <main class="container section">
            <div class="row">
                <div class="col s12 m10 offset-m1">
                    <div class="card">
                        <div class="card-content">
                            <span class="card-title">Panel principal</span>
                            <p>
                                Bienvenido al proyecto de la semana 1. Gestiona usuarios y productos desde un
                                panel claro, moderno y construido con Materialize CSS.
                            </p>
                        </div>
                        <div class="card-action">
                            @auth
                                <a href="{{ route('dashboard') }}" class="btn indigo">Ir al Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="btn indigo">Ingresar</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn grey">Crear cuenta</a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col s12 m6">
                    <div class="card">
                        <div class="card-content">
                            <span class="card-title">Gestión de Productos</span>
                            <p>Consulta y administra el catálogo con un diseño adaptable.</p>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="card">
                        <div class="card-content">
                            <span class="card-title">Gestión de Usuarios</span>
                            <p>Organiza roles y usuarios de manera eficiente y segura.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"
            integrity="sha512-CJ7+4S4Qk6xkU4LD1s7xUvt2A/5e+da+YEX1IhE6F8p7x1z1gFR71FEy0DccEDlDwN3k+Jf4d6v2b9x3D1n5qA=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        ></script>
    </body>
</html>
