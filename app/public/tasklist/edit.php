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

// @TODO Bootstrap Twig 

// Initial Values
$priorities = ['low', 'normal', 'high']; // The possible priorities of a task
$formErrors = []; // The encountered form errors

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0; // The id of the task passed by the URL
$what = isset($_POST['what']) ? $_POST['what'] : ''; // The task that was sent via the form
$priority = isset($_POST['priority']) ? $_POST['priority'] : 'low'; // The priority that was sent via the form


// Handle action 'edit' (user pressed edit button)
if (isset($_POST['moduleAction']) && ($_POST['moduleAction'] == 'edit')) {

    // check if item exists (use the id from the $_POST array!)

    // @TODO (if error, redirect to index.php)

    // check parameters

    // @TODO (if an error was encountered, add it to the $formErrors array)

    // @TODO if no errors: updates values in the database

    // @TODO if query succeeded: redirect to index.php

}

// No action to handle: show edit page

// @TODO Check if the passed id (in $_GET) exists as a task item (if it fails, redirect to index.php)

// @TODO Get the item from the database

// @TODO If the form has not been sent, overwrite the $what and $priority parameters

// render template and persist $what and $priority 

