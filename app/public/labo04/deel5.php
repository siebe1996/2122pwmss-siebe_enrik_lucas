<?php
$name = isset($_POST['name']) ? (string) $_POST['name'] : '';
$email = isset($_POST['email']) ? (string) $_POST['email'] : '';

echo 'Bedankt '.$name.', '.$email;
?>
