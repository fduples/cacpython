document.getElementById('matriculaForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    var cueanexo = document.getElementById('cueanexo').value;
    var fecha = document.getElementById('fecha').value;
    var mes = document.getElementById('mes').value;

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
});
