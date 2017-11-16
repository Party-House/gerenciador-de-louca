<?php
namespace classes;

use classes\auxiliares\Data;
use classes\pessoa\Pessoa;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IndisponibilidadeSemanalDAO
 *
 * @author wagner
 */
class IndisponibilidadeSemanalDAO {
    /* @var $sgbd SGBD */
    private $sgbd;
    const QUERY_SELECIONA_TODOS = "SELECT id_indisponibilidade_semanal, id_pessoa, nome, segunda, terca, quarta, quinta, sexta, sabado, domingo FROM indisponibilidade_semanal JOIN pessoa USING (id_pessoa)";
    
    public function __construct(SGBD $sgbd = null) {
        if (is_null($sgbd)) {
            $sgbd = Postgres::getInstancia();
        }
        $this->sgbd = $sgbd;
    }
    
    private function constroiDiasDaSemana($linha) {
        $dias = [];
        if ($linha[Data::SEGUNDA] == 't') {
            $dias[] = Data::SEGUNDA;
        }
        if ($linha[Data::TERCA] == 't') {
            $dias[] = Data::TERCA;
        }
        if ($linha[Data::QUARTA] == 't') {
            $dias[] = Data::QUARTA;
        }
        if ($linha[Data::QUINTA] == 't') {
            $dias[] = Data::QUINTA;
        }if ($linha[Data::SEXTA] == 't') {
            $dias[] = Data::SEXTA;
        }if ($linha[Data::SABADO] == 't') {
            $dias[] = Data::SABADO;
        }
        if ($linha[Data::DOMINGO] == 't') {
            $dias[] = Data::DOMINGO;
        }
        return $dias;
    }
    
    public function selecionaIndisponibilidadesSemanais() {
        $result = $this->sgbd->executaQuery(self::QUERY_SELECIONA_TODOS);
        $indisponibilidades = [];
        while ($linha = $this->sgbd->getProximaLinha($result)) {
            $indisponibilidades[] = 
            new IndisponibilidadeSemanal(
                new Pessoa(
                    $linha['id_pessoa'], 
                    $linha['nome']
                ),
                $this->constroiDiasDaSemana($linha),
                $linha['id_indisponibilidade_semanal']
            );
        }
        return $indisponibilidades;
    }
}
