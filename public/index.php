<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\Blog\Post;

require_once '../vendor/autoload.php';
$config = require_once('../config.php');

$app = new \Slim\App(["settings" => $config]);

$container = $app->getContainer();

$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$container['view'] = new \Slim\Views\PhpRenderer(__DIR__ . "/../templates/");

$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});

$app->get('/blog/{name}', function (Request $request, Response $response) {
    $post = new Post($this->db, $this->settings);
    $name = $request->getAttribute('name');

    $article = $post->getBlogPost($name);

    $response = $this->view->render($response, "article.phtml", ['article' => $article]);

    return $response;
});

$app->run();