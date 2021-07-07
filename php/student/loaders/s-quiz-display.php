<?php
include '../../include/config.php';
session_start();

$userid = $_SESSION['id'];

error_reporting(E_ALL ^ E_WARNING); 

$schedule = $_SESSION['sched_id'];
$rcode = $_SESSION["room_code"];

$quiz_code = $_SESSION["theCode"];
$sheesh = $_SESSION["status"]; 

$statusUpdate = mysqli_query($conn, "SELECT * FROM `scheduledquizzes` WHERE id ='$schedule'");
$stts_up = mysqli_fetch_array($statusUpdate);


//WAITING 
if ($stts_up['status']  == "waiting"){
    // echo "waiting for prof";?>
    <div class="text-center">
      <img class="text-center" src="../../img/Ellipsis-2s-200px.svg" alt="loading">
      <h1>Waiting for prof to start the quiz</h1>
    </div>
  <?php }

//FINAL ANS
if ($stts_up['status']  == "on-going"){ 
$squery = "SELECT * FROM quiz WHERE quiz_code = '$quiz_code'" ;
$sresult = mysqli_query($conn, $squery);
  while($srow = mysqli_fetch_array($sresult)){ 

    $question_id = $_SESSION['qstn_id'];
      $qq = mysqli_query($conn, "SELECT * FROM `questions` WHERE id ='$question_id'");
      $as = mysqli_fetch_array($qq);
            $status = $as['status']; 
            $in = $as['id'];
            
      //SHOW FINAL ANSWERS              
      if ($status == "done"){

          $ansQuery = mysqli_query($conn, "SELECT * FROM `ans` WHERE `question_id`='$question_id' AND `user_id`='$userid'");
          $ans  = mysqli_fetch_array($ansQuery);
          $user_ans = $ans['ans']; ?>

        <img class="m-2" src="../../img/logo.png" alt="imgDes" height="50px"><br>

<?php
            //IF MULTIPLE CHOICE
            if ($as['question_template'] == "multiple choice") {
            $mcFetch = mysqli_query($conn, "SELECT * FROM `multiplechoice` WHERE `item_number`='$in' AND `quiz_code`='$quiz_code'");
            while ($mc  = mysqli_fetch_array($mcFetch)){
?>
            <div class="text-center p-3">
              <h3 class="p-3"><?php echo $mc['item_question']; ?></h3>
              <br>

            <?php if ($user_ans == $mc['item_answer']) { ?>
              <div class="bg-success bg-gradient p-2 m-2 text-white ans">
                <?php echo $mc['item_answer']; ?>
              </div>

            <?php } else { ?>
              <div class="bg-danger bg-gradient p-2 m-2 text-white ans">
                <?php   echo  "You Answered : " . $user_ans; ?>
              </div>
              <div class="bg-success bg-gradient p-2 m-2 text-white ans">
                <?php   echo  "Correct Answer : " . $mc['item_answer']; ?>
              </div>
            <?php } ?>   

            </div>


            <?php }}
            if ($as['question_template'] == "enumeration") {
              $enuFetch = mysqli_query($conn, "SELECT * FROM `enumeration` WHERE `item_number`='$in' AND `quiz_code`='$quiz_code'");
              while ($enu = mysqli_fetch_array($enuFetch)){
              $ans1 =  $enu['check_a'];
              $ans2 =  $enu['check_b'];
              $ans3 =  $enu['check_c'];
              $ans4 =  $enu['check_d'];
              $ans5 =  $enu['check_e'];
            ?>

          <div class="text-center p-3">
            <h3 class="p-3"><?php echo $enu['item_question']; ?></h3>
            <br>

              <?php if(!empty($enu['choice_a'])){ ?>
                  <label>
                    <?php if($enu['check_a'] == "correct"){ ?>
                      <input type="checkbox" name="enu1" checked disabled>&nbsp;&nbsp; <?php echo $enu['choice_a']; }
                    else { ?>
                      <input type="checkbox" name="enu1" unchecked disabled>&nbsp;&nbsp; <?php echo $enu['choice_a']; }
              } ?></label><br>

              <?php if(!empty($enu['choice_b'])){ ?>
                  <label>
                    <?php if($enu['check_b'] == "correct"){ ?>
                      <input type="checkbox" name="enu2" checked disabled>&nbsp;&nbsp; <?php echo $enu['choice_b']; }
                    else { ?>
                      <input type="checkbox" name="enu2" unchecked disabled>&nbsp;&nbsp; <?php echo $enu['choice_b']; }
              } ?></label><br>

              <?php if(!empty($enu['choice_c'])){ ?>
                  <label>
                    <?php if($enu['check_c'] == "correct"){ ?>
                      <input type="checkbox" name="enu3" checked disabled>&nbsp;&nbsp; <?php echo $enu['choice_c']; }
                    else { ?>
                      <input type="checkbox" name="enu3" unchecked disabled>&nbsp;&nbsp; <?php echo $enu['choice_c']; }
              } ?></label><br>

              <?php if(!empty($enu['choice_d'])){ ?>
                  <label>
                      <?php if($enu['check_d'] == "correct"){ ?>
                      <input type="checkbox" name="enu4" checked disabled>&nbsp;&nbsp; <?php echo $enu['choice_d']; }
                      else { ?>
                      <input type="checkbox" name="enu4" unchecked disabled>&nbsp;&nbsp; <?php echo $enu['choice_d']; }
              } ?></label><br>

              <?php if(!empty($enu['choice_e'])){ ?>
                  <label>
                  <?php if($enu['check_e'] == "correct"){ ?>
                      <input type="checkbox" name="enu5" checked disabled>&nbsp;&nbsp; <?php echo $enu['choice_e']; }
                      else{ ?>
                      <input type="checkbox" name="enu5" unchecked disabled>&nbsp;&nbsp; <?php echo $enu['choice_e']; }
              } ?></label><br>

          </div>

           <!-- IF IDENTIFICATION -->
            <?php }}
            if ($as['question_template'] == "identification") {
              $sidenFetch = mysqli_query($conn, "SELECT * FROM `identification` WHERE `item_number`='$in' AND `quiz_code`='$quiz_code'");
              while ($siden = mysqli_fetch_array($sidenFetch)){
            ?>

          <div class="text-center p-3">
            <h3 class="p-3"><?php echo $siden['item_question']; ?></h3>
            <br>

            <?php  if ($user_ans == $siden['answer_a']) { ?>
              <div class="bg-success bg-gradient p-2 m-2 text-white ans"> 
                <?php echo $siden['answer_a'];?>
              </div>

            <?php } else { ?>
              <div class="bg-danger bg-gradient p-2 m-2 text-white ans">
                <?php echo "You Answered  : " .  $user_ans;?>
              </div>

              <div class="bg-success bg-gradient p-2 m-2 text-white ans">
                <?php echo "Correct Answer : " . $siden['answer_a'];?>
              </div>
            <?php } ?>

          </div>

<?php } } 

}//QUESTIONS
  else { ?>

<!----------------display of quizzes ----->
<?php 
  $results = mysqli_query($conn, "SELECT * FROM `questions` WHERE `quiz_code` = '$quiz_code' and status = 'ready'");
    while ($row = mysqli_fetch_array($results)) {
      $in=$row['id'];
      $_SESSION['qstn_id'] = $in;
        
        if ($ce = mysqli_num_rows($results) == 0){
          echo  "no more questions"; 
        } else{ ?>

<img class="m-2" src="../../img/logo.png" alt="imgDes" height="50px"><br>

        <?php
        if ($row['question_template'] == "multiple choice") {
            $mcFetch = mysqli_query($conn, "SELECT * FROM `multiplechoice` WHERE `item_number`='$in' AND `quiz_code`='$quiz_code'");
            while ($mc  = mysqli_fetch_array($mcFetch)){

            $MCcorrectAnswer = $mc['item_answer'];
?>

<div class="text-center p-3">
  <progress value="0" max="<?php echo $mc['item_timer'];?>" id="progressBar" style="width:80%;"></progress><br>

  <?php if(($mc['item_img']) != "../../img/questPics/"){ ?>
    <a href="#" class="pop">
      <img src="<?php echo $mc['item_img']; ?>" width="100px;" height="100px;" alt="itemImage">
    </a>
  <?php } ?>

  <h3 class="p-3"><?php echo $mc['item_question']; ?></h3>
</div>

    <div class="text-center" style="min-height:120px;">
      <?php if(!empty($mc['item_a'])){ ?>

        <form method="post" action="" id="A_form">
          <input id="MCstatus" type="hidden" name="donnee" value="done">
          <input id="template" type="hidden" name="iden" value="multiple choice">
          <input id="tempID" type="hidden" name="tempID" value="<?php echo $mc['id']; ?>">
          <input type="hidden" name="questionid" id="qst_ID" value="<?php echo $in; ?>">
          <input type="hidden" name="" id="userid" value="<?php echo $userid; ?>">
          <input type="hidden" id="quiz_c" name="" value="<?php echo $quiz_code; ?>">
          <input type="hidden" id="ansA" name="" value="a">
          <input type="hidden" id="point" name="" value="<?php echo $mc['item_point']; ?>">
          <input type="hidden" id="correctAns" name="" value="<?php echo $MCcorrectAnswer ?>">

          <button type="submit" id="subA" class="m-2 p-2 choices chh"> a. <?php echo $mc['item_a']; ?></button>

      <?php }
      
      if(!empty($mc['item_b'])){ ?>

        <form method="post" action="" id="B_form">
          <input id="MCstatus" type="hidden" name="donnee" value="done">
          <input id="template" type="hidden" name="iden" value="multiple choice">
          <input id="tempID" type="hidden" name="tempID" value="<?php echo $mc['id']; ?>">
          <input type="hidden" name="questionid" id="qst_ID" value="<?php echo $in; ?>">
          <input type="hidden" name="" id="userid" value="<?php echo $userid; ?>">
          <input type="hidden" id="quiz_c" name="" value="<?php echo $quiz_code; ?>">
          <input type="hidden" id="ansB" name="" value="b">
          <input type="hidden" id="point" name="" value="<?php echo $mc['item_point']; ?>">
          <input type="hidden" id="correctAns" name="" value="<?php echo $MCcorrectAnswer ?>">

          <button type="submit" id="subB" class="m-2 p-2 choices chh"> b. <?php echo $mc['item_b']; ?></button>
      
      <?php }
      if(!empty($mc['item_c'])){ ?>

        <form method="post" action="" id="C_form">
          <input id="MCstatus" type="hidden" name="donnee" value="done">
          <input id="template" type="hidden" name="iden" value="multiple choice">
          <input id="tempID" type="hidden" name="tempID" value="<?php echo $mc['id']; ?>">
          <input type="hidden" name="questionid" id="qst_ID" value="<?php echo $in; ?>">
          <input type="hidden" name="" id="userid" value="<?php echo $userid; ?>">
          <input type="hidden" id="quiz_c" name="" value="<?php echo $quiz_code; ?>">
          <input type="hidden" id="ansC" name="" value="c">
          <input type="hidden" id="point" name="" value="<?php echo $mc['item_point']; ?>">
          <input type="hidden" id="correctAns" name="" value="<?php echo $MCcorrectAnswer ?>">

          <button type="submit" id="subC" class="m-2 p-2 choices chh"> c. <?php echo $mc['item_c']; ?></button>
                    
      <?php }
      if(!empty($mc['item_d'])){ ?>

        <form method="post" action="" id="D_form">
          <input id="MCstatus" type="hidden" name="donnee" value="done">
          <input id="template" type="hidden" name="iden" value="multiple choice">
          <input id="tempID" type="hidden" name="tempID" value="<?php echo $mc['id']; ?>">
          <input type="hidden" name="questionid" id="qst_ID" value="<?php echo $in; ?>">
          <input type="hidden" name="" id="userid" value="<?php echo $userid; ?>">
          <input type="hidden" id="quiz_c" name="" value="<?php echo $quiz_code; ?>">
          <input type="hidden" id="ansD" name="" value="d">
          <input type="hidden" id="point" name="" value="<?php echo $mc['item_point']; ?>">
          <input type="hidden" id="correctAns" name="" value="<?php echo $MCcorrectAnswer ?>">
                    
          <button type="submit" id="subD" class="m-2 p-2 choices chh"> d. <?php echo $mc['item_d']; ?></button>
          
      <?php }
      if(!empty($mc['item_e'])){ ?>

        <form method="post" action="" id="E_form">
          <input id="MCstatus" type="hidden" name="donnee" value="done">
          <input id="template" type="hidden" name="iden" value="multiple choice">
          <input id="tempID" type="hidden" name="tempID" value="<?php echo $mc['id']; ?>">
          <input type="hidden" name="questionid" id="qst_ID" value="<?php echo $in; ?>">
          <input type="hidden" name="" id="userid" value="<?php echo $userid; ?>">
          <input type="hidden" id="quiz_c" name="" value="<?php echo $quiz_code; ?>">
          <input type="hidden" id="ansE" name="" value="e">
          <input type="hidden" id="point" name="" value="<?php echo $mc['item_point']; ?>">
          <input type="hidden" id="correctAns" name="" value="<?php echo $MCcorrectAnswer ?>">

          <button type="submit" id="subE" class="m-2 p-2 choices chh"> e. <?php echo $mc['item_e']; ?></button>
        </form>
                    
      <?php } ?>
    </div>

  <div class="row">
    <div class="col">
      <img src="../../img/undraw_Faq_re_31cw.svg" alt="imgDes" height="200px">
    </div>
    <div class="col mt-5 p-5">
      <h5 class="text-dark fw-bold result"></h5>
      <h5 class="text-warning">Current Score: </h5>
    </div>
  </div>



<script type="text/javascript">    
//reload page
  function reloadPage() {
    location.reload(true);
  }
  var timeleft =<?php echo $mc['item_timer']; ?>;
  var downloadTimer = setInterval(function(){
    if(timeleft <= 0){
      clearInterval(downloadTimer);
    $( ".chh" ).prop( "disabled", true );
    }

  document.getElementById("progressBar").value = <?php echo $mc['item_timer']; ?> - timeleft;
  timeleft -= 1;
}, 1000);
</script>


<!-- enumeration show question -->
<?php }}
else if ($row['question_template'] == "enumeration") {
    $enuFetch = mysqli_query($conn, "SELECT * FROM `enumeration` WHERE `item_number`='$in' AND `quiz_code`='$quiz_code'");
    while ($enu = mysqli_fetch_array($enuFetch)){
      if ($enu['check_a'] == "correct"){
        $ans1= $enu['choice_a'];
      }else{
        $ans1 = "";
      }

      if ($enu['check_b'] == "correct"){
        $ans2= $enu['choice_b'];
      }else{
        $ans2 = "";
      }

      if ($enu['check_c'] == "correct"){
        $ans3= $enu['choice_c'];
      }else{
        $ans3 = "";
      }

      if ($enu['check_d'] == "correct"){
        $ans4= $enu['choice_d'];
      }else{
        $ans4 = "";
      }

      if ($enu['check_e'] == "correct"){
        $ans5= $enu['choice_e'];
      }else{
        $ans5 = "";
      }
    
    $ENUans=$ans1 . $ans2 . $ans3 . $ans4 . $ans5;
?>

<div class="text-center p-3">
  <progress value="0" max="<?php echo $enu['item_timer'];?>" id="progressBarI" style="width:80%;"></progress><br>

  <?php if(($enu['item_img']) != "../../img/questPics/"){ ?>
    <a href="#" class="pop">
      <img src="<?php echo $enu['item_img']; ?>" width="100px;" height="100px;" alt="itemImage">
    </a>
  <?php } ?>

  <h3 class="p-3"><?php echo $enu['item_question']; ?></h3>
</div>

<div class="text-center" style="min-height:120px;">
<form method="post" id="enuForm">
  <?php if(!empty($enu['choice_a'])){ ?>
    <label>
      <input id="en1" class="opt1" type="checkbox" value="<?php echo $enu['choice_a'];?> " name="enu1">&emsp;<?php echo $enu['choice_a']; ?>
    </label><br>
  <?php } ?>

  <?php if(!empty($enu['choice_b'])){ ?>
    <label>
      <input id="en2" class="opt2" type="checkbox" value="<?php echo $enu['choice_b'];?> " name="enu2">&emsp;<?php echo $enu['choice_b']; ?>
    </label><br>
  <?php } ?>

  <?php if(!empty($enu['choice_c'])){ ?>
    <label>
      <input id="en3" class="opt3" type="checkbox" value="<?php echo $enu['choice_c'];?> " name="enu3">&emsp;<?php echo $enu['choice_c']; ?>
    </label><br>
  <?php } ?>

  <?php if(!empty($enu['choice_d'])){ ?>
    <label>
      <input id="en4" class="opt4" type="checkbox" value="<?php echo $enu['choice_d'];?> " name="enu4">&emsp;<?php echo $enu['choice_d']; ?>
      </label><br>
  <?php } ?>

  <?php if(!empty($enu['choice_e'])){ ?>
    <label>
      <input id="en5" class="opt5" type="checkbox" value="<?php echo $enu['choice_e'];?> " name="enu5">&emsp;<?php echo $enu['choice_e']; ?>
      </label><br>
  <?php } ?>

    <input id="text1" type="hidden" name="" value="<?php echo $enu['choice_a']; ?>">
    <input id="text2" type="hidden" name="" value="<?php echo $enu['choice_b']; ?>">
    <input id="text3" type="hidden" name="" value="<?php echo $enu['choice_c']; ?>">
    <input id="text4" type="hidden" name="" value="<?php echo $enu['choice_d']; ?>">
    <input id="text5" type="hidden" name="" value="<?php echo $enu['choice_e']; ?>">

    <input id="Estatus" type="hidden" name="donnee" value="done">
    <input id="Etemplate" type="hidden" name="iden" value="enumeration">
    <input id="EtempID" type="hidden" name="tempID" value="<?php echo $enu['id']; ?>">
    <input type="hidden" name="questionid" id="Eqst_ID" value="<?php echo $in; ?>">
    <input type="hidden" name="" id="Euserid" value="<?php echo $userid; ?>">
    <input type="hidden" id="Equiz_c" name="" value="<?php echo $quiz_code; ?>">
    <input type="hidden" id="Epoint" name="" value="<?php echo $enu['item_point']; ?>">
    <input type="hidden" id="EcorrectAns" name="" value="<?php echo $ENUans; ?>">

    <button id="ENUsubmit" type="submit" name="ENUsubmit" class="btn btn-outline-dark"><i class="fas fa-check-circle"></i>&emsp;SUBMIT&nbsp;</button>
</form>
</div>

  <div class="row">
    <div class="col">
      <img src="../../img/undraw_Faq_re_31cw.svg" alt="imgDes" height="200px">
    </div>
    <div class="col mt-5 p-5">
      <h5 class="text-dark fw-bold result"></h5>
      <h5 class="text-warning">Current Score: </h5>
    </div>
  </div>



<script type="text/javascript">
  function sampleFunction() {
    location.reload(true);
  }

var timeleft =<?php echo $enu['item_timer']; ?>;
var downloadTimer = setInterval(function(){
  if(timeleft <= 0){
    clearInterval(downloadTimer);
    $( "#answerID" ).prop( "disabled", true );
    $( "#ENUsubmit" ).prop( "disabled", true );
  }

  document.getElementById("progressBarI").value = <?php echo $enu['item_timer']; ?> - timeleft;
  timeleft -= 1;
}, 1000);
</script>


<!-- identification show question -->
<?php }}
else if ($row['question_template'] == "identification") {
    $idenFetch = mysqli_query($conn, "SELECT * FROM `identification` WHERE `item_number`='$in' AND `quiz_code`='$quiz_code'");
    while ($iden = mysqli_fetch_array($idenFetch)){
      $IDcorrectAnswer = $iden['answer_a'];
?>

<div class="text-center p-3">
  <progress value="0" max="<?php echo $iden['item_timer'];?>" id="progressBar1" style="width:80%;"></progress><br>

  <?php if(($iden['item_img']) != "../../img/questPics/"){ ?>
    <a href="#" class="pop">
      <img src="<?php echo $iden['item_img']; ?>" width="100px;" height="100px;" alt="itemImage">
    </a> <br>
  <?php } ?>

  <h3 class="p-3"><?php echo $iden['item_question']; ?></h3>
</div>

<div class="text-center" style="min-height:120px;">

  <form method="post" action="" id="ansform">
    <input id="status" type="hidden" name="donnee" value="done">
    <input id="template" type="hidden" name="iden" value="identification">
    <input id="tempID" type="hidden" name="tempID" value="<?php echo $iden['id']; ?>">
    <input type="hidden" name="questionid" id="qst_ID" value="<?php echo $in; ?>">
    <input type="hidden" name="" id="userid" value="<?php echo $userid; ?>">
    <input type="hidden" id="quiz_c" name="" value="<?php echo $quiz_code; ?>">
    <input type="hidden" id="point" name="" value="<?php echo $iden['item_point']; ?>">
    <input type="hidden" id="correctAns" name="" value="<?php echo $IDcorrectAnswer; ?>">

    <p style="font-size:20px">Answer:
      <input id="answerID" class="m-3 anss" type="text" name="idenAns" required>
    </p>
      <button id="submit" type="submit" name="submit" class="btn btn-dark">
      <i class="fas fa-check-circle"></i>&emsp;SUBMIT&nbsp;</button>

  </form>
</div>

  <div class="row">
    <div class="col">
      <img src="../../img/undraw_Faq_re_31cw.svg" alt="imgDes" height="200px">
    </div>
    <div class="col mt-5 p-5">
      <h5 class="text-dark fw-bold result"></h5>
      <h5 class="text-warning">Current Score: </h5>
    </div>
  </div>
  


<script type="text/javascript">
  function sampleFunction() {
    location.reload(true);
  }

var timeleft =<?php echo $iden['item_timer']; ?>;
var downloadTimer = setInterval(function(){
  if(timeleft <= 0){
    clearInterval(downloadTimer);
    $( "#answerID" ).prop( "disabled", true );
    $( "#submit" ).prop( "disabled", true );
  }

  document.getElementById("progressBar1").value = <?php echo $iden['item_timer']; ?> - timeleft;
  timeleft -= 1;
}, 1000);
</script>

<?php } } } } ?>

<!----------------    display of quizzes ----->

<?php } } } ?> 

