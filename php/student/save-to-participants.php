
<?php
include '../include/config.php';
session_start();

if(isset($_POST['takequiz'])){
	$quiz_code = $_POST['qcode'];
	$room_code = $_POST['rcode'];
	$user_id =  $_POST['user'];
	$sq_id =  $_POST['schedID'];
	$_SESSION['sched_id'] = $sq_id;
	$_SESSION['room_code'] = $room_code;

	$_SESSION["theCode"] = $quiz_code;
	
$stat = mysqli_query($conn, "SELECT `status` FROM `scheduledquizzes` WHERE quiz_code = '$quiz_code' AND quiz_roomcode = '$room_code'");
$sd = mysqli_fetch_assoc($stat);
if ($sd['status'] == "set"){
	echo "<script>window.location='studRoom.php?next=$room_code';</script>";
}else{

	$results = mysqli_query($conn, "SELECT * FROM `users` WHERE `ID` = '$user_id'");
	$row = mysqli_fetch_array($results);
		$uFName =  $row['uFirstName'];
		$uLName = $row['uLastName']; 
		$uE = $row['uEmail'];

		$checkExist = mysqli_query($conn, "SELECT * FROM  `quizaccess` WHERE quiz_takerID = '$user_id' AND q_code = '$quiz_code'");
		if ($ce = mysqli_num_rows($checkExist) == 1){
			echo "<script>window.location='s-quiz-room.php?next=$sq_id';</script>";
		}	else{


	$sql = "INSERT INTO `quizaccess`(`q_code`, `q_roomcode`, `quiz_takerID` ,`quiz_takerFName` ,`quiz_takerLName`, `quiz_takerEmail`) VALUES ('".$quiz_code."','".$room_code."','".$user_id."','".$uFName."','".$uLName."','".$uE."')";
	$check_ = mysqli_query($conn,$sql);

		if($check_){
			echo "<script>window.location='s-quiz-room.php?next=$sq_id';</script>";
		}}	
	}
}