<?php
/**
 * Descarga la matrícula de un CUE Anexo como CSV (una fila por alumno).
 * Uso: exportar_matricula_csv.php?cueanexo=20244401&codigo_op=JNE1818
 * El nombre del archivo es <Codigo OP>_<fecha>_<cantidad>registros.csv.
 * Si no se pasa codigo_op, se deduce desde cues.json a partir del CUE Anexo.
 */

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/matricula.php';

$cueanexo = trim($_GET['cueanexo'] ?? '');
$codigoOp = strtoupper(trim($_GET['codigo_op'] ?? ''));
if ($cueanexo === '') {
    http_response_code(400);
    die('Falta el parámetro "cueanexo".');
}
if (!ctype_digit((string) $cueanexo)) {
    http_response_code(400);
    die('El CUE Anexo indicado no es válido ("' . $cueanexo . '"). No se puede realizar la consulta.');
}

$matricula = new Matricula(API_URL_MATRICULA, API_CLIENT_ID, API_SECRET, $cueanexo);
$rows = $matricula->fetchData();

if (!is_array($rows)) {
    http_response_code(502);
    die('Error: ' . $rows);
}

// Orden y etiquetas de columnas (mismo orden que la vista)
$columnas = [
    'nivel' => 'Nivel',
    'de' => 'Distrito',
    'dependencia_funcional' => 'Dependencia',
    'cue_anexo' => 'CUE Anexo',
    'establecimiento' => 'Establecimiento',
    'anio' => 'Año',
    'turno' => 'Turno',
    'jornada' => 'Jornada',
    'division' => 'División',
    'apellido' => 'Apellido',
    'nombre' => 'Nombre',
    'tipo_documento' => 'Tipo Doc.',
    'documento' => 'Documento',
    'fecha_nacimiento' => 'Fecha Nac.',
    'plan_estudio' => 'Plan de Estudio',
];

// Nombre del archivo: <Codigo OP>_<fecha>_<cantidad>registros.csv
$base = $codigoOp;
if ($base === '') {
    // Si no vino el Código OP, intentamos recuperarlo desde cues.json
    $cues = json_decode(file_get_contents(__DIR__ . '/../scripts/cues.json'), true);
    if (is_array($cues)) {
        $encontrado = array_search((string) $cueanexo, $cues, true);
        if ($encontrado !== false) {
            $base = $encontrado;
        }
    }
}
if ($base === '') {
    $base = $cueanexo;
}
$base = preg_replace('/[^0-9A-Za-z_-]/', '', $base);
$nombreArchivo = $base . '_' . date('Y-m-d') . '_' . count($rows) . 'registros.csv';

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');
header('Pragma: no-cache');
header('Expires: 0');

$out = fopen('php://output', 'w');

// BOM UTF-8 para que Excel muestre bien los acentos
fwrite($out, "\xEF\xBB\xBF");

// Excel en español abre mejor el CSV separado por ";"
fputcsv($out, array_values($columnas), ';');

foreach ($rows as $row) {
    $linea = [];
    foreach ($columnas as $clave => $etiqueta) {
        $valor = $row[$clave] ?? '';
        if ($clave === 'establecimiento') {
            $valor = trim((string) $valor);
        } elseif ($clave === 'fecha_nacimiento') {
            $valor = substr((string) $valor, 0, 10);
        }
        $linea[] = $valor;
    }
    fputcsv($out, $linea, ';');
}

fclose($out);
