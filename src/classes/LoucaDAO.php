<?php

namespace classes;

use classes\auxiliares\Data;
use classes\exception\SQLException;
use classes\pessoa\Pessoa;

class LoucaDAO {
    /* @var $sgbd SGBD */
    private $sgbd;
    const QUERY_SELECIONA_TODOS = "SELECT id_historico, id_pessoa, nome, data FROM historico left join pessoa using(id_pessoa) ORDER BY data ASC";
    const QUERY_INSERE = "INSERT INTO historico(id_pessoa, data) VALUES (%s, '%s')";
    
    public function __construct(SGBD $sgbd = null) {
        if (is_null($sgbd)) {
            $sgbd = Postgres::getInstancia();
        }
        $this->sgbd = $sgbd;
    }
    
    /**
     * @return Pessoa[]
     */
    public function selecionaLoucas(): array {
        $result = $this->sgbd->executaQuery(self::QUERY_SELECIONA_TODOS);
        $loucas = [];
        while ($linha = $this->sgbd->getProximaLinha($result)) {
            $loucas[] = new Louca(
                new Pessoa(
                    $linha['id_pessoa'] ?? 0, 
                    $linha['nome'] ?? "Ninguém lavou"
                ),
                new Data($linha['data']),
                $linha['id_historico']
            );
        }
        return $loucas;
    }
    
    /**
     * @return Pessoa[]
     */
    public function insere(Louca $louca) {
        $idPessoa = $louca->getPessoa()->getId();
        if ($idPessoa == 0) {
            $idPessoa = "null";
        }
        $query = sprintf(
            self::QUERY_INSERE,
            $idPessoa,
            $louca->getData()->formatoSQL()
        );
        $result = $this->sgbd->executaQuery($query);
        if ($this->sgbd->getNumeroDeLinhas($result) == 0) {
            throw new SQLException();
        }
    }
    
    public function selecionaUltimaData(): Data {
        $query = "SELECT MAX(data) as data FROM historico";
        $result = $this->sgbd->executaQuery($query);
        $linha = $this->sgbd->getProximaLinha($result);
        if (!$linha) {
            throw new SQLException();
        }
        return new Data($linha['data']);
    }
    
    public function alteraQuemLavou(int $idLouca, int $idPessoa) {
      if($idPessoa === 0) {
        $idPessoa = 'NULL';
      }

      $query = "UPDATE historico SET id_pessoa = $idPessoa WHERE id_historico = $idLouca";

      return $this->sgbd->executaQuery($query);
    }
}
