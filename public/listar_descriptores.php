<?php
// listar_descriptores.php

header('Content-Type: application/json');

// Incluir la clase Conexion
require '../vendor/autoload.php';

use Clases\Conexion;

// Lista de direcciones IP permitidas
$ip_permitidas = ['127.0.0.1', '::1']; // Localhost

// Verificar si la IP del cliente está en la lista de permitidas
if (!in_array($_SERVER['REMOTE_ADDR'], $ip_permitidas)) {
    http_response_code(403); // Código de estado 403: Prohibido
    echo json_encode(['message' => 'Acceso no autorizado.']);
    exit;
}

// Crear una instancia de la clase Conexion
$conn = new Conexion();


// Verificar si la conexión fue exitosa
if (!$conn) {
    echo json_encode(['message' => 'Error al conectar a la base de datos.']);
    exit;
}

// Consulta SQL para obtener los datos de la tabla tbio donde COD_TIPO_BIO = 1
$sql = "SELECT COD_BIO, COD_TIPO_BIO, COD_EMPLEADO, DATO_BIO FROM tbio WHERE COD_TIPO_BIO = 1";
$stmt = $conn->conexion->prepare($sql);
$stmt->execute();
// Array para almacenar los descriptores
$descriptores = [];
$so = PHP_OS;
if (stripos($so, 'WIN') !== false) {
    $ruta_clave = 'c:/xampp/clave.txt';
} else {
    $ruta_clave = '/var/www/clave.txt';
}
// Verificar si se obtuvieron resultados
if ($stmt->rowCount() > 0) {
    // Recorrer cada fila de resultados
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Desencriptar los datos
        $datos_desencriptados = desencriptarDatos($row['DATO_BIO'], $ruta_clave);

        // Control de errores
        if ($datos_desencriptados !== false) {
            $data = json_decode($datos_desencriptados, true);
        } else {
            echo "Error al desencriptar los datos.";
            continue;
        }

        // Verificar que los datos tengan el formato correcto
        if (isset($data['nombre']) && isset($data['descriptor'])) {
            $descriptores[] = [
                'cod_tipo' => $row['COD_TIPO_BIO'],
                'cod_bio' => $row['COD_BIO'],
                'cod_empleado' => $row['COD_EMPLEADO'],
                'nombre' => $data['nombre'],
                'descriptor' => $data['descriptor']
            ];
        }
    }
} else {
    echo json_encode(['message' => 'No se encontraron descriptores en la base de datos.']);
    exit;
}

// Devolver la lista de descriptores
echo json_encode($descriptores);

// Función para desencriptar los datos
function desencriptarDatos($datos_encriptados, $ruta_clave) {
    // Comprueba que exista la clave
    if (!file_exists($ruta_clave)) {
        return false; // No se encontró el archivo de la clave
    }

    $clave = trim(file_get_contents($ruta_clave)); // Leer la clave
    // Desencriptar los datos
    $datos_encriptados = base64_decode($datos_encriptados);
    $metodo = 'AES-256-CBC';
    // Obtener la longitud del IV
    $iv_length = openssl_cipher_iv_length($metodo);
    // Obtener el IV y los datos encriptados
    $iv = substr($datos_encriptados, 0, $iv_length);
    $datos_encriptados = substr($datos_encriptados, $iv_length);
    // Devolver los datos desencriptados
    return openssl_decrypt($datos_encriptados, $metodo, $clave, 0, $iv);
}



/*// listar_descriptores.php

header('Content-Type: application/json');

// Directorio donde se guardan los descriptores
$directorio = '../rostros/';

// Verificar si el directorio existe
if (!is_dir($directorio)) {
    echo json_encode(['message' => 'El directorio de rostros no existe.']);
    exit;
}

// Obtener todos los archivos JSON en el directorio
$archivos = glob($directorio . '*.json');

// Array para almacenar los descriptores
$descriptores = [];

// Ruta al archivo que contiene la clave de encriptación
$so = PHP_OS;
if (stripos($so, 'WIN') !== false) {
    $ruta_clave = 'c:/xampp/clave.txt';
} else {
    $ruta_clave = '/var/www/clave.txt';
}

// Recorrer cada archivo y leer su contenido
foreach ($archivos as $archivo) {
    // Leer el contenido del archivo
	$contenido = file_get_contents($archivo);
    //Desencriptar los datos
    $datos_desencriptados = desencriptarDatos($contenido, $ruta_clave);
    //Control de errores
    if ($datos_desencriptados !== false) {
		$data = json_decode($datos_desencriptados, true);
	} else {
		echo "Error al desencriptar los datos.";
	}
	
    // Verificar que el archivo tenga el formato correcto
    if (isset($data['nombre']) && isset($data['descriptor'])) {
        $descriptores[] = $data;
    }
}

// Devolver la lista de descriptores
echo json_encode($descriptores);

//Función para desencriptar los datos
function desencriptarDatos($datos_encriptados, $ruta_clave) {
    //Comprueba que exista la clave
    if (!file_exists($ruta_clave)) {
        return false; // No se encontró el archivo de la clave
    }

    $clave = trim(file_get_contents($ruta_clave)); // Leer la clave
    //Desencriptar los datos
    $datos_encriptados = base64_decode($datos_encriptados);
    $metodo = 'AES-256-CBC';
    //Obtener la longitud del IV
    $iv_length = openssl_cipher_iv_length($metodo);
    //Obtener el IV y los datos encriptados
    $iv = substr($datos_encriptados, 0, $iv_length);
    $datos_encriptados = substr($datos_encriptados, $iv_length);
    //Devolver los datos desencriptados
    return openssl_decrypt($datos_encriptados, $metodo, $clave, 0, $iv);
}*/
?>
