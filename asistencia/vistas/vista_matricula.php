<?php
require_once "../clases/matricula.php";

if (isset($_GET['cueanexo'])) {
    $cueanexo = $_GET['cueanexo'];
    $url = 'http://100.65.8.133:3000/godd/alumno/matricula';
    $client_id = 'godd';
    $secret = '249db411dc038e06a';
    $matricula = new Matricula($url, $client_id, $secret, $cueanexo);
    $rows = $matricula->fetchData();
    
    if (is_array($rows)) {
        $totalRows = $matricula->countTotalRows($rows);
        $countByLevel = $matricula->countByLevel($rows);
        $countByTurn = $matricula->countByTurn($rows);
        $countByJornada = $matricula->countByJornada($rows);
        $escuela = $matricula->getEstablecimiento($rows);
    } else {
        $error = $rows; // Mensaje de error
    }
} else {
    $error = "No se proporcionó el número de CUE Anexo.";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Vista Matrícula</title>
    <link rel="icon" href="../img/favicon_amarillo.png">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Incluir el CSS de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h1 class="mb-4">Vista Matrícula</h1>
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
    <?php if (isset($error)): ?>
        <div class="alert alert-danger" role="alert">
            Error: <?= htmlspecialchars($error) ?>
        </div>
    <?php else: ?>
        <p class="mt-4">Total de filas: <?= $totalRows ?></p>
        <h2 class="mt-4">Cantidad por nivel:</h2>
        <ul class="list-group mb-4">
            <?php foreach ($countByLevel as $nivel => $count): ?>
                <li class="list-group-item"><?= htmlspecialchars($nivel) ?>: <?= $count ?></li>
            <?php endforeach; ?>
        </ul>
        <h2 class="mt-4">Cantidad por turno:</h2>
        <ul class="list-group mb-4">
            <?php foreach ($countByTurn as $turno => $count): ?>
                <li class="list-group-item"><?= htmlspecialchars($turno) ?>: <?= $count ?></li>
            <?php endforeach; ?>
        </ul>
        <h2 class="mt-4">Cantidad por jornada:</h2>
        <ul class="list-group mb-4">
            <?php foreach ($countByJornada as $jornada => $count): ?>
                <li class="list-group-item"><?= htmlspecialchars($jornada) ?>: <?= $count ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <div>
        <a href="../" class="btn btn-secondary">Volver</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
