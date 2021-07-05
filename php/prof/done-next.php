<?php
include '../include/config.php';

//insert into database
if(!empty($_POST)) {
 $status = $_POST['status'];
 $qst_ID = $_POST['qst_ID'];
 $template = $_POST['template'];
 $tempID = $_POST['tempID'];

 $Ustatus = "none";
 $readyNextQuestion = "ready";


 $qqResult = mysqli_query($conn, "SELECT * FROM `questions` WHERE `id`='$qst_ID'");
		    $qq= mysqli_fetch_array($qqResult);
		    $quiz_code = $qq['quiz_code'];

		    mysqli_query($conn, "UPDATE `quizaccess` SET `status` = '$Ustatus' WHERE `q_code` = '$quiz_code'"); 



if ($status == "finished"){


//UPDATE QUESTION TO FINISHED
	 		mysqli_query($conn, "UPDATE `questions` SET `status` = '$status' WHERE `id` = '$qst_ID'"); 


//FOR READY STATUS
		    mysqli_query($conn, "UPDATE `questions` SET `status` = '$readyNextQuestion' WHERE quiz_code =  '$quiz_code' AND `status` = 'set' LIMIT 1");  

//IDENTIFICATION SAVE
		if ($template == "identification")  {
			$idenFetch = mysqli_query($conn, "SELECT * FROM `identification` WHERE `id`='$tempID'");
		    $iden = mysqli_fetch_array($idenFetch);

		 echo "STATUS : ".$status."</br>";
		 echo "<style> #doneID { display: none;  }</style>";
		 echo "CORRECT ANSWER: " . $iden['answer_a'];
		 }
//IDENTIFICATION SAVE



//MULTIPLE CHOICE SAVE
		else if ($template == "multiple choice"){
				$mcFetch = mysqli_query($conn, "SELECT * FROM `multiplechoice` WHERE `id`='$tempID'");
				 $mc = mysqli_fetch_array($mcFetch);

				 echo "STATUS : ".$status."</br>";
				 echo "<style> #doneID { display: none;  }</style>";
				 echo "CORRECT ANSWER: " . $mc['item_answer'];
				}
//MULTIPLE CHOICE SAVE

				//IDENTIFICATION SAVE
		else if ($template == "enumeration")  {
			$enuFetch = mysqli_query($conn, "SELECT * FROM `enumeration` WHERE `id`='$tempID'");
		    $enu = mysqli_fetch_array($enuFetch);

		 echo "STATUS : ".$status."</br>";
		 echo "<style> #doneID { display: none;  }</style>";
		 echo "CORRECT ANSWER: " . $enu['answer_a'];
		 }
//IDENTIFICATION SAVE
}


		if ($status == "done"){
//UPDATE QUESTION STATUS TO DONE 

			mysqli_query($conn, "UPDATE `questions` SET `status` = '$status' WHERE `id` = '$qst_ID'"); 

//IDENTIFICATION SAVE
		if ($template == "identification")  {
			$idenFetch = mysqli_query($conn, "SELECT * FROM `identification` WHERE `id`='$tempID'");
		    $iden = mysqli_fetch_array($idenFetch);

		 echo "STATUS : ".$status."</br>";
		 echo "<style> #doneID { display: none;  }</style>";
		 echo "CORRECT ANSWER: " . $iden['answer_a'];
		 }
//IDENTIFICATION SAVE



//MULTIPLE CHOICE SAVE
		else if ($template == "multiple choice"){
				$mcFetch = mysqli_query($conn, "SELECT * FROM `multiplechoice` WHERE `id`='$tempID'");
				 $mc = mysqli_fetch_array($mcFetch);

				 echo "STATUS : ".$status."</br>";
				 echo "<style> #doneID { display: none;  }</style>";
				 echo "CORRECT ANSWER: " . $mc['item_answer'];
				}
//MULTIPLE CHOICE SAVE



//ENUMERATION SAVE 
				else if ($template == "enumeration"){
				$enuFetch = mysqli_query($conn, "SELECT * FROM `enumeration` WHERE `id`='$tempID'");
				 $enu = mysqli_fetch_array($enuFetch);

				   $ans1 =  $enu['check_a'];
  				   $ans2 =  $enu['check_b'];
			       $ans3 =  $enu['check_c'];
     			   $ans4 =  $enu['check_d'];
 			       $ans5 =  $enu['check_e'];


				 echo "STATUS : ".$status."</br>";
				 echo "<style> #doneID { display: none;  }</style>";
				 echo "CORRECT ANSWER: " . $ans1 . "/" . $ans2 . "/" . $ans3 . "/" . $ans4 . "/" . $ans5;
				}
		}
}