@extends('layouts.materialize')

@section('content')
    <div class="row">
        <div class="col s12 m10 offset-m1">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Editar Usuario</span>

                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="input-field">
                            <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                            <label for="name" class="active">Nombre</label>
                            @error('name')
                                <span class="helper-text red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-field">
                            <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                            <label for="email" class="active">Correo electrónico</label>
                            @error('email')
                                <span class="helper-text red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-field">
                            <select id="role" name="role" required>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" {{ old('role', $user->roles->first()?->name) === $role->name ? 'selected' : '' }}>
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
                            <button type="submit" class="btn indigo">Actualizar</button>
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
