<?php
require_once ('../vendor/autoload.php');
require_once ('../config/database.php');
require_once ('../src/Services/DatabaseConnector.php');

$conn = \Services\DatabaseConnector::getConnection();

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../resources/templates');
$twig = new Twig\Environment($loader, [
    'cache' => __DIR__ . '/../storage/cache',
    'auto-reload' => true
]);

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$address = $_POST['address'] ?? '';
$telephone = $_POST['telephone'] ?? '';
$password = $_POST['password'] ?? '';

$formErrors = [];

if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'register')) {

    if(empty(trim($_POST["name"]))) {
        $formErrors[] = "Please enter your name.";
    }

    if(empty(trim($_POST["email"]))) {
        $formErrors[] = "Please enter your email.";
    }

    if(empty(trim($_POST["address"]))) {
        $formErrors[] = "Please enter your address.";
    }

    if(empty(trim($_POST["password"]))) {
        $formErrors[] = "Please enter your password.";
    }

    if (sizeof($formErrors) == 0){
        $stmt = $conn->prepare('INSERT INTO users (name, email, address, phonenumber, password) VALUES (?, ?, ?, ?, ?)');
        $result = $stmt->executeStatement([$name, $email, $address, $telephone, password_hash($password, PASSWORD_DEFAULT)]);
        header('Location: login.php');
    }


}

$tpl = $twig->load('pages/register.twig');
echo $tpl->render([
    'name' => $name,
    'email' => $email,
    'address' => $address,
    'telephone' => $telephone,
    'errors' => $formErrors
]);
