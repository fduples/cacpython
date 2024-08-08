<?php

require_once "Presentismo.php"; // Asegúrate de incluir la clase Presentismo o ajusta la ruta según sea necesario

class PresentismoMensual {
    protected $url;
    protected $client_id;
    protected $secret;
    protected $cueanexo;
    protected $anio;
    protected $mes;

    public function __construct($url, $client_id, $secret, $cueanexo, $anio, $mes) {
        $this->url = $url;
        $this->client_id = $client_id;
        $this->secret = $secret;
        $this->cueanexo = $cueanexo;
        $this->anio = $anio;
        $this->mes = $mes;
    }

    public function fetchMonthlyData() {
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $this->mes, $this->anio);
        $dataMensual = [];

        for ($dia = 1; $dia <= $daysInMonth; $dia++) {
            $fecha = sprintf('%04d-%02d-%02d', $this->anio, $this->mes, $dia);
            if ($this->esDiaHabil($fecha)) {
                $presentismo = new Presentismo($this->url, $this->client_id, $this->secret, $this->cueanexo, $fecha);
                $dataDiaria = $presentismo->fetchData();

                if (is_array($dataDiaria)) {
                    $this->agregarDatosDiarios($dataMensual, $dataDiaria, $fecha);
                } else {
                    continue; // Manejar errores si es necesario
                }
            }
        }

        return $dataMensual;
    }

    private function agregarDatosDiarios(&$dataMensual, $dataDiaria, $fecha) {
        foreach ($dataDiaria as $registro) {
            $jornada = $registro['jornada'];
            if (!isset($dataMensual[$fecha])) {
                $dataMensual[$fecha] = [];
            }
            if (!isset($dataMensual[$fecha][$jornada])) {
                $dataMensual[$fecha][$jornada] = [
                    'matriculados' => 0,
                    'presente' => 0,
                    'ausente' => 0,
                    'sincarga' => 0,
                ];
            }

            $dataMensual[$fecha][$jornada]['matriculados'] += $registro['matriculados'];
            $dataMensual[$fecha][$jornada]['presente'] += $registro['presente_ajustado'];
            $dataMensual[$fecha][$jornada]['ausente'] += $registro['ausente_ajustado'];
            $dataMensual[$fecha][$jornada]['sincarga'] += $registro['no_corresponde_o_sincarga'];
        }
    }

    private function esDiaHabil($fecha) {
        // Aquí puedes implementar la lógica para verificar si $fecha es un día hábil
        // Por ejemplo, verificar si es lunes a viernes y no es feriado
        $diaSemana = date('N', strtotime($fecha)); // Obtener el día de la semana (1: lunes, ..., 7: domingo)
        return $diaSemana >= 1 && $diaSemana <= 5; // Ejemplo básico: solo lunes a viernes
    }
}
?>
