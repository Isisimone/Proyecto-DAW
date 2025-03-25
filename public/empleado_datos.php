<?php
session_start();
date_default_timezone_set('Europe/Madrid');

// Carga librerías de Composer
require '../vendor/autoload.php';

// Clases a usar
use Clases\Empleado;
use Clases\Marcaje;

// Inicializa variables
$nombreCompleto = '';
$fotoEmpleado = '';
$ultimosMarcajes = [];
$horasTrabajadas = 0;
$labels = [];
$valores = [];
$admin = false;

// Verifica si hay una sesión activa
if (isset($_SESSION['COD_USUARIO'])) {
    if (in_array('Empleado', $_SESSION['ROLES'])) {
        // Obtiene el código del empleado desde la sesión
        $codEmpleado = $_SESSION['COD_EMPLEADO'];

        // Crea una instancia de la clase Empleado
        $empleado = new Empleado();
        if ($empleado->cargarDatosEmpleado($codEmpleado)) {
            // Obtiene los datos del empleado
            $nombreCompleto = $empleado->getNombre() . ' ' . $empleado->getApellido1() . ' ' . $empleado->getApellido2();
            $fotoEmpleado = $empleado->getFoto();

            // Crea una instancia de la clase Marcaje
            $marcaje = new Marcaje();

            // Obtiene los últimos 5 marcajes
            $ultimosMarcajes = $marcaje->obtenerUltimosMarcajes($codEmpleado, 5);

            // Obtiene las horas trabajadas hoy
            $fechaHoy = new DateTime('now', new DateTimeZone('UTC'));
            $fechaHoy->setTimezone(new DateTimeZone('Europe/Madrid'));
            $horasTrabajadas = $marcaje->calcularHorasTrabajadas($codEmpleado, $fechaHoy);

            // Determina las fechas según el filtro seleccionado
            $filtro = $_POST['filter-mode'] ?? 'week';
            $fechaInicio = null;
            $fechaFin = new DateTime('now', new DateTimeZone('Europe/Madrid'));

            switch ($filtro) {
                case 'week':
                    $fechaInicio = (clone $fechaFin)->modify('-7 days');
                    break;
                case 'month':
                    $fechaInicio = (clone $fechaFin)->modify('first day of this month');
                    break;
                case 'year':
                    $fechaInicio = (clone $fechaFin)->modify('first day of January');
                    break;
                case 'range':
                    $fechaInicio = isset($_POST['start-date']) ? new DateTime($_POST['start-date'], new DateTimeZone('Europe/Madrid')) : null;
                    $fechaFin = isset($_POST['end-date']) ? new DateTime($_POST['end-date'], new DateTimeZone('Europe/Madrid')) : null;
                    break;
            }

            if (!$fechaInicio || !$fechaFin) {
                die('Fechas no válidas.');
            }

            // Carga los marcajes entre las fechas seleccionadas
            $datosMarcajes = $marcaje->cargarMarcajesEntreFechas($codEmpleado, $codEmpleado, $fechaInicio, $fechaFin);

            // Procesa los datos para la gráfica
            $horasPorDia = [];
            $periodo = new DatePeriod($fechaInicio, new DateInterval('P1D'), $fechaFin->modify('+1 day'));
            foreach ($periodo as $fecha) {
                $horasTrabajadasGrafica = $marcaje->calcularHorasTrabajadas($codEmpleado, $fecha);
                $fechaFormateada = $fecha->format('Y-m-d');
                $horasPorDia[$fechaFormateada] = $horasTrabajadasGrafica;
            }

            ksort($horasPorDia);
            $labels = array_keys($horasPorDia);
            $valores = array_values($horasPorDia);
        }
    } else {
        header('Location: login.php');
        exit();
    }

    if (in_array('Admin', $_SESSION['ROLES'])) {
        $admin = true;
    }

    if (in_array('Conserje', $_SESSION['ROLES'])) {
        header('Location: wellcome.php');
        exit();
    }
} else {
    header('Location: login.php');
    exit();
}