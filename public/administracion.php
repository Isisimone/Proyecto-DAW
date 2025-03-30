<?php
date_default_timezone_set('Europe/Madrid');
//Carga la lógica de la página
require './logica/administracion_datos.php';

//Espacio para POST
//if (isset($_POST['registro_id'])) {
//    solicitarRevision($codEmpleado,$_POST['comentario-fecha'],$_POST['comentario'],intval($_POST['prioridad']));
//    unset($_POST['']);
//}

//Defino la fecha de hoy
$fechaDiaHoy = (new DateTime('now', new DateTimeZone('Europe/Madrid')))->format('Y-m-d');

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Admin</title>
    
    <!-- Favicon (Logo de la pestaña del navegador) -->
    <link rel="icon" href="../recursos/logo.png" type="image/png">

    <!-- Estilos -->
    <link rel="stylesheet" href="../css/admin_panel.css">

    <!-- Librería Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!--Librerías JS propias-->
    <script src="../js/admin_panel.js"></script>

    <!--Librerías de bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .combo {
        background-color:rgb(250, 250, 250); /* Morado */
        color: black;
    }

    .marcoListados{
        background-color: #fff;
        border-radius: 10px;
        box-shadow: inset 0 0 4px 1px rgba(0, 0, 0, 0.15);
        padding: 5px;
        border: 1px solid #f0f0f0; 
    }

    .enLinea{
        display: grid; 
        grid-template-columns: auto 1fr auto; 
        align-items: center; 
        gap: 10px;
    }
    .fila {
            display: flex;
            margin-bottom: 5px;
        }

    .fila_foto {
            display: flex;
            margin-bottom: 15px;
            gap: 10px;
        }
        
        .columna {
            padding-left: 10px;
            background-color: #fff;
            border-radius: 5px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input, select {
            width: 100%;
            padding: 2px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .bloque-mostrardatos {
            width: 80%;
            max-width: 500px;
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }

        .dashboard {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr; /* 3 columnas iguales */
      gap: 20px; /* Espacio entre columnas */
      max-width: 900px;
      margin: 0 auto;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Columna 1: Progreso y horas */
    .columna-progreso {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .barra-progreso {
      height: 20px;
      background: #e0e0e0;
      border-radius: 10px;
      overflow: hidden;
    }

    .progreso {
      height: 100%;
      background: #4CAF50;
      border-radius: 10px;
      animation: animacion-progreso 2s ease-in-out;
    }
    
    .foto_peque{
        width:50px;
        height: 50px;
    }
    @keyframes animacion-progreso {
      from { width: 0%; }
      to { width: 70%; }
    }

    .horas {
      text-align: center;
    }

    .horas h3, .bolsa h3 {
      margin: 0;
      color: #333;
    }

    .ventana {
        width: 80%;
        max-width: 500px;
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 0 15px rgba(0,0,0,0.2);
    }

    .horas p, .bolsa p {
      margin: 5px 0;
      font-size: 1.2em;
      font-weight: bold;
      color: #4CAF50;
    }

    /* Columna 2: Foto */
    .columna-foto {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .foto-empleado {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #4CAF50;
    }

    .foto-empleado-peque {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      object-fit: cover;
      border: 1px solid #4CAF50;
    }

    /* Columna 3: Nombre y horario */
    .columna-info {
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .nombre-empleado {
      font-size: 1.5em;
      font-weight: bold;
      margin-bottom: 10px;
      color: #333;
    }

    .horario {
      background: #f9f9f9;
      padding: 10px;
      border-radius: 5px;
      border-left: 4px solid #4CAF50;
    }

    .horario p {
      margin: 5px 0;
    }

    .tabs {
      max-width: 900px;
      margin: 0 auto;
      background: white;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    .tabs-header {
      display: flex;
      border-bottom: 1px solid #ddd;
    }

    .tab {
      padding: 12px 20px;
      cursor: pointer;
      background: #f9f9f9;
      border-right: 1px solid #ddd;
      font-weight: bold;
    }

    .tab.active {
      background: white;
      color: #d32f2f; /* Rojo para Pendientes */
      border-top: 3px solid #d32f2f;
    }

    .tab:nth-child(2).active {
      color: #1976D2; /* Azul para Completados */
      border-top: 3px solid #1976D2;
    }

    .tab-content {
      display: none;
      padding: 15px;
    }

    .tab-content.active {
      display: block;
    }

    /* Lista con scroll */
    .lista-tareas {
      max-height: 300px;
      overflow-y: auto;
      margin-top: 10px;
    }

    .fila-tarea {
      display: grid;
      grid-template-columns: 50px 1fr 100px 50px;
      align-items: center;
      padding: 10px;
      border-bottom: 1px solid #eee;
    }

    /* Estilos diferenciales por pestaña */
    #pendientes .fila-tarea:nth-child(odd) {
      background: #ffebee; /* Fondo rojo claro */
    }

    #completados .fila-tarea:nth-child(odd) {
      background: #e3f2fd; /* Fondo azul claro */
    }

    .prioridad {
      text-align: center;
      font-weight: bold;
      width: 24px;
      height: 24px;
      line-height: 24px;
      border-radius: 50%;
    }

    .prioridad-1 { background: #ffcdd2; color: #d32f2f; } /* Rojo */
    .prioridad-2 { background: #ffecb3; color: #ffa000; } /* Amarillo */
    .prioridad-3 { background: #c8e6c9; color: #388e3c; } /* Verde */

    .contenedor-empleado {
      max-width: 900px;
      margin: 0 auto;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Cabecera (foto + nombre + fecha) */
    .cabecera-empleado {
      display: flex;
      gap: 15px;
      align-items: center;
      margin-bottom: 15px;
    }

    .info-empleado {
      flex: 1;
    }

    .nombre-empleado {
      font-size: 1.3em;
      font-weight: bold;
      margin: 0;
    }

    .fecha-empleado {
      color: #666;
      margin: 5px 0 0 0;
    }

    /* Queja */
    .queja-empleado {
      background: #ffebee;
      padding: 12px;
      border-radius: 5px;
      margin-bottom: 20px;
      border-left: 4px solid #d32f2f;
    }

    /* Lista de eventos */
    .lista-eventos {
      max-height: 300px;
      overflow-y: auto;
      border: 1px solid #eee;
      border-radius: 5px;
    }

    .fila-evento {
      display: grid;
      grid-template-columns: 100px 1fr 60px;
      align-items: center;
      padding: 10px;
      border-bottom: 1px solid #eee;
    }

    .fila-evento:nth-child(odd) {
      background: #f9f9f9;
    }

    .tipo-evento {
      font-weight: bold;
      color: #1976D2;
    }

    .tipo-evento.salida {
      color: #d32f2f;
    }

    .fecha-evento {
      color: #555;
    }

    @media (max-width: 600px) {
  .dashboard {
    grid-template-columns: 1fr; /* 1 columna en móviles */
  }
}

.cerrar {
    position: absolute;
    top: 0px;
    right: 10px;
    background: none;
    border: none;
    font-size: 24px;
    color: #999;
    cursor: pointer;
    padding: 0px 0px;
    transition: color 0.3s;
}

.cerrar:hover {
    color: #333;
}

.contenedor-empleado {
    position: relative; /* Necesario para posicionar el botón correctamente */
}

.cabecera-empleado {
    position: relative; /* Contenedor para el botón de cerrar */
}
    </style>
    
</head>
<body>
    <div class="admin-panel-container">
        <!-- Barra de navegación -->
        <div class="navbar">
            <!-- Botón Principal -->
            <button class="nav-btn" id="menuPrincipal">Principal</button>

            <!-- Menú Admin -->
            <div class="nav-btn-container">
                <button class="nav-btn" id="menuAdmin">Admin</button>
                <div class="dropdown-content">
                    <a href="#" id="menuEmpleados"><button>Empleados</button></a>
                    <a href="#" id="menuUsuarios"><button>Usuarios</button></a>
                    <a href="#" id="menuMarcajes"><button>Marcajes</button></a>
                    <a href="#" id="menuTransacciones"><button>Transacciones</button></a>
                </div>
            </div>

            <!-- Menú Configuración -->
            <div class="nav-btn-container">
                <button class="nav-btn" id="menuConfiguracion">Configuración</button>
                <div class="dropdown-content">
                    <a href="#" id="menuRoles"><button>Roles</button></a>
                    <a href="#" id="menuUsuariosRoles"><button>Usuarios y Roles</button></a>
                    <a href="#" id="menuAjustes"><button>Ajustes</button></a>
                </div>
            </div>
            <button class="nav-btn" id="menuCerrar">Cerrar sesión</button>
        </div>

        <!-- Sección Principal con el Logo y mensaje de Bienvenida -->
        <div id="main" class="section">
            <div id="welcome-message">
                <div class="logo-container">
                    <img src="../recursos/logo.png" alt="Logo" class="logo">
                        <div id="current-time"></div>
                </div>
            </div>

            <div id="dynamicContent">
                <h1>Bienvenido al Panel de Administración</h1>
                <div id="current-time"></div>
            <!--Paneles de la página principal-->
            <!--Panel de datos del empleado administrador-->
            <div id="panelDatosAdmin" class="contenido" style="display: none;">
                
            <div class="dashboard">
                <!-- Columna 1: Progreso y horas -->
                <div class="columna-progreso">
                    <div class="barra-progreso">
                        <div class="progreso" style="width:<?php echo htmlspecialchars($progresoHorario); ?>%;"></div>
                    </div>
                    <div class="horas">
                        <h3>Horas trabajadas hoy</h3>
                        <?php 
                            $horas = floor($horasTrabajadas); // Parte entera de las horas
                            $minutos = round(($horasTrabajadas - $horas) * 60); // Calcula los minutos
                        ?>
                        <p><?php echo $horas . ' horas y ' . $minutos . ' minutos'; ?></p>
                    </div>
                    <div class="bolsa">
                        <h3>Bolsa acumulada</h3>
                        <?php 
                            $horas = intval($bolsa); // Parte entera de las horas
                            $minutos = abs(round(($bolsa - $horas) * 60)); // Calcula los minutos
                            //ajustamos si son negativos
                            if ($bolsa < 0 && $minutos > 0) {
                                $horas = $horas === 0 ? -1 : $horas; // Asegura que las horas sean negativas si es necesario
                                $minutos = -$minutos;
                            }
                        ?>
                        <p><?php echo $horas . ' horas y ' . $minutos . ' minutos '; ?></p>
                    </div>
                </div>

                <!-- Columna 2: Foto -->
                <div class="columna-foto">
                    <img src="./logica/mostrar_imagen.php?perfil=perfil&archivo=<?php echo htmlspecialchars($empleado->getFoto()); ?>" alt="Foto empleado" class="foto-empleado">
                </div>

                <!-- Columna 3: Nombre y horario -->
                <div class="columna-info">
                    <div class="nombre-empleado"><?php echo htmlspecialchars($empleado->getNombre()." ".$empleado->getApellido1()); ?></div>
                        <div class="horario">
                            <p><strong>Horario:</strong></p>
                            <p><?php echo htmlspecialchars($empleado->getHorario()); ?></p>
                        </div>
                    </div>
                </div>
                
            </div>
            <div></br></div>
            <!--Paneles de incidencias-->
            <div id="panelIncidenciasPendientes" style="display: none;">
                <div class="tabs">
                    <!-- Header de pestañas -->
                    <div class="tabs-header">
                        <div class="tab active" onclick="openTab('pendientes')">Pendientes</div>
                        <div class="tab" onclick="openTab('completados')">Completados</div>
                    </div>

                    <!-- Contenido de pestañas -->
                    <div id="pendientes" class="tab-content active">
                        <div class="lista-tareas">
                            <!-- Bucle incidencias pendientes -->
                            <?php foreach ($incidenciasPendientes as $incidenciaP): ?>
                                <?php $fotoIncidencia=pideFoto($incidenciaP['COD_EMPLEADO']);
                                    $empleadoIncidencia = pideNombre($incidenciaP['COD_EMPLEADO']);
                                    $marcajes=$marcaje->marcajesHoy($incidenciaP['COD_EMPLEADO'],new DateTime($incidenciaP['FECHA_INC']));
                                    $marcajesPorIncidencia[$incidenciaP['ID']] = $marcajes;
                                ?>
                                <div class="fila-tarea incidenciaP" data-id="<?php echo $incidenciaP['ID'];?>" data-foto="<?php echo htmlspecialchars($fotoIncidencia); ?>" data-nombre="<?php echo htmlspecialchars($empleadoIncidencia);?>">
                                
                                <img src="./logica/mostrar_imagen.php?perfil=perfil&archivo=<?php echo htmlspecialchars($fotoIncidencia); ?>" class="foto-empleado-peque">
                                <div><?php echo htmlspecialchars($empleadoIncidencia);?></div>
                                <div><?php echo htmlspecialchars($incidenciaP['FECHA_INC']);?></div>
                                <div class="prioridad prioridad-1">1</div>
                            </div>
                            <?php endforeach; ?>
                            <script>
                                const incidenciasP = <?php echo json_encode($incidenciasPendientes); ?>;
                                var marcajesPorIncidencia = <?php echo json_encode($marcajesPorIncidencia); ?>;
                            </script>
                            
                        </div>
                    </div>

                    <div id="completados" class="tab-content">
                        <div class="lista-tareas">
                            <!-- Bucle incidencias Resueltas -->
                            <?php foreach ($incidenciasResueltas as $incidenciaR): ?>
                            <div class="fila-tarea" data-id="<?php echo $incidenciaR['ID'];?>">
                            <?php $fotoIncidencia=pideFoto($incidenciaR['COD_EMPLEADO']);
                                    $empleadoIncidencia = pideNombre($incidenciaR['COD_EMPLEADO']);
                                ?>
                                <img src="./logica/mostrar_imagen.php?perfil=perfil&archivo=<?php echo htmlspecialchars($fotoIncidencia); ?>" class="foto-empleado-peque">
                                <div><?php echo htmlspecialchars($empleadoIncidencia);?></div>
                                <div><?php echo htmlspecialchars($incidenciaR['FECHA_INC']);?></div>
                                <div class="prioridad prioridad-3">3</div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>    
            <div id="panelIncidenciasResueltas" style="display: none;"></div>    
                <!--Subpanel ficha incidencia-->
            <div id="panelFichaIncidencia" class="ventana" style="display: none;">
                
            </div>
                <!--Subpanel Formulario de resolución-->
            <div id="panelFormularioResolucion" style="display: none;"></div>        
            <!--Panel de Entradas y salidas-->
            <div id="panelEntrasSalidas" style="display: none;"></div>    
                <!--Subpanel con datos del empleado-->
            <div id="panelDatosEmpleado" style="display: none;"></div>    
            <!--Paneles de la página Admin-->
            <!--Panel de Mantenimiento de empleados-->
            <div id="panelEmpleados" style="display: none;">
                <div class="contenido">
                <div class="d-flex align-items-center gap-2">
                        <!-- Dropdown Bootstrap -->
                        <div class="dropdown me-2">
                            <button class="btn btn-secondary combo dropdown-toggle" type="button" id="dropdownEmpleados" data-bs-toggle="dropdown">
                                Selecciona un empleado
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownEmpleados">
                                <?php foreach ($empleados as $empleado): ?>
                                <li>
                                    <a class="dropdown-item" href="#" data-cod="<?= $empleado['id'] ?>" onclick="seleccionarEmpleado(this)">
                                    <img src="<?= $empleado['foto'] ?>" width="30" height="30" class="rounded-circle me-2">
                                    <?= $empleado['nombre'] ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                            </ul>
                            <button id="modificarEmpleado" name="modificarEmpleado">Modificar</button>
                            <button id="nuevoEmpleado" name="nuevoEmpleado">Nuevo</button>
                            <button id="bajaEmpleado" name="bajaEmpleado">Dar de baja</button>
                        </div>
                    </div>
                    <form class="marcoListados">
                        <div class="fila">
                        <div class="columna" style="flex:1;">
                            <img src="<?= $empleados[0]['foto'] ?>" width="100" id= "fotoEmpleados" height="100" class="rounded-circle me-2">
                        </div>
                        <div class="columna" style="flex:2;">
                            <label for="apellido1Empleados">1er apellido</label>
                            <input type="text" id="apellido1Empleados">
                        </div>
                        <div class="columna" style="flex:2;">
                            <label for="apellido2Empleados">2º apellido</label>
                            <input type="text" id="apellido2Empleados">
                        </div>
                        <div class="columna" style="flex:2;">
                            <label for="usuarioEmpleados">Usuario</label>
                            <input type="text" id="usuarioEmpleados">
                        </div>
                    </div>
        
                    <div class="fila">
                        <div class="columna" style="flex:2;">
                            <label for="nombreEmpleados">Nombre</label>
                            <input type="text" id="nombreEmpleados">
                        </div>
                        <div class="columna" style="flex:2;">
                            <label for="usuarioAltaEmpleados">Usuario alta</label>
                            <input type="text" id="usuarioAltaEmpleados">
                        </div>
                        <div class="columna" style="flex:2;">
                            <label for="fechaAltaEmpleados">Fec_alta</label>
                            <input type="date" id="fechaAltaEmpleados">
                        </div>
                    </div>
        
                    <div class="fila">
                        <div class="columna" style="flex:4;">
                            <label for="contactoEmpleados">Contacto</label>
                            <input type="text" id="contactoEmpleados">
                        </div>
                        <div class="columna" style="flex:2;">
                            <label for="usuarioBajaEmpleados">Usuario Baja</label>
                            <input type="text" id="usuarioBajaEmpleados">
                        </div>
                        <div class="columna" style="flex:1;">
                            <label for="fechaBajaEmpleados">Fecha Baja</label>
                            <input type="date" id="fechaBajaEmpleados">
                        </div>
                        
                    </div>
                    <div class="fila">
                        <div class="columna" style="flex:2;">
                            <label for="horarioEmpleados">Horario</label>
                            <input type="text" id="horarioEmpleados">
                        </div>
                        <div class="columna" style="flex:2;">
                            <label for="horasEmpleados">Máx.horas</label>
                            <input type="number" id="horasEmpleados">
                        </div>
                        <div class="columna" style="flex:2;">
                            <label for="bolsaEmpleados">Bolsa de horas</label>
                            <input type="text" id="bolsaEmpleados">
                        </div>
                        <div class="columna" style="flex:1;">
                            <label for="botonRecalcularEmpleados"></label>
                            <button id="botonRecalcularEmpleados">Recalcular</button>
                        </div>
                    </div> 
                </form>
                <div class="enLinea">
                    <input type="checkbox" id="incluirBajaEmpelados" name="incluirBajaEmpelados" value="1">
                    <label for="incluirBajaEmpelados" style="text-align:left">Incluir empelados de baja.</label>
                    <button id="exportarEmpleados">Exportar</button>    
                </div>
                </div>    
            </div>
                <!--Subpanel Confirmar Baja-->
            <div id="panelConfirmarBaja" style="display: none;"></div>
                <!--Subpanel Exportar Empleados-->
            <div id="panelExportarEmpleados" style="display: none;"></div>
            <!--Panel de Mantenimiento de usuarios-->
            <div id="panelUsuarios" style="display: none;">
                <h2>Gestión de Usuarios</h2>
                <p>Aquí podrás agregar o eliminar usuarios del sistema.</p>
                <h3>Agregar Usuario</h3>
                <form id="add-user-form" method="POST" enctype="multipart/form-data">
                    <label for="user-name">Nombre:</label>
                    <input type="text" id="user-name" name="user-name" required>
                    <label for="user-photo">Foto (Escaneo Facial):</label>
                    <input type="file" id="user-photo" name="user-photo" accept="image/*" required>
                    <button type="submit" name="add-user">Agregar Usuario</button>
                </form>
                <h3>Eliminar Usuario</h3>
                <form id="delete-user-form" method="POST">
                    <label for="user-id">Seleccionar Usuario:</label>
                    <select id="user-id" name="user-id" required>
                        <option value="1">Juan Pérez</option>
                        <option value="2">María López</option>
                        <option value="3">Carlos García</option>
                    </select>
                    <button type="submit" name="delete-user">Eliminar Usuario</button>
                </form>
            </div>
                <!--Subpanel Mantenimiento Descriptores-->
            <div id="panelDescriptores" style="display: none;"></div>
                    <!--Subpanel Eliminar descriptor-->
            <div id="panelEliminarDescriptor" style="display: none;"></div>
                <!--Subpanel Exportar usuarios-->
            <div id="panelExportarUsuarios" style="display: none;"></div>
            <!--Panel Listado Transacciones-->
            <div id="panelListadoTransacciones" style="display: none;">
                <h2>Registro de Actividades</h2>
                <p>Aquí podrás ver un historial de las actividades registradas en el sistema.</p>
                <ul>
                    <li>Actividad 1: Registro de entrada de Juan Pérez - 08:00 AM</li>
                    <li>Actividad 2: Registro de salida de María López - 05:30 PM</li>
                    <li>Actividad 3: Registro de entrada de Carlos García - 09:00 AM</li>
                </ul>
            </div>
            <!--Panel Listado Marcajes-->
            <div id="panelListadoMarcajes" style="display: none;"></div>
            <!--Paneles de la página Configuración-->
            <!--Panel Mantenimiento de permisos por Rol-->
            <div id="panelRoles" style="display: none;">
                <h2>Gestión de Roles</h2>
                <p>Aquí podrás ver y gestionar los roles de los usuarios.</p>
                <ul>
                    <li><strong>Administrador</strong> - Acceso total al sistema.</li>
                    <li><strong>Empleado</strong> - Acceso limitado a tareas y registros.</li>
                    <li><strong>Supervisor</strong> - Acceso para supervisar a los empleados.</li>
                </ul>
            </div>
            <!--Panel listado usuarios asignados por Rol-->
            <div id="panelUsuariosAsigandos" style="display: none;"></div>
            <!--Panel de Mantenimiento de usuarios por rol-->
            <div id="panelAsignarRoles" style="display: none;">
                <h2>Asignación de Roles a Usuarios</h2>
                <p>Aquí podrás buscar usuarios y asignarles roles.</p>

                <div>
                    <label for="search-user">Buscar Usuario:</label>
                    <input type="text" id="search-user" placeholder="Buscar por nombre..." oninput="searchUser()">
                </div>

                <div id="search-results">
                    <p>No hay resultados.</p>
                </div>

                <h3>Asignar Rol</h3>
                <form id="assign-role-form" method="POST">
                    <label for="user-select">Seleccionar Usuario:</label>
                    <select id="user-select" name="user-select" required></select>

                    <label for="role-select"> Seleccionar Rol:</label>
                    <select id="role-select" name="role-select" required>
                        <option value="admin">Administrador</option>
                        <option value="empleado">Empleado</option>
                        <option value="supervisor">Supervisor</option>
                    </select>

                    <button type="submit" name="assign-role">Asignar Rol</button>
                </form>
            </div>
            <!--Panel de ajustes-->
            <div id="panelAjustes" style="display: none;"></div>
            </div>
        </div>
    </div>
    <!--Bootstrap para el dropdown con fotos de empleados-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