<!-- save answer for multiple choice A-->
<script type="text/javascript">
  
  $(document).ready(function() {
    $('#subA').click(function(e) {
      e.preventDefault();
        $( ".chh" ).prop( "disabled", true );
          var ansID = $('#ansA').val();
          var status = $('#MCstatus').val();
          var qst_ID = $('#qst_ID').val();
          var template = $('#template').val();
          var tempID = $('#tempID').val();
          var userid = $('#userid').val();
          var quiz_code = $('#quiz_c').val();
          var point = $('#point').val();
          var correctAns = $('#correctAns').val();
      $.ajax
        ({
          type: "POST",
          url: "loaders/s-answers.php",
          data: {"ansID": ansID, "status": status , "qst_ID": qst_ID , "template": template , "tempID": tempID , "userid": userid , "quiz_code": quiz_code , "point": point , "correctAns": correctAns},
          success: function(data) {
            $('.result').html(data);
            $('#A_form')[0].reset();
          }
        });
    });
  });

</script>
<!-- save answer for multiple choice -->

<!-- save answer for multiple choice B-->
<script type="text/javascript">
  
  $(document).ready(function() {
    $('#subB').click(function(e) {
      e.preventDefault();
        $( ".chh" ).prop( "disabled", true );
          var ansID = $('#ansB').val();
          var status = $('#MCstatus').val();
          var qst_ID = $('#qst_ID').val();
          var template = $('#template').val();
          var tempID = $('#tempID').val();
          var userid = $('#userid').val();
          var quiz_code = $('#quiz_c').val();
          var point = $('#point').val();
          var correctAns = $('#correctAns').val();
      $.ajax
        ({
          type: "POST",
          url: "loaders/s-answers.php",
          data: {"ansID": ansID, "status": status , "qst_ID": qst_ID , "template": template , "tempID": tempID , "userid": userid , "quiz_code": quiz_code , "point": point , "correctAns": correctAns},
          success: function(data) {
            $('.result').html(data);
            $('#B_form')[0].reset();
          }
        });
    });
  });

