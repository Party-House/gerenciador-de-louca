<?php
require_once 'vendor/autoload.php';

use classes\IndisponibilidadeDAO;

$indisponibilidadeDAO = new IndisponibilidadeDAO();
$indisponibilidadeDAO->deleta((int) $_POST['id']);

