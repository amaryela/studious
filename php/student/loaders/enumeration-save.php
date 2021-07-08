<?php
include '../../include/config.php';

//insert into database
if(!empty($_POST)) {

  $enu1 = $_POST['ae1'];
  $enu2 = $_POST['ae2'];
  $enu3 = $_POST['ae3'];
  $enu4 = $_POST['ae4'];
  $enu5 = $_POST['ae5'];

  $en1 = $_POST['txt1'];
  $en2 = $_POST['txt2'];
  $en3 = $_POST['txt3'];
  $en4 = $_POST['txt4'];
  $en5 = $_POST['txt5'];

if ($enu1 == "true"){
	$ans1 = $en1;
}else{
	$ans1 = "";
}

if ($enu2 == "true"){
	$ans2 = $en2;
}else{
	$ans2 = "";
}

if ($enu3 == "true"){
	$ans3 = $en3;
}else{
	$ans3 = "";
}

if ($enu4 == "true"){
	$ans4 = $en4;
}else{
	$ans4 = "";
}

if ($enu5 == "true"){
	$ans5 = $en5;
}else{
	$ans5 = "";
}

	 $answerID = $ans1 . $ans2 .  $ans3 .  $ans4 .$ans5;
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

			$enuans = "INSERT INTO `enumeration ans`(`quiz_code`, `quiz_id`, `user_id`, `choice_a`, `checked_a`, `choice_b`, `checked_b`, `choice_c`, `checked_c`, `choice_d`, `checked_d`, `choice_e`, `checked_e`) VALUES ('".$quizcode."', '".$qst_ID."' , '".$userid."' ,'".$en1."' ,'".$enu1."' ,'".$en2."' ,'".$enu2."' ,'".$en3."' ,'".$enu3."' ,'".$en4."' ,'".$enu4."' ,'".$en5."' ,'".$enu5."')";
			$check_enu = mysqli_query($conn,$enuans);
			
			if($check_enu){
				if ($answerID !=  $correctAnswer){
					$score = 0;

//insert answersif 
					mysqli_query($conn, "INSERT INTO ans (ans, template, question_id, user_id , quiz_code , score , status) VALUES ('$answerID' , '$template' , '$qst_ID' , '$userid' , '$quizcode', '$score', '$status')"); 
 
//update quizaccess status if student is done answering
	$total = mysqli_query($conn, "SELECT * FROM `quizaccess` WHERE `q_code` = '$quizcode' AND quiz_takerID ='$userid'");
			$tr = mysqli_fetch_assoc($total);
 			$currentScore = $tr['score'];

 			$totalScore = $currentScore + $score;

		 $sql = "UPDATE `quizaccess` SET  `status` = '$status' , `score` = '$totalScore' WHERE `q_code` = '$quizcode' AND quiz_takerID ='$userid'";
			$check_ = mysqli_query($conn,$sql);

			if($check_){
				echo "You answered: ".$answerID."<br>";
			} 
	 }

	 if ($answerID == $correctAnswer){
		 $score = $item_point;
//insert answers
		 mysqli_query($conn, "INSERT INTO ans (ans, template, question_id, user_id , quiz_code , score , status) VALUES ('$answerID' , '$template' , '$qst_ID' , '$userid' , '$quizcode', '$score', '$status')"); 
 
//update quizaccess status if student is done answering
			$total = mysqli_query($conn, "SELECT * FROM `quizaccess` WHERE `q_code` = '$quizcode' AND quiz_takerID ='$userid'");
			$tr = mysqli_fetch_assoc($total);
 			$currentScore = $tr['score'];

 			$totalScore = $currentScore + $score;

		 	$sql = "UPDATE `quizaccess` SET  `status` = '$status' , `score` = '$totalScore' WHERE `q_code` = '$quizcode' AND quiz_takerID ='$userid'";
			$check_ = mysqli_query($conn,$sql);

			if($check_){
				echo "You answered: ".$answerID."<br>";
			} 
	  }
}
}
}
?>