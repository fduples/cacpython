<?php
require_once 'PresentismoMensual.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cueanexo = $_POST['cueanexo'];
    $anio = $_POST['anio'];
    $mes = $_POST['mes'];

    $url = 'http://100.65.8.133:3000/godd/alumno/presentismo_x_cue_x_dia_v2';
    $client_id = 'godd';
    $secret = '249db411dc038e06a';

    $presentismoMensual = new PresentismoMensual($url, $client_id, $secret, $cueanexo, $anio, $mes);
  
    $datosMes = $presentismoMensual->fetchMonthlyData();
    var_dump($datosMes);
    // Agrupar datos por jornada, nivel y turno
    $datosAgrupadosJornada = [];
    $datosAgrupadosNivel = [];
    $datosAgrupadosTurno = [];

    foreach ($datosMes as $fecha => $data) {
        $datosAgrupadosJornada[$fecha] = $presentismoMensual->groupDataByCriteria($data, 'jornada');
        $datosAgrupadosNivel[$fecha] = $presentismoMensual->groupDataByCriteria($data, 'nivel');
        $datosAgrupadosTurno[$fecha] = $presentismoMensual->groupDataByCriteria($data, 'turno');
    }
}
