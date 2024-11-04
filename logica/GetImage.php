<?php
class GetImage
{
    private $uploadDir;

    public function __construct($directory = '../../persistencia/assets/')
    {
        $this->uploadDir = $directory;
        $this->createUploadDir();
    }

    // Método para crear el directorio de subida si no existe
    private function createUploadDir()
    {
        if (!is_dir($this->uploadDir)) {
            if (!mkdir($this->uploadDir, 0755, true)) {
                die("Error: No se pudo crear el directorio de subida.");
            }
        }
    }

    // Método para subir la imagen
    public function uploadImage(array $file)
    {
        // Verificar si el archivo fue subido
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            die("Error: No se ha subido ningún archivo o hubo un problema durante la subida.");
        }

        $uploadFile = $this->uploadDir . basename($file['name']);
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

        // Validar si el archivo es una imagen real
        $check = getimagesize($file['tmp_name']);
        if ($check === false) {
            die("Error: El archivo no es una imagen.");
        }

        // Limitar los tipos de archivo permitidos
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($imageFileType, $allowedTypes)) {
            die("Error: Solo se permiten archivos JPG, JPEG, PNG y GIF.");
        }

        // Limitar el tamaño de la imagen (máximo 2 MB)
        if ($file['size'] > 2000000) {
            die("Error: El archivo es demasiado grande. Máximo permitido: 2 MB.");
        }

        // Renombrar archivo para evitar colisiones
        $newFileName = uniqid() . "." . $imageFileType;
        $targetFile = $this->uploadDir . $newFileName;

        // Mover la imagen subida al directorio especificado
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return $newFileName;
        } else {
            return "Error: Ocurrió un problema al mover la imagen al directorio de subida.";
        }
    }
}