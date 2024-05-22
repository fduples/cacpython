<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Asistencia</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body class="">
<div class="container">
    <div class="alert alert-light fs-4 fw-bold">
        <h1>Consulta de Asistencia</h1>
    </div>
    <form action="asistencia.php" method="post">
        <div class="mb-3">
            <label for="cueanexo" class="form-label">CUEANEXO</label>
            <input type="text" class="form-control" id="cueanexo" name="cueanexo" required>
        </div>
        <div class="mb-3">
            <label for="mes" class="form-label">Mes</label>
            <input type="number" class="form-control" id="mes" name="mes" min="1" max="12" required>
        </div>
        <div class="mb-3">
            <label for="anio" class="form-label">Año</label>
            <input type="number" class="form-control" id="anio" name="anio" required>
        </div>
        <button type="submit" class="btn btn-primary">Consultar</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
