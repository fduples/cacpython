<?php
require_once __DIR__ . '/../config.php';

$cuesPath = __DIR__ . '/../scripts/cues.json';
$cues = json_decode(file_get_contents($cuesPath), true);
if (!is_array($cues)) {
    $cues = [];
}

// Contar códigos con CUE numérico
$totalConCUE = 0;
foreach ($cues as $codigoOp => $cueanexo) {
    $cueanexoStr = trim((string) $cueanexo);
    if ($cueanexoStr !== '' && ctype_digit($cueanexoStr)) {
        $totalConCUE++;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Exportar Matrícula Masiva</title>
    <link rel="icon" href="../img/favicon_amarillo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1 class="mb-4">Exportar Matrícula Masiva (Todo)</h1>
    <div class="alert alert-info">
        <p class="mb-1">Se recorrerán <strong><?= $totalConCUE ?></strong> códigos OP con CUE Anexo numérico válidos (desde <code>scripts/cues.json</code>).</p>
        <p class="mb-0">Para cada uno se consultará la API, se unirán todos los alumnos y se agregará la columna <strong>Codigo OP</strong>.</p>
    </div>
    <div class="mb-4">
        <a class="btn btn-success" href="../clases/exportar_matricula_masiva.php">Descargar CSV Masivo</a>
        <a class="btn btn-secondary" href="../index.php">Volver al inicio</a>
    </div>
    <div class="alert alert-warning">
        <small>Nota: Esto puede tardar varios segundos dependiendo de la cantidad de establecimientos.</small>
    </div>
</body>
</html>
