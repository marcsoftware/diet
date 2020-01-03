<?php



error_reporting();


$date = $_POST['date'];
$txt = ($_POST['consumed']);

$myfile = fopen("archive/${date}.txt", "w");

fwrite($myfile, $txt);

fclose($myfile);
