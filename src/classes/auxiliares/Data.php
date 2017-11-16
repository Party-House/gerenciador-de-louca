<?php
namespace classes\auxiliares;

use DateTime;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Data
 *
 * @author wagner
 */
class Data extends DateTime {
    
    const DOMINGO = "domingo";
    const SEGUNDA = "segunda";
    const TERCA = "terca";
    const QUARTA = "quarta";
    const QUINTA = "quinta";
    const SEXTA = "sexta";
    const SABADO = "sabado";
    const DIAS_DA_SEMANA_PARA_PORTUGUES= [
        "Sunday" => self::DOMINGO,
        "Monday" => self::SEGUNDA,
        "Tuesday" => self::TERCA,
        "Wednesday" => self::QUARTA,
        "Thursday" => self::QUINTA,
        "Friday" => self::SEXTA,
        "Saturday" => self::SABADO,
    ];

    public function __construct($data = null) {
        date_default_timezone_set('America/Sao_Paulo');
        parent::__construct($data);
        $this->setTime(0, 0, 0);
    }

    public static function criaHoje(): Data {
        return new Data();
    }
    
    public static function criaOntem(): Data {
        $data = new Data();
        $data->modify("-1 day");
        return $data;
    }
    
    public static function criaDiaSeguinte(Data $data): Data {
        $novaData = clone $data;
        $novaData->modify('+1 day');
        return $novaData;
    }
    
    public function getDiaDaSemana(): string {
        $diaEmIngles = date('l', strtotime($this->format('Y-m-d')));
        return self::DIAS_DA_SEMANA_PARA_PORTUGUES[$diaEmIngles];
    }
    
    public function formatoSQL(): string {
        return $this->format('Y-m-d');
    }
    
    public function __toString() {
        return $this->format('d/m/Y');
    }
}
