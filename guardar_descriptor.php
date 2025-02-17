<?php
// guardar_descriptor.php

header('Content-Type: application/json');

// Directorio donde se guardarán los descriptores
$directorio = 'rostros/';

// Ruta al archivo que contiene la clave de encriptación
$ruta_clave = 'c:/xampp/clave.txt';

// Leer la clave de encriptación desde el archivo
if (!file_exists($ruta_clave)) {
    echo json_encode(['message' => 'Error: No se encontró el archivo de la clave de encriptación.']);
    exit;
}

$clave = trim(file_get_contents($ruta_clave)); // Leer y eliminar espacios en blanco

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

    // Convertir el array a JSON
    $json_data = json_encode($data);

    // Encriptar los datos
    $metodo = 'AES-256-CBC'; // Método de encriptación
    $iv_length = openssl_cipher_iv_length($metodo);
    $iv = openssl_random_pseudo_bytes($iv_length); // Vector de inicialización
    $datos_encriptados = openssl_encrypt($json_data, $metodo, $clave, 0, $iv);

    // Guardar el IV junto con los datos encriptados
    $datos_guardar = base64_encode($iv . $datos_encriptados);

    // Nombre del archivo (usamos el nombre proporcionado)
    $nombreArchivo = $directorio . $nombre . '.json';

    // Guardar el archivo
    if (file_put_contents($nombreArchivo, $datos_guardar)) {
        echo json_encode(['message' => 'Descriptor guardado correctamente.']);
    } else {
        echo json_encode(['message' => 'Error: No se pudo guardar el descriptor.']);
    }
}
?>