<?php
require_once('vendor/autoload.php');

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array("Entity");
$isDevMode = false;

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'root',
    'password' => '',
    'dbname'   => 'foo',
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);

$app = new Silex\Application();

foreach (scandir(dirname(__FILE__)) as $filename) {
    $path = dirname(__FILE__) . '/' . $filename;
    if (is_file($path)) {
        require $path;
    }
}

return $app;
