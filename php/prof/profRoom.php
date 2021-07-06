<?php
session_start();
include '../include/config.php';

$userid = $_SESSION['id'];

if (empty($_SESSION['id'])){
  header('Location: ../../index.php');
}

  if (isset($_GET['next'])) {
        $id = $_GET['next'];

        $sql = "SELECT * FROM room WHERE roomCode = '$id'";
        $results = mysqli_query($conn, $sql);
    }

  if(isset($_POST['crtquiz'])){

    $user=$_POST['profuser'];
    $quizn= $_POST['qzn'];
    $qcode= $_POST['gencode'];
    $roomcode = $_POST['rmcode'];
    $stats = "gen";


    $sql = "INSERT INTO `quiz`(`quiz_code` , `quiz_name` , `quiz_roomcode`, `quiz_owner`, `status`) 
        VALUES ('".$qcode."','".$quizn."','".$roomcode."','".$user."','".$stats."')";

        $check_reg = mysqli_query($conn,$sql);

        if($check_reg){
          echo "<script>window.location='makeQuiz.php?next=$qcode';</script>";
        }
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
        <div class="col-sm" style="text-align:center;">

          <?php while ($row = mysqli_fetch_array($results)) {?>
          <h1 style="text-transform:uppercase;"><?php echo $row['roomName']; ?></h1>
          <p>Room code: <?php echo $row['roomCode']; ?></p>

          <button type="button" class="btn btn-dark m-2" data-bs-toggle="modal" data-bs-target="#createQuiz"><i class="fas fa-plus-circle"></i>&emsp;Quiz</button>
          
          <a href="drafts.php?next=<?php echo $row['roomCode']; ?>"><button type="button" class="btn btn-dark m-2"><i class="fas fa-pencil-ruler"></i>&emsp;Drafts</button></a><br>

          <a href="quizHistory.php?next=<?php echo $row['roomCode']; ?>"><button type="button" class="btn btn-warning text-white m-2"><i class="fas fa-history"></i>&emsp;Quiz History</button></a>
          
          <a href="reportStuds.php?next=<?php echo $row['roomCode']; ?>"><button type="button" class="btn btn-warning text-white m-2"><i class="fas fa-chalkboard-teacher"></i>&emsp;Students Records</button></a>

        </div>

        <div class="col-sm text-center mt-3">
          <img src="../../img/undraw_online_test_gba7.svg" height="150px" alt="design-icon">
        </div>
      </div>
      <hr>

<!-- Modal for creating quiz -->
<div id="createQuiz" class="modal fade">
  <div class="modal-dialog modal-pop">
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title">CREATE QUIZ</h4>
      </div>
      <div class="modal-body">

        <form action="profRoom.php" method="post">
          <div class="form-group">
            <i class="fas fa-pen"></i>

            <input type="hidden" name="profuser" value="<?php echo $userid; ?>">
            <input type="hidden" name="rmcode" value="<?php echo $row['roomCode']; ?>">
            <input type="hidden" name="gencode" value="<?php echo rand(10000,50000);?>">
            <input type="text" class="form-control" name="qzn" placeholder="Quiz Name" required style="width:100%; margin:auto;">
          </div><br>

          <div class="text-center form-group">
            <input style="width:150px;" type="submit" name="crtquiz" class="btn btn-dark" value="SUBMIT"><br><br>
          </div>
        </form>       
        
      </div>
  </div>
</div>       
</div>

</div> <!-- first jumbotron div -->

    <div class="container jumbotron" style="width:50%;">

      <?php 
          $rcodes = $row['roomCode'];
          //joining quiz and scheduled quiz here
          $go = "SELECT quiz.*, scheduledquizzes.* FROM quiz JOIN scheduledquizzes ON quiz.quiz_code=scheduledquizzes.quiz_code WHERE quiz.quiz_owner='$userid' AND scheduledquizzes.status !='finished' AND quiz.quiz_roomcode = '$rcodes'";
          $join = mysqli_query($conn, $go);

          if (mysqli_num_rows($join) == 0) { ?>
            <div class="text-center">
              <p style="font-size:20px;">No scheduled quiz yet. Browse quiz history.</p>
              <img src="../../img/undraw_Notify_re_65on.svg" alt="icon-no-room" height="300px">
            </div>
          <?php } else {
            while ($data = mysqli_fetch_array($join)) { ?>
              <div class="row records">
                <div class="col-sm ps-3 pt-3">
                  <h3><?php echo $data['quiz_name']; ?></h3>
                  <!-- <p style="font-size:15px"><?php echo $data['quiz_code']; ?></p> -->
                  <p class="m-0" style="font-size:15px;">Scheduled by:</p>
                  <p style="font-size:15px;"><?php echo date('F d, Y', strtotime($data['quiz_date'])). "&emsp;-&emsp;".date('g:i a', strtotime($data['quiz_time'])); ?></p>
                </div>

                <div class="col-sm text-center" style="margin:auto;">
                  <form action="launch-quiz.php" method="post">
                      <input type="hidden" name="status" value="waiting">
                      <input type="hidden" name="rcode" value="<?php echo $rcodes; ?>">
                      <input type="hidden" name="qcode" value="<?php echo $data['quiz_code'] ?>">
                      
                      <button type="submit" name="launch" style="" class="btn btn-dark"><i class="fas fa-play-circle"></i>&emsp;Launch quiz</button>
                  </form>
                </div>
              </div>
              <br>
          <?php  } } ?>

    </div>

<?php } ?> <!-- end for while above quizDB -->


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