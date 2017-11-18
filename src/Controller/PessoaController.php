<?php
namespace Controller;

//get
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
