<?php

$date = $_POST['date'];
$myfile = fopen("archive/${date}.txt", "w") or die("Unable to open file!");
$today=date("Y-m-d");
//get todays date
	
	//read file
	$file = file_get_contents("archive/${date}.txt", FILE_USE_INCLUDE_PATH);
	echo $file;