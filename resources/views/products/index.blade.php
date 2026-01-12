@extends('layouts.materialize')

@section('content')
    @php
        $isAdmin = auth()->user()->hasRole('admin');
    @endphp

    <div class="row">
        <div class="col s12">
            <h4>Gestión de Productos</h4>

            @if (session('success'))
                <div class="card-panel green lighten-4 green-text text-darken-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-content">
                    <div class="row valign-wrapper" style="margin-bottom: 0;">
                        <div class="col s8">
                            <span class="card-title">Listado de Productos</span>
                        </div>
                        <div class="col s4 right-align">
                            @if ($isAdmin)
                                <a href="{{ route('products.create') }}" class="btn indigo">Crear Producto</a>
                            @else
                                <span class="btn disabled">Crear Producto</span>
                            @endif
                        </div>
                    </div>

                    <table class="highlight responsive-table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Imagen</th>
                                <th>Precio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>
                                        <img
                                            src="{{ $product->image_path }}"
                                            alt="{{ $product->name }}"
                                            class="circle responsive-img"
                                            style="max-width: 48px;"
                                        >
                                    </td>
                                    <td>${{ number_format($product->price, 2) }}</td>
                                    <td>
                                        @if ($isAdmin)
                                            <a href="{{ route('products.edit', $product) }}" class="btn-small amber darken-2">Editar</a>
                                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-small red" onclick="return confirm('¿Estás seguro?');">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @else
                                            <span class="btn-small disabled">Editar</span>
                                            <span class="btn-small disabled">Eliminar</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-action">
                    @if ($products->hasPages())
                        <ul class="pagination center-align">
                            <li class="{{ $products->onFirstPage() ? 'disabled' : 'waves-effect' }}">
                                <a href="{{ $products->previousPageUrl() ?? '#' }}">
                                    <i class="material-icons">chevron_left</i>
                                </a>
                            </li>

                            @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                <li class="{{ $products->currentPage() === $page ? 'active indigo' : 'waves-effect' }}">
                                    <a href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            <li class="{{ $products->hasMorePages() ? 'waves-effect' : 'disabled' }}">
                                <a href="{{ $products->nextPageUrl() ?? '#' }}">
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
