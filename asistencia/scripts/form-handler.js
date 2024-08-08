document.getElementById('matriculaForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var cueanexo = document.getElementById('cueanexo').value;
    var codigoOp = document.getElementById('codigo_op').value.toUpperCase();
    var fecha = document.getElementById('fecha').value;
    var mes = document.getElementById('mes').value;

    // Función para realizar la búsqueda
    function realizarBusqueda(cueanexo) {
        var action = 'vistas/vista_matricula.php';

        if (fecha) {
            action = 'vistas/vista_presentismo.php';
        } else if (mes) {
            action = 'vistas/vista_presentismo_mensual.php';
        }

        var form = document.createElement('form');
        form.method = 'GET';
        form.action = action;

        var cueanexoInput = document.createElement('input');
        cueanexoInput.type = 'hidden';
        cueanexoInput.name = 'cueanexo';
        cueanexoInput.value = cueanexo;
        form.appendChild(cueanexoInput);

        if (fecha) {
            var fechaInput = document.createElement('input');
            fechaInput.type = 'hidden';
            fechaInput.name = 'fecha';
            fechaInput.value = fecha;
            form.appendChild(fechaInput);
        } else if (mes) {
            var [year, month] = mes.split('-');

            var anioInput = document.createElement('input');
            anioInput.type = 'hidden';
            anioInput.name = 'anio';
            anioInput.value = year;
            form.appendChild(anioInput);

            var mesInput = document.createElement('input');
            mesInput.type = 'hidden';
            mesInput.name = 'mes';
            mesInput.value = month;
            form.appendChild(mesInput);
        }

        document.body.appendChild(form);
        form.submit();
    }

    // Si se proporciona un código OP, buscar el CUE anexo en cues.json
    if (codigoOp) {
        fetch('scripts/cues.json')
            .then(response => response.json())
            .then(data => {
                // Buscar el CUE anexo correspondiente al código OP
                var cueanexo = data[codigoOp];
                if (cueanexo) {
                    realizarBusqueda(cueanexo);
                } else {
                    alert('No se encontró un CUE anexo para el código OP proporcionado.');
                }
            })
            .catch(error => {
                console.error('Error al cargar cues.json:', error);
            });
    } else if (cueanexo) {
        // Si se proporciona un CUE anexo, realizar la búsqueda directamente
        realizarBusqueda(cueanexo);
    }
});
