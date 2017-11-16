<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QuantidadeLavadaDAO
 *
 * @author wagner
 */
namespace classes;

use classes\pessoa\Pessoa;

class QuantidadeLavadaDAO {
    /* @var $sgbd SGBD */
    private $sgbd;
    const QUERY_SELECIONA_TODOS = "SELECT id_pessoa, nome, quantidade FROM quantidade_lavada JOIN pessoa USING (id_pessoa)";
    
    public function __construct(SGBD $sgbd = null) {
        if (is_null($sgbd)) {
            $sgbd = Postgres::getInstancia();
        }
        $this->sgbd = $sgbd;
    }
    
    public function selecionaQuantidadesLavadas() {
        $result = $this->sgbd->executaQuery(self::QUERY_SELECIONA_TODOS);
        $quantidades = [];
        while ($linha = $this->sgbd->getProximaLinha($result)) {
            $quantidades[] = 
            new QuantidadeLavada(
                $linha['quantidade'],
                new Pessoa(
                    $linha['id_pessoa'], 
                    $linha['nome']
                )
            );
        }
        return $quantidades;
    }
}