</script>
<!-- save answer for multiple choice -->

<!-- save answer for multiple choice C-->
<script type="text/javascript">
  
  $(document).ready(function() {
    $('#subC').click(function(e) {
        e.preventDefault();
        $( ".chh" ).prop( "disabled", true );
          var ansID = $('#ansC').val();
          var status = $('#MCstatus').val();
          var qst_ID = $('#qst_ID').val();
          var template = $('#template').val();
          var tempID = $('#tempID').val();
          var userid = $('#userid').val();
          var quiz_code = $('#quiz_c').val();
          var point = $('#point').val();
          var correctAns = $('#correctAns').val();
      $.ajax
        ({
          type: "POST",
          url: "loaders/s-answers.php",
          data: {"ansID": ansID, "status": status , "qst_ID": qst_ID , "template": template , "tempID": tempID , "userid": userid , "quiz_code": quiz_code , "point": point , "correctAns": correctAns},
          success: function(data) {
            $('.result').html(data);
            $('#C_form')[0].reset();
          }
        });
    });
  });

</script>
<!-- save answer for multiple choice -->

<!-- save answer for multiple choice D-->
<script type="text/javascript">
  
  $(document).ready(function() {
    $('#subD').click(function(e) {
      e.preventDefault();
        $( ".chh" ).prop( "disabled", true );
          var ansID = $('#ansD').val();
          var status = $('#MCstatus').val();
          var qst_ID = $('#qst_ID').val();
          var template = $('#template').val();
          var tempID = $('#tempID').val();
          var userid = $('#userid').val();
          var quiz_code = $('#quiz_c').val();
          var point = $('#point').val();
          var correctAns = $('#correctAns').val();
      $.ajax
        ({
          type: "POST",
          url: "loaders/s-answers.php",
          data: {"ansID": ansID, "status": status , "qst_ID": qst_ID , "template": template , "tempID": tempID , "userid": userid , "quiz_code": quiz_code , "point": point , "correctAns": correctAns},
          success: function(data) {
            $('.result').html(data);
            $('#D_form')[0].reset();
          }
        });
    });
  });

