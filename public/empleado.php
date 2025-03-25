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
        .chart-container {
            margin-top: 20px;
            width: 80%;
            max-width: 800px; /* Establece un ancho máximo */
            height: auto; /* Permite que la altura se ajuste automáticamente */
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
        </div>

        <!-- Sección central: Foto del empleado -->
        <div class="section" id="foto-empleado">
            <img class="foto" src="mostrar_imagen.php?perfil=perfil&archivo=<?php echo htmlspecialchars($fotoEmpleado); ?>" alt="Foto del empleado">
        </div>

        <!-- Sección derecha: Últimos accesos -->
        <div class="section" id="recent-accesses">
            <h3>Últimos 5 accesos</h3>
            <ul>
                <?php foreach ($ultimosMarcajes as $marcaje): ?>
                <?php 
                    // Obtiene solo la fecha del marcaje (sin la hora)
                    $fechaMarcaje = (new DateTime($marcaje['FEC_MARCAJE']))->format('Y-m-d');
                    // Verifica si la fecha del marcaje coincide con la fecha de hoy
                    $esHoy = ($fechaMarcaje === $fechaDiaHoy);
                ?>
                    <li style="color: <?php echo !$esHoy ? 'darkgrey' : 'inherit'; ?>;">
                        <?php echo $marcaje['COD_TIPO_MARCAJE'] == 1 ? 'Entrada' : 'Salida'; ?> - 
                        <?php echo (new DateTime($marcaje['FEC_MARCAJE']))->format('Y-m-d H:i:s'); ?>
                        <img class="foto_peque" src="mostrar_imagen.php?archivo=<?php echo htmlspecialchars($marcaje['DES_FOTO']); ?>" alt="Foto de fichaje">
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- Contenedor para el filtro -->
    <div class="filter-container">
        <h3>Filtrar registros</h3>
        <form method="POST" action="empleado.php">
            <!--Opciones del combo-->
            <select id="filter-mode" name="filter-mode">
                <option value="week" <?php echo ($filtro === 'week') ? 'selected' : ''; ?>>Última semana</option>
                <option value="month" <?php echo ($filtro === 'month') ? 'selected' : ''; ?>>Último mes</option>
                <option value="year" <?php echo ($filtro === 'year') ? 'selected' : ''; ?>>Último año</option>
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
    <div class="chart-container">
        <canvas id="hours-chart"></canvas>
    </div>
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
        renderChart(labels, data, average);
        
    </script>

</body>
</html>