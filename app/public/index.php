<?php
require __DIR__ . '/../vendor/autoload.php';



$router = new \Bramus\Router\Router();

$router->setNamespace('Http');
//shop page
$router->get('/shop', 'Controller@shop');
$router->post('/shop', 'Controller@shop');
//login page
$router->get('/login', 'Controller@login');
$router->post('/login', 'Controller@login');
//register page
$router->get('/register', 'Controller@register');
$router->post('/register', 'Controller@register');
//admin page
$router->get('/admin', 'Controller@admin');
$router->post('/admin', 'Controller@admin');



$router->run();