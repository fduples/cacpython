<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../clases/matricula.php';

$cueanexo = trim($_GET['cueanexo'] ?? '');
$codigoOp = strtoupper(trim($_GET['codigo_op'] ?? ''));
$error = null;
$rows = null;

// Resolver Código OP -> CUE Anexo si no se cargó el CUE directamente
$cues = json_decode(file_get_contents(__DIR__ . '/../scripts/cues.json'), true);
if (!is_array($cues)) {
    $cues = [];
}

if ($codigoOp !== '' && $cueanexo === '') {
    if (isset($cues[$codigoOp])) {
        $cueanexo = $cues[$codigoOp];
    } else {
        $error = "No se encontró un CUE anexo para el código OP: " . $codigoOp;
    }
}

// Código OP para el nombre del archivo: el ingresado o, si no, el que corresponda al CUE
$codigoOpArchivo = $codigoOp;
if ($codigoOpArchivo === '' && $cueanexo !== '') {
    $encontrado = array_search((string) $cueanexo, $cues, true);
    if ($encontrado !== false) {
        $codigoOpArchivo = $encontrado;
    }
}

if ($error === null && $cueanexo !== '') {
    $matricula = new Matricula(API_URL_MATRICULA, API_CLIENT_ID, API_SECRET, $cueanexo);
    $data = $matricula->fetchData();
    if (is_array($data)) {
        $rows = $data;
    } else {
        $error = $data;
    }
}

// Orden y etiquetas de columnas (una fila por alumno)
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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Exportar Matrícula</title>
    <link rel="icon" href="../img/favicon_amarillo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="container mt-5">
    <h1 class="mb-4">Exportar Matrícula a CSV</h1>

    <form method="GET" class="row g-3 align-items-end mb-4">
        <div class="col-md-4">
            <label for="cueanexo" class="form-label">CUE Anexo:</label>
            <input type="text" id="cueanexo" name="cueanexo" class="form-control" value="<?= htmlspecialchars($cueanexo) ?>">
        </div>
        <div class="col-md-4">
            <label for="codigo_op" class="form-label">o Código OP:</label>
            <input type="text" id="codigo_op" name="codigo_op" class="form-control" value="<?= htmlspecialchars($codigoOp) ?>">
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Consultar</button>
            <a href="../" class="btn btn-secondary">Volver</a>
        </div>
    </form>

    <?php if ($error !== null): ?>
        <div class="alert alert-danger" role="alert">
            Error: <?= htmlspecialchars($error) ?>
        </div>
    <?php elseif ($rows !== null): ?>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <p class="mb-0">
                Total de alumnos: <strong><?= count($rows) ?></strong>
                (CUE Anexo: <?= htmlspecialchars($cueanexo) ?><?= $codigoOpArchivo !== '' ? ' · Código OP: ' . htmlspecialchars($codigoOpArchivo) : '' ?>)
            </p>
            <a class="btn btn-success" href="../clases/exportar_matricula_csv.php?cueanexo=<?= urlencode($cueanexo) ?>&codigo_op=<?= urlencode($codigoOpArchivo) ?>">Descargar CSV</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="table-light">
                    <tr>
                        <?php foreach ($columnas as $etiqueta): ?>
                            <th><?= htmlspecialchars($etiqueta) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $fila): ?>
                        <tr>
                            <?php foreach ($columnas as $clave => $etiqueta): ?>
                                <?php
                                    $valor = $fila[$clave] ?? '';
                                    if ($clave === 'establecimiento') {
                                        $valor = trim((string) $valor);
                                    } elseif ($clave === 'fecha_nacimiento') {
                                        $valor = substr((string) $valor, 0, 10);
                                    }
                                ?>
                                <td><?= htmlspecialchars((string) $valor) ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</body>
</html>
