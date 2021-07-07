<?php
$servername = "remotemysql.com"; 
$database 	= "zQGfcDFPDS"; 
$dbname 	= "zQGfcDFPDS"; 
$dbpass 	= "1n00OOSXww"; 

// xampp connection
// $servername = "localhost"; 
// $database 	= "studious"; 
// $dbname 	= "root"; 
// $dbpass 	= ""; 

$conn = mysqli_connect($servername, $dbname,
$dbpass, $database);

if ($conn === false){
	die ("CONNECTION ERROR".mysqli_connect_error());
}
?>