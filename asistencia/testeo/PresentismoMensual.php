<?php
require_once 'Presentismo.php';
class PresentismoMensual extends Presentismo {
    private $anio;
    private $mes;

    public function __construct($url, $client_id, $secret, $cueanexo, $anio, $mes) {
        parent::__construct($url, $client_id, $secret, $cueanexo, null);
        $this->anio = $anio;
        $this->mes = $mes;
    }

    public function fetchMonthlyData() {
        $diasHabiles = $this->getDiasHabiles($this->anio, $this->mes);
        $dataMensual = [];

        foreach ($diasHabiles as $dia) {
            $this->setFecha($dia);
            $dataDiaria = $this->fetchData();
            if (is_array($dataDiaria)) {
                $dataMensual[$dia] = $dataDiaria;
            }
        }

        return $dataMensual;
    }

    private function getDiasHabiles($anio, $mes) {
        $diasHabiles = [];
        $numeroDias = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);

        for ($dia = 1; $dia <= $numeroDias; $dia++) {
            $fecha = new DateTime("$anio-$mes-$dia");
            $diaSemana = $fecha->format('N');

            if ($diaSemana < 6) { // 1 (lunes) - 5 (viernes) son días hábiles
                $diasHabiles[] = $fecha->format('Y-m-d');
            }
        }

        return $diasHabiles;
    }

    public function groupDataByCriteria($data, $criteria) {
        $groupedData = [];

        foreach ($data as $record) {
            if (!isset($record[$criteria], $record['matriculados'], $record['presente'], $record['ausente'])) {
                continue; // O ignorar registros inválidos
            }

            $key = $record[$criteria];

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
?>
