<?php
// guardar_descriptor.php

header('Content-Type: application/json');

// Directorio donde se guardarán los descriptores
$directorio = 'rostros/';

// Verificar si se recibieron los datos necesarios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$input = file_get_contents('php://input');
    $data = json_decode($input, true);
if (!isset($data['nombre']) || !isset($data['descriptor'])) {
    // Mensaje de error si falta el nombre o el descriptor
    $error = [];
    if (!isset($data['nombre'])) {
        $error[] = 'Falta el campo "nombre".';
    }
    if (!isset($data['descriptor'])) {
        $error[] = 'Falta el campo "descriptor".';
    }
    echo json_encode(['message' => 'Error: ' . implode(' ', $error)]);
    exit;
}

$nombre = $data['nombre'];
$descriptor = $data['descriptor'];

// Verificar que el descriptor tenga 128 valores
if (count($descriptor) !== 128) {
    echo json_encode(['message' => 'Error: El descriptor debe tener 128 valores.']);
    exit;
}

// Crear un array con los datos
$data = [
    'nombre' => $nombre,
    'descriptor' => $descriptor
];

// Nombre del archivo (usamos el nombre proporcionado)
$nombreArchivo = $directorio . $nombre . '.json';

// Guardar el archivo
if (file_put_contents($nombreArchivo, json_encode($data))) {
    echo json_encode(['message' => 'Descriptor guardado correctamente.']);
} else {
    echo json_encode(['message' => 'Error: No se pudo guardar el descriptor.']);
}
}
?>