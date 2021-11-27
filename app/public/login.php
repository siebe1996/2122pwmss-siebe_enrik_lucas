<?php


require_once ('../../vendor/autoload.php');
require_once ('../../config/database.php');
require_once ('../../src/Services/DatabaseConnector.php');

// Fetch database connection
$conn = \Services\DatabaseConnector::getConnection();

// Bootstrap Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../resources/templates');
$twig = new \Twig\Environment($loader, [
    'cache' => __DIR__ . '/../../storage/cache',
    'auto_reload' => true // set to false on production
]);



// Get the item from the database


// render template and persist $formErrors, $what, $priority and show $tasks
$tpl = $twig->load('pages/login.twig');
echo $tpl->render([

]);
