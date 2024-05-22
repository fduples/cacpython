<?php
require_once 'Presentismo.php';
class Presentismo {
    private $url;
    private $headers;
    private $cueanexo;
    private $fecha;

    public function __construct($url, $client_id, $secret, $cueanexo, $fecha) {
        $this->setUrl($url, $cueanexo, $fecha);
        $this->headers = array(
            'client_id: ' . $client_id,
            'secret: ' . $secret
        );
        $this->cueanexo = $cueanexo;
        $this->fecha = $fecha;
    }

    public function setUrl($baseUrl, $cueanexo, $fecha) {
        $this->url = $baseUrl . '?cueanexo=' . $cueanexo . '&fecha=' . $fecha;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
        $this->setUrl($this->url, $this->cueanexo, $fecha);
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

        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            curl_close($curl);
            return "Error en la conexión cURL: " . $error_msg;
        }

        curl_close($curl);

        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return "Error al decodificar JSON: " . json_last_error_msg();
        }

        if (!isset($data['status']) || !$data['status']) {
            return "Respuesta de API no válida o status false.";
        }

        if (!isset($data['rows']) || !is_array($data['rows'])) {
            return "Datos de 'rows' no válidos.";
        }

        return $data['rows'];
    }

    public function groupData($data) {
        $groupedData = [];

        foreach ($data as $record) {
            if (!isset($record['nombre_seccion'], $record['jornada'], $record['turno'], $record['matriculados'], $record['presente'], $record['ausente'])) {
                return "Datos faltantes o inválidos en la respuesta de la API.";
            }

            $key = $record['nombre_seccion'] . '|' . $record['jornada'] . '|' . $record['turno'];

            if (!isset($groupedData[$key])) {
                $groupedData[$key] = [
                    'nombre_seccion' => $record['nombre_seccion'],
                    'jornada' => $record['jornada'],
                    'turno' => $record['turno'],
                    'matriculados' => 0,
                    'presente' => 0,
                    'ausente' => 0
                ];
            }

            $groupedData[$key]['matriculados'] += $record['matriculados'];
            $groupedData[$key]['presente'] += $record['presente'];
            $groupedData[$key]['ausente'] += $record['ausente'];
        }

        return $groupedData;
    }

    public function groupByJornada($data) {
        $groupedData = [];

        foreach ($data as $record) {
            if (!isset($record['jornada'], $record['matriculados'], $record['presente'], $record['ausente'])) {
                return "Datos faltantes o inválidos en la respuesta de la API.";
            }

            $key = $record['jornada'];

            if (!isset($groupedData[$key])) {
                $groupedData[$key] = [
                    'matriculados' => 0,
                    'presente' => 0,
                    'ausente' => 0
                ];
            }

            $groupedData[$key]['matriculados'] += $record['matriculados'];
            $groupedData[$key]['presente'] += $record['presente'];
            $groupedData[$key]['ausente'] += $record['ausente'];
        }

        return $groupedData;
    }

    public function groupByNivel($data) {
        $groupedData = [];

        foreach ($data as $record) {
            if (!isset($record['nivel'], $record['matriculados'], $record['presente'], $record['ausente'])) {
                return "Datos faltantes o inválidos en la respuesta de la API.";
            }

            $key = $record['nivel'];

            if (!isset($groupedData[$key])) {
                $groupedData[$key] = [
                    'matriculados' => 0,
                    'presente' => 0,
                    'ausente' => 0
                ];
            }

            $groupedData[$key]['matriculados'] += $record['matriculados'];
            $groupedData[$key]['presente'] += $record['presente'];
            $groupedData[$key]['ausente'] += $record['ausente'];
        }

        return $groupedData;
    }

    public function groupByTurno($data) {
        $groupedData = [];

        foreach ($data as $record) {
            if (!isset($record['turno'], $record['matriculados'], $record['presente'], $record['ausente'])) {
                return "Datos faltantes o inválidos en la respuesta de la API.";
            }

            $key = $record['turno'];

            if (!isset($groupedData[$key])) {
                $groupedData[$key] = [
                    'matriculados' => 0,
                    'presente' => 0,
                    'ausente' => 0
                ];
            }

            $groupedData[$key]['matriculados'] += $record['matriculados'];
            $groupedData[$key]['presente'] += $record['presente'];
            $groupedData[$key]['ausente'] += $record['ausente'];
        }

        return $groupedData;
    }
}
