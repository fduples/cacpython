<?php

class Presentismo {
    protected $url;
    protected $headers;
    protected $cueanexo;
    protected $fecha;

    public function __construct($url, $client_id, $secret, $cueanexo, $fecha) {
        $this->url = $url . '?cueanexo=' . $cueanexo . '&fecha=' . $fecha;
        $this->headers = array(
            'client_id: ' . $client_id,
            'secret: ' . $secret
        );
        $this->cueanexo = $cueanexo;
        $this->fecha = $fecha;
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
            if (!isset($record['nombre_seccion'], $record['jornada'], $record['turno'], $record['matriculados'], $record['presente_ajustado'], $record['ausente_ajustado'], $record['no_corresponde_o_sincarga'])) {
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
                    'ausente' => 0,
                    'sincarga' => 0
                ];
            }

            $groupedData[$key]['matriculados'] += $record['matriculados'];
            $groupedData[$key]['presente'] += $record['presente_ajustado'];
            $groupedData[$key]['ausente'] += $record['ausente_ajustado'];
            $groupedData[$key]['sincarga'] += $record['no_corresponde_o_sincarga'];
        }

        return $groupedData;
    }

    public function groupByJornada($data) {
        $groupedData = [];

        foreach ($data as $record) {
            if (!isset($record['jornada'], $record['matriculados'], $record['presente_ajustado'], $record['ausente_ajustado'], $record['no_corresponde_o_sincarga'])) {
                return "Datos faltantes o inválidos en la respuesta de la API.";
            }

            $key = $record['jornada'];

            if (!isset($groupedData[$key])) {
                $groupedData[$key] = [
                    'matriculados' => 0,
                    'presente' => 0,
                    'ausente' => 0,
                    'sincarga' => 0
                ];
            }

            $groupedData[$key]['matriculados'] += $record['matriculados'];
            $groupedData[$key]['presente'] += $record['presente_ajustado'];
            $groupedData[$key]['ausente'] += $record['ausente_ajustado'];
            $groupedData[$key]['sincarga'] += $record['no_corresponde_o_sincarga'];
        }

        return $groupedData;
    }

    public function groupByNivel($data) {
        $groupedData = [];

        foreach ($data as $record) {
            if (!isset($record['nivel'], $record['matriculados'], $record['presente_ajustado'], $record['ausente_ajustado'], $record['no_corresponde_o_sincarga'])) {
                return "Datos faltantes o inválidos en la respuesta de la API.";
            }

            $key = $record['nivel'];

            if (!isset($groupedData[$key])) {
                $groupedData[$key] = [
                    'matriculados' => 0,
                    'presente' => 0,
                    'ausente' => 0,
                    'sincarga' => 0
                ];
            }

            $groupedData[$key]['matriculados'] += $record['matriculados'];
            $groupedData[$key]['presente'] += $record['presente_ajustado'];
            $groupedData[$key]['ausente'] += $record['ausente_ajustado'];
            $groupedData[$key]['sincarga'] += $record['no_corresponde_o_sincarga'];
        }

        return $groupedData;
    }

    public function groupByTurno($data) {
        $groupedData = [];

        foreach ($data as $record) {
            if (!isset($record['turno'], $record['matriculados'], $record['presente_ajustado'], $record['ausente_ajustado'], $record['no_corresponde_o_sincarga'])) {
                return "Datos faltantes o inválidos en la respuesta de la API.";
            }

            $key = $record['turno'];

            if (!isset($groupedData[$key])) {
                $groupedData[$key] = [
                    'matriculados' => 0,
                    'presente' => 0,
                    'ausente' => 0,
                    'sincarga' => 0
                ];
            }

            $groupedData[$key]['matriculados'] += $record['matriculados'];
            $groupedData[$key]['presente'] += $record['presente_ajustado'];
            $groupedData[$key]['ausente'] += $record['ausente_ajustado'];
            $groupedData[$key]['sincarga'] += $record['no_corresponde_o_sincarga'];
        }

        return $groupedData;
    }
}
