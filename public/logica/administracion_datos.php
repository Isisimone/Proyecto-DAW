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
//datos falsos
$empleados = [
    [
        "id" => 1,
        "foto" => "../recursos/foto1.jpg",
        "nombre" => "Julián Celamor",
        "apellido" => "Celamor",
        "usuario" => "JulianC",
        "contacto" => "Julian@celo.com",
        "fec_alta" => "12/02/2025",
        "fec_baja" => "",
        "user_alta" => "Admon",
        "user_baja" => "",
        "horario" => "De 8 a 16h",
        "flex" => true,
        "max_horas" => 6,
        "bolsa" => 4

    ],
    [
        "id" => 2,
        "foto" => "../recursos/foto2.jpg",
        "nombre" => "María García",
        "apellido" => "García",
        "usuario" => "MariaG",
        "contacto" => "maria@celo.com",
        "fec_alta" => "12/02/2025",
        "fec_baja" => "",
        "user_alta" => "Admon",
        "user_baja" => "",
        "horario" => "De 8 a 16h",
        "flex" => true,
        "max_horas" => 6,
        "bolsa" => 4
    ],
    [
        "id" => 3,
        "foto" => "../recursos/foto3.jpg",
        "nombre" => "Carlos Ruiz",
        "apellido" => "Ruiz",
        "usuario" => "CalorsR",
        "contacto" => "carlos@celo.com",
        "fec_alta" => "12/02/2025",
        "fec_baja" => "",
        "user_alta" => "Admon",
        "user_baja" => "",
        "horario" => "De 8 a 16h",
        "flex" => true,
        "max_horas" => 6,
        "bolsa" => 4
    ]
];



// Verifica si hay una sesión activa
if (isset($_SESSION['COD_USUARIO'])) {
    if (in_array('Admin', $_SESSION['ROLES'])) {

        //Fecha de hoy
        $fechaHoy = new DateTime('now', new DateTimeZone('UTC'));
        $fechaHoy->setTimezone(new DateTimeZone('Europe/Madrid'));

        // Obtiene el código del empleado desde la sesión y sus datos propios
        $codEmpleado = $_SESSION['COD_EMPLEADO'];
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