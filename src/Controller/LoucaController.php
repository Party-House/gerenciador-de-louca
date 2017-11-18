<?php
namespace Controller;

//get
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

//insert
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

//update
$loucaDAO->alteraQuemLavou($_POST['idLouca'], $_POST['idPessoa']);

//get
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

