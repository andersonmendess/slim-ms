<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Models\Entity\Book;

require 'bootstrap.php';

/**
 * get all books
 */
$app->get('/book', function (Request $request, Response $response) use ($app) {
    $entityManager = $this->get('em');
    $booksRepository = $entityManager->getRepository('App\Models\Entity\Book');
    $books = $booksRepository->findAll();

    $return = $response->withJson($books, 200);
    return $return;
});

/**
 * get a specific book
 */
$app->get('/book/{id}', function (Request $request, Response $response) use ($app) {
    $route = $request->getAttribute('route');
    $id = $route->getArgument('id');    

    $entityManager = $this->get('em');
    $booksRepository = $entityManager->getRepository('App\Models\Entity\Book');
    $book = $booksRepository->find($id);

    if (!$book) {
        throw new \Exception("Book not Found", 404);
    }

    $return = $response->withJson($book, 200)
        ->withHeader('Content-type', 'application/json');
    return $return;
});

/**
 * create a new book
 */
$app->post('/book', function (Request $request, Response $response) use ($app) {

    $params = (object) $request->getParams();

    $entityManager = $this->get('em');

    $book = (new Book())->setName($params->name)
        ->setAuthor($params->author);

    $entityManager->persist($book);
    $entityManager->flush();


    $logger = $this->get('logger');
    $logger->info('Book Created!', $book->getValues());

    $return = $response->withJson(['msg' => "Creating a new book"], 201)
        ->withHeader('Content-type', 'application/json');
    return $return;
});

/**
 * update a book
 */
$app->put('/book/{id}', function (Request $request, Response $response) use ($app) {
    $route = $request->getAttribute('route');
    $id = $route->getArgument('id');    

    $entityManager = $this->get('em');
    $booksRepository = $entityManager->getRepository('App\Models\Entity\Book');
    $book = $booksRepository->find($id);

    if (!$book) {
        throw new \Exception("Book not Found", 404);
    }

    $book->setName($request->getParam('name'))
        ->setAuthor($request->getParam('author'));

    $entityManager->persist($book);
    $entityManager->flush();   

    $logger = $this->get('logger');
    $logger->info('Book Edited!', $book->getValues());

    $return = $response->withJson($book, 200)
        ->withHeader('Content-type', 'application/json');
    return $return;
});

/**
 * delete a book
 */
$app->delete('/book/{id}', function (Request $request, Response $response) use ($app) {
    $route = $request->getAttribute('route');
    $id = $route->getArgument('id');    

    $entityManager = $this->get('em');
    $booksRepository = $entityManager->getRepository('App\Models\Entity\Book');
    $book = $booksRepository->find($id);

    if (!$book) {
        throw new \Exception("Book not Found", 404);
    }

    $entityManager->remove($book);
    $entityManager->flush(); 


    $logger = $this->get('logger');
    $logger->info('Book Deleted!', $book->getValues());
    
    $return = $response->withJson([], 204)
        ->withHeader('Content-type', 'application/json');
    return $return;
});


$app->run();