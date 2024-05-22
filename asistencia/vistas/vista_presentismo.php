<?php
require_once "../clases/Presentismo.php";

if (isset($_GET['cueanexo']) && isset($_GET['fecha'])) {
    $cueanexo = $_GET['cueanexo'];
    $fecha = $_GET['fecha'];
    $url = 'http://100.65.8.133:3000/godd/alumno/presentismo_x_cue_x_dia_v2';
    $client_id = 'godd';
    $secret = '249db411dc038e06a';
    $presentismo = new Presentismo($url, $client_id, $secret, $cueanexo, $fecha);
    $data = $presentismo->fetchData();
    
    if (is_array($data)) {
        $groupedData = $presentismo->groupData($data);
        $groupByJornada = $presentismo->groupByJornada($data);
        $groupByNivel = $presentismo->groupByNivel($data);
        $groupByTurno = $presentismo->groupByTurno($data);
        if (!is_array($groupedData) || !is_array($groupByJornada) || !is_array($groupByNivel) || !is_array($groupByTurno)) {
            $error = "Error al agrupar los datos.";
        }
    } else {
        $error = $data; // Mensaje de error devuelto por fetchData
    }
} else {
    $error = "No se proporcionaron los parámetros necesarios.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Vista Presentismo</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body class="container mt-5">
    <h1 class="mb-4">Vista Presentismo</h1>
    <div class="mt-4">
        <a href="../" class="btn btn-secondary">Volver</a>
    </div>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger" role="alert">
            Error: <?= htmlspecialchars($error) ?>
        </div>
    <?php else: ?>
        
        <h2 class="mt-4">Agrupado por Nivel</h2>
        <?php foreach ($groupByNivel as $nivel => $values): ?>
            <h3>Nivel: <?= htmlspecialchars($nivel) ?></h3>
            <p>Matriculados: <?= $values['matriculados'] ?></p>
            <p>Presentes: <?= $values['presente'] ?></p>
            <p>Ausentes: <?= $values['ausente'] ?></p>
        <?php endforeach; ?>

        <h2 class="mt-4">Agrupado por Turno</h2>
        <?php foreach ($groupByTurno as $turno => $values): ?>
            <h3>Turno: <?= htmlspecialchars($turno) ?></h3>
            <p>Matriculados: <?= $values['matriculados'] ?></p>
            <p>Presentes: <?= $values['presente'] ?></p>
            <p>Ausentes: <?= $values['ausente'] ?></p>
        <?php endforeach; ?>

        <h2 class="mt-4">Agrupado por Jornada</h2>
        <?php foreach ($groupByJornada as $jornada => $values): ?>
            <h3>Jornada: <?= htmlspecialchars($jornada) ?></h3>
            <p>Matriculados: <?= $values['matriculados'] ?></p>
            <p>Presentes: <?= $values['presente'] ?></p>
            <p>Ausentes: <?= $values['ausente'] ?></p>
        <?php endforeach; ?>

        <h2 class="mt-4">Agrupado por Sección</h2>
        <?php foreach ($groupedData as $key => $values): ?>
            <h3><?= htmlspecialchars($values['nombre_seccion']) ?></h3>
            <p>Jornada: <?= htmlspecialchars($values['jornada']) ?></p>
            <p>Turno: <?= htmlspecialchars($values['turno']) ?></p>
            <p>Matriculados: <?= $values['matriculados'] ?></p>
            <p>Presentes: <?= $values['presente'] ?></p>
            <p>Ausentes: <?= $values['ausente'] ?></p>
        <?php endforeach; ?>

    <?php endif; ?>
</body>
</html>
