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

        if ($data === null) {
            return "Error: no hay respuesta de la API";
        } elseif (empty($data['status']) || empty($data['rows'])) {
            return "No hay información para el CUEanexo: " . $this->cueanexo;
        } else {
            return $data['rows'];
        }
    }

    public function countTotalRows($rows) {
        return count($rows);
    }

    public function countByLevel($rows) {
        $countByLevel = array();
        foreach ($rows as $row) {
            if (isset($row['nivel'])) {
                if (!isset($countByLevel[$row['nivel']])) {
                    $countByLevel[$row['nivel']] = 0;
                }
                $countByLevel[$row['nivel']]++;
            }
        }
        return $countByLevel;
    }

    public function countByTurn($rows) {
        $countByTurn = array();
        foreach ($rows as $row) {
            if (isset($row['turno'])) {
                if (!isset($countByTurn[$row['turno']])) {
                    $countByTurn[$row['turno']] = 0;
                }
                $countByTurn[$row['turno']]++;
            }
        }
        return $countByTurn;
    }

    public function countByJornada($rows) {
        $countByJornada = array();
        foreach ($rows as $row) {
            if (isset($row['jornada'])) {
                if (!isset($countByJornada[$row['jornada']])) {
                    $countByJornada[$row['jornada']] = 0;
                }
                $countByJornada[$row['jornada']]++;
            }
        }
        return $countByJornada;
    }

    public function getEstablecimiento($rows) {
        $escuela = array();
        foreach ($rows as $row) {
            if (isset($row['de'], $row['establecimiento']) && $row['de'] != 0 && $row['establecimiento'] != "") {
                $escuela['de'] = $row['de'];
                $escuela['establecimiento'] = $row['establecimiento'];
                return $escuela;
            }
        }
        return "Error al obtener los datos de la API.";
    }
}
