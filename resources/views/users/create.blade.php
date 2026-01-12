@extends('layouts.materialize')

@section('content')
    <div class="row">
        <div class="col s12 m10 offset-m1">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Crear Usuario</span>

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <div class="input-field">
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
                            <label for="name" class="{{ old('name') ? 'active' : '' }}">Nombre</label>
                            @error('name')
                                <span class="helper-text red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-field">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                            <label for="email" class="{{ old('email') ? 'active' : '' }}">Correo electrónico</label>
                            @error('email')
                                <span class="helper-text red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-field">
                            <input id="password" type="password" name="password" required>
                            <label for="password">Contraseña</label>
                            @error('password')
                                <span class="helper-text red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-field">
                            <input id="password_confirmation" type="password" name="password_confirmation" required>
                            <label for="password_confirmation">Confirmar contraseña</label>
                        </div>

                        <div class="input-field">
                            <select id="role" name="role" required>
                                <option value="" disabled {{ old('role') ? '' : 'selected' }}>Selecciona un rol</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" {{ old('role') === $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="role">Rol</label>
                            @error('role')
                                <span class="helper-text red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="section right-align">
                            <a href="{{ route('users.index') }}" class="btn-flat">Cancelar</a>
                            <button type="submit" class="btn indigo">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const elems = document.querySelectorAll('select');
            M.FormSelect.init(elems);
        });
    </script>
@endpush
