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

        return $res->withJson($users, 200)->withHeader('Content-Type', 'application/json');
    }

    public function show($req, $res) {
        $entityManager = $this->container->get('em');

        $id = $req->getAttribute('route')->getArgument('id');

        $userRepository = $entityManager->getRepository('App\Models\Entity\User');
        $user = $userRepository->find($id);

        return $res->withJson($user, 200)->withHeader('Content-Type', 'application/json');
    }


    public function create($req, $res) {
        $entityManager = $this->container->get('em');

        $user =new User();
        $user->fromArr($req->getParams());

        $entityManager->persist($user);
        $entityManager->flush();

        return $res->withJson($user, 201)->withHeader('Content-Type', 'application/json');

    }

    public function edit($req, $res){
        $entityManager = $this->container->get('em');

        $id = $req->getAttribute('route')->getArgument('id');

        $userRepository = $entityManager->getRepository('App\Models\Entity\User');
        $user = $userRepository->find($id);
        $user->fromArr($req->getParams());

        $entityManager->persist($user);
        $entityManager->flush();

        return $res->withJson($user, 201)->withHeader('Content-Type', 'application/json');
    }

    public function delete($req, $res){
        $entityManager = $this->container->get('em');

        $id = $req->getAttribute('route')->getArgument('id');

        $userRepository = $entityManager->getRepository('App\Models\Entity\User');
        $user = $userRepository->find($id);
        
        $entityManager->remove($user);
        $entityManager->flush(); 

        return $res->withJson([], 200)->withHeader('Content-Type', 'application/json');
    }


}