<?php 

$isDevMode = true;

require './vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$configs = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$container = new \Slim\Container($configs);

// setup models Entity path;
$models = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src/Models/Entity"), $isDevMode);

// setup databse configs
$dbConfig = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/db.sqlite',
);

// entity instance
$entityManager = EntityManager::create($dbConfig, $models);

 // put the Entity manager inside 'em' of container
$container['em'] = $entityManager;

$app = new \Slim\App($container);