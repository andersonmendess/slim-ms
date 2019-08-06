<?php 

$isDevMode = true;

require './vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

use Psr7Middlewares\Middleware\TrailingSlash;

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


// logger 
$container['logger'] = function($container) {
    $logger = new Monolog\Logger('books-microservice');
    $logfile = __DIR__ . '/log/books-microservice.log';
    $stream = new Monolog\Handler\StreamHandler($logfile, Monolog\Logger::DEBUG);
    $fingersCrossed = new Monolog\Handler\FingersCrossedHandler(
        $stream, Monolog\Logger::INFO);
    $logger->pushHandler($fingersCrossed);
    
    return $logger;
};

// error handler
$container['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        $statusCode = $exception->getCode() ? $exception->getCode() : 500;
        return $c['response']->withStatus($statusCode)
            ->withHeader('Content-Type', 'Application/json')
            ->withJson(["message" => $exception->getMessage()], $statusCode);
    };
};

// not allowed handler
$container['notAllowedHandler'] = function ($c) {
    return function ($request, $response, $methods) use ($c) {
        return $c['response']
            ->withStatus(405)
            ->withHeader('Allow', implode(', ', $methods))
            ->withHeader('Content-Type', 'Application/json')
            ->withHeader("Access-Control-Allow-Methods", implode(",", $methods))
            ->withJson(["message" => "Method not Allowed; Method must be one of: " . implode(', ', $methods)], 405);
    };
};

// 404 hanlder
$container['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
        return $container['response']
            ->withStatus(404)
            ->withHeader('Content-Type', 'Application/json')
            ->withJson(['message' => 'Not found 404']);
    };
};

// secret key for jwt
$container['secretkey'] = "hereisthesecret";

$app = new \Slim\App($container);


// Midllewares

$app->add(new TrailingSlash(false));

/**
 * Auth HTTP basic
 */
$app->add(new Tuupola\Middleware\HttpBasicAuthentication([
    /**
     * Usuários existentes
     */
    "users" => [
        "root" => "toor"
    ],
    /**
     * Blacklist - Deixa todas liberadas e só protege as dentro do array
     */
    "path" => ["/auth"],
    /**
     * Whitelist - Protege todas as rotas e só libera as de dentro do array
     */
    //"passthrough" => ["/auth/liberada", "/admin/ping"],
]));

/**
 * Basic JWT Auth
 */
$app->add(new Tuupola\Middleware\JwtAuthentication([
    "regexp" => "/(.*)/",
    "header" => "X-Token",
    "path" => "/book",
    "passthrough" => ["/auth"],
    "realm" => "Protected", 
    "secret" => $container['secretkey']
]));