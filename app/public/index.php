<?php
require_once ('../vendor/autoload.php');

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../resources/templates');
$twig = new Twig\Environment($loader, [
    //'cache' => __DIR__ . '/../../storage/cache',
    'auto-reload' => true
]);
$variables = [

];

$tpl = $twig->load('index.twig');
echo $tpl->render($variables);