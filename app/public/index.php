<?php
require __DIR__ . '/../vendor/autoload.php';
require_once __Dir__ . '../../src/Http/Controller.php';



$router = new \Bramus\Router\Router();

$router->setNamespace('Http');
//shop page
$router->get('/shop', 'Controller@shop');
//$router->post('/shop', 'Controller@shop');
//login page
$router->get('/login', 'Controller@login');
//$router->post('/login', 'Controller@login');
//register page
$router->get('/register', 'Controller@register');
//$router->post('/register', 'Controller@register');
//admin page
$router->get('/admin', 'Controller@admin');
$router->post('/admin', 'Controller@admin');

$router->get('/index', 'Controller@index');

$router->get('/order', 'Controller@order');
$router->post('/order', 'Controller@order');

$router->get('/order', 'Controller@order');
$router->post('/order', 'Controller@order');

$router->get('/order/1', 'Controller@order1');
$router->post('/order/1', 'Controller@order1');

$router->get('/order/2', 'Controller@order2');
$router->post('/order/2', 'Controller@order2');

$router->get('/order/3/ijs', 'Controller@order3Icecream');
$router->post('/order/3/ijs', 'Controller@order3Icecream');

$router->get('/order/finish', 'Controller@finishOrder');
$router->post('/order/finish', 'Controller@finishOrder');

$router->get('/order/submit', 'Controller@submitOrder');
$router->post('/order/submit', 'Controller@submitOrder');

$router->get('/order/3/alcoholijs', 'Controller@order3alcohol');
$router->post('/order/3/alcoholijs', 'Controller@order3alcohol');

$router->run();