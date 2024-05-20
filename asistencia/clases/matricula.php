<?php
class Matricula {
    private $url;
    private $headers;
    private $cueanexo;

    public function __construct($url, $client_id, $secret, $cueanexo) {
        $this->url = $url . '?cueanexo=' . $cueanexo;
        $this->headers = array(
            'client_id: ' . $client_id,
            'secret: ' . $secret
        );
        $this->cueanexo = $cueanexo;
    }

    public function fetchData() {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url,
            CURLOPT_HTTPHEADER => $this->headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($response, true);

        if ($data !== null && isset($data['rows']) && is_array($data['rows'])) {
            $rowCount = count($data['rows']);
            return $rowCount;
        } else {
            return "Error al obtener los datos de la API.";
        }
    }
}

/*

// URL de la API
$url = 'http://100.65.8.133:3000/godd/alumno/matricula?cueanexo=20104700';

// Headers requeridos
$headers = array(
    'client_id: godd',
    'secret: 249db411dc038e06a'
);

// Inicializar cURL
$curl = curl_init();

// Establecer la URL y otras opciones necesarias
curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
));

// Ejecutar la consulta, obtener la respuesta y cerrar la conexión
$response = curl_exec($curl);
curl_close($curl);

//var_dump($response);
// Decodificar la respuesta JSON
$data = json_decode($response, true);

// Verificar si la respuesta fue exitosa y contabilizar las filas
if ($data !== null && isset($data['rows']) && is_array($data['rows'])) {
    $rowCount = count($data['rows']);
    echo "Número de filas: $rowCount";
} else {
    echo "Error al obtener los datos de la API.";
}
*/
