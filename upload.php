<?php
//https://www.php.net/manual/en/features.file-upload.post-method.php
//https://www.php.net/manual/en/function.file-exists.php

$dirname = dirname(__FILE__);
$filename = $dirname . "/uploads/";
$uploaddir = $dirname.'/uploads/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
$extension = pathinfo($uploadfile, PATHINFO_EXTENSION);

if($extension == 'csv' && $_FILES['userfile']['size'] >= 1){
    if (file_exists($filename)) {
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
        {
            echo "<h1 style='text-align: center'>File is valid, and was successfully uploaded!</h1>".PHP_EOL;
        }
    } else {
        mkdir($dirname."/uploads/", 0755);
        (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile));
        echo "<h1 style='text-align: center'>The directory $filename doesn't exist, it was successfully created</h1>".PHP_EOL;
        echo "<h2 style='text-align: center'>File is valid, and was successfully uploaded.</h2>".PHP_EOL;
    }
}
else {
    exit("<h1 style='text-align: center'>Invalid file format. The file must be in CSV format and not empty.</h1>".PHP_EOL);
}

if (file_exists($filename)){
    echo "<table style='box-shadow: inset -1px -1px 10px #3383FF; margin-left: auto; margin-right: auto; padding: 5px; border-radius: 3px; width: 50%'>";

    $stream = fopen($uploadfile, "r");
    $first = true;

    while (($row = fgetcsv($stream,'0',";")) !== false) {
        echo "<tr>";
        if ($first) {
            foreach ($row as $col) { echo "<th style='border: #3383FF 1px solid; padding: 5px; font-size: 20px; border-radius: 3px; background-color: #33B5FF;'>$col</th>"; }
            $first = false;
        } else { foreach ($row as $col) { echo "<td style='border: brown 1px solid; padding: 5px; border-radius: 3px;'>$col</td>"; } }
        echo "</tr>";
    }
    fclose($stream);
    echo "</table>";
}