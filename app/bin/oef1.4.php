<?php
$dateString = $argv[1];
try {
    $dateTimeObject = new DateTime($dateString);
    echo $dateTimeObject->format('y-d-m');
}catch (\Exception $e){
    echo  $dateString.' is not a valid date.';
}
print_r($dateTimeObject);
?>