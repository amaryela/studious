<?php
session_start();
include '../include/config.php';

$userid = $_SESSION['id'];

if (empty($_SESSION['id'])){
  header('Location: ../../index.php');
}

    if (isset($_GET['next'])) {
        $id = $_GET['next'];

        $sql = "SELECT * FROM quiz WHERE quiz_code = '$id'";
        $results = mysqli_query($conn, $sql);
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <!-- Font Awesome -->
    <script crossorigin="anonymous" src="https://kit.fontawesome.com/c8e4d183c2.js"></script>

    <title>studious | room for all your quizzes</title>
    <link rel="stylesheet" type="text/css" href="../../css/rooms.css">

  </head>
  <body>
    <?php include('../include/nav-prof.php'); ?>

    <div class="container jumbotron">
      <div class="row">
        <div class="col-sm" style="text-align:center; margin-bottom:20px;">
        <?php while ($row = mysqli_fetch_array($results)) { ?>
         
          <h1 style="text-transform:uppercase;">SUBJECT</h1>
          <p style="text-transform:uppercase;"><?php echo $row['quiz_name']; ?></p>
          <button type="button" class="btn btn-dark" style="width:150px;" data-bs-toggle="modal" data-bs-target="#publishQuiz" id="<?php echo $row['quiz_code']; ?>"><i class="fas fa-save"></i>&nbsp;&nbsp;&nbsp;Publish</button>
        </div>

<!-- PUBLISH Modal -->
<div class="modal fade" id="publishQuiz" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form action="quiz-code.php" method="post">
        <div class="modal-header border-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="text-center">
            <h5 style="font-weight:1000;">Scheduled Quiz</h5><br>
            <input type="date" name="date" style="width:50%;"><br><br>
            <input type="time" name="time" style="width:30%;"><br><br>
            <input type="hidden" name="quizcode" value="<?php echo $row['quiz_code'];?>">
            <input type="hidden" name="quizname" value="<?php echo $row['quiz_name'];?>">
            <input type="hidden" name="status" value="set">
        </div>
        <div class="modal-footer border-0">
            <button type="button" class="btn btn-warning text-white" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-outline-warning" name="publish">Proceed</button>
        </div>
    </form>
    </div>
  </div>
</div>

        <div class="col-sm text-center">
          <img src="../../img/undraw_content_team_3epn.svg" height="150px" alt="design-content">
        </div>
        </div>
      <hr>
    </div>

    <div class="container jumbotron file" style="margin-top:2vh;">
      <div class="temp" id="temp"><br>
        <p style="text-align:center; font-weight:bold; font-size:22px; margin-bottom:50px;">Choose question template:
          <select id="qtemp">
            <option></option>
            <option value="mc">Multiple choice</option>
            <option value="ident">Identification</option>           
            <option value="enu">Enumeration</option>
          </select>
        </p>

<!--MULTIPLE CHOICE -->
<form action="quiz-code.php" method="post" enctype="multipart/form-data">
    <div class="template" id="mc">
        <input type="hidden" name="quizcode" value="<?php echo $row['quiz_code']; ?>">
        <input type="hidden" name="quizname" value="<?php echo $row['quiz_name'];?>">
        <input type="hidden" name="mctemplate" value="multiple choice">

        <div class="tempIMG text-center p-3">
            <label>Add image</label>
            <input type="file" name="imgMC" accept="image/*">
        </div><br>

        <textarea name="mcqfield" required placeholder="Type your question here"></textarea><br><br>

        <div class="choices" style="text-align:left;">
            <input type="radio" name="mcAns" value="a" required>&nbsp;&nbsp;
            a. <input type="text" name="mcchoicea" required placeholder="Type options here"><br>

            <input type="radio" name="mcAns" value="b">&nbsp;&nbsp;
            b. <input type="text" name="mcchoiceb" required placeholder="Type options here"><br>
       
        <div class="mul3">
            <input type="radio" name="mcAns" value="c">&nbsp;&nbsp;
            c. <input type="text" name="mcchoicec" placeholder="Type options here"><br>
        </div>

        <div class="mul4">
            <input type="radio" name="mcAns" value="d">&nbsp;&nbsp;
            d. <input type="text" name="mcchoiced" placeholder="Type options here"><br>
        </div>

        <div class="mul5">
            <input type="radio" name="mcAns" value="e">&nbsp;&nbsp;
            e. <input type="text" name="mcchoicee" placeholder="Type options here"><br>
        </div>
        </div>

        <div class="choices" style="text-align:right;">
            <p>Set Time: 
                <select name="mcTime">
                    <option value="5">5 seconds</option>
                    <option value="10">10 seconds</option>
                    <option value="15">15 seconds</option>
                    <option value="20">20 seconds</option>
                    <option value="25">25 seconds</option>
                    <option value="30">30 seconds</option>
                </select>
            </p>
            <p>Set Point: <input type="number" name="mcPnt" required></Set><br>

            <button type="button" class="btn btn-dark muladd" style="width:150px; margin-bottom:10px;"><i class="fas fa-plus-circle"></i>&nbsp;&nbsp;Add Option</button><br>
            <button type="submit" class="btn btn-warning text-white" style="width:150px;" name="mcsave">
                <i class="fas fa-save"></i>&nbsp;&nbsp;Save</button>
        </div>
</div>
</form>

<!--IDENTIFICATION -->
<form action="quiz-code.php" method="post" enctype="multipart/form-data">
    <div class="template" id="ident">
        <input type="hidden" name="quizcode" value="<?php echo $row['quiz_code']; ?>">
        <input type="hidden" name="quizname" value="<?php echo $row['quiz_name'];?>">
        <input type="hidden" name="identemplate" value="identification">
        
        <div class="tempIMG text-center p-3">
            <label>Add image</label>
            <input type="file" name="imgIDEN" accept="image/*">
        </div><br>

        <textarea name="idenQuest" required></textarea><br><br>

        <div class="choices" style="text-align:left;">
            <p class="fs-5">Answer: <input type="text" name="idenAns" required></p>
        </div>

        <div class="choices" style="text-align:right;">
            <p>Set Time: 
                <select name="idenTime">
                    <option value="5">5 seconds</option>
                    <option value="10">10 seconds</option>
                    <option value="15">15 seconds</option>
                    <option value="20">20 seconds</option>
                    <option value="25">25 seconds</option>
                    <option value="30">30 seconds</option>
                </select>
            </p>
            <p>Set Point: <input type="number" name="idenPnt" required></Set><br>

            <button type="submit" class="btn btn-warning text-white" style="width:150px;" name="idenSave"><i class="fas fa-save"></i>&nbsp;&nbsp;Save</button>
        </div>
    </div>
</form>

<!--ENUMERATION -->
<form action="quiz-code.php" method="post" enctype="multipart/form-data">
    <div class="template" id="enu">
        <input type="hidden" name="quizcode" value="<?php echo $row['quiz_code']; ?>">
        <input type="hidden" name="quizname" value="<?php echo $row['quiz_name'];?>">
        <input type="hidden" name="enutemplate" value="enumeration">
        
        <div class="tempIMG text-center p-3">
            <label>Add image</label>
            <input type="file" name="imgENU" accept="image/*">
        </div><br>

        <textarea name="eqfield"></textarea><br><br>
       
        <div class="choices" style="text-align:left;">
            <input class="optHidden1" type="hidden" value="not" name="enu1">
            <input class="opt1" type="checkbox" value="correct" name="enu1">&nbsp;&nbsp;
            <input type="text" name="e1" required><br>

            <input class="optHidden2" type="hidden" value="not" name="enu2">
            <input class="opt2" type="checkbox" value="correct" name="enu2">&nbsp;&nbsp;
            <input type="text" name="e2" required><br>

        <div class="enum3">
            <input class="optHidden3" type="hidden" value="not" name="enu3">
            <input class="opt3" type="checkbox" value="correct" name="enu3">&nbsp;&nbsp;
            <input type="text" name="e3"><br>
        </div>

        <div class="enum4">
            <input class="optHidden4" type="hidden" value="not" name="enu4">
            <input class="opt4" type="checkbox" value="correct" name="enu4">&nbsp;&nbsp;
            <input type="text" name="e4"><br>
        </div>

        <div class="enum5">
            <input class="optHidden5" type="hidden" value="not" name="enu5">
            <input class="opt5" type="checkbox" value="correct" name="enu5">&nbsp;&nbsp;
            <input type="text" name="e5"><br>
        </div>
        </div>

        <div class="choices" style="text-align:right;">
               <p>Set Time: 
                <select name="enumTime">
                    <option value="5">5 seconds</option>
                    <option value="10">10 seconds</option>
                    <option value="15">15 seconds</option>
                    <option value="20">20 seconds</option>
                    <option value="25">25 seconds</option>
                    <option value="30">30 seconds</option>
                </select>
            </p>
            <p>Set Point: <input type="number" name="enumPnt" required></Set><br>

            <button type="button" class="btn btn-dark enumadd" style="width:150px; margin-bottom:10px;"><i class="fas fa-plus-circle"></i>&nbsp;&nbsp;Add Option</button><br>
            <button type="submit" class="btn btn-warning text-white" style="width:150px" name="enusave"><i class="fas fa-save"></i>&nbsp;&nbsp;Save</button>
        </div>
    </div>
</div> <!-- end of temp div -->
</form>

<?php
$codeee = $row['quiz_code'];
$results = mysqli_query($conn, "SELECT * FROM `questions` WHERE `quiz_code` = '$codeee'");
while ($row = mysqli_fetch_array($results)) {
    $in = $row['id'];
    $cod = $row['quiz_code'];

    if ($row['question_template'] == "multiple choice") {
        $mcFetch = mysqli_query($conn, "SELECT * FROM `multiplechoice` WHERE `item_number`='$in' AND `quiz_code`='$codeee'");
        while ($mc  = mysqli_fetch_array($mcFetch)){
?>       

<div class="pb-3 quest"><br>
    <div class="text-center">
        <?php if(($mc['item_img']) != "../../img/questPics/"){ ?>
            <img src="<?php echo $mc['item_img']; ?>" width="100px;" height="100px;" alt="itemImage">
        <?php } ?>

        <p class="m-3 fw-bold fs-3"><?php echo $mc['item_question']; ?></p><br>
    </div>

        <div class="quest-choices" style="text-align:left;">
            <?php if(!empty($mc['item_a'])){ ?>
                <label><input type="radio"<?php if ($mc['item_answer'] == "a") {echo "checked";}?> disabled> a. <?php echo $mc['item_a']; ?></label><br>
            <?php } ?>

            <?php if(!empty($mc['item_b'])){ ?>
                <label><input type="radio"<?php if ($mc['item_answer'] == "b") {echo "checked";}?> disabled> b. <?php echo $mc['item_b']; ?></label><br>
            <?php } ?>

            <?php if(!empty($mc['item_c'])){ ?>
                <label><input type="radio"<?php if ($mc['item_answer'] == "c") {echo "checked";}?> disabled> c. <?php echo $mc['item_c']; ?></label><br>
            <?php } ?>

            <?php if(!empty($mc['item_d'])){ ?>
                <label><input type="radio"<?php if ($mc['item_answer'] == "d") {echo "checked";}?> disabled> d. <?php echo $mc['item_d']; ?></label><br>
            <?php } ?>

            <?php if(!empty($mc['item_e'])){ ?>
                <label><input type="radio"<?php if ($mc['item_answer'] == "e") {echo "checked";}?> disabled> e. <?php echo $mc['item_e']; ?></label>
            <?php } ?>
         </div>

         <div class="quest-choices" style="text-align:right;">
            <p class="m-0">Set Time: <?php echo $mc['item_timer']; ?></p>
            <p class="m-0">Set Point: <?php echo $mc['item_point']; ?></p>

            <button type="button" class="btn btn-warning text-white m-2 mcEdit" data-bs-toggle="modal" data-bs-target="#editMCmodal" id="<?php echo $mc['item_number']; ?>"><i class="fas fa-edit"></i>&nbsp;&nbsp;Edit</button>
            <button type="button" class="btn btn-danger text-white m-2 mcDelete" data-bs-toggle="modal" data-bs-target="#deleteMCmodal" id="<?php echo $mc['item_number']; ?>"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp;Delete</button>
        </div>

<!-- MC Edit Modal -->
<div class="modal fade bd-example-modal-lg" id="editMCmodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content p-3">
        <form action="#" method="post" enctype="multipart/form-data" class="updateMC">
        <div class="modal-header border-0">
            <h3 class="modal-title text-warning">EDIT QUESTION</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="display_editMC">
            
        </div>
        <div class="modal-footer border-0">
            <button type="button" class="btn btn-dark mcOpts"><i class="fas fa-plus-circle"></i>&nbsp;&nbsp;Add Option</button>
            <button type="submit" class="btn btn-warning text-white mcEditSave"><i class="fas fa-save"></i>&nbsp;&nbsp;Save Changes</button>
        </div>
    </form>
    </div>
  </div>
</div>

<!-- MC Delete Modal -->
<div class="modal fade" id="deleteMCmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form action="#" method="post" class="deleteMC">
      <div class="modal-header border-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center" id="display_deleteMC">
            
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
        <button type="submit" class="btn btn-outline-danger mcDeleteSave">Yes</button>
      </div>
    </form>
    </div>
  </div>
</div>
</div> <!-- end div quest for mc-->

<?php
}
}
else if ($row['question_template'] == "identification") {
    $idenFetch = mysqli_query($conn, "SELECT * FROM `identification` WHERE `item_number`='$in' AND `quiz_code`='$cod'");
    while ($iden = mysqli_fetch_array($idenFetch)){
?>

<div class="pb-3 quest"><br>
    <div class="text-center">
        <?php if(($iden['item_img']) != "../../img/questPics/"){ ?>
            <img src="<?php echo $iden['item_img']; ?>" width="100px;" height="100px;" alt="itemImage">
        <?php } ?>
        <p class="m-3 fw-bold fs-3"><?php echo $iden['item_question']; ?></p><br>
    </div>
    
    <div class="quest-choices" style="text-align:left;">
        <p>Answer: <?php echo $iden['answer_a']; ?></p>
    </div>

    <div class="quest-choices" style="text-align:right;">
        <p class="m-0">Set Time: <?php echo $iden['item_timer']; ?></p>
        <p class="m-0">Set Point: <?php echo $iden['item_point']; ?></p>

        <button type="button" class="btn btn-warning text-white m-2 idenEdit" data-bs-toggle="modal" data-bs-target="#editIDENmodal" id="<?php echo $iden['item_number']; ?>"><i class="fas fa-edit"></i>&nbsp;&nbsp;Edit</button>
        <button type="button" class="btn btn-danger text-white m-2 idenDelete" data-bs-toggle="modal" data-bs-target="#deleteIDENmodal" id="<?php echo $iden['item_number']; ?>"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp;Delete</button>
    </div>

<!-- IDEN Edit Modal -->
<div class="modal fade bd-example-modal-lg" id="editIDENmodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content p-3">
        <form action="#" method="post" enctype="multipart/form-data" class="updateIDEN">
        <div class="modal-header border-0">
            <h3 class="modal-title text-warning">EDIT QUESTION</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div><br>
        <div class="modal-body" id="display_editIDEN">
            
        </div>
        <div class="modal-footer border-0">
            <button type="submit" class="btn btn-warning text-white idenEditSave"><i class="fas fa-save"></i>&nbsp;&nbsp;Save Changes</button>
        </div>
    </form>
    </div>
  </div>
</div>

<!-- IDEN Delete Modal -->
<div class="modal fade" id="deleteIDENmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form action="#" method="post" class="deleteIDEN">
    <div class="modal-header border-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center" id="display_deleteIDEN">
       
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
        <button type="submit" class="btn btn-outline-danger idenDeleteSave">Yes</button>
      </div>
    </form>
    </div>
  </div>
</div>
</div> <!-- end div quest for iden-->

<?php
}
}
elseif ($row['question_template'] == "enumeration") {
    $enuFetch = mysqli_query($conn, "SELECT * FROM `enumeration` WHERE `item_number`='$in' AND `quiz_code`='$cod'");
    while ($enu = mysqli_fetch_array($enuFetch)){
?>

<div class="pb-3 quest"><br>
    <div class="text-center">
        <?php if(($enu['item_img']) != "../../img/questPics/"){ ?>
            <img src="<?php echo $enu['item_img']; ?>" width="100px;" height="100px;" alt="itemImage">
        <?php } ?>

        <p class="m-3 fw-bold fs-3"><?php echo $enu['item_question']; ?></p><br>
    </div>
    
    <div class="quest-choices" style="text-align:left;">
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

    <div class="quest-choices" style="text-align:right;">
        <p class="m-0">Set Time: <?php echo $enu['item_timer']; ?></p>
        <p class="m-0">Set Point: <?php echo $enu['item_point']; ?></p>

        <button type="button" class="btn btn-warning text-white m-2 enuEdit" data-bs-toggle="modal" data-bs-target="#editENUmodal" id="<?php echo $enu['item_number']; ?>"><i class="fas fa-edit"></i>&nbsp;&nbsp;Edit</button>
        <button type="button" class="btn btn-danger text-white m-2 enuDelete" data-bs-toggle="modal" data-bs-target="#deleteENUmodal" id="<?php echo $enu['item_number']; ?>"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp;Delete</button>
    </div>

<!-- ENUM Edit Modal -->
<div class="modal fade bd-example-modal-lg" id="editENUmodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content p-3">
        <form action="#" method="post" enctype="multipart/form-data" class="updateENU">
        <div class="modal-header border-0">
            <h3 class="modal-title text-warning">EDIT QUESTION</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div><br>
        <div class="modal-body" id="display_editENU">
            
        </div>
        <div class="modal-footer border-0">
            <button type="button" class="btn btn-dark enuOpts"><i class="fas fa-plus-circle"></i>&nbsp;&nbsp;Add Option</button>

            <button type="submit" class="btn btn-warning text-white enuEditSave"><i class="fas fa-save"></i>&nbsp;&nbsp;Save Changes</button>
        </div>
    </form>
    </div>
  </div>
</div>

<!-- ENU Delete Modal -->
<div class="modal fade" id="deleteENUmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form action="#" method="post" class="deleteENU">
    <div class="modal-header border-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center" id="display_deleteENU">
        
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
        <button type="submit" class="btn btn-outline-danger enuDeleteSave">Yes</button>
      </div>
    </form>
    </div>
  </div>
</div>

</div> <!-- end of div enu quest -->

<?php
        }
    }
 }
?>

<?php } ?> <!-- end of while loop -->

</div> <!--end of input questions file -->

    <!--Bootstrap Bundle-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
      let header1 = document.getElementById('navhead');
        header1.classList.add("bg-color");
    </script>
    <script>
        $(document).ready(function(){
            $("#qtemp").on('change', function(){
                $(".template").hide();
                $("#" + $(this).val()).fadeIn(700);
            });
        });

        // Showing of options
        $(document).ready(function(){
        $(".muladd").click(function(){
            $(".mul3").show();

            $(document).ready(function(){
        $(".muladd").click(function(){
            $(".mul4").show();


            $(document).ready(function(){
        $(".muladd").click(function(){
            $(".mul5").show();
        });
    });
        });
    });
        });
    });

    $(document).ready(function(){
        $(".mcOpts").click(function(){
            $(".mcOptionCdiv").show();

            $(document).ready(function(){
        $(".mcOpts").click(function(){
            $(".mcOptionDdiv").show();


            $(document).ready(function(){
        $(".mcOpts").click(function(){
            $(".mcOptionEdiv").show();
        });
    });
        });
    });
        });
    });

     $(document).ready(function(){
        $(".enumadd").click(function(){
            $(".enum3").show();

            $(document).ready(function(){
        $(".enumadd").click(function(){
            $(".enum4").show();

            $(document).ready(function(){
        $(".enumadd").click(function(){
            $(".enum5").show();
        });
    });
        });
    });
        });
    });

    $(document).ready(function(){
        $(".enuOpts").click(function(){
            $(".enuOptionCdiv").show();

            $(document).ready(function(){
        $(".enuOpts").click(function(){
            $(".enuOptionDdiv").show();

            $(document).ready(function(){
        $(".enuOpts").click(function(){
            $(".enuOptionEdiv").show();
        });
    });
        });
    });
        });
    });

    // CHECKED LIST 
    if(document.getElementsByClassName("opt1").checked) {
    document.getElementsByClassName("optHidden1").disabled = true;
    }
    if(document.getElementsByClassName("opt2").checked) {
    document.getElementsByClassName("optHidden2").disabled = true;
    }
    if(document.getElementsByClassName("opt3").checked) {
    document.getElementsByClassName("optHidden3").disabled = true;
    }
    if(document.getElementsByClassName("opt4").checked) {
    document.getElementsByClassName("optHidden4").disabled = true;
    }
    if(document.getElementsByClassName("opt5").checked) {
    document.getElementsByClassName("optHidden5").disabled = true;
    };

    // EDIT CHECKLIST
    if(document.getElementsByClassName("check1").checked) {
    document.getElementsByClassName("check-not1").disabled = true;
    }
    if(document.getElementsByClassName("check2").checked) {
    document.getElementsByClassName("check-not2").disabled = true;
    }
    if(document.getElementsByClassName("check3").checked) {
    document.getElementsByClassName("check-not3").disabled = true;
    }
    if(document.getElementsByClassName("check4").checked) {
    document.getElementsByClassName("check-not4").disabled = true;
    }
    if(document.getElementsByClassName("check5").checked) {
    document.getElementsByClassName("check-not5").disabled = true;
    };

    // Show Modal MC Edit Script
    $(document).on('click','.mcEdit', function(e){
        e.preventDefault();
        var edit_id = $(this).attr('id');
        $.ajax({
            url:"quizDisplays.php",
            type:"post",
            data:{edit_id:edit_id},
            success: function(data){
                $("#display_editMC").html(data);
                $("#editMCmodal").modal('show');
            }
        });
    });

    // Show Modal MC Update Script
    $(document).on('click','.mcEditSave', function(e){
        e.preventDefault();
        $.ajax({
            url:"quizProcess.php",
            type:"post",
            data:$(".updateMC").serialize(),
            success:function(data){
                $("#editMCmodal").modal('hide');
                location.reload();
            }
        });
    });

    // Show Modal MC Delete Script
     $(document).on('click','.mcDelete', function(e){
        e.preventDefault();
        var del_id = $(this).attr('id');
        $.ajax({
            url:"quizDisplays.php",
            type:"post",
            data:{del_id:del_id},
            success: function(data){
                $("#display_deleteMC").html(data);
                $("#deleteMCmodal").modal('show');
            }
        });
    });

    $(document).on('click','.mcDeleteSave', function(e){
        e.preventDefault();
        $.ajax({
            url:"quizProcess.php",
            type:"post",
            data:$(".deleteMC").serialize(),
            success:function(data){
                $("#deleteMCmodal").modal('hide');
                location.reload();
            }
        });
    });

// ******************************************************************************
     // Show Modal IDEN Edit Script
    $(document).on('click','.idenEdit', function(e){
        e.preventDefault();
        var edit_iden_id = $(this).attr('id');
        $.ajax({
            url:"quizDisplays.php",
            type:"post",
            data:{edit_iden_id:edit_iden_id},
            success: function(data){
                $("#display_editIDEN").html(data);
                $("#editIDENmodal").modal('show');
            }
        });
    });

    // Show Modal IDEN Update Script
    $(document).on('click','.idenEditSave', function(e){
        e.preventDefault();
        $.ajax({
            url:"quizProcess.php",
            type:"post",
            data:$(".updateIDEN").serialize(),
            success:function(data){
                $("#editIDENmodal").modal('hide');
                location.reload();
            }
        });
    });

    // Show Modal IDEN Delete Script
     $(document).on('click','.idenDelete', function(e){
        e.preventDefault();
        var del_iden_id = $(this).attr('id');
        $.ajax({
            url:"quizDisplays.php",
            type:"post",
            data:{del_iden_id:del_iden_id},
            success: function(data){
                $("#display_deleteIDEN").html(data);
                $("#deleteIDENmodal").modal('show');
            }
        });
    });

    $(document).on('click','.idenDeleteSave', function(e){
        e.preventDefault();
        $.ajax({
            url:"quizProcess.php",
            type:"post",
            data:$(".deleteIDEN").serialize(),
            success:function(data){
                $("#deleteIDENmodal").modal('hide');
                location.reload();
            }
        });
    });

// ******************************************************************************
     // Show Modal ENU Edit Script
    $(document).on('click','.enuEdit', function(e){
        e.preventDefault();
        var edit_enu_id = $(this).attr('id');
        $.ajax({
            url:"quizDisplays.php",
            type:"post",
            data:{edit_enu_id:edit_enu_id},
            success: function(data){
                $("#display_editENU").html(data);
                $("#editENUmodal").modal('show');
            }
        });
    });

    // Show Modal ENU Update Script
    $(document).on('click','.enuEditSave', function(e){
        e.preventDefault();
        $.ajax({
            url:"quizProcess.php",
            type:"post",
            data:$(".updateENU").serialize(),
            success:function(data){
                $("#editENUmodal").modal('hide');
                location.reload();
            }
        });
    });

    // Show Modal ENU Delete Script
     $(document).on('click','.enuDelete', function(e){
        e.preventDefault();
        var del_enu_id = $(this).attr('id');
        $.ajax({
            url:"quizDisplays.php",
            type:"post",
            data:{del_enu_id:del_enu_id},
            success: function(data){
                $("#display_deleteENU").html(data);
                $("#deleteENUmodal").modal('show');
            }
        });
    });

    $(document).on('click','.enuDeleteSave', function(e){
        e.preventDefault();
        $.ajax({
            url:"quizProcess.php",
            type:"post",
            data:$(".deleteENU").serialize(),
            success:function(data){
                $("#deleteENUmodal").modal('hide');
                location.reload();
            }
        });
    });

// ******************************************************************************
    </script>
  
  </body>

</html>