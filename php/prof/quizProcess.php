<?php
include '../include/config.php';
// MULTIPLE CHOICE
    $edit_id = $_POST['edit_id'];
    $mcQuest = $_POST['mcQuest'];
    $mcImg = $_POST['mcImg'];
    $mcAnswer = $_POST['mcAns'];
    $mcItemA = $_POST['mcChoiceA'];
    $mcItemB = $_POST['mcChoiceB'];
    $mcItemC = $_POST['mcChoiceC'];
    $mcItemD = $_POST['mcChoiceD'];
    $mcItemE = $_POST['mcChoiceE'];
    $mcPnt = $_POST['mcPnt'];
    $mcTime = $_POST['mcTime'];

    $newimgMC = $_FILES['new_imgMC']['name'];
    $oldimgMC = $_POST['old_imgMC'];

    //check if there is a pic or not//
    if(!empty($newimgMC)){
        $imgMC = "../../img/questPics/".$_FILES['new_imgMC']['name'];
    }
    else{
        $imgMC =  $oldimgMC;
    }
    
    $mcUpdate = "UPDATE `multiplechoice` SET `item_question`='$mcQuest',`item_a`='$mcItemA'  , `item_b`='$mcItemB' , `item_c`='$mcItemC' , `item_d`='$mcItemD' , `item_e`='$mcItemE' , `item_timer`='$mcTime' , `item_point`='$mcPnt' , `item_answer`='$mcAnswer' , `item_img`='$imgMC' WHERE item_number = '$edit_id'";
    $result = mysqli_query($conn, $mcUpdate);

    if ($result){
        move_uploaded_file($_FILES['new_imgMC']['tmp_name'], $imgMC);
    }
?>

<?php
$del_id = $_POST['del_id'];

    $mcDelete = "DELETE FROM multiplechoice WHERE item_number = '$del_id'";
    $result = mysqli_query($conn, $mcDelete);

        if($result){
            $del_quest = mysqli_query($conn,"DELETE FROM questions WHERE id = '$del_id'");
        }
?>


<!-- IDENTIFICATION -->
<?php
    $edit_iden_id = $_POST['edit_iden_id'];

    $idenQuest = $_POST['idenQuest'];
    $idenImg = $_POST['idenImg'];
    $idenAns = $_POST['idenAns'];
    $idenTime = $_POST['idenTime'];
    $idenPnt = $_POST['idenPnt'];

    $newimgIDEN = $_FILES['new_imgIDEN']['name'];
    $oldimgIDEN = $_POST['old_imgIDEN'];
    
    //check if there is a pic or not//
    if(!empty($newimgIDEN)){
        $imgIDEN = "../../img/questPics/".$_FILES['new_imgIDEN']['name'];
    }
    else{
        $imgIDEN =  $oldimgIDEN;
    }

     $idenUpdate = "UPDATE `identification` SET `item_question`='$idenQuest',`item_img`='$idenImg',`answer_a`='$idenAns',`item_timer`='$idenTime',`item_point`='$idenPnt',`item_img`='$imgIDEN' WHERE item_number = '$edit_iden_id'";
     $result = mysqli_query($conn, $idenUpdate);

    if ($result){
        move_uploaded_file($_FILES['new_imgIDEN']['tmp_name'], $imgIDEN);
    }
?>

<?php
$del_iden_id = $_POST['del_iden_id'];

    $idenDelete = "DELETE from identification WHERE item_number = '$del_iden_id'";
    $result = mysqli_query($conn, $idenDelete);

    if($result){
        $del_quest = mysqli_query($conn,"DELETE FROM questions WHERE id = '$del_iden_id'");
    }
?>


<!-- ENUMERATION -->
<?php
    $edit_enu_id = $_POST['edit_enu_id'];
    $enuQuest = $_POST['enuQuest'];

    $enuPnt = $_POST['enuPnt'];
    $enuTime = $_POST['enuTime'];

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

    $newimgENU = $_FILES['new_imgENU']['name'];
    $oldimgENU = $_POST['old_imgENU'];
    
    //check if there is a pic or not//
    if(!empty($newimgENU)){
        $imgENU = "../../img/questPics/".$_FILES['new_imgENU']['name'];
    }
    else{
        $imgENU =  $oldimgENU;
    }

    $enuUpdate = "UPDATE `enumeration` SET `item_question`='$enuQuest',`choice_a`='$text1',`choice_b`='$text2',`choice_c`='$text3',`choice_d`='$text4',`choice_e`='$text5',`check_a`='$enu1',`check_b`='$enu2',`check_c`='$enu3',`check_d`='$enu4',`check_e`='$enu5',`item_point`='$enuPnt',`item_timer`='$enuTime',`item_img`='$imgENU' WHERE item_number = '$edit_enu_id'";
    $result = mysqli_query($conn, $enuUpdate);

   if ($result){
       move_uploaded_file($_FILES['new_imgENU']['tmp_name'], $imgENU);
    }
?>

<?php
$del_enu_id = $_POST['del_enu_id'];

    $enuDelete = "DELETE from enumeration WHERE item_number = '$del_enu_id'";
    $result = mysqli_query($conn, $enuDelete);

    if($result){
        $del_quest = mysqli_query($conn,"DELETE FROM questions WHERE id = '$del_enu_id'");
    }
?>
