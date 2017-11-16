<?php
require_once('vendor/autoload.php');

use classes\auxiliares\TwigLouca;

$twig = new TwigLouca();
$twig->render('disponibilidades');
