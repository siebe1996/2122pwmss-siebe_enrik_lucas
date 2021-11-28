<?php
require_once ('../vendor/autoload.php');
require_once ('../config/database.php');
require_once ('../src/Services/DatabaseConnector.php');

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
$products = $stmt->executeQuery()->fetchAllAssociative();

$amountOfResults = count($products);

$query = 'SELECT * FROM categories';
$stmt = $conn->prepare($query);
$categories = $stmt->executeQuery()->fetchAllAssociative();


$variables = [
    'amountOfResults' => $amountOfResults,
    'categories' => $categories,
    'products' => $products,
    'title' => 'shop'
];

$tpl = $twig->load('pages/shop.twig');
echo $tpl->render();