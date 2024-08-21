
function obtenerNombreMes(month) {
    const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    const mes = document.getElementById('mes').innerText = meses[month - 1];
    return meses[month - 1];
}


function generarPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Obtener el nombre de la escuela, el mes, y el año
    const escuela = document.getElementById('escuela').innerText;
    const distrito = document.getElementById('distrito').innerText;
    const anio = document.getElementById('anio').innerText;
    const nombreMes = document.getElementById('mes').innerText;
    const codigoOp = document.getElementById('codOp').innerText;

    // Título del PDF
    doc.setFontSize(18);
    doc.text('Reporte de Presentismo Mensual', 105, 10, { align: 'center' });
    doc.setFontSize(12);
    doc.text(`Escuela: ${escuela} - Distrito: ${distrito} - Codigo: ${codigoOp}`, 10, 30);
    doc.text(`Mes: ${nombreMes} ${anio}`, 10, 40);

    // Configuración de la tabla con autoTable
    const encabezados = [
        [{ content: 'Fecha', styles: { halign: 'center', fillColor: [255, 0, 0] } }, 
        { content: 'Jornada', styles: { halign: 'center', fillColor: [255, 0, 0] } },
        { content: 'Matriculados', styles: { halign: 'center', fillColor: [255, 0, 0] } },
        { content: 'Presentes', styles: { halign: 'center', fillColor: [255, 0, 0] } },
        { content: 'Ausentes', styles: { halign: 'center', fillColor: [255, 0, 0] } },
        { content: 'Sin registrar', styles: { halign: 'center', fillColor: [255, 0, 0] } }]
    ];

    const filas = [];
    document.querySelectorAll('#tabla-presentismo tbody tr').forEach((fila) => {
        const columnas = fila.querySelectorAll('td');
        const filaData = [];
        columnas.forEach((columna) => {
            filaData.push({ content: columna.innerText, styles: { halign: 'center' } });
        });
        filas.push(filaData);
    });

    // Agregar tabla al PDF con autoTable
    doc.autoTable({
        head: encabezados,
        body: filas,
        startY: 60, // Ajustar para dejar espacio para la información adicional
        theme: 'striped',
        styles: {
            fontSize: 10,
            cellPadding: 3,
            valign: 'middle',
            halign: 'center',
            overflow: 'linebreak',
            fillColor: [240, 240, 240]
        },
        headStyles: {
            fillColor: [255, 0, 0],
            textColor: [255, 255, 255],
            fontStyle: 'bold'
        },
        alternateRowStyles: {
            fillColor: [220, 220, 220]
        }
    });

    // Generar nombre del archivo
    const nombreArchivo = `${codigoOp}_MiEscuela_Asistencia_${nombreMes}_${anio}.pdf`;

    // Descargar el PDF
    doc.save(nombreArchivo);
}