<?php
namespace App\v1\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Models\Entity\User;

class UserController {

    protected $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function listUser($req, $res){
        $entityManager = $this->container->get('em');
        $userRepository = $entityManager->getRepository('App\Models\Entity\User');
        $users = $userRepository->findAll();

        $res->getBody()->write(json_encode($users));
        
        return $res
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);

    }

    public function createUser($req, $res){

        $entityManager = $this->container->get('em');

        $user =new User();
        $user->fromArr($req->getParams());

        $entityManager->persist($user);
        $entityManager->flush();

        $res->getBody()->write(json_encode($user));
        
        return $res
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(201);
    }
}