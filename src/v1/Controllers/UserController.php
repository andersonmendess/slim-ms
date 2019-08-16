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

    public function list($req, $res){
        $entityManager = $this->container->get('em');

        $userRepository = $entityManager->getRepository('App\Models\Entity\User');
        $users = $userRepository->findAll();

        return $res->withJson($users, 200);
    }

    public function show($req, $res) {
        $entityManager = $this->container->get('em');

        $id = $req->getAttribute('route')->getArgument('id');

        $userRepository = $entityManager->getRepository('App\Models\Entity\User');
        $user = $userRepository->find($id);

        if (!$user) {
            throw new \Exception("User not Found", 404);
        }

        return $res->withJson($user, 200);
    }


    public function create($req, $res) {
        $entityManager = $this->container->get('em');

        $user = new User();
        $user->fromArr($req->getParams());

        $entityManager->persist($user);
        $entityManager->flush();

        return $res->withJson($user, 201);

    }

    public function edit($req, $res){
        $entityManager = $this->container->get('em');

        $id = $req->getAttribute('route')->getArgument('id');

        $userRepository = $entityManager->getRepository('App\Models\Entity\User');
        $user = $userRepository->find($id);

        if (!$user) {
            throw new \Exception("User not Found", 404);
        }

        $user->fromArr($req->getParams());

        $entityManager->persist($user);
        $entityManager->flush();

        return $res->withJson($user, 201);
    }

    public function delete($req, $res){
        $entityManager = $this->container->get('em');

        $id = $req->getAttribute('route')->getArgument('id');

        $userRepository = $entityManager->getRepository('App\Models\Entity\User');
        $user = $userRepository->find($id);

        if (!$user) {
            throw new \Exception("User not Found", 404);
        }
        
        $entityManager->remove($user);
        $entityManager->flush(); 

        return $res->withJson([], 200);
    }


}