@extends('layouts.materialize')

@section('content')
    <div x-data="{ showModal: false, modalTitle: '', modalData: {} }">
        <div class="row">
            <div class="col s12">
                <h4>Auditorías de Sistema</h4>

                <!-- Filtros -->
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Filtrar Auditorías</span>
                        <form method="GET" action="{{ route('audits.index') }}">
                            <div class="row">
                                <div class="input-field col s12 m3">
                                    <select name="user_id" class="browser-default">
                                        <option value="">Todos los Usuarios</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-field col s12 m3">
                                    <select name="event" class="browser-default">
                                        <option value="">Todos los Eventos</option>
                                        @foreach($events as $event)
                                            <option value="{{ $event }}" {{ request('event') == $event ? 'selected' : '' }}>
                                                {{ ucfirst($event) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-field col s12 m3">
                                    <select name="auditable_type" class="browser-default">
                                        <option value="">Todos los Modelos</option>
                                        @foreach($models as $model)
                                            <option value="{{ $model }}" {{ request('auditable_type') == $model ? 'selected' : '' }}>
                                                {{ class_basename($model) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-field col s12 m3">
                                    <input type="text" name="ip_address" id="ip_address" value="{{ request('ip_address') }}" placeholder="Buscar por IP">
                                    <label for="ip_address" class="active">IP Address</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 right-align">
                                    <a href="{{ route('audits.index') }}" class="btn grey">Limpiar</a>
                                    <button type="submit" class="btn indigo">Filtrar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabla -->
                <div class="card">
                    <div class="card-content">
                        <table class="highlight responsive-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Usuario</th>
                                    <th>Evento</th>
                                    <th>Modelo</th>
                                    <th>IP</th>
                                    <th class="center-align">Antiguo</th>
                                    <th class="center-align">Nuevo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($audits as $audit)
                                    <tr>
                                        <td>{{ $audit->id }}</td>
                                        <td>{{ $audit->user ? $audit->user->name : '-' }}</td>
                                        <td>
                                            @php
                                                $color = match($audit->event) {
                                                    'created' => 'green',
                                                    'updated' => 'blue',
                                                    'deleted' => 'red',
                                                    default => 'grey'
                                                };
                                            @endphp
                                            <span class="new badge {{ $color }}" data-badge-caption="">
                                                {{ ucfirst($audit->event) }}
                                            </span>
                                        </td>
                                        <td>{{ class_basename($audit->auditable_type) }}</td>
                                        <td>{{ $audit->ip_address }}</td>
                                        <td class="center-align">
                                            @if($audit->old_values)
                                                <button type="button" class="btn-small waves-effect waves-light indigo lighten-2" 
                                                    @click="modalTitle = 'Datos Antiguos'; modalData = {{ json_encode($audit->old_values) }}; showModal = true">
                                                    Ver
                                                </button>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="center-align">
                                            @if($audit->new_values)
                                                <button type="button" class="btn-small waves-effect waves-light indigo lighten-2" 
                                                    @click="modalTitle = 'Datos Nuevos'; modalData = {{ json_encode($audit->new_values) }}; showModal = true">
                                                    Ver
                                                </button>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="center-align">No se encontraron registros.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-action">
                        @if ($audits->hasPages())
                            <ul class="pagination center-align">
                                <li class="{{ $audits->onFirstPage() ? 'disabled' : 'waves-effect' }}">
                                    <a href="{{ $audits->previousPageUrl() ?? '#' }}">
                                        <i class="material-icons">chevron_left</i>
                                    </a>
                                </li>

                                @foreach ($audits->getUrlRange(1, $audits->lastPage()) as $page => $url)
                                    <li class="{{ $audits->currentPage() === $page ? 'active indigo' : 'waves-effect' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                <li class="{{ $audits->hasMorePages() ? 'waves-effect' : 'disabled' }}">
                                    <a href="{{ $audits->nextPageUrl() ?? '#' }}">
                                        <i class="material-icons">chevron_right</i>
                                    </a>
                                </li>
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para mostrar JSON (Alpine.js) -->
        <div 
            class="custom-modal-overlay" 
            x-show="showModal" 
            x-cloak 
            @click.self="showModal = false"
            style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; display: flex; align-items: center; justify-content: center;"
        >
            <div 
                class="card" 
                style="width: 90%; max-width: 800px; max-height: 90vh; overflow-y: auto;"
                @click.stop
            >
                <div class="card-content">
                    <span class="card-title" x-text="modalTitle"></span>
                    <div style="background: #f5f5f5; padding: 15px; border-radius: 4px; overflow-x: auto;">
                        <pre style="margin: 0; font-family: monospace; font-size: 13px;" x-text="JSON.stringify(modalData, null, 2)"></pre>
                    </div>
                </div>
                <div class="card-action right-align">
                    <button type="button" class="btn grey" @click="showModal = false">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush

<style>
    [x-cloak] { display: none !important; }
    .custom-modal-overlay {
        transition: opacity 0.3s ease;
    }
</style>
