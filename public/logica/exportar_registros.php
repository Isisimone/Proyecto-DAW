<?php
// filepath: c:\xampp\htdocs\Proyecto-DAW\public\exportar_registros.php
require '../../vendor/autoload.php';
require 'empleado_datos.php'; // Asegúrate de que `$datosMarcajes` esté disponible

// Verifica el tipo de exportación solicitado
$tipo = $_GET['tipo'] ?? 'csv';

if ($tipo === 'csv') {
    // Exportar a CSV
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=registros.csv');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['Tipo de Marcaje', 'Tipo de Entrada', 'Fecha y Hora']);

    foreach ($datosMarcajes as $registro) {
        $tipoMarcaje = $registro['COD_TIPO_MARCAJE'] == 1 ? 'Entrada' : 'Salida';
        $metodoEntrada = match ($registro['COD_TIPO_ACCESO']) {
            1 => 'Facial',
            2 => 'RFID',
            3 => 'Manual',
            default => 'Desconocido'
        };
        $fechaHora = (new DateTime($registro['FEC_MARCAJE']))->format('Y-m-d H:i:s');
        fputcsv($output, [$tipoMarcaje, $metodoEntrada, $fechaHora]);
    }

    fclose($output);
    exit;
} elseif ($tipo === 'excel') {
    // Exportar a Excel utilizando HTML
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename=registros.xls');

    echo "<table border='1'>";
    echo "<tr><th>Tipo de Marcaje</th><th>Metodo de Entrada</th><th>Fecha y Hora</th></tr>";

    foreach ($datosMarcajes as $registro) {
        $tipoMarcaje = $registro['COD_TIPO_MARCAJE'] == 1 ? 'Entrada' : 'Salida';
        $metodoEntrada = match ($registro['COD_TIPO_ACCESO']) {
            1 => 'Facial',
            2 => 'RFID',
            3 => 'Manual',
            default => 'Desconocido'
        };
        $fechaHora = (new DateTime($registro['FEC_MARCAJE']))->format('Y-m-d H:i:s');

        echo "<tr>";
        echo "<td>{$tipoMarcaje}</td>";
        echo "<td>{$metodoEntrada}</td>";
        echo "<td>{$fechaHora}</td>";
        echo "</tr>";
    }

    echo "</table>";
    exit;
} elseif ($tipo === 'pdf'){
    // Exportar a PDF utilizando FPDF
    class PDF extends FPDF {
        // Encabezado del PDF
        function Header() {
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 10, 'Registros Detallados', 0, 1, 'C');
            $this->Ln(10);
        }

        // Pie de página del PDF
        function Footer() {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
        }
    }

    // Crear el PDF
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);

    // Encabezados de la tabla
    $pdf->Cell(50, 10, 'Tipo de Marcaje', 1);
    $pdf->Cell(50, 10, 'Metodo de Entrada', 1);
    $pdf->Cell(90, 10, 'Fecha y Hora', 1);
    $pdf->Ln();

    // Agregar los registros
    foreach ($datosMarcajes as $registro) {
        $tipoMarcaje = $registro['COD_TIPO_MARCAJE'] == 1 ? 'Entrada' : 'Salida';
        $metodoEntrada = match ($registro['COD_TIPO_ACCESO']) {
            1 => 'Facial',
            2 => 'RFID',
            3 => 'Manual',
            default => 'Desconocido'
        };
        $fechaHora = (new DateTime($registro['FEC_MARCAJE']))->format('Y-m-d H:i:s');

        $pdf->Cell(50, 10, $tipoMarcaje, 1);
        $pdf->Cell(50, 10, $metodoEntrada, 1);
        $pdf->Cell(90, 10, $fechaHora, 1);
        $pdf->Ln();
    }

    // Salida del PDF
    $pdf->Output('D', 'registros.pdf'); // 'D' fuerza la descarga
    exit;
}else {
    echo "Tipo de exportación no válido.";
    exit;
}