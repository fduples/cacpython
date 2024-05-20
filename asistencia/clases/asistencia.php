<?php
class Asistencia {
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
