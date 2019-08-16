<?php
namespace App\Handlers;

class ExceptionHandler {

   private $container;

   public function __construct($container){
      $this->container = $container;
   }

   public function __invoke($request, $response, $exception) {

      $statusCode = $exception->getCode() ? $exception->getCode() : 500;

      return $this->container['response']->withStatus($statusCode)
          ->withJson([
              "message" => $exception->getMessage(),
              "status" => $statusCode
          ], $statusCode);

   }
}