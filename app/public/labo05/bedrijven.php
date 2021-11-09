<?php
/**
 * Lab 05 — Start from this version
 * Companies
 * @author <your name>
 */

require_once ('../../vendor/autoload.php');
require_once ('../../config/database.php');
require_once ('../../src/Services/DatabaseConnector.php');

$connectionParams = [
        'host' => DB_HOST,
        'dbname' => DB_NAME,
        'user' => DB_USER,
        'password' => DB_PASS,
        'driver' => 'pdo_mysql',
        'charset' => 'utf8mb4'
];

$connection = \Services\DatabaseConnector::getConnection($connectionParams);

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


$stmt = $connection->prepare('SELECT * FROM companies');
$result = $stmt->executeQuery();
$companies = $result->fetchAllAssociative();

/*
$id = 1;
$stmt = $connection->prepare('SELECT * FROM labo-wmss WHERE id = ?');
//$result = $stmt->executeQuery([$id]);
$stmt->bindValue(1, $id, 'integer');
$result = $stmt->executeQuery();
*/
// fetch GET/POST parameters

// connect to database

// build SQL query depending on parameters (sort, search)
$moduleAction = isset($_GET['moduleAction']) ? (string) $_GET['moduleAction'] : '';
$name = isset($_GET['search']) ? (string) $_GET['search'] : '';
$sort = isset($_GET['sort']) ? (string)$_GET['sort'] : '';
$type = isset($_GET['type']) ? (string)$_GET['type'] : '';
if ($moduleAction === 'processName'){
    if (trim($name) != ''){
        //echo $name;
        $stmtName = $connection->prepare('SELECT * FROM companies WHERE  name LIKE ?');
        $result = $stmtName->executeQuery(['%'.$name.'%']);
        $companies = $result->fetchAllAssociative();
    }
}
if (trim($sort) === 'name'){
    if(trim($type) === 'DESC'){
        $stmtName = $connection->prepare('SELECT * FROM companies ORDER BY name DESC');
    }
    else{
        $stmtName = $connection->prepare('SELECT * FROM companies ORDER BY name');
    }
    $result = $stmtName->executeQuery();
    $companies = $result->fetchAllAssociative();
}
if (trim($sort) === 'zip'){
    if(trim($type) === 'DESC'){
        $stmtName = $connection->prepare('SELECT * FROM companies ORDER BY zip DESC');
    }
    else{
        $stmtName = $connection->prepare('SELECT * FROM companies ORDER BY zip');
    }
    $result = $stmtName->executeQuery();
    $companies = $result->fetchAllAssociative();
}
/*
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$CurPageURL = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
echo "The URL of current page: ".$CurPageURL;
$currentPath = $_SERVER['PHP_SELF'];
if (str_ends_with($CurPageURL, $currentPath)){
    $CurPageURL=$CurPageURL.'?';
}
else{
    $CurPageURL=$CurPageURL.'&';
}
*/

// execute query and fetch result

?><!DOCTYPE html>
<html>
<head>
    <title>Voka - bedrijfslijst</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--[if lte IE 8]><script src="js/ie/html5shiv.js"></script><![endif]-->
    <link rel="stylesheet" href="css/main.css" />
    <!--[if lte IE 8]><link rel="stylesheet" href="css/ie8.css" /><![endif]-->

    <!-- Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.poptrox.min.js"></script>
    <script src="js/skel.min.js"></script>
    <script src="js/util.js"></script>
    <!--[if lte IE 8]><script src="js/ie/respond.min.js"></script><![endif]-->
    <script src="js/main.js"></script>
</head>
<body id="top">

<!-- Header -->
<header id="header">
    <h1><a href="#"><strong>voka</strong></a></h1>
    <h1>Vlaams netwerk van ondernemingen</h1>
</header>

<!-- Main -->
<div id="main">
    <!-- Welcome -->
    <section id="welcome">
        <header class="major">
            <h2>Overzicht bedrijven</h2>
        </header>
        <p>Hieronder vindt u een overzicht van alle grote bedrijven in Belgi&euml;.</p>
        <form method="get" action="bedrijven.php">
            <input type="hidden" name="moduleAction" value="processName">
            <div class="row uniform 50%">
                <div class="6u 12u$(xsmall)"></div>
                <div class="3u 12u$(xsmall)">
                    <input type="text" name="search" id="search" value="" placeholder="Zoekterm" />
                </div>
                <div class="3u 12u$(xsmall)">
                    <input type="submit" value="Zoeken" class="special fit small" style="height: 3.4em"/>
                </div>
            </div>
        </form>
        <div class="table-wrapper">
            <table class="alt">
                <thead>
                <tr>
                    <th>Naam &nbsp; <a href="?sort=name&type=DESC" style="border-bottom: 0;">&#9660;</a>&nbsp;<a href="?sort=name&type=ASC" style="border-bottom: 0;">&#9650;</a></th>
                    <th>Straat en nummer</th>
                    <th>Postcode en gemeente &nbsp; <a href="?sort=zip&type=DESC" style="border-bottom: 0;">&#9660;</a>&nbsp;<a href="?sort=zip&type=ASC" style="border-bottom: 0;">&#9650;</a></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($companies as $company) { ?>
                    <tr>
                        <td><?php echo $company['name']; ?></td>
                        <td><?php echo $company['address']; ?></td>
                        <td><?php echo $company['zip'] . ' ' . $company['city']; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<!-- Footer -->
<footer id="footer">
    <ul class="icons">
        <li><a href="http://www.events.be/" class="icon fa-globe"><span class="label">Website</span></a></li>
        <li><a href="mailto:info@events.be" class="icon fa-envelope-o"><span class="label">Email</span></a></li>
    </ul>
    <ul class="copyright">
        <li>&copy; <a href="http://www.ikdoeict.be/" title="IkDoeICT.be">IkDoeICT.be</a></li>
        <li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
    </ul>
</footer>

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
    function dump($var) {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }


    /**
     * Main Program Code
     * ========================
     */

    // dump $_GET
    //dump($companies);

    ?>

</div>

</body>
</html>