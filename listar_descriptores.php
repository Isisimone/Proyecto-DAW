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
$ruta_clave = '/var/www/clave.txt';

foreach ($archivos as $archivo) {
    // Leer el contenido del archivo
	$contenido = file_get_contents($archivo);
    $datos_desencriptados = desencriptarDatos($contenido, $ruta_clave);
    if ($datos_desencriptados !== false) {
		$data = json_decode($datos_desencriptados, true);
	} else {
		echo "Error al desencriptar los datos.";
	}
	//$data = json_decode($contenido, true);

    // Verificar que el archivo tenga el formato correcto
    if (isset($data['nombre']) && isset($data['descriptor'])) {
        $descriptores[] = $data;
    }
}

// Devolver la lista de descriptores
echo json_encode($descriptores);

function desencriptarDatos($datos_encriptados, $ruta_clave) {
    if (!file_exists($ruta_clave)) {
        return false; // No se encontró el archivo de la clave
    }

    $clave = trim(file_get_contents($ruta_clave)); // Leer la clave
    $datos_encriptados = base64_decode($datos_encriptados);
    $metodo = 'AES-256-CBC';
    $iv_length = openssl_cipher_iv_length($metodo);
    $iv = substr($datos_encriptados, 0, $iv_length);
    $datos_encriptados = substr($datos_encriptados, $iv_length);
    return openssl_decrypt($datos_encriptados, $metodo, $clave, 0, $iv);
}
?>
