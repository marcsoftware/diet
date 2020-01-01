<?php
header("Content-Type: application/json");




$date = $_POST['date'];

$today=date("Y-m-d");
//get todays date
	
	//read file
	$file = file_get_contents("archive/${date}.txt", FILE_USE_INCLUDE_PATH);
	//echo $file;
	//return $file;

echo $file;