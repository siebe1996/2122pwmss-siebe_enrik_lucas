<?php
require_once ('../vendor/autoload.php');

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../resources/templates');
$twig = new Twig\Environment($loader, [
    'cache' => __DIR__ . '/../storage/cache',
    'auto-reload' => true
]);


$conn = \Services\DatabaseConnector::getConnection();

$sort = isset($_POST['sort']) ? (string)$_POST['sort'] : '';


$query = 'SELECT * FROM products';

if(strtoupper($sort) == 'ASC') {
    $query = 'SELECT * FROM products ORDER BY price ASC';
}
else if(strtoupper($sort) == 'DESC') {
    $query = 'SELECT * FROM products ORDER BY price DESC';
}
else if(strtoupper($sort) == 'POPULARITY') {
    $query = 'SELECT * FROM products ORDER BY stock';
}

$stmt = $conn->prepare($query);
$stmt->executeQuery()->fetchAllAssociative();

$variables = [

];

$tpl = $twig->load('pages/shop.twig');
echo $tpl->render($variables);