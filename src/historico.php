<?php
require_once './vendor/autoload.php';

use classes\LoucaDAO;

if (isset($_GET["resultados"])) {
    $resultados = $_GET["resultados"];
} else {
    $resultados = 10;
}

$loucaDAO = new LoucaDAO();
$loucas = $loucaDAO->selecionaLoucas();

$loucasSaida = [];
foreach($loucas as $louca) {
  $loucaSaida = [
    'id' => $louca->getId(),
    'idPessoa' => $louca->getPessoa()->getId(),
    'nome' => $louca->getPessoa()->getNome(),
    'data' => "{$louca->getData()}",
    'dia' => $louca->getData()->getDiaDaSemana()
  ];

  array_unshift($loucasSaida, $loucaSaida);
}

$loucasPedidas = array_slice($loucasSaida, 0, $resultados);
echo(json_encode($loucasPedidas));

