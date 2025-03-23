<?php

// guardar_descriptor.php

header('Content-Type: application/json');

// Incluir la clase Conexion
require '../vendor/autoload.php';

use Clases\Conexion;

// Crear una instancia de la clase Conexion
$conn = new Conexion();


// Verificar si la conexión fue exitosa
if (!$conn) {
    echo json_encode(['message' => 'Error al conectar a la base de datos.']);
    exit;
}

// Ruta al archivo que contiene la clave de encriptación
$so = PHP_OS;
if (stripos($so, 'WIN') !== false) {
    $ruta_clave = 'c:/xampp/clave.txt';
} else {
    $ruta_clave = '/var/www/clave.txt';
}

// Leer la clave de encriptación desde el archivo
if (!file_exists($ruta_clave)) {
    echo json_encode(['message' => 'Error: No se encontró el archivo de la clave de encriptación.']);
    exit;
} else {
    $clave = trim(file_get_contents($ruta_clave)); // Leer y eliminar espacios en blanco
}

// Verificar si se recibieron los datos necesarios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Comprobar si falta alguno de los campos
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

    // Obtener el nombre y el descriptor
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

    // Insertar los datos en la base de datos
    try {
        // Preparar la consulta SQL
        $sql = "INSERT INTO tbio (COD_TIPO_BIO, DATO_BIO, COD_EMPLEADO) VALUES (:cod_tipo_bio, :dato_bio, :cod_empleado)";
        $stmt = $conn->conexion->prepare($sql);

        // Asignar valores a los parámetros
        $cod_tipo_bio = 1; // COD_TIPO_BIO siempre será 1
        $dato_bio = $datos_guardar; // Datos encriptados
        $cod_empleado = 1; // Usamos el nombre como COD_EMPLEADO

        // Ejecutar la consulta
        $stmt->execute([
            ':cod_tipo_bio' => $cod_tipo_bio,
            ':dato_bio' => $dato_bio,
            ':cod_empleado' => $cod_empleado
        ]);

        // Mensaje de éxito
        echo json_encode(['message' => 'Descriptor guardado correctamente en la base de datos.']);
    } catch (PDOException $e) {
        // Manejar errores de la base de datos
        echo json_encode(['message' => 'Error al guardar el descriptor en la base de datos: ' . $e->getMessage()]);
    }
}







/*
// guardar_descriptor.php

header('Content-Type: application/json');

// Directorio donde se guardarán los descriptores
$directorio = '../rostros/';

// Ruta al archivo que contiene la clave de encriptación
$so = PHP_OS;
if (stripos($so, 'WIN') !== false) {
    $ruta_clave = 'c:/xampp/clave.txt';
} else {
    $ruta_clave = '/var/www/clave.txt';
}

// Leer la clave de encriptación desde el archivo
if (!file_exists($ruta_clave)) {
    echo json_encode(['message' => 'Error: No se encontró el archivo de la clave de encriptación.']);
    exit;
} else {
    $clave = trim(file_get_contents($ruta_clave)); // Leer y eliminar espacios en blanco
}

// Verificar si se recibieron los datos necesarios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    //comprueba si falta alguno de ellos
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

    // Obtener el nombre y el descriptor
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

    // Guardar el archivo y mostrar el mensaje en consola.
    if (file_put_contents($nombreArchivo, $datos_guardar)) {
        echo json_encode(['message' => 'Descriptor guardado correctamente.']);
    } else {
        echo json_encode(['message' => 'Error: No se pudo guardar el descriptor.']);
    }
}*/
?>
