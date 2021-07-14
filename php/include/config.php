<?php
// heroku 
$servername = "remotemysql.com"; 
$database 	= "zQGfcDFPDS"; 
$dbname 	= "zQGfcDFPDS"; 
$dbpass 	= "1n00OOSXww"; 

// xampp connection
// $servername = "localhost"; 
// $database 	= "studious"; 
// $dbname 	= "root"; 
// $dbpass 	= "";

// infinityfree
// $servername = "localhost"; 
// $database 	= "id17231359_studious"; 
// $dbname 	= "id17231359_studiousdb"; 
// $dbpass 	= "04CfUeh(DxAAalms";


$conn = mysqli_connect($servername, $dbname,
$dbpass, $database);

if ($conn === false){
	die ("CONNECTION ERROR".mysqli_connect_error());
}
?>
