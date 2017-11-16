<?php
namespace classes;

use classes\exception\SQLException;

class Postgres implements SGBD {
    private $conexao;
    private static $instancia;
    
    private function __construct() {
       $this->conexao =$this->getConexao();
    }
    
    public static function getInstancia() {
        if (is_null(self::$instancia)) {
            self::$instancia = new Postgres();
        }
        return self::$instancia;
    }
    
    public function __destruct() {
        $this->fechaConexao($this->conexao);
    }

    
    private function verificaRetorno($objeto) {
        if ($objeto === false) {
            throw new SQLException();
        }
    }
    
    public function executaQuery($query, $conexao = null) {
        if (is_null($conexao)) {
            $conexao = $this->conexao;
        }
        $result = pg_query($conexao, $query);
        $this->verificaRetorno($result);
        return $result;
    }

    public function fechaConexao($conexao) {
        $close = pg_close($conexao);
        $this->verificaRetorno($close);
    }

    public function getConexao() {
        //$connectionString = getenv('DATABASE_URL');
        $connectionString = "postgres://cnlrszihkmetqd:0a8dabc20dc98cdb5e8d09396dc016e55082e9f1aeea00becd131294e51eb485@ec2-54-83-205-71.compute-1.amazonaws.com:5432/dfqb1glpe8j1dl";
        $conexao = pg_connect($connectionString);
        $this->verificaRetorno($conexao);
        return $conexao;
    }

    public function getNumeroDeLinhas($result): int {
        $retorno = pg_affected_rows($result);
        $this->verificaRetorno($retorno);
        return $retorno;
    }

    public function getProximaLinha($result) {
        $retorno = pg_fetch_assoc($result);
        return $retorno;
    }

    public function getTodasAsLinhas($result): array {
        $retorno = pg_fetch_all($result);
        $this->verificaRetorno($retorno);
        return $retorno;
    }

}
