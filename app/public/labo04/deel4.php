<?php

// Show all errors (for educational purposes)
ini_set('error_reporting', E_ALL);


$name = isset($_POST['name']) ? (string) $_POST['name'] : '';
$email = isset($_POST['email']) ? (string) $_POST['email'] : '';
$bedrijf = isset($_POST['bedrijf']) ? (string) $_POST['bedrijf'] : '';
$land = isset($_POST['land']) ? (int) $_POST['land'] : 0;
$food = isset($_POST['food']) ? (string) $_POST['food'] : '';
$moduleAction = isset($_POST['moduleAction']) ? (string) $_POST['moduleAction'] : '';
$voorkeur = isset($_POST['voorkeur']) ? (string) $_POST['voorkeur'] : '';
$voorkeuren = ['server-side','front-end','full-stack'];
$message1 = '*';
$message2 = '*';
$message3 = '*';
$message4 = '*';
$message5 = '*';

$action = $_SERVER["PHP_SELF"];

if ($moduleAction === 'processName'){
    $isValid = true;
    if(trim($name) === ''){
        $message1 = 'Gelieve een naam in te vullen';
        $isValid = false;
    }
    if(trim($email) === ''){
        $message2 = 'Gelieve een email in te vullen';
        $isValid = false;
    }
    if(trim($bedrijf) === ''){
        $message3 = 'Gelieve een bedrijf in te vullen';
        $isValid = false;
    }
    if($land === 0){
        $message4 = 'Gelieve een land in te vullen';
        $isValid = false;
    }
    if ($voorkeur === ''){
        $message5 = 'Gelieve een voorkeur in te vullen';
        $isValid = false;
    }
    if ($isValid){
        $action = 'deel5.php';
    }
}
print_r(basename(__DIR__));
print_r(basename($_SERVER['PHP_SELF']));
?><!DOCTYPE html>
<html>
<head>
    <title>Testform</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<body>

<form action='<?php echo $action; ?>' method="post">

    <fieldset>

        <h2>Schrijf je in voor onze conferentie</h2>

        <dl class="clearfix">
            <input type="hidden" name="moduleAction" value="processName"> <!--checkt als formulier is verstuurt-->

            <dt><label for="name">Name</label></dt>
            <dd class="text"><input type="text" id="name" name="name" value="<?php echo htmlentities($name); ?>" class="input-text" />
                <?php echo  $message1;?>
            </dd>

            <dt><label for="email">Email</label></dt>
            <dd class="text"><input type="email" id="email" name="email" value="<?php echo htmlentities($email); ?>" class="input-text" />
                <?php echo  $message2;?>
            </dd>

            <dt><label for="bedrijf">Bedrijf</label></dt>
            <dd class="text"><input type="text" id="bedrijf" name="bedrijf" value="<?php echo htmlentities($bedrijf); ?>" class="input-text" />
                <?php echo  $message3;?>
            </dd>

            <dt><label for="land">Land</label></dt>
            <dd>
                <select name="land" id="land">
                    <option value="0"<?php if ($land == 0) { echo ' selected="selected"'; } ?>>Please select...</option>
                    <option value="1"<?php if ($land == 1) { echo ' selected="selected"'; } ?>>Belgie</option>
                    <option value="2"<?php if ($land == 2) { echo ' selected="selected"'; } ?>>Nederland</option>
                    <option value="3"<?php if ($land == 3) { echo ' selected="selected"'; } ?>>Frankrijk</option>
                    <option value="4"<?php if ($land == 4) { echo ' selected="selected"'; } ?>>Engeland</option>
                    <option value="5"<?php if ($land == 5) { echo ' selected="selected"'; } ?>>Duitsland</option>
                </select>
                <?php echo  $message4;?>
            </dd>

            <dt><label>Voorkeur</label></dt>
            <dd>
                <?php foreach($voorkeuren as $value){
                    ?>
                    <label for="voorkeur_<?php echo $value?>"><input type="radio" class="option" name="voorkeur" id="voorkeur_<?php echo $value?>" value="<?php echo $value?>"<?php if ($voorkeur == $value) { echo ' checked="checked"'; } ?> /><?php echo $value?></label>
                    <?php
                }
                echo $message5;
                ?>
            </dd>

            <dt><label for="food">Food restrictions</label></dt>
            <dd class="text"><textarea name="food" id="food" rows="5" cols="40"><?php echo htmlentities($food); ?></textarea></dd>

            <dt class="full clearfix" id="lastrow">
                <input type="submit" id="btnSubmit" name="btnSubmit" value="Send" />
            </dt>

        </dl>

    </fieldset>

</form>

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
    dump($_GET);

    ?>

</div>

</body>
</html>

