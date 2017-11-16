<?php

use classes\pessoa\PessoaDAO;
require_once 'vendor/autoload.php';

$pessoaDAO = new PessoaDAO();
$pessoas = $pessoaDAO->selecionaPessoas();
$json = [];
foreach ($pessoas as $pessoa) {
    $json[] = [
        "id" => $pessoa->getId(),
        "nome" => $pessoa->getNome()
    ];
}
echo(json_encode($json));
