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
            integrity="sha512-UJfAaOlIRtdR+0P6C3KUoTDAxVTuy3lnSXLyLKlHYJlcSU8Juge/mjeaxDNMlw9LgeIotgz5FP8eUQPhX1q10A=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />
        <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    </head>
    <body class="grey lighten-4">
        <nav class="indigo">
            <div class="nav-wrapper container">
                <a href="{{ url('/') }}" class="brand-logo">Supermercados OR</a>
                <ul class="right hide-on-med-and-down">
                    @auth
                        <li><a href="{{ route('products.index') }}">Productos</a></li>
                        <li><a href="{{ route('users.index') }}">Usuarios</a></li>
                        @role('admin')
                            <li><a href="{{ route('audits.index') }}">Auditorías</a></li>
                        @endrole
                        <li x-data>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form-layout" style="display: none;">
                                @csrf
                            </form>
                            <a href="{{ route('logout') }}" @click.prevent="$root.submit();" class="waves-effect waves-light btn red accent-2">Cerrar sesión</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </nav>

        <main class="container section">
            @yield('content')
        </main>

        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"
            integrity="sha512-NiWqa2rceHnN3Z5j6mSAvbwwg3tiwVNxiAQaaSMSXnRRDh5C2mk/+sKQRw8qjV1vN4nf8iK2a0b048PnHbyx+Q=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        ></script>
        @stack('scripts')
    </body>
</html>
