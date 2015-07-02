<?php

/**
 * Application_Model_Taxas class
 * 
 */
class Application_Model_Taxas extends Application_Model_Ddd {

    /**
     * Taxas padrão de ligações  via DDD 
     *
     * @return array
     */
    public function taxaPadrao() {

        $array = array(
            '1' => array('origem' => '011', 'destino' => '016', 'taxa' => '1.90'),
            '2' => array('origem' => '016', 'destino' => '011', 'taxa' => '2.90'),
            '3' => array('origem' => '011', 'destino' => '017', 'taxa' => '1.70'),
            '4' => array('origem' => '017', 'destino' => '011', 'taxa' => '2.70'),
            '5' => array('origem' => '011', 'destino' => '018', 'taxa' => '0.90'),
            '6' => array('origem' => '018', 'destino' => '011', 'taxa' => '1.90')
        );

        return $array;
    }

    private function calculaTaxa($taxas, $origem, $destino, $tempo, $plano) {
        if ($tempo >= 0) {
            foreach ($taxas as $key => $value) {
                if (($value['origem'] == $origem) && ($value['destino'] == $destino)) {
                    // Calcula taxa sem o plano
                    $ftaxa = $value['taxa'] * $tempo;

                    // Calcula taxa se exceder o plano com um
                    //  acrescimo de 10% sobre a tarifa normal do minuto
                    if ($tempo > $plano) {
                        $valor = $value['taxa'] + self::porcentagem($value['taxa']) . '<br>';
                        $taxa = ($tempo - $plano) * $valor;
                    }
                }
            }
        }
        return array('sem_plano' => $ftaxa, 'com_plano' => $taxa);
    }

    /**
     * Planos disponiveis para contratar
     *
     * @return array
     */
    public function planos() {
        $array = array(
            '1' => array('plano' => 'FaleMais  30', 'minutos' => '30'),
            '2' => array('plano' => 'FaleMais  60', 'minutos' => '60'),
            '3' => array('plano' => 'FaleMais 120', 'minutos' => '120')
        );
        return $array;
    }

    /**
     * Seleciona plano 
     * @param string $plano
     * @param array $planos
     * @return var $plano_texto
     */
    public function select_plano($plano, $planos = array()) {
        foreach ($planos as $value) {
            if ($value['minutos'] == $plano) {
                $plano_texto = $value['plano'];
            }
        }
        return $plano_texto;
    }

    /**
     * Taxas Paga Mais ligações  via DDD
     * @param string $origem
     * @param string $destino
     * @param int $tempo
     * @param int $plano
     * @return var total
     */
    public function taxaPagMais($origem, $destino, $tempo, $plano) {

        // Seleciona plano
        $plano_texto = $this->select_plano($plano, $this->planos());

        // Calcula taxas
        $result = $this->calculaTaxa($this->taxaPadrao(), $origem, $destino, $tempo, $plano);

        // Formata valores
        $ftaxa = self::formatar($result['sem_plano']);
        $taxa = self::formatar($result['com_plano']);

        // Resultados
        $retorno = array('origem' => $origem,
            'destino' => $destino,
            'tempo' => $tempo,
            'plano' => $plano_texto,
            'taxa' => $taxa,
            'ftaxa' => $ftaxa,
            'retorno' => true);

        return $retorno;
    }

    /*
     * Calcula porcentagem  Os minutos excedentes tem um acrescimo de 10% sobre a tarifa normal do minuto 
     * @param string $total
     * @return var total
     */

    public static function porcentagem($total) {
        return ( 10 / 100 ) * $total;
    }

    /*
     * Calcula porcentagem  Os minutos excedentes tem um acrescimo de 10% sobre a tarifa normal do minuto 
     * @param string $total
     * @return var total
     */

    public static function formatar($valor) {
        if (empty($valor) || $valor == null) {
            if (is_int($valor)) {
                $valor = 'R$ 0,00';
            } else {
                $valor = '--';
            }
        } else {
            $valor = 'R$ ' . number_format($valor, 2, ',', '.');
        }
        return $valor;
    }

}
