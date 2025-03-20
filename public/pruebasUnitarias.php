<?php
session_start();

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



//$privilejio = new Privilejio();




$fecha = new DateTime();

function pruebaAjuste(bool $crear, bool $modificar, bool $mostrar, ?int $id){
    $ajuste = new Ajuste();
    if ($crear){
        $ajuste->crear('MaxLoginRq','3');
    }
    if ($modificar){
        $ajuste->actualizarAjuste(1, 'umbral', '0.8');
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
        $marcajes = $marcaje->cargarMarcajesEntreFechas($fecha2, $fecha);
        foreach ($marcajes as $marcaje) {
            if ($marcaje->getCodMarcaje() == 2) {
                echo $marcaje->getFoto();
                break;
            }
        }
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
        $roles = $rol->cargarRoles();
        var_dump($roles);
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
        $transacciones=$transaccion->obtenerTransaccionesEntreFechas($fecha1,$fecha2);
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
        $usuario->cargarUsuario(1);
        $usuario->setDesContrasena('Prueba');
        $usuario->grabar();
    }
    if ($mostrar){
        /*$usuario->cargarUsuario(1);
        $resultado=$usuario->compararContrasena('Prueba');
        if ($resultado){
            var_dump($usuario);
        } else {
            echo "Error de login";
        }*/
        $usuario->iniciarSesion('Admon','Prueba');
        var_dump($_SESSION);
    }
}


pruebaAjuste(false,false,false,3);
pruebaDatosBio(false,false,false,1);
pruebaEmpleado(false,false,false,5);
pruebaMarcaje(false,false,false,2);
pruebaRol(false,false,false,2);
pruebaTipoBio(false,false,false,1);
pruebaTransaccion(false,false,false,6); //Sin pasar
pruebaUsuario(false,false,true,1);