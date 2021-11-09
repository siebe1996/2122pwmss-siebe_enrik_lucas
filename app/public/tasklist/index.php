<?php

/**
 * Lab 06 — Start from this version
 * Tasklist
 * @author <your name>
 */

require_once ('../../vendor/autoload.php');
require_once ('../../config/database.php');
require_once ('../../src/Services/DatabaseConnector.php');

// @TODO Fetch database connection
$conn = \Services\DatabaseConnector::getConnection();

// @TODO Bootstrap Twig

$loader = new  \Twig\Loader\FilesystemLoader(__DIR__.'/../../resources/templates');
$twig = new \Twig\Environment($loader);


// Initial Values
$priorities = ['low', 'normal', 'high']; // The possible priorities of a task
$formErrors = []; // The encountered form errors

$what = isset($_POST['what']) ? $_POST['what'] : ''; 
$priority = isset($_POST['priority']) ? $_POST['priority'] : 'low';

// Handle action 'add' (user pressed add button)
if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] === 'add')) {

    // check parameters
    if (trim($what) === ''){
        array_push($formErrors,'Voer een naam in voor je taak');
    }
    if(!in_array($priority, $priorities)){
        array_push($formErrors, 'Ongeldige prioriteit geselecteerd');
    }

    if (sizeof($formErrors) === 0){
        $stmt = $conn->prepare('INSERT INTO tasks (name, priority, added_on) VALUES (?, ?, ?)');
        $result = $stmt->executeStatement([$what, $priority, (new DateTime()) -> format('y-m-d h:i:s')]);
        header('Location: /tasklist/index.php');
    }

    // @TODO (if an error was encountered, add it to the $formErrors array)

    // @TODO if no errors: insert values into database

    // @TODO if insert query succeeded: redirect to this very same page

}

// No action to handle: show our page itself

// @TODO get all task items from the databases

$tasks = $conn->fetchAllAssociative('SELECT * FROM tasks');
// render template and persist $formErrors, $what, $priority and show $tasks

$tpl = $twig->load('home.twig');
echo $tpl->render([
    'tasks' => $tasks,
    'errors' => $formErrors,
    'priorities' => $priorities
]);