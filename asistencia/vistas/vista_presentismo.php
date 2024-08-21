<?php
require_once "../clases/Presentismo.php";
require_once "../clases/matricula.php";

if (isset($_GET['cueanexo']) && isset($_GET['fecha'])) {
    $cueanexo = $_GET['cueanexo'];
    $fecha = $_GET['fecha'];
    $url = 'http://100.65.8.133:3000/godd/alumno/presentismo_x_cue_x_dia_v2';
    $url2 = 'http://100.65.8.133:3000/godd/alumno/matricula';
    $client_id = 'godd';
    $secret = '249db411dc038e06a';
    $presentismo = new Presentismo($url, $client_id, $secret, $cueanexo, $fecha);
    $data = $presentismo->fetchData();
    $matricula = new Matricula($url2, $client_id, $secret, $cueanexo);
    $rows = $matricula->fetchData();
    
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
    if (is_array($rows)) {
        $escuela = $matricula->getEstablecimiento($rows);
    } else {
        $error = $rows; // Mensaje de error
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
    <link rel="icon" href="../img/favicon_amarillo.png">
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
        <div class="row g-2">
        <div class="col-md-6 mb-6">
            <div class="form-floating">
                <label for="floatingInputGrid">Escuela</label>
                <h3><?php echo $escuela['establecimiento']; ?></h3>
            </div>
        </div>
        <div class="col-md-2 mb-6">
            <div class="form-floating">
                <label for="floatingSelectGrid">Distrito</label>
                <h3><?php echo $escuela['de']; ?></h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <h2 class="mt-4">Agrupado por Nivel</h2>
            <?php foreach ($groupByNivel as $nivel => $values): ?>
                <h3>Nivel: <?= htmlspecialchars($nivel) ?></h3>
                <p>Matriculados: <?= $values['matriculados'] ?></p>
                <p>Presentes: <?= $values['presente'] ?></p>
                <p>Ausentes: <?= $values['ausente'] ?></p>
                <p>No registrados: <?= $values['sincarga'] ?></p>
            <?php endforeach; ?>
        </div>
        <div class="col-md-4">
            <h2 class="mt-4">Agrupado por Turno</h2>
            <?php foreach ($groupByTurno as $turno => $values): ?>
                <h3>Turno: <?= htmlspecialchars($turno) ?></h3>
                <p>Matriculados: <?= $values['matriculados'] ?></p>
                <p>Presentes: <?= $values['presente'] ?></p>
                <p>Ausentes: <?= $values['ausente'] ?></p>
                <p>No registrados: <?= $values['sincarga'] ?></p>
            <?php endforeach; ?>
        </div>
        <div class="col-md-4">
            <h2 class="mt-4">Agrupado por Jornada</h2>
            <?php foreach ($groupByJornada as $jornada => $values): ?>
                <h3>Jornada: <?= htmlspecialchars($jornada) ?></h3>
                <p>Matriculados: <?= $values['matriculados'] ?></p>
                <p>Presentes: <?= $values['presente'] ?></p>
                <p>Ausentes: <?= $values['ausente'] ?></p>
                <p>No registrados: <?= $values['sincarga'] ?></p>
            <?php endforeach; ?>
        </div>
    </div>
        <?php if (isset($error)): ?>
        <div class="alert alert-danger" role="alert">
            Error: <?= htmlspecialchars($error) ?>
        </div>
    <?php else: ?>
        <h2 class="mt-4">Agrupado por Sección</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sección</th>
                    <th>Jornada</th>
                    <th>Turno</th>
                    <th>Matriculados</th>
                    <th>Presentes</th>
                    <th>Ausentes</th>
                    <th>No registrados</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($groupedData as $key => $values): ?>
                    <tr>
                        <td><?= htmlspecialchars($values['nombre_seccion']) ?></td>
                        <td><?= htmlspecialchars($values['jornada']) ?></td>
                        <td><?= htmlspecialchars($values['turno']) ?></td>
                        <td><?= $values['matriculados'] ?></td>
                        <td><?= $values['presente'] ?></td>
                        <td><?= $values['ausente'] ?></td>
                        <td><?= $values['sincarga'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <!--
        <h2 class="mt-4">Agrupado por Sección</h2>
        <?php foreach ($groupedData as $key => $values): ?>
            <h3><?= htmlspecialchars($values['nombre_seccion']) ?></h3>
            <p>Jornada: <?= htmlspecialchars($values['jornada']) ?></p>
            <p>Turno: <?= htmlspecialchars($values['turno']) ?></p>
            <p>Matriculados: <?= $values['matriculados'] ?></p>
            <p>Presentes: <?= $values['presente'] ?></p>
            <p>Ausentes: <?= $values['ausente'] ?></p>
            <p>No registrados: <?= $values['sincarga'] ?></p>
        <?php endforeach; ?> -->

    <?php endif; ?>
    <div class="mt-4">
        <a href="../" class="btn btn-secondary">Volver</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
