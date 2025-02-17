<?php
// listar_descriptores.php

header('Content-Type: application/json');

// Directorio donde se guardan los descriptores
$directorio = 'rostros/';

// Verificar si el directorio existe
if (!is_dir($directorio)) {
    echo json_encode(['message' => 'El directorio de rostros no existe.']);
    exit;
}

// Obtener todos los archivos JSON en el directorio
$archivos = glob($directorio . '*.json');

// Array para almacenar los descriptores
$descriptores = [];

foreach ($archivos as $archivo) {
    // Leer el contenido del archivo
    $contenido = file_get_contents($archivo);
    $data = json_decode($contenido, true);

    // Verificar que el archivo tenga el formato correcto
    if (isset($data['nombre']) && isset($data['descriptor'])) {
        $descriptores[] = $data;
    }
}

// Devolver la lista de descriptores
echo json_encode($descriptores);
?>