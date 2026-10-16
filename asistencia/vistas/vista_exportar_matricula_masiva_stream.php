<?php
$cuesPath = __DIR__ . '/../scripts/cues.json';
$cues = json_decode(file_get_contents($cuesPath), true);
$totalConCUE = 0;
if (is_array($cues)) {
    foreach ($cues as $codigoOp => $cueanexo) {
        $cueanexoStr = trim((string) $cueanexo);
        if ($cueanexoStr !== '' && ctype_digit($cueanexoStr)) {
            $totalConCUE++;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Exportar Matrícula Masiva (Streaming)</title>
    <link rel="icon" href="../img/favicon_amarillo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1 class="mb-4">Exportar Matrícula Masiva (Streaming)</h1>
    <div class="alert alert-info">
        <p class="mb-1">Versión optimizada en memoria. Recorre <strong><?= $totalConCUE ?></strong> CUEs y descarga directamente (sin acumular todo en PHP).</p>
        <p class="mb-0">Agrega columna <strong>Codigo OP</strong> a cada registro.</p>
    </div>
    <div class="mb-4">
        <a class="btn btn-success" href="../clases/exportar_matricula_masiva_stream.php">Descargar CSV Masivo (Streaming)</a>
        <a class="btn btn-secondary" href="../index.php">Volver</a>
    </div>
</body>
</html>
