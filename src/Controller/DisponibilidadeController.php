<?php

//get
if($_GET['tipo'] == 'semanais') {
    $indisponibilidadeSemanalDAO = new IndisponibilidadeSemanalDAO();
    $indisponibilidades = $indisponibilidadeSemanalDAO->selecionaIndisponibilidadesSemanais();
    $retorno = [];
    foreach ($indisponibilidades as $indisponibilidade) {
        $retorno[] = [
            "nome" => $indisponibilidade->getPessoa()->getNome(),
            "dias" => $indisponibilidade->getDiasDaSemana()
        ];
    }
    echo(json_encode($retorno));
} else {
    $indisponibilidadeDAO = new IndisponibilidadeDAO();
    $indisponibilidades = $indisponibilidadeDAO->selecionaIndisponibilidades();
    $retorno = [];
    foreach ($indisponibilidades as $indisponibilidade) {
        $retorno[] = [
            "id" => $indisponibilidade->getId(),
            "nome" => $indisponibilidade->getPessoa()->getNome(),
            "data" => "{$indisponibilidade->getData()} - {$indisponibilidade->getData()->getDiaDaSemana()}"
        ];
    }
    echo(json_encode($retorno));
}

//insert
$idPessoa = intval($_POST['quem']);
$data = new Data($_POST['quando']);
$pessoa = new Pessoa($idPessoa, "");
$indisponibilidade = new Indisponibilidade($pessoa, $data);

$indisponibilidadeDAO = new IndisponibilidadeDAO();
$indisponibilidadeDAO->insere($indisponibilidade);

header('Location: disponibilidades.php');

//delete
$indisponibilidadeDAO = new IndisponibilidadeDAO();
$indisponibilidadeDAO->deleta((int) $_POST['id']);
