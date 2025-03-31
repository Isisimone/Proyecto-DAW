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

            if ($datos['accion']=='mostrar_empleado'){
                $empleado = new Empleado();
                $empleado->cargarDatosEmpleado($datos['cod_empleado']);
                $html= '<div class="fila">
                        <div class="columna" style="flex:1;">
                            <img src="./logica/mostrar_imagen.php?perfil=perfil&archivo='.$empleado->getFoto().'" width="100" id= "fotoEmpleado" height="100" class="rounded-circle me-2">
                        </div>
                        <div class="columna" style="flex:2;">
                            <label for="apellido1Empleado">1er apellido</label>
                            <input type="text" id="apellido1Empleado">
                        </div>
                        <div class="columna" style="flex:2;">
                            <label for="apellido2Empleado">2º apellido</label>
                            <input type="text" id="apellido2Empleado">
                        </div>
                        <div class="columna" style="flex:2;">
                            <label for="usuarioEmpleado">Usuario</label>
                            <input type="text" id="usuarioEmpleado">
                        </div>
                    </div>
        
                    <div class="fila">
                        <div class="columna" style="flex:4;">
                            <label for="nombreEmpleado">Nombre</label>
                            <input type="text" id="nombreEmpleado">
                        </div>
                        <div class="columna" style="flex:2;">
                            <label for="usuarioAltaEmpleado">Usuario alta</label>
                            <input type="text" id="usuarioAltaEmpleado">
                        </div>
                        <div class="columna" style="flex:1;">
                            <label for="fechaAltaEmpleado">Fec_alta</label>
                            <input type="date" id="fechaAltaEmpleado">
                        </div>
                    </div>
        
                    <div class="fila">
                        <div class="columna" style="flex:4;">
                            <label for="contactoEmpleado">Contacto</label>
                            <input type="text" id="contactoEmpleado">
                        </div>
                        <div class="columna" style="flex:2;">
                            <label for="usuarioBajaEmpleado">Usuario Baja</label>
                            <input type="text" id="usuarioBajaEmpleado">
                        </div>
                        <div class="columna" style="flex:1;">
                            <label for="fechaBajaEmpleado">Fecha Baja</label>
                            <input type="date" id="fechaBajaEmpleado">
                        </div>
                        
                    </div>
                    <div class="fila">
                        <div class="columna" style="flex:3;">
                            <label for="horarioEmpleado">Horario</label>
                            <input type="text" id="horarioEmpleado">
                        </div>
                        <div class="columna" style="flex:2;">
                            <label for="horasEmpleado">Máx.horas</label>
                            <input type="number" id="horasEmpleado">
                        </div>
                        <div class="columna" style="flex:2;">
                            <label for="bolsaEmpleado">Bolsa de horas</label>
                            <input type="text" id="bolsaEmpleado">
                        </div>
                        
                    </div>
                    <div>
                            <button class="btn btn-primary" id="guardarEmpleado">Guardar cambios</button>
                            <button class="btn btn-secondary" id="recalcularBolsa">Recalcular Bolsa</button>
                            <button class="btn btn-danger" id="bajaEmpelado">Dar de baja</button>
                        </div>';
                    header('Content-Type: text/html');
                    echo $html;
                    exit;
            } 

            if ($datos['accion']=='mostrar_usuario'){
                $usuario = new Usuario();
                $usuario->cargarUsuario($datos['cod_usuario']);
                $html= '<div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Código Usuario</label>
                                        <input type="text" class="form-control" value="'.$usuario->getCodUsuario().'" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Login</label>
                                        <input type="text" class="form-control" value="'.$usuario->getNomLogin().'">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Correo</label>
                                        <input type="email" class="form-control" value="'.$usuario->getDesCorreo().'">
                                    </div>
                                </div>
                                <button class="btn btn-primary" id="guardarUsuario">Guardar cambios</button>
                                <button class="btn btn-danger" id="bajaUsuario">Dar de baja</button>
                                <button class="btn btn-success" id="bioUsuario">Datos Biométricos</button>
                            </div>
                        </div>';
                    header('Content-Type: text/html');
                    echo $html;
                    exit;
            }


            if ($datos['accion']=='mostrar_transacciones'){
                $transaccion = new Transaccion();
                $transacciones = $transaccion->obtenerTransaccionesFiltradas(new DateTime($datos['desdeFecha']),new DateTime($datos['hastaFecha']),intval($datos['desdeUsuario']),intval($datos['hastaUsuario']),$datos['desdeActividad'],$datos['hastaActividad']);
                $html= '
                <ul class="marcoListados">
                    <li class="cabecera_trans">
                        <span class="">Fecha</span>
                        <span class="">Usuario</span>
                        <span class="">IP</span>
                        <span class="">Tipo</span>
                        <span class="">Descripción</span>
                        <span class="">Nombre Objeto</span>
                    </li>';
                foreach ($transacciones as $registro){
                $html=$html.'
                    <li class="linea_trans" data-id="'.$registro['COD_TRANSACCION'].'">
                        <span><b>'.$registro['FEC_SIS'].'</b></span>
                        <span>'.$registro['COD_USUARIO'].'</span>
                        <span>'.$registro['IP_USUARIO'].'</span>
                        <span>'.$registro['TIP_TRANS'].'</span>
                        <span>'.$registro['DESC_TRANS'].'</span>
                        <span>'.$registro['NOM_OBJ'].'</span>
                    </li>';
                };
                $html=$html.'</ul>';
                header('Content-Type: text/html');
                echo $html;
                exit;
            }

            if ($datos['accion']=='mostrar_marcajes'){
                $marcaje = new Marcaje();
                $marcajes = $marcaje->cargarMarcajesFiltro(intval($datos['desdeEmpleado']),intval($datos['hastaEmpleado']),new DateTime($datos['desdeFecha']),new DateTime($datos['hastaFecha']),$datos['desdeTipo'],$datos['hastaTipo']);
                $html= '
                <ul class="marcoListados">
                    <li class="cabecera_trans">
                        <span class="">Fecha</span>
                        <span class="">Empelado</span>
                        <span class="">Foto</span>
                        <span class="">Tipo</span>
                        <span class="">Observaciones</span>
                        <span class="">Pendiente</span>
                    </li>';
                foreach ($marcajes as $registro){
                $html=$html.'
                    <li class="linea_trans" data-id="'.$registro['COD_MARCAJE'].'">
                        <span><b>'.$registro['FEC_MARCAJE'].'</b></span>
                        <span>'.$registro['COD_EMPLEADO'].'</span>
                        <span><img src="./logica/mostrar_imagen.php?archivo='.$registro['DES_FOTO'].'" alt="Foto acceso" class="foto-acceso"></span>
                        <span>'.$registro['COD_TIPO_MARCAJE'].'</span>
                        <span>'.$registro['DES_OBSERVACIONES'].'</span>
                        <span>'.$registro['IND_PENDIENTE'].'</span>
                    </li>';
                };
                $html=$html.'</ul>';
                header('Content-Type: text/html');
                echo $html;
                exit;
            }
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
    ]);
}
