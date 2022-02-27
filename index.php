<?php
if (!session_id()) @session_start();

require './vendor/autoload.php';

use Aura\SqlQuery\QueryFactory;
use Delight\Auth\Auth;
use DI\ContainerBuilder;
use League\Plates\Engine;

$builder = new ContainerBuilder();
$builder->addDefinitions([
    Engine::class => function () {
        return new Engine('./app/views');
    },
    PDO::class => function () {
        return new PDO('mysql:dbname=exam_mod3;host=localhost;charset=utf8mb4', 'root', '');
    },
    Auth::class => function ($conteiner) {
        return new Auth($conteiner->get('PDO'));
    },
    QueryFactory::class =>function () {
        return new QueryFactory('mysql');
    }

]);
$conteiner = $builder->build();

// d($_SERVER);
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', ['App\controllers\HomController', 'users']);
    $r->addRoute('GET', '/register', ['App\controllers\HomController', 'register']);
    $r->addRoute('GET', '/login', ['App\controllers\HomController', 'login']);
    $r->addRoute('GET', '/edit/{id:\d+}', ['App\controllers\HomController', 'editUser']);
    $r->addRoute('GET', '/create_user', ['App\controllers\HomController', 'createUser']);
    $r->addRoute('GET', '/security/{id:\d+}', ['App\controllers\HomController', 'security']);
    $r->addRoute('GET', '/status/{id:\d+}', ['App\controllers\HomController', 'status']);
    $r->addRoute('GET', '/media/{id:\d+}', ['App\controllers\HomController', 'media']);
    $r->addRoute('GET', '/profile/{id:\d+}', ['App\controllers\HomController', 'profile']);
    // $r->addRoute('GET', '/verificationmail/{id:\d+}[/{title}]', ['App\controllers\RequestHandler', 'verificationmail']);
    $r->addRoute('GET', '/verificationmail', ['App\controllers\RequestHandler', 'verificationmail']);
    $r->addRoute('GET', '/dell/{id:\d+}', ['App\controllers\RequestHandler', 'dell']);
    $r->addRoute('POST', '/logic', ['App\controllers\Logic', 'input_POST']);
    

});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
// d($routeInfo);die;
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        
        $conteiner->call($routeInfo[1], [$vars]);


        // $proba = new $handler[0];



        // call_user_func([$proba, $handler[1]], $vars);
        break;
}
