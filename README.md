# MiEscuela — Asistencias

Aplicación web en **PHP** para consultar la **matrícula** y el **presentismo (asistencia)** de escuelas a partir de un **Código OP** o un **CUE Anexo**. Los datos se obtienen de una API externa (GODD) y se muestran en vistas web, con opción de descargar un PDF.

## Requisitos

- **XAMPP** (Apache + PHP 8.x). El proyecto se sirve desde `htdocs`.
- Extensiones PHP: `curl`, `calendar` (viene con XAMPP).
- Acceso de red a la API configurada en `config.php`.

## Configuración

Toda la configuración está centralizada en **`asistencia/config.php`**:

```php
define('API_BASE_URL', 'http://100.65.8.133:3000/godd/alumno');
define('API_CLIENT_ID', 'godd');
define('API_SECRET', '...');
```

Si cambia la API o las credenciales, se edita **solo ese archivo**.

> ⚠️ Seguridad: la `API_SECRET` queda versionada en el repositorio. Si el proyecto va a producción, conviene mover las credenciales a una variable de entorno o a un archivo fuera de Git.

## Estructura

```
asistencia/
├─ config.php                     Configuración y credenciales
├─ index.php                      Formulario de búsqueda
├─ clases/
│  ├─ matricula.php               Consulta y agrupa matrícula
│  ├─ presentismo.php             Presentismo diario
│  ├─ presentismoMensual.php      Presentismo de todo el mes
│  ├─ descarga_pdf.php            PDF del servidor (FPDF)
│  ├─ exportar_matricula_csv.php  Descarga la matrícula en CSV
│  ├─ CodController.php           CRUD de códigos (endpoint AJAX)
│  ├─ CodModel.php                Persistencia en cues.json
│  └─ fpdf.php / font/            Librería FPDF
├─ vistas/
│  ├─ vista_matricula.php
│  ├─ vista_presentismo.php
│  ├─ vista_presentismo_mensual.php
│  ├─ vista_exportar_matricula.php  Consulta y exporta matrícula a CSV
│  └─ cod_cues.php                Administración de códigos
├─ scripts/
│  ├─ form-handler.js             Redirige según fecha/mes
│  ├─ crud.js                     CRUD de códigos
│  ├─ generarPdf.js               PDF en el cliente (jsPDF)
│  └─ cues.json                   Mapa Código OP → CUE Anexo
└─ img/                           Favicons
```

## Uso

1. Copiá la carpeta del proyecto dentro de `C:\xampp\htdocs\`.
2. Iniciá **Apache** desde el panel de XAMPP.
3. Abrí `http://localhost/MiEscuela/asistencia/`.
4. Ingresá un **Código OP** y/o **CUE Anexo** y, opcionalmente:
   - una **fecha** → presentismo diario,
   - un **mes** → presentismo mensual (con botón *Descargar PDF*).
5. En **Administrar Códigos OP y CUES** se pueden crear/editar/eliminar los códigos guardados en `cues.json`.
6. En **Exportar Matrícula (CSV)** se ingresa un CUE Anexo (o Código OP), se ve una vista previa de los alumnos y se descarga el listado en CSV (una fila por alumno).

## Notas

- La vista mensual consulta la API **día por día** (solo días hábiles: lunes a viernes). No contempla feriados.
- Existen dos generadores de PDF: `scripts/generarPdf.js` (cliente, jsPDF, es el que está activo) y `clases/descarga_pdf.php` (servidor, FPDF; quedó como alternativa).
