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
            integrity="sha512-UJfAaOlIRtdR+0P6C3KUoTDAxVTuy3lnSXLyLKlHYJlcSU8Juge/mjeaxDNMlw9LgeIotgz5FP8eUQPhX1q10A=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />
    </head>
    <body class="grey lighten-4">
        <nav class="indigo">
            <div class="nav-wrapper container">
                <a href="{{ url('/') }}" class="brand-logo">Supermercados OR</a>
                <ul class="right hide-on-med-and-down">
                    @if (Route::has('login'))
                        @auth
                            <li><a href="{{ route('products.index') }}">Productos</a></li>

                            @role('admin')
                                <li><a href="{{ route('users.index') }}">Usuarios</a></li>
                            @endrole
                            @role('admin')
                                <li><a href="{{ route('audits.index') }}">Auditorías</a></li>
                            @endrole
                            <li x-data>
                                <form method="POST" action="{{ route('logout') }}" id="logout-form-welcome" style="display: none;">
                                    @csrf
                                    <button type="submit" @click.prevent="$root.submit();" class="waves-effect waves-light btn red accent-2">Cerrar sesión</button>
                                </form>
                            </li>
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
                        <div class="card-action">
                            @auth
                                <div class="row">
                                    <div class="col s12 m6">
                                        <div class="card">
                                            <div class="card-content">
                                                <span class="card-title">Gestión de Productos</span>
                                                <p>Consulta y administra los productos con un diseño adaptable.</p>
                                                <a href="{{ route('products.index') }}" class="btn indigo">Productos</a>
                                            </div>
                                        </div>
                                    </div>
                                    @role('admin')
                                    <div class="col s12 m6">
                                        <div class="card">
                                            <div class="card-content">
                                                <span class="card-title">Gestión de Usuarios</span>
                                                <p>Organiza roles y usuarios de manera eficiente y segura.</p>
                                                <a href="{{ route('users.index') }}" class="btn indigo">Usuarios</a>
                                            </div>
                                        </div>
                                    </div>
                                    @endrole
                                    @role('admin')
                                    <div class="col s12 m6">
                                        <div class="card">
                                            <div class="card-content">
                                                <span class="card-title">Auditorias</span>
                                                <p>Estate atento a todo lo que pasa en la aplicación</p>
                                                    <a href="{{ route('audits.index') }}" class="btn indigo">Auditorías</a>
                                            </div>
                                        </div>
                                    </div>
                                    @endrole
                                </div>
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

            
        </main>

        <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"
            integrity="sha512-NiWqa2rceHnN3Z5j6mSAvbwwg3tiwVNxiAQaaSMSXnRRDh5C2mk/+sKQRw8qjV1vN4nf8iK2a0b048PnHbyx+Q=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        ></script>
    </body>
</html>
