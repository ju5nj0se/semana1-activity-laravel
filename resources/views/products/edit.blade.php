<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Producto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <x-label for="name" value="{{ __('Nombre') }}" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $product->name)" required autofocus />
                            <x-input-error for="name" class="mt-2" />
                        </div>

                        <div>
                            <x-label for="description" value="{{ __('Descripción') }}" />
                            <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('description', $product->description) }}</textarea>
                            <x-input-error for="description" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <x-label for="price" value="{{ __('Precio') }}" />
                                <x-input id="price" class="block mt-1 w-full" type="number" step="0.01" name="price" :value="old('price', $product->price)" required />
                                <x-input-error for="price" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-label for="image" value="{{ __('Imagen') }}" />
                            @if ($product->image_path)
                                <div class="mt-2 mb-2">
                                    <img src="{{ $product->image_path }}" alt="{{ $product->name }}" class="h-20 w-20 object-cover rounded">
                                </div>
                            @endif
                            
                            <div class="mt-2 flex flex-col space-y-4">
                                <!-- Standard File Input -->
                                <input id="image" type="file" name="image" accept="image/*" class="block mt-1 w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700
                                    hover:file:bg-blue-100" />
                                
                                <!-- Camera Preview and Capture -->
                                <div id="camera-container" class="hidden">
                                    <video id="video-preview" width="320" height="240" autoplay class="border rounded"></video>
                                    <button type="button" id="capture-btn" class="mt-2 bg-green-500 text-white px-4 py-2 rounded">Capturar Foto</button>
                                    <canvas id="canvas" width="320" height="240" class="hidden"></canvas>
                                </div>
                                
                                <!-- Button to Activate Camera -->
                                <button type="button" id="start-camera-btn" class="bg-gray-500 text-white px-4 py-2 rounded w-fit">
                                    Usar Cámara
                                </button>

                                <!-- Captured Image Preview (Just to show user) -->
                                <img id="captured-image-preview" src="#" alt="Captura" class="hidden w-40 h-auto rounded border" />
                            </div>

                            <x-input-error for="image" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            {{ __('Cancelar') }}
                        </a>
                        <x-button>
                            {{ __('Actualizar') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                    cameraContainer.classList.remove('hidden');
                    startCameraBtn.classList.add('hidden');
                } catch (err) {
                    alert("Error al acceder a la cámara: " + err);
                }
            });

            captureBtn.addEventListener('click', () => {
                const context = canvas.getContext('2d');
                context.drawImage(video, 0, 0, 320, 240);
                
                canvas.toBlob((blob) => {
                    const file = new File([blob], "camera-capture.jpg", { type: "image/jpeg" });
                    
                    // Create a container for the file
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    
                    // Assign to input
                    imageInput.files = dataTransfer.files;
                    
                    // Show preview
                    capturedPreview.src = URL.createObjectURL(blob);
                    capturedPreview.classList.remove('hidden');

                    // Stop stream
                    stream.getTracks().forEach(track => track.stop());
                    cameraContainer.classList.add('hidden');
                    startCameraBtn.classList.remove('hidden');
                    startCameraBtn.textContent = "Tomar otra foto";

                }, 'image/jpeg');
            });
        });
    </script>
</x-app-layout>
