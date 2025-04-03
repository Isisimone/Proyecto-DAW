<?php
session_start();
date_default_timezone_set('Europe/Madrid');

require '../vendor/autoload.php';

use Clases\Conexion;
use Clases\Ajuste;
use Clases\DatosBiometricos;
use Clases\Empleado;
use Clases\Marcaje;
use Clases\Privilejio;
use Clases\Rol;
use Clases\TipoDatoBiometrico;
use Clases\Transaccion;
use Clases\Usuario;
use Clases\Privilegio;
use Clases\Incidencia;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


//$privilejio = new Privilejio();




$fecha = new DateTime('now', new DateTimeZone('UTC'));
$fecha->setTimezone(new DateTimeZone('Europe/Madrid'));

function pruebaAjuste(bool $crear, bool $modificar, bool $mostrar, ?int $id){
    $ajuste = new Ajuste();
    if ($crear){
        $ajuste->crear('MaxLoginRq','3');
    }
    if ($modificar){
        //$ajuste->actualizarAjuste(1, 'umbral', '0.8');
        $ajuste->cargar($id);
        $ajuste->setValor('4');
        $ajuste->grabar();
    }
    if ($mostrar){
        $ajustes = $ajuste->obtenerAjustes($id);
        var_dump($ajustes);
    }
}
function pruebaDatosBio(bool $crear, bool $modificar, bool $mostrar, ?int $id){
    global $fecha;
    $datosBiometricos = new DatosBiometricos();
    if ($crear){
        $datosBiometricos->setCodEmpleado(1);
        $datosBiometricos->setCodTipo(1);
        $datosBiometricos->setDatoBio('dadsdsdsdsds');
        $datosBiometricos->setFecAlta($fecha);
        $datosBiometricos->setNomUsuarioAlta('Admon');
        $datosBiometricos->grabar();
        //$datosBiometricos->eliminar();
    }
    if ($modificar){
        $datosBiometricos = $datosBiometricos->cargar($id);
        $datosBiometricos->setDatoBio('dadsdsdsdsds-Modificado');
        $datosBiometricos->grabar();
    }
    if ($mostrar){
        $datosBiometricos = $datosBiometricos->cargar($id);
        var_dump($datosBiometricos);
    }

}
function pruebaEmpleado(bool $crear, bool $modificar, bool $mostrar, ?int $id){
    global $fecha;
    $empleado = new Empleado();
    if ($crear){
        $empleado->setCodUsuario(1);
        $empleado->setNombre('Juan');
        $empleado->setApellido1('Perez');
        $empleado->setApellido2('Gomez');
        $empleado->setContacto('juanpg@local.com');
        $empleado->setFecAlta($fecha);
        $empleado->setNomUsuarioAlta('admon');
        $empleado->grabar();
        $empleado->darBaja('admon',$fecha);
    }
    if ($modificar){
        $empleado->cargarDatosEmpleado($id);
        $empleado->setApellido1('Velázquez');
        $empleado->grabar();
    }
    if ($mostrar){
        $empleado->cargarDatosEmpleado($id);
        var_dump($empleado);
        $empleados =$empleado->listarEmpleados();
        var_dump($empleados);
    }
}
function pruebaMarcaje(bool $crear, bool $modificar, bool $mostrar, ?int $id){
    global $fecha;
    $marcaje = new Marcaje();
    if ($crear){
        $marcaje->setCodTipoMarcaje(1);
        $marcaje->setCodEmpleado(1);
        $marcaje->setCodBio(1);
        $marcaje->setFecMarcaje($fecha);
        $marcaje->setFecGrabacion($fecha);
        $marcaje->setIncidencia(false);
        $marcaje->setPendiente(false);
        $marcaje->setFoto('foto');
        $marcaje->setTipoAcceso(1);
        $marcaje->setObs('observaciones');
        $marcaje->grabar();
    }
    if ($modificar){
        $marcaje = $marcaje->cargar($id);
        $marcaje->setObs('observaciones nuevas');
        $marcaje->grabar();
    }
    if ($mostrar){
        $fecha2= new DateTime('2025-3-10 00:00');
        $marcajes = $marcaje->cargarMarcajesEntreFechas(1,1,$fecha2, $fecha);
        $marcajes2=$marcaje->marcajesHoy(1,$fecha);
        var_dump($marcajes2);
        echo($marcaje->calcularHorasTrabajadas(1,$fecha));
       
    }
}
function pruebaRol(bool $crear, bool $modificar, bool $mostrar, ?int $id){
    global $fecha;
    $rol = new Rol();
    $privis = new Privilegio();
    if ($crear){
        $rol->setNombreRol('MdCrear');
        $rol->setDescripcion('Crear MD');
        $rol->setUsuarioAlta('Admon');
        $rol->setFechaAlta($fecha);
        $rol->setPermisos($privis);
        $rol->grabar();
    }
    if ($modificar){
        $rol->cargarRol($id);
        $rol->setPermisos($privis);
        $rol->grabar();
    }
    if ($mostrar){
        $rol->cargarRol(1);
        $privis=$rol->getPermisos();
        //var_dump($privis);
        $privilegios = $privis->getPrivilegios();
        //var_dump($privilegios);
        $privilegios['empCrear'] = true;
        $privis->setPrivilegios($privilegios);
        var_dump($privis->getPrivilegios());
        $rol->setPermisos($privis);
        //$rol->grabar();
    }
}
function pruebaTipoBio(bool $crear, bool $modificar, bool $mostrar, ?int $id){
    global $fecha;
    $tipoDatoBiometrico = new TipoDatoBiometrico();
    if ($crear){
        $tipoDatoBiometrico->setDesTipoBio('Keypad');
        $tipoDatoBiometrico->setNomUsuarioAlta('Admon');
        $tipoDatoBiometrico->setFecAlta($fecha);
        $tipoDatoBiometrico->grabar();
    }
    if ($modificar){
        $tipoDatoBiometrico->cargar($id);
        $tipoDatoBiometrico->setDesTipoBio('Teclado');
        $tipoDatoBiometrico->grabar();
    }
    if ($mostrar){
        $tipoDatoBiometrico->cargar($id);
        var_dump($tipoDatoBiometrico);
    }
}
function pruebaTransaccion(bool $crear, bool $modificar, bool $mostrar, ?int $id){
    global $fecha;
    $transaccion = new Transaccion();
    if ($crear){
        $transaccion->setTipoTrans('mod_usuario');
        $transaccion->setDesTrans('Modificación del usuario Admon');
        $transaccion->setCodObj(1);
        $transaccion->setNomObj('tUsuario');
        $transaccion->setCodUsuario(1);
        $transaccion->setFecSis($fecha);
        $transaccion->setIpUsuario('127.0.0.1');
        $transaccion->nueva();
    }
    if ($modificar){
        echo "No se pueden modificar";
    }
    if ($mostrar){
        
        $fecha1 = new DateTime('2025-3-17 10:10');
        $fecha2 = new DateTime('2025-3-25 10:10');
        $transacciones=$transaccion->obtenerTransaccionesFiltradas($fecha1,$fecha2,1,6,'','zzzzzzzz');
        var_dump($transacciones);
    }
}
function pruebaUsuario(bool $crear, bool $modificar, bool $mostrar, ?int $id){
    global $fecha;
    $usuario = new Usuario();
    if ($crear){
        $usuario->setNomLogin('Admon');
        $usuario->setDesContrasena('Prueba');
        $usuario->setDesCorreo('benito@sefue.com');
        $usuario->setFecAlta($fecha);
        $usuario->setNomUsuarioAlta('Admon');
        $usuario->grabar();
    }
    if ($modificar){
        $usuario->cargarUsuario(cod_usuario: $id);
        /*$usuario->setDesContrasena('Prueba');
        $usuario->grabar();*/
        //$usuario->setRol(2);
        //var_dump($usuario->getRoles());
        //$usuario->unsetRol(2);
        //var_dump($usuario->getRoles());
    }
    if ($mostrar){
        $usuario->cargarUsuario($id);
        //$resultado=$usuario->compararContrasena('Prueba');
        //if ($resultado){
            var_dump($usuario);
        //} else {
        //    echo "Error de login";
        //}
        //$usuario->iniciarSesion('Admon','Prueba');
        //var_dump($_SESSION);*/
    }
}
$bio = new DatosBiometricos();
                    $bio->cargar(2);
                    $bio->eliminar();

