<?php

/**
 * Lab 03, Exercise 1 & 2 — Start File
 * @author Bramus Van Damme <bramus.vandamme@odisee.be>
 */

	// vars

		$basePath = __DIR__ . DIRECTORY_SEPARATOR . 'images'; // check the location on disk!
		$baseUrl = 'images'; // images
		$images = []; // An array which will hold all our images

	// Main code

		// @TODO Open directory and captions file using some SPL classes

    $dir = new DirectoryIterator(($basePath));
    foreach ($dir as $file){
        $linesArr = [];
        //$spl = new SplFileInfo($file);
        if (!$file -> isDot() && !$file -> isDir() && $file -> getExtension() == 'jpg'){
            //$images[$file -> getFilename()] = $file -> getExtension();
            $images[] = $file -> getFilename();
        }
        else if(!$file -> isDot() && !$file -> isDir()){
            $caption = $file -> getFilename();
            $lines = new SplFileObject($basePath.'/'.$caption);
            $i = 0;
            while (!$lines -> eof()){
                $linesArr[$i] = $lines -> fgets();
                    $i++;
            }
        }
        /*$imageArr = [];
        $j = 0;
        foreach ($images as $image){
            $imageArr[$image] = $linesArr[$j];
            $j++;
        }*/
    }
$imageArr = [];
$j = 0;
foreach ($images as $image){
    $imageArr[$image] = $linesArr[$j];
    $j++;
}
		// @TODO loop directory


			// If it's a '.jpg', add it onto an array named $images
			// Use an associative array so you can store the filename, and caption


?><!doctype html>
<html>
<head>
	<title>Images</title>
	<meta charset="utf-8" />
	<style>

		body {
			font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", sans-serif;
			font-weight: 300;
			font-size: 14px;
			line-height: 1.2;
			background: #FCFCFC;
		}

		ul {
			margin: 0;
			padding: 0;
			list-style: none;
		}

		li {
			display:  block;
			width: 310px;
			height: 310px;
			float: left;
			border: 1px solid #ccc;
			margin: 20px;
			position: relative;
			box-shadow: 0 0 20px #CCC;

		}

		li img {
			max-width: 100%;
		}

		li .caption {
			display: block;
			position: absolute;
			bottom: 0;
			left: 0;
			right: 0;
			padding: 5px;
			color: #000;
			background: rgba(255,255,255,0.9);
			border-top: 1px solid #ccc;
			text-shadow: 1px 1px 1px #fff;
		}

		li:hover {
			box-shadow: 0 0 20px #999;
		}

	</style>
</head>
<body>
	<ul>
<?php
	foreach ($imageArr as $image => $image_value) {
		echo '<li><img src="'.$baseUrl.'/'.$image.'" alt=""><span class="caption">'.$image_value.'</span></li>' . PHP_EOL;
	}
?>
	</ul>
</body>
</html>