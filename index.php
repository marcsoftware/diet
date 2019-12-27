<!DOCTYPE html>
<html>
<title>pantry</title>
<link rel="stylesheet" type="text/css" href="food.css" />
<body>

<h2>PANTRY</h2>


<p id="demo"></p>

<script>

//---------------------------------------------------------------------------------
// 
//---------------------------------------------------------------------------------
window.onload=init;


//---------------------------------------------------------------------------------
//
//---------------------------------------------------------------------------------
function init(){
	var pantry =document.getElementById('pantry').innerHTML;
	var list = pantry.split("\n");

	
	

	list = list.map(wrap);

	

	document.getElementById('list').innerHTML=list.join("<br/>");
	
}

//---------------------------------------------------------------------------------
// turn each item into a button
//---------------------------------------------------------------------------------
function wrap(item, index) {
  return "<button value='ITEM' onclick='consume(this)'>ITEM</button>".replace(/ITEM/g,item);
}

//---------------------------------------------------------------------------------
//
//---------------------------------------------------------------------------------
function consume(handle){
	document.getElementById('consumed').value+=(handle.value)+'\n';
	total();
	
}


//---------------------------------------------------------------------------------
//
//---------------------------------------------------------------------------------
function total(){
	var all = document.getElementById('consumed').value;
	var numbers = all.match(/\d+/g);
	var sum=numbers.reduce(myFunc);
	document.getElementById('total').innerHTML=sum	;
	save();
}

//---------------------------------------------------------------------------------
// add
//---------------------------------------------------------------------------------
function myFunc(total, num) {
  return parseInt(total) + parseInt(num);
} 

//---------------------------------------------------------------------------------
// save
//---------------------------------------------------------------------------------
function save() {
      // GET DATA
	  var data = new FormData();
      var consumed = document.getElementById('consumed').value;
	  data.append('consumed',consumed);
      // AJAX CALL
      var xhr = new XMLHttpRequest();
      xhr.open('POST', "save.php", true);
      xhr.onload = function () {
        console.log(this.response);
       
      };
      xhr.send(data);
      return false;
    }
</script>


<p id='pantry' class='hide'>
	<?php
	//C:\xampp\htdocs\index.php
	$file = file_get_contents('./food.txt', FILE_USE_INCLUDE_PATH);
	echo $file;
	?>
</p>

<div class='left'>
	<p id='list'>
		<?php
		//C:\xampp\htdocs\index.php
		$file = file_get_contents('./food.txt', FILE_USE_INCLUDE_PATH);
		echo $file;
		?>
	</p>
</div>

<div class='right'>
<button onclick="save()">Click me</button> 
<p id='total'></p>
<textarea id='consumed' onkeyup='total()'>
<?php
	//C:\xampp\htdocs\index.php
	$file = file_get_contents('./data.txt', FILE_USE_INCLUDE_PATH);
	echo $file;
	?>

</textarea>

</div>

</body>
</html>

