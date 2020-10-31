<?php

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Query\QueryBuilder;

require_once 'vendor/autoload.php';

session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function database(): Connection
{
    $connectionParams = [
        'dbname' => $_ENV['DB_DATABASE'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
        'host' => $_ENV['DB_HOST'],
        'driver' => 'pdo_mysql',
    ];

    $connection = DriverManager::getConnection($connectionParams);
    $connection->connect();

    return $connection;
}

function query(): QueryBuilder
{
    return database()->createQueryBuilder();
}

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $namespace = '\App\Controllers\\';

    $r->addRoute('GET', '/', $namespace . 'ArticlesController@index');

    $r->addRoute('GET', '/articles', $namespace . 'ArticlesController@index');
    $r->addRoute('GET', '/articles/{id}', $namespace . 'ArticlesController@show');
    $r->addRoute('POST', '/articles/{id}/like', $namespace . 'ArticlesController@like');

    $r->addRoute('DELETE', '/articles/{id}', $namespace . 'ArticlesController@delete');

    $r->addRoute('POST', '/articles/{id}/comments', $namespace . 'CommentsController@store');

    $r->addRoute('DELETE', '/articles/{id}/comments/delete', $namespace . 'CommentsController@delete');

    $r->addRoute('GET', '/register', $namespace . 'RegisterController@index');
    $r->addRoute('POST', '/register', $namespace . 'RegisterController@register');

    $r->addRoute('GET', '/login', $namespace . 'LoginController@index');
    $r->addRoute('POST', '/login', $namespace . 'LoginController@login');
    $r->addRoute('POST', '/logout', $namespace . 'LoginController@logout');
});

// Fetch method and URI from somewhere
$httpMethod = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo '404 PAGE NOT FOUND';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo 'METHOD NOT ALLOWED';
        break;
    case FastRoute\Dispatcher::FOUND:
        [$controller, $method] = explode('@', $routeInfo[1]);
        $vars = $routeInfo[2];

        (new $controller)->$method($vars);

        break;
}