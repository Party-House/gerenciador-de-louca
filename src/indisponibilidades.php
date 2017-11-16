<?php

require_once './vendor/autoload.php';

use classes\IndisponibilidadeDAO;
use classes\IndisponibilidadeSemanalDAO;

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
