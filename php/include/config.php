<?php
$servername = "remotemysql.com"; 
$database 	= "7b6lAP0DIS"; 
$dbname 	= "7b6lAP0DIS"; 
$dbpass 	= "Bgts20RA5Z"; 

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