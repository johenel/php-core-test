<?php

include('app/Services/Router.php');

global $routes;

include('routes.php');

$router = new \app\Services\Router();
$router->render();