<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

use App\Handlers\ExceptionHandler;
use App\Handlers\NotAllowedHandler;
use App\Handlers\NotFoundHandler;

$container = new \Slim\Container;
$app = new \Slim\App($container);

$paths = array(__DIR__."/Models/Entity");
$isDevMode = true;
    
$dbParams = array(
    'host'     => '127.0.0.1',
    'driver'   => 'pdo_mysql',
    'user'     => 'root',
    'password' => 'docker',
    'dbname'   => 'local',
);
    
$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);

$container['em'] = $entityManager;

// register handlers
$container['errorHandler'] = function ($container) {
    return new ExceptionHandler($container);
};

$container['notAllowedHandler'] = function ($container) {
    return new NotAllowedHandler($container);
};

$container['notFoundHandler'] = function ($container) {
    return new NotFoundHandler($container);
};

require 'routes.php';

$app->run();