<?php



//
// PHP FUNCTION YOU WANT TO CALL
function save ($data) {
    // Do your processing
    // Save to database of something

    $myfile = fopen("data.txt", "w") or die("Unable to open file!");
$txt = $data;
fwrite($myfile, $txt);

fclose($myfile);


    
  }
  
  // PUT THE POST VARIABLES IN
  $pass = save($_POST['consumed']);

//
echo json_encode([
    "status" => true,
    "message" => true
  ]);