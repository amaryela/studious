<?php
$servername = "remotemysql.com"; 
$database 	= "nWajPpcVbX"; 
$dbname 	= "nWajPpcVbX"; 
$dbpass 	= "aHivNFs58c"; 

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