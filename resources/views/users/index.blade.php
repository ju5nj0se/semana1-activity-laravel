@extends('layouts.materialize')

@section('content')
    <div class="row">
        <div class="col s12">
            <h4>Gestión de Usuarios</h4>

            @if (session('success'))
                <div class="card-panel green lighten-4 green-text text-darken-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="card-panel red lighten-4 red-text text-darken-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-content">
                    <div class="row valign-wrapper" style="margin-bottom: 0;">
                        <div class="col s8">
                            <span class="card-title">Listado de Usuarios</span>
                        </div>
                        <div class="col s4 right-align">
                            <a href="{{ route('users.create') }}" class="btn indigo">Crear Usuario</a>
                        </div>
                    </div>

                    <table class="highlight responsive-table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Última Actividad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @foreach ($user->roles as $role)
                                            <span class="new badge green" data-badge-caption="">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ $user->last_activity_at ? $user->last_activity_at->diffForHumans() : 'Nunca' }}</td>
                                    <td>
                                        <a href="{{ route('users.edit', $user) }}" class="btn-small amber darken-2">Editar</a>
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-small red" onclick="return confirm('¿Estás seguro de querer eliminar este usuario?');">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-action">
                    @if ($users->hasPages())
                        <ul class="pagination center-align">
                            <li class="{{ $users->onFirstPage() ? 'disabled' : 'waves-effect' }}">
                                <a href="{{ $users->previousPageUrl() ?? '#' }}">
                                    <i class="material-icons">chevron_left</i>
                                </a>
                            </li>

                            @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                <li class="{{ $users->currentPage() === $page ? 'active indigo' : 'waves-effect' }}">
                                    <a href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            <li class="{{ $users->hasMorePages() ? 'waves-effect' : 'disabled' }}">
                                <a href="{{ $users->nextPageUrl() ?? '#' }}">
                                    <i class="material-icons">chevron_right</i>
                                </a>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
