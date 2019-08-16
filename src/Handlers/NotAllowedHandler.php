<?php
namespace App\Handlers;

class NotAllowedHandler {

   private $container;

   public function __construct($container){
      $this->container = $container;
   }

   public function __invoke($request, $response, $methods) {

      return $this->container['response']
            ->withStatus(405)
            ->withHeader('Allow', implode(', ', $methods))
            ->withHeader('Content-Type', 'Application/json')
            ->withHeader("Access-Control-Allow-Methods", implode(",", $methods))
            ->withJson(
               ["message" => "Method not Allowed; Method must be one of: " . implode(', ', $methods),
               "status" => 405
            ], 405);

   }
}