</script>
<!-- save answer for multiple choice -->

<!-- save answer for multiple choice E-->
<script type="text/javascript">
  
  $(document).ready(function() {
    $('#subE').click(function(e) {
      e.preventDefault();
        $( ".chh" ).prop( "disabled", true );
          var ansID = $('#ansE').val();
          var status = $('#MCstatus').val();
          var qst_ID = $('#qst_ID').val();
          var template = $('#template').val();
          var tempID = $('#tempID').val();
          var userid = $('#userid').val();
          var quiz_code = $('#quiz_c').val();
          var point = $('#point').val();
          var correctAns = $('#correctAns').val();
      $.ajax
        ({
          type: "POST",
          url: "loaders/s-answers.php",
          data: {"ansID": ansID, "status": status , "qst_ID": qst_ID , "template": template , "tempID": tempID , "userid": userid , "quiz_code": quiz_code , "point": point , "correctAns": correctAns},
          success: function(data) {
            $('.result').html(data);
            $('#E_form')[0].reset();
          }
        });
    });
  });

</script>
<!-- save answer for multiple choice -->


<!-- save answer for identification -->
<script type="text/javascript">
  
  $(document).ready(function() {
    $('#submit').click(function(e) {
      e.preventDefault();
        $( ".chh" ).prop( "disabled", true );
          var ansID = $('#answerID').val();
          var status = $('#status').val();
          var qst_ID = $('#qst_ID').val();
          var template = $('#template').val();
          var tempID = $('#tempID').val();
          var userid = $('#userid').val();
          var quiz_code = $('#quiz_c').val();
          var point = $('#point').val();
          var correctAns = $('#correctAns').val();
      $.ajax
        ({
          type: "POST",
          url: "loaders/s-answers.php",
          data: {"ansID": ansID, "status": status , "qst_ID": qst_ID , "template": template , "tempID": tempID , "userid": userid , "quiz_code": quiz_code , "point": point , "correctAns": correctAns},
          success: function(data) {
            $('.result').html(data);
            $('#ansform')[0].reset();
          }
        });
    });
  });

