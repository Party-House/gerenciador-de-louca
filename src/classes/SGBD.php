<?php
namespace classes;

interface SGBD {
    public function getConexao();
    public function executaQuery($query, $conexao = null);
    public function fechaConexao($conexao);
    public function getNumeroDeLinhas($result): int;
    public function getTodasAsLinhas($result): array;
    public function getProximaLinha($result);
}
