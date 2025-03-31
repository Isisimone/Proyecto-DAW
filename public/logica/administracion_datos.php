<?php
session_start();
date_default_timezone_set('Europe/Madrid');

// Carga librerías de Composer
require '../vendor/autoload.php';

// Clases a usar
use Clases\Incidencia;
use Clases\Empleado;
use Clases\Usuario;
use Clases\Transaccion;
use Clases\Ajuste;
use Clases\Marcaje;
use Clases\DatosBiometricos;
use Clases\Privilegio;
use Clases\Rol;

// Verifica si hay una sesión activa
if (isset($_SESSION['COD_USUARIO'])) {
    if (in_array('Admin', $_SESSION['ROLES'])) {

        //Fecha de hoy
        $fechaHoy = new DateTime('now', new DateTimeZone('UTC'));
        $fechaHoy->setTimezone(new DateTimeZone('Europe/Madrid'));

        // Obtiene el código del empleado y usuario desde la sesión y sus datos propios
        $codEmpleado = $_SESSION['COD_EMPLEADO'];
        $codUsuarioSesion = $_SESSION['COD_USUARIO'];
        $empleado= new Empleado();
        $marcaje = new Marcaje();
        $empleado->cargarDatosEmpleado($codEmpleado);
        $horasTrabajadas = $marcaje->calcularHorasTrabajadas($codEmpleado, $fechaHoy,0,89);
        $horasSemanales = $marcaje->calcularHorasSemana($codEmpleado,$fechaHoy,0,89);
        $marcaje->calcularBolsaMensual($codEmpleado,$fechaHoy);
        $bolsa = $empleado->getBolsa();
        $progresoHorario=($horasTrabajadas*100)/$empleado->getMaxHorasDia();

        //Obtiene solicitudes pendientes
        $incidencia = new Incidencia;
        $incidenciasPendientes = $incidencia->cargarPendientes();
        $incidenciasResueltas = $incidencia->cargarResueltas();

        //Obtener empleados de la BBDD
        $empleados=$empleado->listarEmpleados();
        $empleadosDentro=[];
        $empleadosFuera=[];
        $empleadosAusentes=[];
        //Obtener asistencias
        foreach ($empleados as $asiste){
            switch($marcaje->asistencia($asiste['COD_EMPLEADO'],$fechaHoy)){
                case 1:
                    $empleadosDentro[]=$asiste;
                    break;
                case 2:
                    $empleadosFuera[]=$asiste;
                    break;
                default:
                    $empleadosAusentes[]=$asiste;
                    break;
            }
        }

        //Obtener lista de usuarios
        $usuario=new Usuario();
        $usuarios=$usuario->obtenerUsuarios();

        //Obtención lista de roles;
        $rol = new Rol();
        $roles = $rol->cargarRoles();
        
    }
}

function pideFoto($codEmpleado){
    $empleado= new Empleado();
    $empleado->cargarDatosEmpleado($codEmpleado);
    return $empleado->getFoto();
}

function pideNombre($codEmpleado){
    $empleado= new Empleado();
    $empleado->cargarDatosEmpleado($codEmpleado);
    return $empleado->getNombre()." ".$empleado->getApellido1();
}