</script>
<!-- save answer for identification -->


<!-- save answer for ENUMERATION-->
<script type="text/javascript">

  $(document).ready(function() {
    $('#ENUsubmit').click(function(e) {
      e.preventDefault();

          var ae1 = document.getElementById("en1").checked;
          var ae2 = document.getElementById("en2").checked;
          var ae3 = document.getElementById("en3").checked;
          var ae4 = document.getElementById("en4").checked;
          var ae5 = document.getElementById("en5").checked;

          var txt1 = $('#text1').val();
          var txt2 = $('#text2').val();
          var txt3 = $('#text3').val();
          var txt4 = $('#text4').val();
          var txt5 = $('#text5').val();

          var status = $('#Estatus').val();
          var qst_ID = $('#Eqst_ID').val();
          var template = $('#Etemplate').val();
          var tempID = $('#EtempID').val();
          var userid = $('#Euserid').val();
          var quiz_code = $('#Equiz_c').val();
          var point = $('#Epoint').val();
          var correctAns = $('#EcorrectAns').val();
      $.ajax
        ({
          type: "POST",
          url: "loaders/enumeration-save.php",
          data: {"txt1": txt1, "txt2": txt2, "txt3": txt3, "txt4": txt4, "txt5": txt5,  "ae1": ae1, "ae2": ae2, "ae3": ae3, "ae4": ae4, "ae5": ae5, "status": status , "qst_ID": qst_ID , "template": template , "tempID": tempID , "userid": userid , "quiz_code": quiz_code , "point": point , "correctAns": correctAns},
          success: function(data) {
            $('.result').html(data);
            $('#enuForm')[0].reset();
          }
        });
    });
  });

</script>
<!-- save answer for ENUMERATION -->

<!--Bootstrap Bundle-->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- MODAL IMAGE -->
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content"> 
      <div class="modal-header border-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>             
      <div class="modal-body">
        <img src="" class="imagepreview" style="width: 100%;" >
      </div>
    </div>
  </div>
</div>

    <script>
      $(function() {
        $('.pop').on('click', function() {
          $('.imagepreview').attr('src', $(this).find('img').attr('src'));
          $('#imagemodal').modal('show');   
          });		
      });
    </script>