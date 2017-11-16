<?php
require_once 'vendor/autoload.php';

use classes\auxiliares\Data;
use classes\Indisponibilidade;
use classes\IndisponibilidadeDAO;
use classes\pessoa\Pessoa;

$idPessoa = intval($_POST['quem']);
$data = new Data($_POST['quando']);
$pessoa = new Pessoa($idPessoa, "");
$indisponibilidade = new Indisponibilidade($pessoa, $data);

$indisponibilidadeDAO = new IndisponibilidadeDAO();
$indisponibilidadeDAO->insere($indisponibilidade);

header('Location: disponibilidades.php');
