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
            return $data['rows'];
        } else {
            return "Error al obtener los datos de la API.";
        }
    }

    public function countTotalRows($rows) {
        return count($rows);
    }

    public function countByLevel($rows) {
        $countByLevel = array();
        //$cuentaNivel = 0;
        foreach ($rows as $row) {
            if (isset($row['nivel'])) {
                if (!isset($countByLevel[$row['nivel']])) {
                    $countByLevel[$row['nivel']] = 0;
                }
                $countByLevel[$row['nivel']]++;
                //$cuentaNivel++;
            }
        }
        return $countByLevel;
    }

    public function countByTurn($rows) {
        $countByTurn = array();
        $cuentaTurno = 0;
        foreach ($rows as $row) {
            if (isset($row['turno'])) {
                if (!isset($countByTurn[$row['turno']])) {
                    $countByTurn[$row['turno']] = 0;
                }
                $countByTurn[$row['turno']]++;
                $cuentaTurno++;
            }
        }
        return $countByTurn;
    }

    public function countByJornada($rows) {
        $countByJornada = array();
        $cuentaJornada = 0;
        foreach ($rows as $row) {
            if (isset($row['jornada'])) {
                if (!isset($countByJornada[$row['jornada']])) {
                    $countByJornada[$row['jornada']] = 0;
                }
                $countByJornada[$row['jornada']]++;
                $cuentaJornada++;
            }
        }
        return $countByJornada;
    }
}





/*
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
}*/
