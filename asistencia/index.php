<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrícula</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container">
    <h1 class="mt-5">Buscar Matrícula</h1>
    <form id="matriculaForm" class="mt-3">
        <div class="form-group">
            <label for="cueanexo">Número de CUE Anexo:</label>
            <input type="text" id="cueanexo" name="cueanexo" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="fecha">Fecha (opcional):</label>
            <input type="date" id="fecha" name="fecha" class="form-control">
        </div>
        <div class="form-group">
            <label for="mes">Fecha (opcional):</label>
            <input type="month" id="mes" name="mes" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <script src="scripts/form-handler.js"></script>
</body>
</html>
