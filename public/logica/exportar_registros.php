<?php
// filepath: c:\xampp\htdocs\Proyecto-DAW\public\exportar_registros.php
require($_SERVER['DOCUMENT_ROOT'] . '/Proyecto-DAW/vendor/autoload.php');
require($_SERVER['DOCUMENT_ROOT'] . '/Proyecto-DAW/public/logica/empleado_datos.php');

use Dompdf\Dompdf;

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del cuerpo de la solicitud POST
    $datos = isset($_POST['datos']) ? $_POST['datos'] : null;
    
    if ($datos) {
        // Decodificar si los datos vienen como JSON
        if ($_POST['tipo'] == 'csv') {
            $registros = is_string($datos) ? json_decode($datos, true) : $datos;
            // Configurar cabeceras para descarga CSV
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=exportacion_' . date('Y-m-d') . '.csv');
            // Crear el archivo de salida
            $output = fopen('php://output', 'w');
            // Escribir encabezados (asumiendo que todos los registros tienen la misma estructura)
            if (!empty($registros)) {
                fputcsv($output, array_keys($registros[0]));
                foreach ($registros as $registro) {
                    fputcsv($output, $registro);
                }
            }
            fclose($output);
            exit;
        } elseif ($_POST['tipo'] == 'xls') {
            $registros = is_string($datos) ? json_decode($datos, true) : $datos;
            $cabeceras = array_keys($registros[0]);
        
            // Exportar a Excel utilizando HTML
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename=registros.xls');
        
            echo "<table border='1'>";
            
            echo '<tr>';
            foreach ($cabeceras as $cabecera) {
                // Opcional: transformar nombres de campos a más legibles
                $nombreLegible = str_replace('_', ' ', ucfirst($cabecera));
                echo '<th>' . htmlspecialchars($nombreLegible) . '</th>';
            }
            echo '</tr>';
            foreach ($registros as $registro) {
                echo '<tr>';
                foreach ($cabeceras as $campo) {
                    echo '<td>' . htmlspecialchars($registro[$campo] ?? '') . '</td>';
                }
                echo '</tr>';
            }
            echo '</table>';
            exit;
        } elseif ($_POST['tipo'] == 'pdf') {
            /*$registros = is_string($datos) ? json_decode($datos, true) : $datos;
            $cabeceras = array_keys($registros[0]);*/
            if (!empty($registros)) {
                /*
                $html = '<h1>Registros Detallados</h1><table>';

                // Cabeceras
                $html .= '<tr>';
                foreach ($cabeceras as $cabecera) {
                    $html .= '<th style="background:#f2f2f2;padding:5px;">'.$cabecera.'</th>';
                }
                $html .= '</tr>';

                // Datos
                foreach ($registros as $fila) {
                    $html .= '<tr>';
                    foreach ($fila as $valor) {
                        $html .= '<td style="border:1px solid #ddd;padding:5px;">'.$valor.'</td>';
                    }
                    $html .= '</tr>';
                }
                $html .= '</table>';*/
                $html=is_string($datos) ? json_decode($datos, true) : $datos;

                $dompdf = new Dompdf();
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream("document.pdf");
                exit;
            }else {
                echo "Tipo de exportación no válido.";
                exit;
            }
   
        }

    } else {
        http_response_code(400);
        echo "Error: No se recibieron datos para exportar";
    }
} else {
    http_response_code(405);
    echo "Error: Método no permitido. Se requiere POST";
}

















