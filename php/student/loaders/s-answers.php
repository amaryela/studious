<?php
include '../../include/config.php';

//insert into database
if(!empty($_POST)) {
	 $answerID = $_POST['ansID'];
	 $status = "done";
	 $qst_ID = $_POST['qst_ID'];
	 $template = $_POST['template'];
	 $tempID = $_POST['tempID'];
	 $userid = $_POST['userid'];
	 $quizcode = $_POST['quiz_code'];
	 $item_point = $_POST['point'];
	 $correctAnswer = $_POST['correctAns'];

$checkExist = mysqli_query($conn, "SELECT * FROM `ans` WHERE `quiz_code` = '$quizcode' AND `question_id` = '$qst_ID' AND user_id ='$userid'");
		if ($ce = mysqli_num_rows($checkExist) == 1){
			echo "<script>alert('you have answered already!');</script>";
		}	else{


if ($answerID !=  $correctAnswer){
	 	$score = 0;

//insert answersif 
		 mysqli_query($conn, "insert into ans (ans, template, question_id, user_id , quiz_code , score , status) values ('$answerID' , '$template' , '$qst_ID' , '$userid' , '$quizcode', '$score', '$status')"); 
 

//update quizaccess status if student is done answering

	$total = mysqli_query($conn, "SELECT * FROM `quizaccess` WHERE `q_code` = '$quizcode' AND quiz_takerID ='$userid'");
			$tr = mysqli_fetch_assoc($total);
 			$currentScore = $tr['score'];

 			$totalScore = $currentScore + $score;


		 $sql = "UPDATE `quizaccess` SET  `status` = '$status' , `score` = '$totalScore' WHERE `q_code` = '$quizcode' AND quiz_takerID ='$userid'";
			$check_ = mysqli_query($conn,$sql);

			if($check_){
				 echo "YOUR ANSWER : ".$answerID."</br>";
			}  

	 }


	 if ($answerID == $correctAnswer){
	 	$score = $item_point;

//insert answers
		 mysqli_query($conn, "insert into ans (ans, template, question_id, user_id , quiz_code , score , status) values ('$answerID' , '$template' , '$qst_ID' , '$userid' , '$quizcode', '$score', '$status')"); 
 

//update quizaccess status if student is done answering
			$total = mysqli_query($conn, "SELECT * FROM `quizaccess` WHERE `q_code` = '$quizcode' AND quiz_takerID ='$userid'");
			$tr = mysqli_fetch_assoc($total);
 			$currentScore = $tr['score'];

 			$totalScore = $currentScore + $score;

		 $sql = "UPDATE `quizaccess` SET  `status` = '$status' , `score` = '$totalScore' WHERE `q_code` = '$quizcode' AND quiz_takerID ='$userid'";
			$check_ = mysqli_query($conn,$sql);

			if($check_){
				 echo "YOUR ANSWER : ".$answerID."</br>";
			} 
	  }
	}
}
?>