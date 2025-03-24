<?php
// Incluir la clase Conexion
require '../vendor/autoload.php';

use Clases\Marcaje;

// Lista de direcciones IP permitidas
$ip_permitidas = ['127.0.0.1', '::1']; // Localhost

// Verificar si la IP del cliente está en la lista de permitidas
if (!in_array($_SERVER['REMOTE_ADDR'], $ip_permitidas)) {
    http_response_code(403); // Código de estado 403: Prohibido
    echo json_encode(['message' => 'Acceso no autorizado.']);
    exit;
}
//Rutas por S.O
$so = PHP_OS;
if (stripos($so, 'WIN') !== false) {
    $ruta_foto = 'c:/xampp/fotos/';
} else {
    $ruta_foto = '/var/www/fotos/';
}

//Obtengo los datos del POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    // Validar que los datos se hayan recibido correctamente
    if (isset($data['empleado']) && isset($data['bio'])) {
        $cod_Empleado = intval($data['empleado']);
        $cod_Bio = intval($data['bio']);
        $foto = $data['foto'];
        $tipo_acceso = intval($data['tipo_acceso']);
        $fec_Marcaje = $data['fec_marcaje'];
        $incidencia = intval($data['incidencia']);
        $pendiente = intval($data['pendiente']);
        $obs = $data['obs'];

         // Decodificar la imagen Base64
         $fotoData = explode(',', $foto);
         $fotoBinaria = base64_decode(end($fotoData));

         // Crear un nombre único para la imagen
        $nombreArchivo = 'empleado_' . $cod_Empleado . '_' . time() . '.jpg';

        // Guardar la imagen en la carpeta "uploads"
       if (!file_exists($ruta_foto)) {
            mkdir($ruta_foto, 0777, true); // Crear la carpeta si no existe
        }
        $rutaArchivo = $ruta_foto . $nombreArchivo;
        file_put_contents($rutaArchivo, $fotoBinaria);

        
        echo json_encode(['message' => 'Datos recibidos correctamente.']);
    } else {
        echo json_encode(['message' => 'Faltan datos en la solicitud.']);
    }
}else{
    http_response_code(403); // Código de estado 403: Prohibido
    echo json_encode(['message' => 'Empleado no indicado.']);
    exit;
}

// Crear una instancia de la clase Marcaje
$marca = new Marcaje();
//Cargamos el último marcaje realizado
//añadir aquí más controles horarios <<<<<<<<<<<Controles horarios>>>>>>>>>>>>>>
$tipo_marca = $marca->ultimoMarcaje($cod_Empleado);
//Si el último marcaje era de Entrada, ahora graba salida y al revés.
if ($tipo_marca==1){
    $tipo_marca=2;
} else {
    $tipo_marca=1;
}
//Marco la fecha actual como fecha de grabación.
$fecha_Grab=new DateTime();

$marca->marcar($tipo_marca,$cod_Empleado,$cod_Bio,$fec_Marcaje,$fecha_Grab->format('Y-m-d H:i:s'),$incidencia,$pendiente,$nombreArchivo,$tipo_acceso,$obs);


