<?php
require_once './vendor/autoload.php';

use classes\auxiliares\Data;
use classes\LoucaDAO;
use classes\Previsao;

$loucaDAO = new LoucaDAO();
$previsao = new Previsao();

$loucaDeHoje = $previsao->getLoucaDoDia(Data::criaHoje());
try {
    $loucaDAO->insere($loucaDeHoje);
    echo "Louça do dia {$loucaDeHoje->getData()} - {$loucaDeHoje->getPessoa()->getNome()} inserida com sucesso!";
    exit(0);
} catch (Exception $ex) {
    echo "Ocorreu algum problema";
    $ex->getMessage();
    $ex->getTraceAsString();
    exit(-1);
}

