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

$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$formErrors = [];
$result = [];


if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'login')) {

    if(empty(trim($_POST["email"]))) {
        $formErrors[] = "Please enter your email.";
    }

    if(empty(trim($_POST["password"]))) {
        $formErrors[] = "Please enter your password.";
    }

    if (sizeof($formErrors) == 0){
        $stmt = $conn->prepare('SELECT id, name, password FROM users WHERE email = ?');
        $result = $stmt->executeQuery([$email])->fetchAllAssociative();
        if (sizeof($result) == 0){
            $formErrors[] = "email of wachtwoord is incorrect";
        }else{
            if (password_verify( $password,   $result[0]['password']) == 1) {
                session_start();
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $result['id'];
                $_SESSION["name"] = $result['name'];
                header("location: index.php");
            }else{
                $formErrors[] = "email of wachtwoord is incorrect";
            }
        }
    }
}

$tpl = $twig->load('pages/login.twig');
echo $tpl->render([
    'email' => $email,
    'errors' => $formErrors,
    'res'=>$result
]);