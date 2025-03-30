<?php
session_start();

// Verificar si la sesión es válida y tiene el rol requerido
if (empty($_SESSION['COD_USUARIO']) && in_array('Admin', $_SESSION['ROLES'])) {
    http_response_code(403); // Forbidden
    echo json_encode(['success' => false, 'error' => 'Acceso no autorizado']);
    exit;
}
header('Content-Type: application/json');
require '../../vendor/autoload.php';
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
        try {
            $datos = json_decode(file_get_contents('php://input'), true);
            
            // Validar datos recibidos
            if (empty($datos['accion'])) {
                throw new Exception('Acción no válida');
            }else{
                
                if ($datos['accion']=='actualizar_marcaje_incidencia'){
                $marcaje= new Marcaje();
                $marcaje->cargar($datos['cod_marcaje']);
                $marcaje->setCodEmpleado($datos['cod_empleado']);
                $marcaje->setFecMarcaje(new DateTime($datos['fec_marcaje']));
                $marcaje->grabar();

                $incidencia = new Incidencia();
                if (!$incidencia->cargar($datos['cod_incidencia'])) {
                    throw new Exception('Incidencia no encontrada'.$datos['cod_incidencia']);
                }
                $incidencia->setResuelta(true);
                $incidencia->setUsuario($datos['cod_usuario']);
                $incidencia->grabar();
           
            echo json_encode(['success' => true]);
            }
            
            if ($datos['accion']=='actualizar_incidencia'){
                $incidencia = new Incidencia();
                if (!$incidencia->cargar($datos['cod_incidencia'])) {
                    throw new Exception('Incidencia no encontrada'.$datos['cod_incidencia']);
                }
                $incidencia->setResuelta(true);
                $incidencia->setUsuario($datos['cod_usuario']);
                $incidencia->grabar();
            echo json_encode(['success' => true]);
            }
        }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
