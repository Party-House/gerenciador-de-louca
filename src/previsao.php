<?php
require_once './vendor/autoload.php';

use classes\Previsao;

if (isset($_GET["resultados"])) {
    $resultados = $_GET["resultados"];
} else {
    $resultados = 10;
}

$previsao = new Previsao();
$loucas = $previsao->getProximasLoucas($resultados);

$loucasSaida = [];
foreach($loucas as $louca) {
  $loucaSaida = [
    'nome' => $louca->getPessoa()->getNome(),
    'data' => "{$louca->getData()}",
    'dia' => $louca->getData()->getDiaDaSemana()
  ];

  $loucasSaida[] = $loucaSaida;
}

echo(json_encode($loucasSaida));
