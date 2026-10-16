<?php
/**
 * Exporta la matrícula de TODOS los CUE Anexo presentes en cues.json (masivo).
 * Para cada código OP con CUE numérico válido, consulta la API y agrega la columna "Codigo OP".
 * Genera un único CSV con todos los alumnos.
 */

set_time_limit(0);
ini_set('max_execution_time', '0');
ini_set('default_socket_timeout', '300');
ini_set('memory_limit', '-1');

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/matricula.php';

$cuesPath = __DIR__ . '/../scripts/cues.json';
$cues = json_decode(file_get_contents($cuesPath), true);
if (!is_array($cues)) {
    http_response_code(500);
    die('No se pudo leer cues.json');
}

// Filtrar solo códigos con CUE numérico
$items = [];
foreach ($cues as $codigoOp => $cueanexo) {
    $cueanexoStr = trim((string) $cueanexo);
    if ($cueanexoStr === '') {
        continue;
    }
    // Solo CUE numérico
    if (!ctype_digit($cueanexoStr)) {
        continue;
    }
    $items[] = [
        'codigo_op' => strtoupper((string) $codigoOp),
        'cueanexo'  => $cueanexoStr,
    ];
}

// Ordenar por código OP
usort($items, function ($a, $b) {
    return strcmp($a['codigo_op'], $b['codigo_op']);
});

// Traer todos los registros
$allRows = [];
$totalConsultas = 0;
$errores = [];

foreach ($items as $item) {
    $totalConsultas++;
    $matricula = new Matricula(API_URL_MATRICULA, API_CLIENT_ID, API_SECRET, $item['cueanexo']);
    $rows = $matricula->fetchData(180, 60);
    if (!is_array($rows)) {
        // Guardar error pero continuar
        $errores[] = $item['codigo_op'] . ' (' . $item['cueanexo'] . '): ' . $rows;
        continue;
    }
    foreach ($rows as $row) {
        // Agregar columna Codigo OP
        $row['codigo_op'] = $item['codigo_op'];
        $allRows[] = $row;
    }
}

// Columnas: agregar Codigo OP al inicio o mantener orden existente y agregar al final? Pedido: agregar columna del Codigo OP correspondiente
// Mantener estructura similar a vista/export actual + columna Codigo OP
$columnasBase = [
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
$columnas = $columnasBase;
$columnas = array_merge(['codigo_op' => 'Codigo OP'], $columnas);

// Nombre del archivo
$n = count($allRows);
$fecha = date('Y-m-d');
$nombreArchivo = 'matricula_masiva_' . $fecha . '_' . $n . 'registros.csv';

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');
header('Pragma: no-cache');
header('Expires: 0');

$out = fopen('php://output', 'w');
fwrite($out, "\xEF\xBB\xBF");
fputcsv($out, array_values($columnas), ';');

foreach ($allRows as $row) {
    $linea = [];
    foreach ($columnas as $clave => $etiqueta) {
        $valor = $row[$clave] ?? '';
        if ($clave === 'establecimiento') {
            $valor = trim((string) $valor);
        } elseif ($clave === 'fecha_nacimiento') {
            $valor = substr((string) $valor, 0, 10);
        } elseif ($clave === 'codigo_op') {
            $valor = strtoupper((string) $valor);
        }
        $linea[] = $valor;
    }
    fputcsv($out, $linea, ';');
}

fclose($out);
