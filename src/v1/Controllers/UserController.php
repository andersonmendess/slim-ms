<?php
namespace App\v1\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Models\Entity\User;
use Psr\Container\ContainerInterface;

class UserController {

    protected $container;

    public function __construct(ContainerInterface $container) {
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

    public function createUser($req, $res, $args){

        var_dump($req->getHeaderLine());die();

        $entityManager = $this->get('em');

        $user = (new User())
                    ->setName($params->name)
                    ->setEmail($params->email)
                    ->setPassword($params->password);

        $entityManager->persist($user);
        $entityManager->flush();

        $res->getBody()->write(json_encode($user));
        
        return $res
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(201);
    }
}