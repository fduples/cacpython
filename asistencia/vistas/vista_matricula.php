<?php
require_once "matricula.php";

// Uso de la clase
$url = 'http://100.65.8.133:3000/godd/alumno/matricula';
$client_id = 'godd';
$secret = '249db411dc038e06a';
$cueanexo = '20104700';

$matricula = new Matricula($url, $client_id, $secret, $cueanexo);
$rowCount = $matricula->fetchData();


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <body>
    
        <div>
            <h1><?php echo "Número de filas: $rowCount"; ?></h1>
        </div>
        
        <script src="" async defer></script>
    </body>
</html>