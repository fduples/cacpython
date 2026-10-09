<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/presentismoMensual.php';
require_once __DIR__ . '/matricula.php';
require_once __DIR__ . '/fpdf.php';

if (isset($_GET['cueanexo'], $_GET['anio'], $_GET['mes'])) {
    $cueanexo = $_GET['cueanexo'];
    $anio = $_GET['anio'];
    $mes = $_GET['mes'];
    $presentismoMensual = new PresentismoMensual(API_URL_PRESENTISMO, API_CLIENT_ID, API_SECRET, $cueanexo, $anio, $mes);
    $dataMensual = $presentismoMensual->fetchMonthlyData();
    $matricula = new Matricula(API_URL_MATRICULA, API_CLIENT_ID, API_SECRET, $cueanexo);
    $rows = $matricula->fetchData();
    
    if (is_array($rows)) {
        $escuela = $matricula->getEstablecimiento($rows);
        if (!is_array($escuela)) {
            die("Error: " . $escuela);
        }
    } else {
        die("Error: " . $rows); // detengo la ejecución si hay un error
    }
} else {
    die("No se proporcionaron los parámetros necesarios.");
}

// Crear un nuevo documento PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Título del PDF
$pdf->Cell(0, 10, 'Asistencia mes de' . $mes . ' de ' . $anio, 0, 1, 'C');
$pdf->Ln(10);

// Información de la Escuela
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 10, 'Escuela: ', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 10, $escuela['establecimiento'], 0, 1);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 10, 'Distrito: ', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 10, $escuela['de'], 0, 1);
$pdf->Ln(10);

// Encabezados de tabla
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(30, 10, 'Fecha', 1);
$pdf->Cell(40, 10, 'Jornada', 1);
$pdf->Cell(30, 10, 'Matriculados', 1);
$pdf->Cell(30, 10, 'Presentes', 1);
$pdf->Cell(30, 10, 'Ausentes', 1);
$pdf->Cell(30, 10, 'Sin registrar', 1);
$pdf->Ln();

// Contenido de la tabla
$pdf->SetFont('Arial', '', 10);
foreach ($dataMensual as $fecha => $jornadas) {
    foreach ($jornadas as $jornada => $datos) {
        $pdf->Cell(30, 10, $fecha, 1);
        $pdf->Cell(40, 10, $jornada, 1);
        $pdf->Cell(30, 10, $datos['matriculados'], 1);
        $pdf->Cell(30, 10, $datos['presente'], 1);
        $pdf->Cell(30, 10, $datos['ausente'], 1);
        $pdf->Cell(30, 10, $datos['sincarga'], 1);
        $pdf->Ln();
    }
}

// Salida del archivo PDF
$pdf->Output('D', 'Reporte_Presentismo_Mensual.pdf');

