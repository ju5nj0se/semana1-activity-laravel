# Cloudinary en Laravel – Guía rápida de uso

Esta guía explica cómo integrar y usar **Cloudinary** en un proyecto **Laravel**, utilizando el SDK oficial `cloudinary-labs/cloudinary-laravel`.

---

## 1. Requisitos

- PHP 8.1+ (ideal 8.2)
- Laravel 10 o 11
- Cuenta activa en Cloudinary

---

## 2. Instalación del SDK

```bash
composer require cloudinary-labs/cloudinary-laravel
php artisan cloudinary:install

Esto registra automáticamente el Service Provider y las dependencias necesarias.
3. Configuración (.env)

En el archivo .env agrega:

CLOUDINARY_URL=cloudinary://API_KEY:API_SECRET@CLOUD_NAME

Opcionalmente:

CLOUDINARY_UPLOAD_PRESET=mi_preset

    Recomendación: para cargas desde backend no es obligatorio usar upload presets.

4. Subir imágenes a Cloudinary
Subida básica de una imagen

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

$upload = Cloudinary::upload(
    $request->file('image')->getRealPath(),
    [
        'folder' => 'mi_app/imagenes'
    ]
);

$url = $upload->getSecurePath();
$publicId = $upload->getPublicId();

Datos importantes que devuelve

    getSecurePath() → URL HTTPS de la imagen

    getPublicId() → Identificador único (clave para gestionar la imagen)

👉 Buena práctica: guardar siempre el public_id en la base de datos, no solo la URL.
5. Subir otros recursos (PDF, videos, etc.)

Cloudinary::upload(
    $file->getRealPath(),
    [
        'resource_type' => 'auto',
        'folder' => 'mi_app/documentos'
    ]
);

6. Mostrar imágenes (entrega optimizada)

Cloudinary permite transformaciones dinámicas sobre la URL.

Ejemplos de buenas prácticas:

    f_auto → formato automático (WebP / AVIF)

    q_auto → calidad automática

    resize y crop según UI

Normalmente:

    Backend guarda public_id

    Frontend consume la URL generada por Cloudinary

7. Eliminar una imagen

Cloudinary::destroy($publicId);

Usar esto cuando:

    Se elimina un registro

    Se reemplaza una imagen existente

8. Reemplazar una imagen

Flujo recomendado:

    Eliminar la imagen anterior (destroy)

    Subir la nueva

    Guardar el nuevo public_id

9. Métodos principales del SDK
Método	Uso
Cloudinary::upload()	Subir imágenes o archivos
getSecurePath()	Obtener URL HTTPS
getPublicId()	Obtener identificador del recurso
Cloudinary::destroy()	Eliminar recurso
resource_type	Definir tipo (image, video, auto)
folder	Organizar archivos en Cloudinary