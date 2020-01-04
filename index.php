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
var date_offset=0;
var full_date;

//---------------------------------------------------------------------------------
//
//---------------------------------------------------------------------------------
function init(){
	var pantry =document.getElementById('pantry').innerHTML;
	var list = pantry.split("\n");

	list = list.map(wrap);
	getDate();
	readArchive(full_date);
 	
	document.getElementById('list').innerHTML=list.join("<br/>");
	total();

	setTimeout(function () {
		total();
	}, 100);
	
	
	
}

//---------------------------------------------------------------------------------
// turn each item into a button
//---------------------------------------------------------------------------------
function wrap(item, index) {
  return "<button value='ITEM' onclick='consume(this)'>ITEM</button>".replace(/ITEM/g,item);
}

//---------------------------------------------------------------------------------
// copy buttons contents to the TEXATAREA 
// this function is called when user clicks button
//---------------------------------------------------------------------------------
function consume(handle){
	//get hours and minutes
	var date= new Date();
	var seconds = date.getSeconds();
	var minutes = date.getMinutes();
	var label="am"
	if(minutes <10){
		minutes = "0"+minutes;
	}
	var hour = date.getHours();
	if(hour <10){
		hour = "0"+hour;
	}

	if(hour > 12){
		hour=hour-12;
		label="pm";
	}

	var clock = `( ${hour}:${minutes}${label} )`;
	
	// put in textarea called consumed
	document.getElementById('consumed').value+=clock+(handle.value)+'\n';
	total();
	save();
	
	
}

//---------------------------------------------------------------------------------
// Read archived file
//---------------------------------------------------------------------------------
function readArchive( date){
	// GET DATA
	var data = new FormData();
      
	  //var type = XMLHttpRequest.responseType;

//XMLHttpRequest.responseType = type;
	  
	  data.append('date',date);
      // AJAX CALL
      var xhr = new XMLHttpRequest();
      xhr.open('POST', "readArchive.php", true);
      xhr.onload = function () {
		  document.getElementById("consumed").value=this.response;
		 
		  
		  console.log(this.response);
        var res = (this.response);
       
       
      };
      xhr.send(data);
      return false;
}

//---------------------------------------------------------------------------------
// caculate the total calories and render the total
//---------------------------------------------------------------------------------
function total(){
	var all = document.getElementById('consumed').value;
	
	 all = all.replace(/\(([^\)]+)\)/g,""); // ignore numbers in parenthesis
	 all +=" 0 "; // to prevent null error
	var numbers = all.match(/\d+/g);
	
	var sum=numbers.reduce(myFunc);
	document.getElementById('total').innerHTML=sum	;
	
}

//---------------------------------------------------------------------------------
// add number to the total
//---------------------------------------------------------------------------------
function myFunc(total, num) {
  return parseInt(total) + parseInt(num);
} 

//---------------------------------------------------------------------------------
// permanantly save the users's consumed food items to a file
//---------------------------------------------------------------------------------
function save() {
      // GET DATA
	  var data = new FormData();
      var consumed = document.getElementById('consumed').value;
	  
	  data.append('consumed',consumed);
	  
	  data.append('date',full_date);
      // AJAX CALL
      var xhr = new XMLHttpRequest();
      xhr.open('POST', "save.php", true);
      xhr.onload = function () {
        console.log(this.response);
       
      };
      xhr.send(data);
      return false;
}

//---------------------------------------------------------------------------------
// change date to yesterday or before
//---------------------------------------------------------------------------------	
function prev(){
	
	date_offset--;
	
	getDate();
	readArchive(full_date);
	total();
}


//---------------------------------------------------------------------------------
// change date to tomarrow or later
//---------------------------------------------------------------------------------	
function next(){
	
	date_offset++;
	
	getDate();
	readArchive(full_date);
	total();
}


//---------------------------------------------------------------------------------
// get date that matches the  PHP format
//---------------------------------------------------------------------------------	
function getDate(){

	today = new Date();
	target_date = new Date(today);
	target_date.setDate(today.getDate() + date_offset); 

	var year=target_date.getFullYear();
	var month=target_date.getMonth()+1;
	if(month<10){
		month="0"+month;
	}
	var date=target_date.getDate();
	if(date<10){
		date="0"+date;
	}
	
	 full_date=( `${year}-${month}-${date}`);
	document.getElementById("date").innerHTML=full_date;
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
<button onclick="prev()">◀</button> <span id='date'>0</span><button onclick="next()">▶</button>
<p id='total'></p>
<textarea id='consumed' onkeyup='total()'>


</textarea>

</div>

</body>
</html>

