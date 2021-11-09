<?php
require_once('../../vendor/autoload.php');
require_once('../../config/database.php');
require_once('../../src/Services/DatabaseConnector.php');

$connectionParams = [
    'host' => DB_HOST,
    'dbname' => DB_NAME,
    'user' => DB_USER,
    'password' => DB_PASS,
    'driver' => 'pdo_mysql',
    'charset' => 'utf8mb4'
];

$connection = \Services\DatabaseConnector::getConnection($connectionParams);

/*
if ($connection) {
    echo 'connection was successfully estabished';
}
*/

function showDbError(string $type): void
{
    header('location: error.php?type=db&detail=' . $type);
    exit();
}


try {
    $connection->connect();
} catch (\Doctrine\DBAL\Exception\ConnectionException $e) {
    showDbError('connect');
}


$file = fopen('../../resources/companies.csv', 'r');
$pureData = [];
$companies = [];

while (!feof($file)) {
    $data = fgetcsv($file);
    array_push($pureData, $data);
}

$stmt = $connection->prepare('INSERT INTO companies (name, address, zip, city, activity, vat, date_added) VALUES (?, ?, ?, ? ,? ,?, ?)');

for ($i = 1; ($i < sizeof($pureData) - 1); $i++) {
    $companies[$i - 1] = array(
        $pureData[0][0] => $pureData[$i][0],
        $pureData[0][1] => $pureData[$i][1],
        $pureData[0][2] => $pureData[$i][2],
        $pureData[0][3] => $pureData[$i][3],
        $pureData[0][4] => $pureData[$i][4],
        $pureData[0][5] => $pureData[$i][5],
        'date_added' => (new DateTime()) -> format('y-m-d h:i:s')
    );
    $result = $stmt->executeStatement([$pureData[$i][0], $pureData[$i][1], $pureData[$i][2], $pureData[$i][3], $pureData[$i][4], $pureData[$i][5], $companies[$i-1]['date_added']]);
}


?>

<div id="debug">

    <?php

    /**
     * Helper Functions
     * ========================
     */

    /**
     * Dumps a variable
     * @param mixed $var
     * @return void
     */
    function dump($var)
    {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }


    /**
     * Main Program Code
     * ========================
     */

    // dump $_GET
    dump($companies);

    //dump($pureData);

    ?>

</div>