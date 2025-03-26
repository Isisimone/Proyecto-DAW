<?php
date_default_timezone_set('Europe/Madrid');
//Carga la lógica de la página
require 'empleado_datos.php';
//Defino la fecha de hoy
$fechaDiaHoy = (new DateTime('now', new DateTimeZone('Europe/Madrid')))->format('Y-m-d');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
        }
        .container {
            display: flex;
            justify-content: space-between;
            width: 80%;
            margin-top: 20px;
        }
        .section {
            flex: 1;
            text-align: center;
            margin: 0 10px;
        }
        .section img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .filter-container {
            margin-top: 20px;
            text-align: center;
            width: 80%;
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }
        .filter-container select,
        .filter-container input,
        .filter-container button {
            margin: 10px;
            padding: 5px;
        }
        .contenedor-grafica-reg{
            display: flex; /* Alinea los elementos en fila */
            justify-content: space-between; /* Espaciado entre los elementos */
            align-items: flex-start; /* Alinea los elementos al inicio vertical */
            width: 90%; /* Ocupa todo el ancho disponible */
            margin-top: 20px;
            max-height: 400px;
        }
        .chart-container {
            flex: 2; /* Ocupa más espacio que los registros */
            max-width: 70%; /* Establece un ancho máximo */
            max-height:350px;
            
        }
        canvas {
            width: 100%;
            height: 400px;
        }
        .foto{
            width:150px;
            height: 150px;
        }
        .foto_peque{
            width:50px;
            height: 50px;
        }

        .registro {
            flex: 1;
            max-height: 300px; /* Altura máxima del contenedor */
            height:100%;
            overflow-y: auto; /* Habilita el scroll vertical */
            border: 1px solid #ccc; /* Borde para separar visualmente */
            padding: 10px;
            margin-left: 20px; /* Espaciado a la izquierda del gráfico */
            background-color: #f9f9f9; /* Fondo claro */
        }

    .registro h3 {
        margin-top: 0;
        text-align: center;
    }

    .registro ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .registro li {
        display: grid; /* Usa grid para organizar los elementos */
        grid-template-columns: 100px 100px 200px; /* Anchos fijos para cada columna */
        gap: 10px; /* Espaciado entre columnas */
        margin-bottom: 10px;
        font-size: 14px;
        line-height: 1.5;
    }

    span.tipoA {
        color: #007BFF; /* Color para el tipo de marcaje */
        font-weight: bold;
    }
    span.tipoB {
        color:rgb(5, 119, 19); /* Color para el tipo de marcaje */
        font-weight: bold;
    }

    .registro li span.metodo {
        color: #555; /* Color para el método de entrada */
        font-style: italic;
    }

    .registro li span.fecha {
        color: #333; /* Color para la fecha y hora */
    }

    .cabeceraRegistros {
        justify-content: space-between; /* Espaciado entre el encabezado y el formulario */
        align-items: center; /* Alinea verticalmente los elementos */
        margin-bottom: 10px; /* Espaciado inferior */
    }

    .cabeceraRegistros div{
        display: flex;
        width:50%;
        justify-content: space-between;
        margin: 10px;
    }

    .cabeceraRegistros h3 {
        margin: 0; /* Elimina el margen superior e inferior del encabezado */
    }

    .export-button {
        background-color: #007BFF;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .export-button:hover {
        background-color: #0056b3;
    }

    .accesos-lista {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .acceso-item {
        display: grid; /* Usa grid para organizar los elementos */
        grid-template-columns: 100px 200px 100px; /* Define anchos fijos para las columnas */
        gap: 10px; /* Espaciado entre columnas */
        align-items: center; /* Alinea verticalmente los elementos */
        margin-bottom: 0px;
        font-size: 14px;
        line-height: 1.5;
    }

    .acceso-item .fecha {
        color: #333; /* Color para la fecha y hora */
    }

    .acceso-item .imagen img {
        width: 50px;
        height: 40px;
        border-radius: 5px; /* Opcional: redondea las esquinas de la imagen */
    }
    
    </style>
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
     <!--Scripts para la gráfica-->
     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script>
    <!-- Contiene método para la gráfica y para cambiar los filtros-->
    <script src="../js/empleado-grafica.js"></script> 
    
 
    <script>
        
        // Datos generados desde PHP
        toggleDateInputs();
        const labels = <?php echo json_encode($labels); ?>; // Fechas
        const data = <?php echo json_encode($valores); ?>; // Horas trabajadas
        const average = <?php echo array_sum($valores) / count($valores); ?>; // a usar en js
        renderChart(labels, data, average,<?php echo $maxHoras;?>);
        
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
            <?php foreach ($datosMarcajes as $registro): ?>
                <li>
                    <?php 
                        // Determina el tipo de marcaje
                        $tipoMarcaje = $registro['COD_TIPO_MARCAJE'] == 1 ? 'Entrada' : 'Salida';
                        $tipoClase = $tipoMarcaje == "Entrada" ? "tipoA":"tipoB";
                        // Determina el método de entrada
                        $metodoEntrada = match ($registro['COD_TIPO_ACCESO']) {
                            1 => 'Facial',
                            2 => 'RFID',
                            3 => 'Manual',
                            default => 'Desconocido'
                        };
                        // Formatea la fecha y hora
                        $fechaHora = (new DateTime($registro['FEC_MARCAJE']))->format('Y-m-d H:i:s');
                    ?>
                    <span class="<?php echo $tipoClase;?>"><?php echo $tipoMarcaje; ?></span>
                    <span class="metodo"><?php echo $metodoEntrada; ?></span>
                    <span class="fecha"><?php echo $fechaHora; ?></span>
                </li>
                <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

</body>
</html>