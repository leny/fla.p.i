<?php
require('vendor/autoload.php');
require('routes.php');
$default_route = $routes['default'];
$route_parts = explode('/', $default_route);

$method = $_SERVER['REQUEST_METHOD'];

// Allow CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET,POST');
header('Access-Control-Allow-Headers: X-Requested-With');
if ($method === 'OPTIONS') {
    http_response_code(200);
    die();
}

$a = isset($_REQUEST['a']) ? $_REQUEST['a'] : $route_parts[1];
$r = isset($_REQUEST['r']) ? $_REQUEST['r'] : $route_parts[2];

if (!in_array($method . '/' . $a . '/' . $r, $routes)) {
    die('Ce que vous cherchez n’est pas ici');
}

$controller_name = 'Controllers\\' . ucfirst($r) . 'Controller';

$container = new \Illuminate\Container\Container();
$controller = $container->make($controller_name);

$data = call_user_func([$controller, $a]);

echo json_encode($data);
