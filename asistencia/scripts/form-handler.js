document.getElementById('matriculaForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var cueanexo = document.getElementById('cueanexo').value;
    var fecha = document.getElementById('fecha').value;
    
    var action = 'vistas/vista_matricula.php';
    if (fecha) {
        action = 'vistas/vista_presentismo.php';
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
    }
    
    document.body.appendChild(form);
    form.submit();
});
