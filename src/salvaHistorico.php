<?php
require_once('vendor/autoload.php');

use classes\LoucaDAO;

$loucaDAO = new LoucaDAO();

$loucaDAO->alteraQuemLavou($_POST['idLouca'], $_POST['idPessoa']);
