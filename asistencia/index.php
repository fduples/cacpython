<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrícula</title>
    <link rel="icon" href="img/favicon_amarillo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="container">
    <div class="m-6 p-3">
        <a type="button" href="vistas/cod_cues.php" class=" btn btn-warning">Administrar Códigos OP y CUES</a>
    </div>
    <h1 class="mt-5">Matrícula y Asistencias MiEscuelaAPP</h1>
    <form id="matriculaForm" class="mt-3">
        <div>
                <h4>Buscar por código o CUEanexo</h4>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="codigo_op">Código OP:</label>
                    <input type="text" id="codigo_op" name="codigo_op" class="form-control">
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="cueanexo">Número de CUE Anexo:</label>
                    <input type="text" id="cueanexo" name="cueanexo" class="form-control">
                </div>
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="fecha">Fecha (opcional):</label>
            <input type="date" id="fecha" name="fecha" class="form-control">
        </div>
        <div class="form-group mb-3">
            <label for="mes">Fecha (opcional):</label>
            <input type="month" id="mes" name="mes" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <script src="scripts/form-handler.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
