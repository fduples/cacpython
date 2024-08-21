<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Códigos y CUEs</title>
    <link rel="icon" href="../img/favicon.ico">
</head>
<body>
    <div class="container">
    <div class="m-6 p-3">
        <a href="../" class="btn btn-secondary">Volver</a>
    </div>
        <h1 class="mt-5">Administración de Códigos y CUEs</h1>
        <div class="row">
            <div class="col-md-6">
                <form id="crudForm" class="mb-3">
                    <div class="mb-3">
                        <label for="key" class="form-label">Clave:</label>
                        <input type="text" id="key" name="key" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="value" class="form-label">Valor:</label>
                        <input type="text" id="value" name="value" class="form-control" required>
                    </div>
                    <button type="button" class="btn btn-primary" id="createBtn">Crear</button>
                    <button type="button" class="btn btn-success" id="updateBtn">Actualizar</button>
                    <button type="button" class="btn btn-danger" id="deleteBtn">Eliminar</button>
                    <button type="button" class="btn btn-secondary" id="getAllBtn">Recargar códigos</button>
                </form>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="filter" class="form-label">Filtrar por Código:</label>
                    <input type="text" id="filter" class="form-control">
                </div>
                <div id="result" style="max-height: 400px; overflow-y: auto;"></div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="../scripts/crud.js"></script>
</body>
</html>
