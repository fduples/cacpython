<?php
require_once 'controladorAsistencia.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistencia <?php echo DateTime::createFromFormat('!m', $mes)->format('F') . ' ' . $anio; ?></title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="alert alert-light fs-4 fw-bold">
        <p>ESCUELA: <?php echo $cueanexo; ?></p>
    </div>

    <?php foreach (['Jornada' => $datosAgrupadosJornada, 'Nivel' => $datosAgrupadosNivel, 'Turno' => $datosAgrupadosTurno] as $criterio => $datosAgrupados): ?>
        <h2><?php echo $criterio; ?></h2>
        <div class="table-responsive">
            <table class="table table-light table-striped table-hover table-borderless align-middle">
                <thead class="table-dark fw-bold">
                    <tr>
                        <th>Fecha</th>
                        <th>Matriculados</th>
                        <th>Presentes</th>
                        <th>Ausentes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datosAgrupados as $fecha => $datos): ?>
                        <?php foreach ($datos as $grupo => $valores): ?>
                            <tr>
                                <td><?php echo $fecha; ?> - <?php echo $grupo; ?></td>
                                <td><?php echo $valores['matriculados']; ?></td>
                                <td><?php echo $valores['presente']; ?></td>
                                <td><?php echo $valores['ausente']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>

    <div>
        <button class="btn btn-success" onclick="location.href='index.php';">Volver</button>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
