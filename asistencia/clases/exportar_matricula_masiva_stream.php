<?php
/**
 * Exportación masiva con streaming: no acumula todos los registros en memoria.
 * Recorre todos los CUEs numéricos, consulta API, agrega columna Codigo OP y escribe directo al CSV.
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

// Filtrar CUEs numéricos
$items = [];
foreach ($cues as $codigoOp => $cueanexo) {
    $cueanexoStr = trim((string) $cueanexo);
    if ($cueanexoStr === '') {
        continue;
    }
    if (!ctype_digit($cueanexoStr)) {
        continue;
    }
    $items[] = [
        'codigo_op' => strtoupper((string) $codigoOp),
        'cueanexo'  => $cueanexoStr,
    ];
}
usort($items, function ($a, $b) {
    return strcmp($a['codigo_op'], $b['codigo_op']);
});

// Columnas
$columnas = [
    'codigo_op' => 'Codigo OP',
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

// Headers
$nTotal = 0;
$fecha = date('Y-m-d');
$nombreArchivo = 'matricula_masiva_' . $fecha . '_streaming.csv';

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');
header('Pragma: no-cache');
header('Expires: 0');

$out = fopen('php://output', 'w');
fwrite($out, "\xEF\xBB\xBF");
fputcsv($out, array_values($columnas), ';');

// Procesar cada CUE
foreach ($items as $item) {
    $matricula = new Matricula(API_URL_MATRICULA, API_CLIENT_ID, API_SECRET, $item['cueanexo']);
    $rows = $matricula->fetchData(180, 60);
    if (!is_array($rows)) {
        continue; // saltar errores
    }
    foreach ($rows as $row) {
        $linea = [];
        foreach ($columnas as $clave => $etiqueta) {
            if ($clave === 'codigo_op') {
                $linea[] = $item['codigo_op'];
                continue;
            }
            $valor = $row[$clave] ?? '';
            if ($clave === 'establecimiento') {
                $valor = trim((string) $valor);
            } elseif ($clave === 'fecha_nacimiento') {
                $valor = substr((string) $valor, 0, 10);
            }
            $linea[] = $valor;
        }
        fputcsv($out, $linea, ';');
        $nTotal++;
    }
    // flush periódico opcional (no necesario con php://output)
}

fclose($out);
