@extends('layouts.materialize')

@section('content')
    <div class="row">
        <div class="col s12 m10 offset-m1">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Crear Producto</span>

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="input-field">
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
                            <label for="name" class="{{ old('name') ? 'active' : '' }}">Nombre</label>
                            @error('name')
                                <span class="helper-text red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-field">
                            <textarea id="description" name="description" class="materialize-textarea">{{ old('description') }}</textarea>
                            <label for="description" class="{{ old('description') ? 'active' : '' }}">Descripción</label>
                            @error('description')
                                <span class="helper-text red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-field">
                            <input id="price" type="number" step="0.01" name="price" value="{{ old('price') }}" required>
                            <label for="price" class="{{ old('price') ? 'active' : '' }}">Precio</label>
                            @error('price')
                                <span class="helper-text red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="file-field input-field">
                            <div class="btn indigo">
                                <span>Imagen</span>
                                <input id="image" type="file" name="image" accept="image/*">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="Selecciona una imagen">
                            </div>
                            @error('image')
                                <span class="helper-text red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div id="camera-container" class="card-panel grey lighten-4" style="display: none;">
                            <video id="video-preview" width="320" height="240" autoplay class="responsive-video"></video>
                            <div class="section">
                                <button type="button" id="capture-btn" class="btn green">Capturar Foto</button>
                            </div>
                            <canvas id="canvas" width="320" height="240" style="display: none;"></canvas>
                        </div>

                        <div class="section">
                            <button type="button" id="start-camera-btn" class="btn grey">Usar Cámara</button>
                        </div>

                        <div class="section">
                            <img id="captured-image-preview" src="#" alt="Captura" class="responsive-img" style="display: none; max-width: 200px;">
                        </div>

                        <div class="section right-align">
                            <a href="{{ route('products.index') }}" class="btn-flat">Cancelar</a>
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
            const startCameraBtn = document.getElementById('start-camera-btn');
            const cameraContainer = document.getElementById('camera-container');
            const video = document.getElementById('video-preview');
            const captureBtn = document.getElementById('capture-btn');
            const canvas = document.getElementById('canvas');
            const imageInput = document.getElementById('image');
            const capturedPreview = document.getElementById('captured-image-preview');
            let stream = null;

            startCameraBtn.addEventListener('click', async () => {
                try {
                    stream = await navigator.mediaDevices.getUserMedia({ video: true });
                    video.srcObject = stream;
                    cameraContainer.style.display = 'block';
                    startCameraBtn.style.display = 'none';
                } catch (err) {
                    alert("Error al acceder a la cámara: " + err);
                }
            });

            captureBtn.addEventListener('click', () => {
                const context = canvas.getContext('2d');
                context.drawImage(video, 0, 0, 320, 240);

                canvas.toBlob((blob) => {
                    const file = new File([blob], "camera-capture.jpg", { type: "image/jpeg" });

                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    imageInput.files = dataTransfer.files;

                    capturedPreview.src = URL.createObjectURL(blob);
                    capturedPreview.style.display = 'block';

                    stream.getTracks().forEach(track => track.stop());
                    cameraContainer.style.display = 'none';
                    startCameraBtn.style.display = 'inline-block';
                    startCameraBtn.textContent = "Tomar otra foto";
                }, 'image/jpeg');
            });
        });
    </script>
@endpush
