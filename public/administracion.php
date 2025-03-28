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
                </div>
            </div>

            <div id="dynamicContent">
                <h1>Bienvenido al Panel de Administración</h1>
            
            <!--Paneles de la página principal-->
            <!--Panel de datos del empleado administrador-->
            <div id="panelDatosAdmin" class="contenido" style="display: none;">
                
                <div class="contenido">
                <h2>Hora Actual</h2>
                <p id="current-time">Cargando...</p>

                <h2>Última Entrada/Salida</h2>
                <p>Empleado: Juan Pérez</p>
                <p>Hora: 08:45 AM</p>

                <h2>Foto del Empleado</h2>
                <img src="empleado.jpg" alt="Foto del Empleado" class="employee-photo">

                <h2>Tiempo Trabajado</h2>
                <p>Horas trabajadas hoy: 6h 30m</p>

                <h2>Gráfico de Asistencia</h2>
                <canvas id="attendanceChart"></canvas>
                </div>
                
            </div>
            <!--Paneles de incidencias-->
            <div id="panelIncidenciasPendientes" style="display: none;"></div>    
            <div id="panelIncidenciasResueltas" style="display: none;"></div>    
                <!--Subpanel ficha incidencia-->
            <div id="panelFichaIncidencia" style="display: none;"></div>
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
                        <div class="columna" style="flex:1;">
                            <label for="usuarioEmpleados">Usuario</label>
                            <input type="text" id="usuarioEmpleados">
                        </div>
                    </div>
        
                    <div class="fila">
                        <div class="columna" style="flex:3;">
                            <label for="nombreEmpleados">Nombre</label>
                            <input type="text" id="nombreEmpleados">
                        </div>
                        <div class="columna" style="flex:2;">
                            <label for="usuarioAltaEmpleados">Usuario alta</label>
                            <input type="text" id="usuarioAltaEmpleados">
                        </div>
                        <div class="columna" style="flex:1;">
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
                        <div class="columna" style="flex:1;">
                            <label for="horasEmpleados">Máx.horas</label>
                            <input type="number" id="horasEmpleados">
                        </div>
                        <div class="columna" style="flex:1;">
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
                    <label for="incluirBajaEmpelados">Incluir empelados de baja.</label>
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
