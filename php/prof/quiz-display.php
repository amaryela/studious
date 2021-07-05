<?php
include '../include/config.php';
include '../q-functions.php';
session_start();


$userid = $_SESSION['id'];
$schedule = $_SESSION['sched_id'];
$rcode = $_SESSION["room_code"];
$quiz_code = $_SESSION["theCode"];

$query = "SELECT * FROM quiz WHERE quiz_code = '$quiz_code'" ;
$result = mysqli_query($conn, $query);
  while($row = mysqli_fetch_array($result)){ 


$runQ = "SELECT * FROM questions WHERE quiz_code = '$quiz_code' and status = 'ready'";
  $qResults = mysqli_query($conn, $runQ);

  if (mysqli_num_rows($qResults)==0) {

    $upQ = "UPDATE scheduledquizzes SET status = 'finished' WHERE quiz_code = '$quiz_code'";
    $qResults = mysqli_query($conn, $upQ);

    echo "<script>window.location='top-participants.php';</script>";

    mysqli_query($conn, "UPDATE quiz SET status = 'finished' WHERE quiz_code = '$quiz_code'");

  }
  else{
    $results = mysqli_query($conn, "SELECT * FROM `questions` WHERE `quiz_code` = '$quiz_code' and status = 'ready'");
    while ($row = mysqli_fetch_array($results)) {
      $in = $row['id'];?>
    
    <img class="m-2" src="../../img/logo.png" alt="imgDes" height="50px"><br>

<?php
      if ($row['question_template'] == "multiple choice") {
          $mcFetch = mysqli_query($conn, "SELECT * FROM `multiplechoice` WHERE `item_number`='$in' AND `quiz_code`='$quiz_code'");
          while ($mc  = mysqli_fetch_array($mcFetch)){
?>

<!-- DISPLAY CODE FOR EVERY QUESTION HERE -->
  <div class="text-center p-3">
    <progress value="0" max="<?php echo $mc['item_timer'];?>" id="progressBar" style="width: 80%;"></progress><br>

    <?php if(($mc['item_img']) != "../../img/questPics/"){ ?>
      <a href="#" class="pop">
        <img src="<?php echo $mc['item_img']; ?>" width="100px;" height="100px;" alt="itemImage">
      </a>
    <?php } ?>

    <h3 class="m-2"><?php echo $mc['item_question']; ?></h3>
  </div>

  <div class="text-center" style="min-height:120px;">
      <?php if(!empty($mc['item_a'])){ ?>
          <p class="m-2 p-2 answer"><input type="radio"<?php if ($mc['item_answer'] == "a") {echo "checked";}?> disabled> a. <?php echo $mc['item_a']; ?></p>
      <?php } ?>

      <?php if(!empty($mc['item_b'])){ ?>
          <p class="m-2 p-2 answer"><input type="radio"<?php if ($mc['item_answer'] == "b") {echo "checked";}?> disabled> b. <?php echo $mc['item_b']; ?></p>
      <?php } ?>

      <?php if(!empty($mc['item_c'])){ ?>
          <p class="m-2 p-2 answer"><input type="radio"<?php if ($mc['item_answer'] == "c") {echo "checked";}?> disabled> c. <?php echo $mc['item_c']; ?></p>
      <?php } ?>

      <?php if(!empty($mc['item_d'])){ ?>
          <p class="m-2 p-2 answer"><input type="radio"<?php if ($mc['item_answer'] == "d") {echo "checked";}?> disabled> d. <?php echo $mc['item_d']; ?></p>
      <?php } ?>

      <?php if(!empty($mc['item_e'])){ ?>
          <p class="m-2 p-2 answer"><input type="radio"<?php if ($mc['item_answer'] == "e") {echo "checked";}?> disabled> e. <?php echo $mc['item_e']; ?></p>
      <?php } ?>
  </div>

    
    <form action="" method="post" id="doneQm">
      <div class="row">
          <input id="done_status" type="hidden" name="donnee" value="done">
          <input id="next_status" type="hidden" name="donnee" value="finished">
          <input id="template" type="hidden" name="iden" value="multiple choice">
          <input id="tempID" type="hidden" name="tempID" value="<?php echo $mc['id']; ?>">
          <input type="hidden" name="questionid" id="qst_ID" value="<?php echo $in; ?>">

          <div class="col">
            <img src="../../img/undraw_Faq_re_31cw.svg" alt="imgDes" height="200px">
          </div>

          <div class="col">
            <button class="btn btn-outline-warning m-3" type="submit" id="doneIDm" name="done"><i class="fas fa-check-circle"></i>&emsp;Show Answer to Students</button>
            
            <button onclick="reloadPage()" type="submit" id="nextBthm" name="done" class="btn btn-outline-dark m-3" style="display:none;"><i class="fas fa-check-circle"></i>&emsp;Next Question</button>
            <!-- button style="display:none;" -->

            <div class="mt-3 text-center sresult"></div>
          </div>

      </div>
    </form>
        
    <script type="text/javascript">
      //NEXT btn SAVE TO DB
      $(document).ready(function () {
      $('#nextBthm').click(function (e) {
              e.preventDefault();
              var status = $('#next_status').val();
              var qst_ID = $('#qst_ID').val();
              var template = $('#template').val();
              var tempID = $('#tempID').val();
              $.ajax
              ({
              type: "POST",
              url: "done-next.php",
              data: { "status": status , "qst_ID": qst_ID , "template": template , "tempID": tempID},
                  success: function (data) {
                  $('.sresult').html(data); //class of div 
                  $('#doneQm')[0].reset(); //id of the form
                  }
                });
            });
          });
//NEXT btn SAVE TO DB  
$("#doneIDm" ).prop("disabled", true ); //DONE BUTTON DISABLED
// QUIZ TIMER
var timeleft =<?php echo $mc['item_timer']; ?>;
var downloadTimer = setInterval(function(){
  if(timeleft <= 0){
    clearInterval(downloadTimer);

$("#doneIDm" ).prop("disabled", false );

  //DONE SAVE TO DB
    $(document).ready(function () {
    $('#doneIDm').click(function (e) {
      e.preventDefault();
        $('#nextBthm').show();
            var status = $('#done_status').val();
            var qst_ID = $('#qst_ID').val();
            var template = $('#template').val();
            var tempID = $('#tempID').val();
            $.ajax
            ({
            type: "POST",
            url: "done-next.php",
            data: { "status": status , "qst_ID": qst_ID , "template": template , "tempID": tempID},
                success: function (data) {
                $('.sresult').html(data); // DIV CLASS
                $('#doneQm')[0].reset(); //FORM ID
              }
            });
        });
      });

//DONE SAVE TO DB
}
    document.getElementById("progressBar").value = <?php echo $mc['item_timer']; ?> - timeleft;
    timeleft -= 1;
  }, 1000);
// QUIZ TIMER
</script>

<!-- identification -->
<?php } }
else if ($row['question_template'] == "identification") {
  $idenFetch = mysqli_query($conn, "SELECT * FROM `identification` WHERE `item_number`='$in' AND `quiz_code`='$quiz_code'");
  while ($iden = mysqli_fetch_array($idenFetch)){
?>

    <div class="text-center p-2">
      <progress value="0" max="<?php echo $iden['item_timer'];?>" id="progressBarI" style="width:80%;"></progress><br>

        <?php if(($iden['item_img']) != "../../img/questPics/"){ ?>
          <a href="#" class="pop">
            <img src="<?php echo $iden['item_img']; ?>" width="100px;" height="100px;" alt="itemImage">
          </a><br>
        <?php } ?>

        <h3 class="m-2"><?php echo $iden['item_question']; ?></h3>
    </div>

    <div class="text-center m-3" style="min-height:120px;">
      <textarea class="anss" name="idenAns" id="answerID" style="min-width:200px;" disabled>Answer: <?php echo $iden['answer_a'];?></textarea>
        
        <!-- <input id="answerID" class="anss" type="text" name="idenAns" value="<?php echo $iden['answer_a'];?>" disabled></p> -->
    </div>

    <form action="" method="post" id="doneQ">
      <div class="row mt-5">
          <input id="done_status" type="hidden" name="donee" value="done">
          <input id="next_status" type="hidden" name="next" value="finished">
          <input id="template" type="hidden" name="iden" value="identification">
          <input id="tempID" type="hidden" name="tempID" value="<?php echo $iden['id']; ?>">
          <input type="hidden" name="questionid" id="qst_ID" value="<?php echo $in; ?>">

          <div class="col">
            <img src="../../img/undraw_Faq_re_31cw.svg" alt="imgDes" height="200px">
          </div>

          <div class="col">
            <button class="btn btn-outline-warning m-3" type="submit" id="doneID" name="done"><i class="fas fa-check-circle"></i>&emsp;Show Answer to Students</button>

            <button onclick="reloadPage()" type="submit" id="nextBth" name="done" class="btn btn-outline-dark" style="display:none;"><i class="fas fa-arrow-circle-right"></i>&emsp;Next Question</button>
            <!-- button style="display:none;" -->

            <div class="mt-3 text-center result"></div>

          </div>
      </div>
    </form>


  <script type="text/javascript">
  //NEXT btn SAVE TO DB
    $(document).ready(function () {
      $('#nextBth').click(function (e) {
        e.preventDefault();
              var status = $('#next_status').val();
              var qst_ID = $('#qst_ID').val();
              var template = $('#template').val();
              var tempID = $('#tempID').val();
              $.ajax
                ({
                  type: "POST",
                  url: "done-next.php",
                  data: { "status": status , "qst_ID": qst_ID , "template": template , "tempID": tempID},
                  success: function (data) {
                    $('.result').html(data);
                    $('#doneQ')[0].reset();

                  }
                });
            });
          });
  //NEXT btn SAVE TO DB
 $("#doneID").prop("disabled", true);

 // QUIZ TIMER             
    var timeleft =<?php echo $iden['item_timer']; ?>;
    var downloadTimer = setInterval(function(){
      if(timeleft <= 0){
        clearInterval(downloadTimer);
         $("#doneID").prop("disabled", false);
        //DONE SAVE TO DB
            $(document).ready(function () {
              $('#doneID').click(function (e) { //BUTTON ID
                e.preventDefault();
                  $('#nextBth').show();
                      var status = $('#done_status').val(); //INPUT IDS
                      var qst_ID = $('#qst_ID').val(); //INPUT IDS
                      var template = $('#template').val(); //INPUT IDS
                      var tempID = $('#tempID').val(); //INPUT IDS
                      $.ajax
                        ({
                          type: "POST",
                          url: "done-next.php",
                          data: { "status": status , "qst_ID": qst_ID , "template": template , "tempID": tempID},
                          success: function (data) {
                            $('.result').html(data); //DIV CLASS
                            $('#doneQ')[0].reset(); //FORM ID
                          }
                        });
                    });
                  });
            //DONE SAVE TO DB

      }
      document.getElementById("progressBarI").value = <?php echo $iden['item_timer']; ?> - timeleft;
      timeleft -= 1;
    }, 1000);
 // QUIZ TIMER 
</script>

<?php }}
else if ($row['question_template'] == "enumeration") {
  $enuFetch = mysqli_query($conn, "SELECT * FROM `enumeration` WHERE `item_number`='$in' AND `quiz_code`='$quiz_code'");
  while ($enu = mysqli_fetch_array($enuFetch)){
    $ans1 =  $enu['check_a'];
    $ans2 =  $enu['check_b'];
    $ans3 =  $enu['check_c'];
    $ans4 =  $enu['check_d'];
    $ans5 =  $enu['check_e'];
?>

  <div class="text-center p-2">
    <progress value="0" max="<?php echo $enu['item_timer'];?>" id="progressBarE" style="width:80%;"></progress><br>

    <?php if(($enu['item_img']) != "../../img/questPics/"){ ?>
      <a href="#" class="pop">
        <img src="<?php echo $enu['item_img']; ?>" width="100px;" height="100px;" alt="itemImage">
      </a> 
    <?php } ?>

    <h3 class="m-2"><?php echo $enu['item_question']; ?></h3>
  </div>

  <div class="text-center" style="min-height:120px;">
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

    <form action="" method="post" id="doneQE">
      <div class="row">
        <input id="done_status" type="hidden" name="donnee" value="done">
        <input id="next_status" type="hidden" name="donnee" value="finished">
        <input id="template" type="hidden" name="iden" value="enumeration">
        <input id="tempID" type="hidden" name="tempID" value="<?php echo $enu['id']; ?>">
        <input type="hidden" name="questionid" id="qst_ID" value="<?php echo $in; ?>">

          <div class="col">
            <img src="../../img/undraw_Faq_re_31cw.svg" alt="imgDes" height="200px">
          </div>

          <div class="col">
            <button class="btn btn-outline-warning m-3" type="submit" id="doneIDE" name="done"><i class="fas fa-check-circle"></i>&emsp;Show Answer to Students</button>
            
            <button onclick="reloadPage()" type="submit" id="nextBthE" name="done" class="btn btn-outline-dark m-3" style="display:none;"><i class="fas fa-check-circle"></i>&emsp;Next Question</button>
            <!-- button style="display:none;" -->

            <div class="mt-3 text-center sresult"></div>
            
          </div>
      </div>
    </form>

<script type="text/javascript">
//NEXT btn SAVE TO DB
  $(document).ready(function () {
  $('#nextBthE').click(function (e) {
          e.preventDefault();
          var status = $('#next_status').val();
          var qst_ID = $('#qst_ID').val();
          var template = $('#template').val();
          var tempID = $('#tempID').val();
          $.ajax
          ({
          type: "POST",
          url: "done-next.php",
          data: { "status": status , "qst_ID": qst_ID , "template": template , "tempID": tempID},
              success: function (data) {
              $('.sresult').html(data); //class of div 
              $('#doneQE')[0].reset(); //id of the form
              }
            });
        });
      });
//NEXT btn SAVE TO DB  

 $("#doneIDE").prop("disabled", true); //DONE BUTTON DISABLED
// QUIZ TIMER
var timeleft =<?php echo $enu['item_timer']; ?>;
var downloadTimer = setInterval(function(){
  if(timeleft <= 0){
    clearInterval(downloadTimer);
    
    $("#doneIDE").prop("disabled", false);
    //DONE SAVE TO DB
      $(document).ready(function () {
      $('#doneIDE').click(function (e) {
        e.preventDefault();
          $('#nextBthE').show();
              var status = $('#done_status').val();
              var qst_ID = $('#qst_ID').val();
              var template = $('#template').val();
              var tempID = $('#tempID').val();
              $.ajax
              ({
              type: "POST",
              url: "done-next.php",
              data: { "status": status , "qst_ID": qst_ID , "template": template , "tempID": tempID},
                  success: function (data) {
                  $('.sresult').html(data); // DIV CLASS
                  $('#doneQE')[0].reset(); //FORM ID
                }
              });
          });
        });
    //DONE SAVE TO DB
    }
    document.getElementById("progressBarE").value = <?php echo $enu['item_timer']; ?> - timeleft;
    timeleft -= 1;
  }, 1000);
// QUIZ TIMER

</script>
 
<?php } } ?> 

<!-- END OF DISPLAYING QUIZ QUESTION -->
<?php 
      } 
    } //sa if wala ng row
  }//} while sa taas for quiz
?> 

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