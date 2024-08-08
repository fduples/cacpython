<?php
require_once "../clases/presentismoMensual.php";
require_once "../clases/matricula.php";

if (isset($_GET['cueanexo'], $_GET['anio'], $_GET['mes'])) {
    $cueanexo = $_GET['cueanexo'];
    $anio = $_GET['anio'];
    $mes = $_GET['mes'];
    $url = 'http://100.65.8.133:3000/godd/alumno/presentismo_x_cue_x_dia_v2';
    $url2 = 'http://100.65.8.133:3000/godd/alumno/matricula';
    $client_id = 'godd';
    $secret = '249db411dc038e06a';
    $presentismoMensual = new PresentismoMensual($url, $client_id, $secret, $cueanexo, $anio, $mes);
    $dataMensual = $presentismoMensual->fetchMonthlyData();
    $matricula = new Matricula($url2, $client_id, $secret, $cueanexo);
    $rows = $matricula->fetchData();
    
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
    <title>Vista Presentismo Mensual</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Incluir el CSS de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1 class="mb-4">Vista Presentismo Mensual</h1>
    <div>
    <div class="row g-2">
        <div class="col-md-6">
            <div class="form-floating">
                <label for="floatingInputGrid">Escuela</label>
                <h3><?php echo $escuela['establecimiento']; ?></h3>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-floating">
                <label for="floatingSelectGrid">Distrito</label>
                <h3><?php echo $escuela['de']; ?></h3>
            </div>
        </div>
    </div>
    </div>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger" role="alert">
            Error: <?= htmlspecialchars($error) ?>
        </div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Jornada</th>
                    <th>Matriculados</th>
                    <th>Presentes</th>
                    <th>Ausentes</th>
                    <th>Sin registrar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataMensual as $fecha => $jornadas): ?>
                    <?php foreach ($jornadas as $jornada => $datos): ?>
                        <tr>
                            <td><?= $fecha ?></td>
                            <td><?= $jornada ?></td>
                            <td><?= $datos['matriculados'] ?></td>
                            <td><?= $datos['presente'] ?></td>
                            <td><?= $datos['ausente'] ?></td>
                            <td><?= $datos['sincarga'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <div class="mt-4">
        <a href="../" class="btn btn-secondary">Volver</a>
    </div>
</body>
</html>
