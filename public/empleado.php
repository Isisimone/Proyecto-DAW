<?php
date_default_timezone_set('Europe/Madrid');
//Carga la lógica de la página
require 'empleado_datos.php';

if (isset($_POST['registro_id'])) {
    solicitarRevision($codEmpleado,$_POST['comentario-fecha'],$_POST['comentario'],intval($_POST['prioridad']));
    unset($_POST['']);
}

//Defino la fecha de hoy
$fechaDiaHoy = (new DateTime('now', new DateTimeZone('Europe/Madrid')))->format('Y-m-d');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleado</title>
    <link rel="stylesheet" href="../css/empleado.css">
    <!--Scripts para la gráfica-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script>
    <!-- Contiene método para la gráfica y para cambiar los filtros-->
    <script src="../js/empleado.js"></script> 
</head>
<body>
    <!--Muestra el botón de administración si tiene el rol-->
    <?php if (isset($admin) && $admin): ?>
        <div style="position: absolute; top: 10px; right: 10px;">
            <a href="administracion.php" style="text-decoration: none; background-color: #007BFF; color: white; padding: 10px 15px; border-radius: 5px; font-size: 14px;">
                Administración
            </a>
        </div>
    <?php endif; ?>
    <!-- Título con el nombre del empleado -->
    <h1 id="employee-name"><?php echo htmlspecialchars($nombreCompleto); ?></h1>

    <!-- Contenedor principal con 3 secciones -->
    <div class="container">
        <!-- Sección izquierda: Horas trabajadas -->
        <div class="section" id="hours-worked">
            <h3>Horas trabajadas hoy</h3>
            <?php 
                $horas = floor($horasTrabajadas); // Parte entera de las horas
                $minutos = round(($horasTrabajadas - $horas) * 60); // Calcula los minutos
            ?>
            <p><?php echo $horas . ' horas y ' . $minutos . ' minutos'; ?></p>
            <h3>Horas trabajadas en la semana</h3>
            <?php 
                $horas = floor($horasSemanales); // Parte entera de las horas
                $minutos = round(($horasSemanales - $horas) * 60); // Calcula los minutos
            ?>
            <p><?php echo $horas . ' horas y ' . $minutos . ' minutos'; ?></p>
            <h3>Bolsa de horas acumuladas</h3>
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

        <!-- Sección central: Foto del empleado -->
        <div class="section" id="foto-empleado">
            <img class="foto" src="mostrar_imagen.php?perfil=perfil&archivo=<?php echo htmlspecialchars($fotoEmpleado); ?>" alt="Foto del empleado">
            <h3>Horario</h3>
            <p><?php echo $horario;?></p>
        </div>

        <!-- Sección derecha: Últimos accesos -->
        <div class="section" id="recent-accesses">
            <h3>Últimos 5 accesos</h3>
            <ul>
                <?php foreach ($ultimosMarcajes as $marcaje): ?>
                <?php 
                    // Obtiene solo la fecha del marcaje (sin la hora)
                    $fechaMarcaje = (new DateTime($marcaje['FEC_MARCAJE']))->format('Y-m-d');
                    $tipoClase = $marcaje['COD_TIPO_MARCAJE'] ==1 ? "tipoA":"tipoB";
                    // Verifica si la fecha del marcaje coincide con la fecha de hoy
                    $esHoy = ($fechaMarcaje === $fechaDiaHoy);
                ?>
                    <li class="acceso-item" style="color: <?php echo !$esHoy ? 'darkgrey' : 'inherit'; ?>;">
                        <span class="<?php echo $tipoClase;?>"><?php echo $marcaje['COD_TIPO_MARCAJE'] == 1 ? 'Entrada' : 'Salida'; ?></span>
                        <span class="fecha"><?php echo (new DateTime($marcaje['FEC_MARCAJE']))->format('Y-m-d H:i:s'); ?></span>
                        <span class="imagen">
                            <img class="foto_peque" src="mostrar_imagen.php?archivo=<?php echo htmlspecialchars($marcaje['DES_FOTO']); ?>" alt="Foto de fichaje">
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="incidencias-container">
        <div class="tabs">
            <button class="tab-button active" onclick="openTab(event, 'pendientes')">Pendientes</button>
            <button class="tab-button" onclick="openTab(event, 'resueltas')">Resueltas</button>
        </div>
        
        <div id="pendientes" class="tab-content" style="display:block;">
            <h4>Incidencias Pendientes</h4>
            <ul class="incidencias-list">
                <?php foreach ($incidenciasPendientes as $incidencia): ?>
                    <li class="incidencia-item prioridad-<?= strtolower($incidencia['PRIORIDAD']) ?>">
                        <span class="fecha"><?= htmlspecialchars($incidencia['FECHA_INC']) ?></span>
                        <span class="descripcion"><?= htmlspecialchars($incidencia['COMENTARIO']) ?></span>
                        <span class="prioridad"><?= htmlspecialchars($incidencia['PRIORIDAD']) ?></span>
                    </li>
                <?php endforeach; ?>
                <?php if (empty($incidenciasPendientes)): ?>
                    <li>No hay incidencias pendientes</li>
                <?php endif; ?>
            </ul>
        </div>
        
        <div id="resueltas" class="tab-content">
            <h4>Incidencias Resueltas</h4>
            <ul class="incidencias-list">
                <?php foreach ($incidenciasResueltas as $incidencia): ?>
                    <li class="incidencia-item resuelta">
                        <span class="fecha"><?= htmlspecialchars($incidencia['fecha']) ?></span>
                        <span class="descripcion"><?= htmlspecialchars($incidencia['descripcion']) ?></span>
                        <span class="resolucion"><?= htmlspecialchars($incidencia['solucion']) ?></span>
                    </li>
                <?php endforeach; ?>
                <?php if (empty($incidenciasResueltas)): ?>
                    <li>No hay incidencias resueltas</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    </div>
    <div class="contenedor-grafica-reg">
    <div class="chart-container">
    <!-- Contenedor para el filtro -->
    <div class="filter-container">
        <h3>Filtrar registros</h3>
        <form method="POST" action="empleado.php">
            <!--Opciones del combo-->
            <select id="filter-mode" name="filter-mode">
                <option value="week" <?php echo ($filtro === 'week') ? 'selected' : ''; ?>>Semana actual</option>
                <option value="lastweek" <?php echo ($filtro === 'lastweek') ? 'selected' : ''; ?>>Semana pasada</option>
                <option value="month" <?php echo ($filtro === 'month') ? 'selected' : ''; ?>>Mes actual</option>
                <option value="lastmonth" <?php echo ($filtro === 'lastmonth') ? 'selected' : ''; ?>>Mes anterior</option>
                <option value="year" <?php echo ($filtro === 'year') ? 'selected' : ''; ?>>Año actual</option>
                <option value="lastyear" <?php echo ($filtro === 'lastyear') ? 'selected' : ''; ?>>Año anterior</option>
                <option value="range" <?php echo ($filtro === 'range') ? 'selected' : ''; ?>>Entre fechas</option>
            </select>
                <!--Inputs para las fechas-->
            <input type="date" id="start-date" name="start-date" disabled>
            <input type="date" id="end-date" name="end-date" disabled>
                <!--Botón-->
            <button type="submit">Filtrar</button>
        </form>
    </div>

    <!-- Contenedor para la gráfica -->
    
        <canvas id="hours-chart"></canvas>
    <script>
        
        // Datos generados desde PHP
        toggleDateInputs();
        const labels = <?php echo json_encode($labels); ?>; // Fechas
        const data = <?php echo json_encode($valores); ?>; // Horas trabajadas
        const average = <?php echo array_sum($valores) / count($valores); ?>; // a usar en js
        const ausencias = <?php echo json_encode($ausencias); ?>;
        var todosMarcajes = <?php echo json_encode($datosMarcajes); ?>;
        renderChart(labels, data, ausencias, average,<?php echo $maxHoras;?>);
        
    </script>
    </div>
    <div> 
        <div class="cabeceraRegistros">
            <h3>Registros detallados</h3>
            <div>
                <a href="exportar_registros.php?tipo=csv" class="export-button">CSV</a>
                <a href="exportar_registros.php?tipo=excel" class="export-button">Excel</a>
                <a href="exportar_registros.php?tipo=pdf" class="export-button">PDF</a>
            </div>
        </div>
        <div class="registro">
            
        <ul>
        <li class="registro-header">
            <span class="col-fecha">Fecha</span>
            <span class="col-tipo">Tipo</span>
            <span class="col-fecha">Entrada</span>
            <span class="col-tipo">Tipo</span>
            <span class="col-fecha">Salida</span>
            <span class="col-incidencia">Incidencia</span>
            <span class="col-estado">Estado</span>
        </li>
            <?php foreach ($registrosDetallados as $index=>$registro): ?>
                <li data-id="<?php echo $index;?>" 
                data-fecha="<?php echo $registro['fecha'];?>">
                    <span class="fecha"><?php echo $registro['fecha']; ?></span>
                    <span class="metodo"><?php echo $registro['tipoAccesoEntrada']; ?></span>
                    <span class="hora"><?php echo $registro['horaEntrada']; ?></span>
                    <span class="metodo"><?php echo $registro['tipoAccesoSalida']; ?></span>
                    <span class="hora"><?php echo $registro['horaSalida']; ?></span>
                    <span class="incidencia"><?php echo $registro['incidencia']; ?></span>
                    <span class="estado"><?php echo $registro['estado']; ?></span>
                </li>
                <?php endforeach; ?>
                </ul>
                
            </div>
            <!--             Bloques ocultos             -->
            <!--Bloque menú contextual -->
            <div id="context-menu" class="context-menu">
                    <ul>
                        <li id="solicitar-revision">Solicitar revisión</li>
                        <li id="mostrar-datos">Mostrar datos</li>
                    </ul>
             </div>

             <!-- Bloque de Revisión -->
            <div id="bloque-revision" style="display: none;">
                <h3>Solicitar Revisión</h3>
                <form id="form-revision" method="post" action="empleado.php">
                    <input type="hidden" id="registro-id-revision" name="registro_id">
                    <div>
                        <label for="comentario-fecha">Fecha:</label>
                        <input id="comentario-fecha" name="comentario-fecha" readonly>
                    </div>
                    <div>
                        <label for="comentario-revision">Comentario:</label>
                        <textarea id="comentario-revision" name="comentario" required></textarea>
                    </div>
                    <div>
                        <label for="prioridad">Prioridad:</label>
                        <select id="prioridad" name="prioridad">
                            <option value="baja">Baja</option>
                            <option value="media">Media</option>
                            <option value="alta">Alta</option>
                        </select>
                    </div>
                    <button type="submit" name="SolRevision">Enviar Revisión</button>
                    <button type="button" id="cerrar-revision">Cancelar</button>
                </form>
            </div>

            <!-- Bloque de Mostrar Datos -->
            <div id="bloque-mostrardatos" style="display: none;">
                <h3>Detalles del Registro</h3>
                <div id="registro-id-datos"></div>
                <div class="detalles-registro" id="detalles-registro" data-fecha="<?= $datosMarcajes ?>">
                    <!-- Los datos se generarán dentro de este DIV-->
                </div>
                <button type="button" id="cerrar-mostrardatos">Cerrar</button>
            </div>
        </div>
    </div>

</body>
</html>