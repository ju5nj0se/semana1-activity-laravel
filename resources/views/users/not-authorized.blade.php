@extends('layouts.materialize')

@section('content')
    <div class="row">
        <div class="col s12 m8 offset-m2">
            <div class="card red lighten-5">
                <div class="card-content">
                    <span class="card-title red-text text-darken-2">Acceso restringido</span>
                    <p>No estás permitido para acceder a esta vista.</p>
                </div>
                <div class="card-action">
                    <a href="{{ route('dashboard') }}" class="btn red">Volver al Dashboard</a>
                </div>
            </div>
        </div>
    </div>
@endsection
