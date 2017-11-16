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
 * Description of IndisponibilidadeDAO
 *
 * @author wagner
 */
class IndisponibilidadeDAO {
    /* @var $sgbd SGBD */
    private $sgbd;
    const QUERY_SELECIONA_TODOS = "SELECT id_indisponibilidade, id_pessoa, nome, data FROM indisponibilidade JOIN pessoa USING (id_pessoa)";
    const QUERY_INSERE = "INSERT INTO indisponibilidade(id_pessoa, data) values (%s,'%s')";
    
    public function __construct(SGBD $sgbd = null) {
        if (is_null($sgbd)) {
            $sgbd = Postgres::getInstancia();
        }
        $this->sgbd = $sgbd;
    }
    
    public function selecionaIndisponibilidades() {
        $result = $this->sgbd->executaQuery(self::QUERY_SELECIONA_TODOS);
        $indisponibilidades = [];
        while ($linha = $this->sgbd->getProximaLinha($result)) {
            $indisponibilidades[] = 
            new Indisponibilidade(
                new Pessoa(
                    $linha['id_pessoa'], 
                    $linha['nome']
                ),
                new Data($linha['data']),
                $linha['id_indisponibilidade']
            );
        }
        return $indisponibilidades;
    }
    
    public function insere(Indisponibilidade $ind) {
        $query = sprintf(
            self::QUERY_INSERE,
            $ind->getPessoa()->getId(),
            $ind->getData()->formatoSQL()
        );
        $result = $this->sgbd->executaQuery($query);
        if ($this->sgbd->getNumeroDeLinhas($result) == 0) {
            throw new SQLException();
        }
    }

    public function deleta(int $id) {
      $query = "DELETE FROM indisponibilidade WHERE id_indisponibilidade = $id";
      $result = $this->sgbd->executaQuery($query);
    }
}
