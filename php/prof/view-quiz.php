
<?php
session_start();
include '../include/config.php';

$userid = $_SESSION['id'];

if (empty($_SESSION['id'])){
  header('Location: ../../index.php');
}

if (isset($_GET['next'])) {
    $id = $_GET['next'];

    $query = "SELECT * FROM quiz WHERE quiz_code = '$id'" ;
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
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
        <div class="col text-end">
            <img src="../../img/undraw_design_team_af2y.svg" height="150px" alt="design-content">
        </div>
        <div class="col m-auto ms-5">
            <h2 class="text-warning" style="text-transform:uppercase;">SUBJECT</h2>
            <p class="m-0 fw-bold fs-6"><?php echo $row['quiz_name']; ?></p>
            <p class="m-0 fw-bold fs-6">Total points</p>
        </div>
      </div>
    </div>

<?php
$results = mysqli_query($conn, "SELECT * FROM `questions` WHERE `quiz_code` = '$id'");
while ($row = mysqli_fetch_array($results)) {
    $in = $row['id'];

    if ($row['question_template'] == "multiple choice") {
        $mcFetch = mysqli_query($conn, "SELECT * FROM `multiplechoice` WHERE `item_number`='$in' AND `quiz_code`='$id'");
        while ($mc  = mysqli_fetch_array($mcFetch)){
?>       

<div class="pb-4 quest" style="width:50%;"><br>
    <div class="text-center">
        <?php if(($mc['item_img']) != "../../img/questPics/"){ ?>
            <img src="<?php echo $mc['item_img']; ?>" width="100px;" height="100px;" alt="itemImage">
        <?php } ?>

        <p class="m-3 fw-bold fs-5"><?php echo $mc['item_question']; ?></p>
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
        </div>
</div> <!-- end div quest for mc-->


<?php
}}
else if ($row['question_template'] == "identification") {
    $idenFetch = mysqli_query($conn, "SELECT * FROM `identification` WHERE `item_number`='$in' AND `quiz_code`='$id'");
    while ($iden = mysqli_fetch_array($idenFetch)){
?>

<div class="pb-4 quest" style="width:50%;"><br>
    <div class="text-center">
        <?php if(($iden['item_img']) != "../../img/questPics/"){ ?>
            <img src="<?php echo $iden['item_img']; ?>" width="100px;" height="100px;" alt="itemImage">
        <?php } ?>
        
        <p class="m-3 fw-bold fs-5"><?php echo $iden['item_question']; ?></p><br>
    </div>
    
    <div class="quest-choices" style="text-align:left;">
        <p>Answer: <?php echo $iden['answer_a']; ?></p>
    </div>

    <div class="quest-choices" style="text-align:right;">
        <p class="m-0">Set Time: <?php echo $iden['item_timer']; ?></p>
        <p class="m-0">Set Point: <?php echo $iden['item_point']; ?></p>
    </div>
</div> <!-- end div quest for iden-->


<?php
}}
elseif ($row['question_template'] == "enumeration") {
    $enuFetch = mysqli_query($conn, "SELECT * FROM `enumeration` WHERE `item_number`='$in' AND `quiz_code`='$id'");
    while ($enu = mysqli_fetch_array($enuFetch)){
?>

<div class="pb-4 quest" style="width:50%;"><br>
    <div class="text-center">
        <?php if(($enu['item_img']) != "../../img/questPics/"){ ?>
            <img src="<?php echo $enu['item_img']; ?>" width="100px;" height="100px;" alt="itemImage">
        <?php } ?>

        <p class="m-3 fw-bold fs-5"><?php echo $enu['item_question']; ?></p><br>
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
    </div>
</div> <!-- end of div enu quest -->

<?php
        } 
    }
 }
?>
</div> <!--end of input questions file -->

    <!--Bootstrap Bundle-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
      let header1 = document.getElementById('navhead');
        header1.classList.add("bg-color");
    </script>
  
  </body>

</html>