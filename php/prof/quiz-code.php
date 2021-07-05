<?php
include '../include/config.php';

if(isset($_POST['mcsave'])){

		$choicea = $_POST['mcchoicea'];
		$choiceb = $_POST['mcchoiceb'];

		if(empty($_POST['mcchoicec'])){
			$choicec = "";
		}else{
			$choicec = $_POST['mcchoicec'];
		}	

		if(empty($_POST['mcchoiced'])){
			$choiced = "";
		}else{
			$choiced = $_POST['mcchoiced'];
		}

		if(empty($_POST['mcchoicee'])){
			$choicee = "";
		}else{
			$choicee = $_POST['mcchoicee'];
		}

$question = $_POST['mcqfield'];
$tmplt = $_POST['mctemplate'];
$answer = $_POST['mcAns'];
$timer = $_POST['mcTime'];
$point = $_POST['mcPnt'];
$codee = $_POST['quizcode'];
$name = $_POST['quizname'];

$stats = "set";

$imgMC = "../../img/questPics/".$_FILES['imgMC']['name'];

$qsql="INSERT INTO `questions`(`quiz_code`,`question_template`,`point`,`status`) VALUES ('".$codee."','".$tmplt."','".$point."','".$stats."')";
$check_reg = mysqli_query($conn,$qsql);
	
	if($check_reg){
		$itemn = mysqli_insert_id($conn);
		
		move_uploaded_file($_FILES['imgMC']['tmp_name'], $imgMC);
	
		$sql = "INSERT INTO `multiplechoice`(`quiz_code`, `quiz_name`, `item_question`, `item_a`, `item_b`, `item_c`, `item_d`, `item_e`, `item_timer`, `item_point`, `item_answer`, `item_img`, `item_number`) VALUES ('".$codee."','".$name."','".$question."','".$choicea."','".$choiceb."','".$choicec."','".$choiced."', '".$choicee."','".$timer."','".$point."','".$answer."','".$imgMC."','".$itemn."')";
		$check_ = mysqli_query($conn,$sql);

		if($check_){
			echo "<script>window.location='makeQuiz.php?next=$codee';</script>";
		}	
	}
}


if(isset($_POST['idenSave'])){
	$idenQuest = $_POST['idenQuest'];
	$tmplt = $_POST['identemplate'];
	$idenAns = $_POST['idenAns'];
	$idenTime = $_POST['idenTime'];
	$idenPnt = $_POST['idenPnt'];
	$codee = $_POST['quizcode'];
	$name = $_POST['quizname'];

	$stats = "set";

	$imgIDEN = "../../img/questPics/".$_FILES['imgIDEN']['name'];

	$qsql="INSERT INTO `questions`(`quiz_code`,`question_template`,`point`,`status`) VALUES ('".$codee."','".$tmplt."','".$idenPnt."','".$stats."')";
	$check_reg = mysqli_query($conn,$qsql);

	if($check_reg){
		$itemn = mysqli_insert_id($conn);

		move_uploaded_file($_FILES['imgIDEN']['tmp_name'], $imgIDEN);

		$reg_sql = "INSERT INTO `identification`(`quiz_code`,`quiz_name`,`item_question`, `answer_a`, `item_timer`, `item_point`, `item_img`, `item_number`)  VALUES ('".$codee."','".$idenQuest."','".$idenAns."','".$idenTime."','".$idenPnt."','".$imgIDEN."','".$itemn."')";
		$check_ = mysqli_query($conn,$reg_sql);

		if($check_){
			echo "<script>window.location='makeQuiz.php?next=$codee';</script>";
		}
	}
}


if(isset($_POST['enusave'])){

	$enu1 = $_POST['enu1'];
  $enu2 = $_POST['enu2'];
  $enu3 = $_POST['enu3'];
  $enu4 = $_POST['enu4'];
  $enu5 = $_POST['enu5'];

  $text1 = $_POST['e1'];
  $text2 = $_POST['e2'];

	if(empty($_POST['e3'])){
		$text3 = "";
	}else{
		$text3 = $_POST['e3'];
	}

	if(empty($_POST['e4'])){
		$text4 = "";
	}else{
		$text4 = $_POST['e4'];
	}

	if(empty($_POST['e5'])){
		$text5 = "";
	}else{
		$text5 = $_POST['e5'];
	}

	$question = $_POST['eqfield'];
	$timer = $_POST['enumTime'];
	$point = $_POST['enumPnt'];
	$tmplt = $_POST['enutemplate'];
	$codee = $_POST['quizcode'];
	$name = $_POST['quizname'];

	$stats = "set";

	$imgENU = "../../img/questPics/".$_FILES['imgENU']['name'];
	$stat = "set";

	$qsql="INSERT INTO `questions`(`quiz_code`,`question_template`,`point`,`status`) VALUES ('".$codee."','".$tmplt."','".$point."','".$stats."')";
	$check_reg = mysqli_query($conn,$qsql);

	if($check_reg){
		$itemn = mysqli_insert_id($conn);

		move_uploaded_file($_FILES['imgENU']['tmp_name'], $imgENU);

		$sql = "INSERT INTO `enumeration`(`quiz_code`,`quiz_name`, `item_question`, `choice_a`, `check_a`, `choice_b`, `check_b`, `choice_c`, `check_c`, `choice_d`, `check_d`, `choice_e`, `check_e`, `item_timer`, `item_point`, `item_img`, `item_number`)  VALUES ('".$codee."','".$question."','".$text1."','".$enu1."','".$text2."','".$enu2."','".$text3."','".$enu3."','".$text4."','".$enu4."','".$text5."','".$enu5."','".$timer."','".$point."', '".$imgENU."', '".$itemn."')";
		$check_ = mysqli_query($conn,$sql);

		if($check_){
			echo "<script>window.location='makeQuiz.php?next=$codee';</script>";
		}
	}
}

/*P U B L I S H  Q U I Z */
if(isset($_POST['publish'])){
  $p_status=$_POST['status'];
  $p_date=$_POST['date'];
  $p_time= $_POST['time'];
  $qcode= $_POST['quizcode'];
	$name= $_POST['quizname'];
  
  $result = mysqli_query($conn , "SELECT * FROM `quiz` WHERE `quiz_code`='$qcode'");
  $row = mysqli_fetch_assoc($result);
  
  $roomcode = $row['quiz_roomcode'];

		$sql = "INSERT INTO `scheduledquizzes`(`quiz_code`, `quiz_name`, `quiz_roomcode`, `quiz_date`, `quiz_time`, `status`) VALUES ('".$qcode."','".$name."','".$roomcode."','".$p_date."','".$p_time."','".$p_status."')";

        $check_reg = mysqli_query($conn,$sql);

        if($check_reg){
					echo "<script>window.location='profRoom.php?next=$roomcode';</script>";
        }
	}
?>