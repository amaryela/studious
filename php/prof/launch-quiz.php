<?php
include '../include/config.php';
session_start();

if(isset($_POST['launch'])){
	$quiz_code = $_POST['qcode'];
	$room_code = $_POST['rcode'];
	$qstatus =  $_POST['status'];
	$_SESSION["theCode"] = $quiz_code;

//UPDATE STATUS FROM SCHEDULEDQUIZZES TABLE FROM 
	$sql = "UPDATE `scheduledquizzes` SET `status` = '$qstatus' WHERE `quiz_code` = '$quiz_code' AND quiz_roomcode ='$room_code'";
	$check_ = mysqli_query($conn,$sql);

		if($check_){
			$sched = "SELECT * FROM `scheduledquizzes` WHERE `quiz_code` = '$quiz_code' AND quiz_roomcode ='$room_code'";
			$result = mysqli_query($conn, $sched);
 			$row = mysqli_fetch_array($result);
 			$sq_id = $row['id'];
 			$stats = $row['status'];
			 
			// echo "<script>alert('QUIZ LAUNCHED!');window.location='waitingRoom.php?next=$quiz_code';</script>";
			echo "<script>window.location='waitingRoom.php?next=$quiz_code';</script>";
		}	
	}




	if(isset($_POST['startquiz'])){
		$State = $_POST['status'];
		$ready = "ready";
		$q_code = $_POST['quizcode'];
		$r_code = $_POST['qroom'];
		$_SESSION["room_code"] = $r_code;
	
	//UPDATE STATUS FROM SCHEDULEDQUIZZES TABLE FROM 
		$ongoing = "UPDATE `scheduledquizzes` SET `status` = '$State' WHERE  `quiz_code` = '$q_code' AND quiz_roomcode ='$r_code'";
		$onResult = mysqli_query($conn, $ongoing);
		 if($onResult){

	//UPDATE STATUS FROM QUESTION TABLE
		 	$readyUp = "UPDATE `questions` SET `status` = '$ready' WHERE  `quiz_code` = '$q_code' LIMIT 1";
				$readyQ = mysqli_query($conn, $readyUp);
		 if($readyQ){
				
	//UPDATE STATUS FROM QUIZ TABLE di na need
				//  $quizStatus="UPDATE `quiz` SET status = '$State' WHERE `quiz_code` = '$q_code' AND quiz_roomcode ='$r_code'";
				//  $quizResult = mysqli_query($conn, $quizStatus);	
				//  if($quizResult){
	
	//GET ID FROM SCHEDULEDQUIZZES 
					 $sched = "SELECT * FROM `scheduledquizzes` WHERE `quiz_code` = '$q_code' AND quiz_roomcode ='$r_code'";
						$result = mysqli_query($conn, $sched);
						 $row = mysqli_fetch_array($result);
						 $sq_id = $row['id'];
						 $_SESSION["sched_id"] = $sq_id;
					 
					 echo "<script>alert('QUIZ STARTED!');window.location='on-going-quiz.php?next=$sq_id';</script>";
			// }
		}
	}
}