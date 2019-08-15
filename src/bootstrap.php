<?php

use Slim\Factory\AppFactory;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use DI\Container;

$container = new Container();

AppFactory::setContainer($container);
$app = AppFactory::create();

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

$container->set('em', $entityManager);


$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$errorHandler = $errorMiddleware->getDefaultErrorHandler();

$errorHandler->forceContentType('application/json');

require 'routes.php';

$app->run();