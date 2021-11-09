<?php

// Show all errors (for educational purposes)
ini_set('error_reporting', E_ALL);

$note = isset($_POST['note']) ? (string) $_POST['note'] : '';
$moduleAction = isset($_POST['moduleAction']) ? (string) $_POST['moduleAction'] : '';

if($moduleAction === 'processName') {
    file_put_contents('../labo03/images/captions.txt', PHP_EOL.$note, FILE_APPEND);
}

print_r($_FILES['image']['error']);

if (isset($_FILES['image']) && ($_FILES['image']['error'] === UPLOAD_ERR_OK)) {
    echo '<p>Uploaded file: ' . $_FILES['image']['name'] . '</p>';
    echo '<p>Temp loaction: ' . $_FILES['image']['tmp_name'] . '</p>';
    echo '<p>Size: ' . $_FILES['image']['size'] . '</p>';

    if (in_array((new SplFileInfo($_FILES['image']['name']))->getExtension(), ['jpeg', 'jpg', 'png', 'gif'])) {
        $moved = @move_uploaded_file($_FILES['image']['tmp_name'], '../labo03/images/' . $_FILES['image']['name']);
        if ($moved) {
            echo '<p><img src="' . $_FILES['image']['name'] . '" alt="" /></p>';
        } else {
            echo('<p>Error while saving file in the uploads folder</p>');
        }
    } else {
        echo('<p>Invalid extension. Only .jpeg, .jpg, .png or .gif allowed</p>');
    }
    print_r("ik kom hier");
}
else{
    print_r("er is iets gebeurt");
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

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">

    <fieldset>

        <h2>Schrijf je in voor onze conferentie</h2>

        <dl class="clearfix">
            <input type="hidden" name="moduleAction" value="processName"> <!--checkt als formulier is verstuurt-->

            <dt><label for="image">Image</label></dt>
            <dd><input type="file" id="image" name="image" value=""/>
            </dd>

            <dt><label for="note">Note</label></dt>
            <dd class="text"><textarea name="note" id="note" rows="5" cols="40"><?php echo htmlentities($note); ?></textarea></dd>


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

    function dumpFile($varfile) {
        echo '<pre>';
        var_dump($varfile);
        echo '</pre>';
    }


    /**
     * Main Program Code
     * ========================
     */

    // dump $_GET
    dump($_POST);
    dumpFile($_FILES);

    ?>

</div>

</body>
</html>

