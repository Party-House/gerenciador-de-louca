<?php
namespace classes\pessoa;

use classes\Postgres;
use classes\SGBD;
class PessoaDAO {
    /* @var $sgbd SGBD */
    private $sgbd;
    const QUERY_SELECIONA_TODOS = "SELECT id_pessoa, nome FROM pessoa ORDER BY nome ASC";
    
    public function __construct(SGBD $sgbd = null) {
        if (is_null($sgbd)) {
            $sgbd = Postgres::getInstancia();
        }
        $this->sgbd = $sgbd;
    }
    
    /**
     * @return Pessoa[]
     */
    public function selecionaPessoas(): array {
        $result = $this->sgbd->executaQuery(self::QUERY_SELECIONA_TODOS);
        $pessoas = [];
        while ($linha = $this->sgbd->getProximaLinha($result)) {
            $pessoas[] = new Pessoa(
                $linha['id_pessoa'], 
                $linha['nome']
            );
        }
        return $pessoas;
    }
    
}
