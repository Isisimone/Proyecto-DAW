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
    /* Estilos base y tipografía */
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
        padding-top: 10px;
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
    /**FOTOS*/
    .foto_peque{
        width:50px;
        height: 50px;
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

    .foto_peque {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #eee;
    }

    .foto-acceso{
        width: 50px;
        height: 40px;
        border-radius: 5px;
    }
    /**Animaciones */
    @keyframes animacion-progreso {
      from { width: 0%; }
      to { width: 70%; }
    }
    /**Textos */
    .horas {
      text-align: center;
    }

    .horas p, .bolsa p {
      margin: 5px 0;
      font-size: 1.2em;
      font-weight: bold;
      color: #4CAF50;
    }

    .nombre-empleado {
      font-size: 1.5em;
      font-weight: bold;
      margin-bottom: 10px;
      color: #333;
    }

    .horario p {
      margin: 5px 0;
    }

    /**Títulos */
    .horas h3, .bolsa h3 {
      margin: 0;
      color: #333;
    }

    /**Ventanas y marcos */
    .ventana {
        position: fixed;
        top:50%;
        left:50%;
        width: 80%;
        transform: translate(-50%, -50%);
        max-width: 500px;
        background: white;
        border-radius: 8px;
        padding: 20px;
        z-index:1000;
        box-shadow: 0 0 15px rgba(0,0,0,0.2);
    }

    .horario {
      background: #f9f9f9;
      padding: 10px;
      border-radius: 5px;
      border-left: 4px solid #4CAF50;
    }

    /**Columnas*/
    .columna-foto {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .columna-info {
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    
    /**Pestañas*/
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



.dashboard-columnas {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 15px;
            max-width: 1200px;
            margin: 20px auto;
            padding: 15px;
        }
        
        .columna-estado {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .cabecera-columna {
            padding: 12px;
            font-weight: bold;
            text-align: center;
            border-radius: 10px 10px 0 0;
            color: white;
        }
        
        .sin-acceso .cabecera-columna {
            background-color: #d32f2f; /* Rojo */
        }
        
        .trabajando .cabecera-columna {
            background-color: #388e3c; /* Verde */
        }
        
        .fuera .cabecera-columna {
            background-color: #1976D2; /* Azul */
        }
        
        .lista-empleados {
            max-height: 500px;
            overflow-y: auto;
            padding: 10px;
        }
        
        /* Aprovechando tus estilos existentes */
        .fila_foto {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            gap: 10px;
            padding: 8px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        
        .fila_foto:hover {
            background-color: #f5f5f5;
        }
        
        
        .info-empleado {
            flex: 1;
        }
        
        .nombre-empleado {
            font-weight: bold;
            margin: 0;
            color: #333;
        }
        
        .apellido-empleado {
            color: #666;
            font-size: 0.9em;
            margin: 2px 0 0 0;
        }
        
        /* Scrollbar personalizada */
        .lista-empleados::-webkit-scrollbar {
            width: 6px;
        }
        
        .lista-empleados::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        
        .lista-empleados::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 3px;
        }
        
        .lista-empleados::-webkit-scrollbar-thumb:hover {
            background: #aaa;
        }

        .marcoListados {
        box-shadow: inset 0 0 4px 1px rgba(0, 0, 0, 0.15);
        border: 1px solid #f0f0f0;
        max-height: 300px;       /* Altura máxima */
        overflow-y: auto;        /* Scroll vertical cuando sea necesario */
        padding: 5px;           /* Manteniendo el padding original */
        background-color: #fff;  /* Manteniendo el fondo blanco */
        border-radius: 10px;     /* Manteniendo el borde redondeado */
    }
    .linea_trans {
        display: grid;
        gap: 10px;
        align-items: center;
        grid-template-columns: 20% 12% 12% 10% 23% 23%;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }
    .linea_roles {
        display: grid;
        gap: 10px;
        align-items: left;
        grid-template-columns: 250px 20px;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }
    .linea_Ajustes {
        display: grid;
        gap: 10px;
        align-items: left;
        grid-template-columns: 24% 50% 24%;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }
    .cabecera_trans{
        display: grid;
        gap: 10px;
        align-items: center;
        grid-template-columns: 20% 12% 12% 10% 23% 23%;
        padding: 10px;
        border-bottom: 1px solid #ddd;
        background-color: #333;
        color: white;
        font-weight: bold;
    }
    .linea_trans:nth-child(even) {
        background-color: #f2f2f2;
    }



    .formulario-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 15px;
    width: 100%;
}

.fila-grid {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    gap: 10px;
    width: 100%;
}

.fila-completa {
    grid-column: 1 / -1;
}

.fila-botones {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
}

/* Estilos comunes para inputs */
input[type="text"],
input[type="date"],
input[type="number"] {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
    border: 1px solid #ddd;
    border-radius: 4px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

    .contenedor-flex{
        display: flex;
        width: 100%;
        gap: 20px;
    }

    .columna-flex{
        flex: 1; 
        min-width: 0;
    }

    .columna-vertical{
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 10px;
    }

    #ventana_emergente, #ventana_emergente_mensaje {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

.emergente {
    background: white;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
}

.botonesSN {
    margin-top: 15px;
}

#botonSI, #botonNO, #botonACEPTAR {
    padding: 8px 16px;
    margin: 0 10px;
    cursor: pointer;
}

#botonSI {
    background: #4CAF50;
    color: white;
    border: none;
}

#botonACEPTAR {
    background:rgb(32, 153, 159);
    color: white;
    border: none;
}

#botonNO {
    background: #f44336;
    color: white;
    border: none;
}
    
    </style>
    