pruebaAjuste(false,false,false,1);
pruebaDatosBio(false,false,false,1);
pruebaEmpleado(false,false,false,5);
pruebaMarcaje(false,false,false,2);
pruebaRol(false,false,false,3);
pruebaTipoBio(false,false,false,1);
pruebaTransaccion(false,false,false,6); //Sin pasar
pruebaUsuario(false,false,false,2);


function enviarCorreoBasico($destinatario, $asunto, $mensaje) {
    $so = PHP_OS;
        if (stripos($so, 'WIN') !== false) {
            $ruta_mail = 'c:/xampp/mail.txt';
        } else {
            $ruta_mail = '/var/www/mail.txt';
        }

        //Compruebo si existe el archivo de conexión
        if (!file_exists($ruta_mail)) {
            die("Error: No se encontró el archivo de la conexión a la base de datos.");
        } else {
            //Leo los datos de conexión desde el archivo
            $datos = file($ruta_mail);
            //Vuelco los datos eliminando espacios en blanco, saltos de línea, etc...
            $localMail = trim($datos[0]);
            $localPass = trim($datos[1]);
            $smtp = trim($datos[2]);
            $mail = new PHPMailer(true);

            try {
                // Configuración del servidor SMTP de Gmail
                $mail->isSMTP();
                $mail->Host = $smtp;
                $mail->SMTPAuth = true;
                $mail->Username = $localMail;
                $mail->Password = $localPass;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS
                $mail->Port = 587; // Puerto para TLS

                // Remitente y destinatario
                $mail->setFrom($localMail, 'Administración'); // El nombre es opcional
                $mail->addAddress($destinatario, ''); // Puedes añadir múltiples destinatarios
    
                // Contenido del correo
                $mail->isHTML(true); // Establecer el formato del email a HTML
                $mail->Subject = $asunto;
                $mail->Body    = $mensaje;
                $mail->AltBody = $mensaje;

                $mail->send();
            } catch (Exception $e) {
                echo("No se pudo enviar el mensaje. Error: {$mail->ErrorInfo}");
            }
        }
}

//enviarCorreoBasico("usdital@gmail.com","Prueba de correo","Esto es una prueba de correo");