</head>
<body>
<script>
        //Variables generadas por administracion_datos
        const usuarioSesion = <?php echo $codUsuarioSesion;?>;
        const incidenciasP = <?php echo json_encode($incidenciasPendientes); ?>;
        
        const empleados = <?php echo json_encode($empleados); ?>; 
        //const usuario = <?php //echo json_encode($usuarios); ?>; 
        //const bios = <?php //echo json_encode($listaBios); ?>;
        //const transacciones = <?php //echo json_encode($transacciones); ?>; 
        //const marcajes = <?php //echo json_encode($marcajes); ?>; 
        console.log(incidenciasP);
    </script>

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

        <div id="dynamicContent" class="section">
            <h1>Bienvenido al Panel de Administración</h1>
            
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
            <div id="panelIncidencias" style="display: none;">
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
                            <div class="fila-tarea incidenciaP" data-id="<?php echo $incidenciaP['ID'];?>" data-foto="<?php echo htmlspecialchars($fotoIncidencia); ?>" 
                                data-nombre="<?php echo htmlspecialchars($empleadoIncidencia);?>" data-empleado="<?php echo $incidenciaP['COD_EMPLEADO'] ?>" 
                                data-fecha="<?php echo $incidenciaP['FECHA_INC']?>">
                                
                                <img src="./logica/mostrar_imagen.php?perfil=perfil&archivo=<?php echo htmlspecialchars($fotoIncidencia); ?>" class="foto-empleado-peque">
                                <div><?php echo htmlspecialchars($empleadoIncidencia);?></div>
                                <div><?php echo htmlspecialchars($incidenciaP['FECHA_INC']);?></div>
                                <div class="prioridad prioridad-1"><?php echo htmlspecialchars($incidenciaP['PRIORIDAD']);?></div>
                            </div>
                            <?php endforeach; ?>  
                            <script>const marcajesPorIncidencia = <?php echo json_encode($marcajesPorIncidencia); ?>;</script>                          
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
                <!--Subpanel ficha incidencia-->
            <div id="panelFichaIncidencia" class="ventana" style="display: none;"></div>
                <!--Subpanel Formulario de resolución-->
            <div id="panelFormularioResolucion" class = "ventana" style="display: none;">     
                <button class="cerrar" aria-label="Cerrar ventana">&times;</button>
                <form>
                    <div class="campo-formulario">
                        <label for="cod_marcaje">COD_MARCAJE:</label>
                        <input type="text" id="resolucionCod" name="cod_marcaje" readonly>
                    </div>
                    <div class="campo-formulario">
                        <select name="empleado" id="resolucionEmpleado" class="form-select" required>
                        <?php if (!empty($empleados)): ?>
                        <?php foreach ($empleados as $empleado): ?>
                            <?php 
                            $codigo = htmlspecialchars($empleado['COD_EMPLEADO'] ?? '');
                            $nombreCompleto = htmlspecialchars(
                                trim(($empleado['NOM_EMPLEADO'] ?? '') . ' ' . 
                            ($empleado['APE1_EMPLEADO'] ?? ''))
                            );
                            ?>
                            <option value="<?php echo $codigo; ?>">
                                <?php echo $nombreCompleto; ?>
                            </option>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <option value="" disabled>No hay empleados disponibles</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="campo-formulario">
                        <label for="fec_marcaje">FEC_MARCAJE:</label>
                        <input id="resolucionFecha" name="fec_marcaje">
                    </div>
    
                    <button id="resolucionG" aria-label="Guardar modificación">Guardar</button>
                </form>
            </div>
            <!--Panel de Entradas y salidas-->
            <div id="panelEntrasSalidas" style="display: none;">
                <div class="dashboard-columnas">
                    <div class="columna-estado sin-acceso marcoListados">
                        <div class="cabecera-columna">Sin acceso</div>
                        <div class="lista-empleados">
                            <?php foreach($empleadosAusentes as $asistente):?>
                            <div class="fila_foto">
                                <img src="./logica/mostrar_imagen.php?perfil=perfil&archivo=<?php echo htmlspecialchars($asistente['FOTO']); ?>" alt="Foto empleado" class="foto-empleado-peque">
                                <div class="info-empleado">
                                    <p class="nombre-empleado"><?php echo $asistente['NOM_EMPLEADO'];?></p>
                                    <p class="apellido-empleado"><?php echo $asistente['APE1_EMPLEADO']." ".$asistente['APE2_EMPLEADO'];?></p>
                                </div>
                            </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <div class="columna-estado trabajando marcoListados">
                        <div class="cabecera-columna">Trabajando</div>
                        <div class="lista-empleados">
                        <?php foreach($empleadosDentro as $asistente):?>
                            <div class="fila_foto">
                                <img src="./logica/mostrar_imagen.php?perfil=perfil&archivo=<?php echo htmlspecialchars($asistente['FOTO']); ?>" alt="Foto empleado" class="foto-empleado-peque">
                                <div class="info-empleado">
                                    <p class="nombre-empleado"><?php echo $asistente['NOM_EMPLEADO'];?></p>
                                    <p class="apellido-empleado"><?php echo $asistente['APE1_EMPLEADO']." ".$asistente['APE2_EMPLEADO'];?></p>
                                </div>
                            </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <div class="columna-estado fuera marcoListados">
                        <div class="cabecera-columna">Fuera</div>
                        <div class="lista-empleados">
                        <?php foreach($empleadosFuera as $asistente):?>
                            <div class="fila_foto">
                                <img src="./logica/mostrar_imagen.php?perfil=perfil&archivo=<?php echo htmlspecialchars($asistente['FOTO']); ?>" alt="Foto empleado" class="foto-empleado-peque">
                                <div class="info-empleado">
                                    <p class="nombre-empleado"><?php echo $asistente['NOM_EMPLEADO'];?></p>
                                    <p class="apellido-empleado"><?php echo $asistente['APE1_EMPLEADO']." ".$asistente['APE2_EMPLEADO'];?></p>
                                </div>
                            </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </div>    
                <!--Subpanel con datos del empleado-->
            <div id="panelDatosEmpleado" style="display: none;"></div>    
            <!--Paneles de la página Admin-->
            <!--Panel de Mantenimiento de empleados-->
            <div id="panelEmpleados" style="display: none;">
                <div class="contenido">
                    <div>
                        <div style="display: flex; gap:10px;height:50px;">
                            <select name="empleado" id="seleccionPanelEmpleado" style="width:250px;" class="form-select" required>
                            <?php if (!empty($empleados)): ?>
                                <?php foreach ($empleados as $empleado): ?>
                                    <?php 
                                        $codigo = htmlspecialchars($empleado['COD_EMPLEADO'] ?? '');
                                        $nombreCompleto = htmlspecialchars(
                                trim(($empleado['NOM_EMPLEADO'] ?? '') . ' ' . 
                                        ($empleado['APE1_EMPLEADO'] ?? '').' '.
                                        ($empleado['APE2_EMPLEADO'] ?? ''))
                                        );
                                    ?>
                                        <option value="<?php echo $codigo; ?>">
                                            <?php echo $nombreCompleto; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="" disabled>No hay empleados disponibles</option>
                                <?php endif; ?>
                            </select>
                            <button id="nuevoEmpleado" name="nuevoEmpleado">Nuevo</button>
                        </div>
                    </div>
                    <div class="contenido" id="formularioEmpleado">
                         
                    </div>
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
                <div class="contenido">
                    <div>
                        <div style="display: flex; gap:10px;height:50px;">
                            <select name="usuario" id="seleccionPanelUsuario" style="width:250px;" class="form-select" required>
                            <?php if (!empty($usuarios)): ?>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <?php 
                                        $codigo = htmlspecialchars($usuario['COD_USUARIO'] ?? '');
                                        $nombreUsuario = $usuario['NOM_LOGIN'];
                                    ?>
                                        <option value="<?php echo $codigo; ?>">
                                            <?php echo $nombreUsuario; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="" disabled>No hay usuarios disponibles</option>
                                <?php endif; ?>
                            </select>
                            <button id="nuevoUsuario" name="nuevoUsuario">Nuevo</button>
                        </div>
                    </div>
                    <div class="contenido" id="formularioUsuario">
                         
                    </div>
                    <div class="enLinea">
                        <input type="checkbox" id="incluirBajaUsuarios" name="incluirBajaUsuarios" value="1">
                        <label for="incluirBajaUsuarios" style="text-align:left">Incluir usuarios de baja.</label>
                        <button id="exportarUsuarios">Exportar</button>    
                    </div>
                </div> 
            
            </div>
                <!--Subpanel Mantenimiento Descriptores-->
            <div id="panelDescriptores" style="display: none;"></div>
                    <!--Subpanel Eliminar descriptor-->
            <div id="panelEliminarDescriptor" style="display: none;"></div>
                <!--Subpanel Exportar usuarios-->
            <div id="panelExportarUsuarios" style="display: none;"></div>
            <!--Panel Listado Transacciones-->
            <div id="panelListadoTransacciones" style="display: none;">
                <div class="contenedor container py-5">
                    <h1 class="mb-4">Transacciones</h1>
                    <div class="row g-4">
                        <!-- Filtros de Fecha -->
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="fechaInicioTrans" class="form-label">Desde Fecha</label>
                                <input type="date" id="fechaInicioTrans" name="fechaInicioTrans" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="usuarioInicioTrans" class="form-label">Desde Usuario</label>
                                <input type="numeric" id="usuarioInicioTrans" name="usuarioInicioTrans" class="form-control" value="0">
                            </div>
                            <div class="col-md-4">
                                <label for="actividadInicioTrans" class="form-label">Desde Actividad</label>
                                <input type="text" id="actividadInicioTrans" name="actividadInicioTrans" class="form-control" value="">
                            </div>
                            <div class="col-md-1">
                                
                            </div>
                        </div>    
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="fechaFinTrans" class="form-label">Hasta Fecha</label>
                                <input type="date" id="fechaFinTrans" name="fechaFinTrans" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="usuarioFinTrans" class="form-label">Hasta Usuario</label>
                                <input type="numeric" id="usuarioFinTrans" name="usuarioFinTrans" class="form-control" value="9999">
                            </div>
                            <div class="col-md-4">
                                <label for="actividadFinTrans" class="form-label">Hasta Actividad</label>
                                <input type="text" id="actividadFinTrans" name="actividadFinTrans" class="form-control" value="ZZZZZZZZZZZZZ">
                            </div>
                            <div class="col-md-1">
                                <button id="filtrarTransacciones" class="btn btn-primary">Filtrar</button>
                            </div>
                        </div>
                            
                    </div>
                </div>
                <div class="contenedor" id="listaTransacciones"></div>                   
            </div>
            <!--Panel Listado Marcajes-->
            <div id="panelListadoMarcajes" style="display: none;">
                <div class="contenedor container py-5">
                    <h1 class="mb-4">Marcajes</h1>
                    <div class="row g-4">
                        <!-- Filtros de Fecha -->
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="fechaInicioMarcaje" class="form-label">Desde Fecha</label>
                                <input type="date" id="fechaInicioMarcaje" name="fechaInicioMarcaje" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="empleadoInicioMarcaje" class="form-label">Desde Empleado</label>
                                <input type="numeric" id="empleadoInicioMarcaje" name="empleadoInicioMarcaje" class="form-control" value="0">
                            </div>
                            <div class="col-md-4">
                                <label for="tipoInicioMarcaje" class="form-label">Desde Tipo</label>
                                <input type="text" id="tipoInicioMarcaje" name="tipoInicioMarcaje" class="form-control" value="0">
                            </div>
                            <div class="col-md-1">
                                
                            </div>
                        </div>    
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="fechaFinMarcaje" class="form-label">Hasta Fecha</label>
                                <input type="date" id="fechaFinMarcaje" name="fechaFinMarcaje" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="empleadoFinMarcaje" class="form-label">Hasta Empleado</label>
                                <input type="numeric" id="empleadoFinMarcaje" name="empleadoFinMarcaje" class="form-control" value="999">
                            </div>
                            <div class="col-md-4">
                                <label for="tipoFinMarcaje" class="form-label">Hasta Tipo</label>
                                <input type="numeric" id="tipoFinMarcaje" name="tipoFinMarcaje" class="form-control" value="99">
                            </div>
                            <div class="col-md-1">
                                <button id="filtrarMarcajes" class="btn btn-primary">Filtrar</button>
                            </div>
                        </div>
                            
                    </div>
                </div>
                <div class="contenedor" id="listaMarcajes"></div>                   
            </div>
            <!--Paneles de la página Configuración-->
            <!--Panel Mantenimiento de permisos por Rol-->
            <div id="panelRoles" style="display: none;">
                <div class="contenido">
                    <div>
                        <div style="display: flex; gap:10px;height:50px;">
                            <select name="seleccionRol" id="seleccionRol" style="width:250px;" class="form-select" required>
                            <?php if (!empty($roles)): ?>
                                <?php foreach ($roles as $rol): ?>
                                    <?php 
                                        // Verificar si el rol NO está dado de baja (FEC_BAJA es NULL)
                                        if ($rol['FEC_BAJA'] === null) {
                                            $codigo = $rol['COD_ROL'];
                                            $nombreRol = $rol['NOM_ROL'];
                                    ?>
                                    <option value="<?php echo $codigo; ?>">
                                        <?php echo $nombreRol; ?>
                                    </option>
                                    <?php } ?>
                                <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="" disabled>No hay roles disponibles</option>
                                <?php endif; ?>
                            </select>
                            <button id="nuevoRol" name="nuevoRol">Nuevo</button>
                        </div>
                    </div>
                    <div id="datosRol">
                         
                    </div>
                </div> 
            </div>
            <!--Panel de Mantenimiento de usuarios por rol-->
            <div id="panelAsignarRoles" style="display: none;">
                <div class="contenido">
                    <div style="display: flex; gap:10px;height:50px;">
                        <select name="seleccionUsuarioRol" id="seleccionUsuarioRol" style="width:250px;" class="form-select" required>
                            <?php if (!empty($usuarios)): ?>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <?php 
                                        $codigo = $usuario['COD_USUARIO'] ?? 0;
                                        $nombreLogin = $usuario['NOM_LOGIN']??'';
                                    ?>
                                        <option value="<?php echo $codigo; ?>">
                                            <?php echo $nombreLogin; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="" disabled>No hay usuarios disponibles</option>
                                <?php endif; ?>
                        </select>
                    </div>
                    <div id="datosUsuarioRol">

                    </div>
                </div> 
            </div>
            <!--Panel de ajustes-->
            <div id="panelAjustes" style="display: none;"></div>
            <!--Ventana de confirmación-->
            <div id="ventana_emergente" style="display: none;">
                <div class="emergente">
                    <p id="mensaje_confirmacion"></p>
                    <div class="botonesSN">
                        <button id="botonSI">Sí</button>
                        <button id="botonNO">No</button>
                    </div>
                </div>
            </div>
            <!--Ventana de mensajes-->
            <div id="ventana_emergente_mensaje" style="display: none;">
                <div class="emergente">
                    <p id="mensaje_info"></p>
                    <div class="botonesSN">
                        <button id="botonACEPTAR">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!--Bootstrap para el dropdown con fotos de empleados-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>
