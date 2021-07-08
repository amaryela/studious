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
          <h1 style="text-transform:uppercase;"><?php echo $row['roomName']; ?></h1>
          <p>Room code: <?php echo $row['roomCode']; ?></p>
          
          <a href="reportStuds.php?next=<?php echo $row['roomCode']; ?>"><button type="button" class="btn btn-dark m-2"><i class="fas fa-chalkboard-teacher"></i>&emsp;Progress</button></a>
        </div>

        <div class="col-sm text-center">
          <img src="../../img/undraw_online_test_gba7.svg" height="150px" alt="design-icon">
        </div>
      </div>
      <hr>
    </div>


    <div class="container jumbotron" style="width:50%;">
      <?php 
          $rcodes = $row['roomCode'];
          $qquery = "SELECT * FROM quiz WHERE quiz_owner = '$userid' AND quiz_roomcode ='$rcodes' ";
          $qresult = mysqli_query($conn, $qquery);
          if (mysqli_num_rows($qresult)==0) { ?>
  
            <div class="text-center">
              <p style="font-size:20px;">No scheduled quiz.</p>
              <img src="../../img/undraw_Notify_re_65on.svg" alt="icon-no-room" height="300px">
            </div>
          
          <?php }
          else{
            while ($quizrow = mysqli_fetch_array($qresult)) {

              $qcodes = $quizrow['quiz_code'];
              $squery = "SELECT * FROM scheduledquizzes WHERE quiz_code = '$qcodes' AND quiz_roomcode ='$rcodes' ";
              $sresult = mysqli_query($conn, $squery);

            while ($schedrow = mysqli_fetch_array($sresult)) {
      ?>

      <div class="row records">
        <div class="col-sm ps-3 pt-3">
          <h3><?php echo $quizrow['quiz_name']; ?></h3>
          <!-- <p style="font-size:15px"><?php echo $schedrow['quiz_code']; ?></p> -->
          
          <p style="font-size:15px;"><?php echo date('F d, Y', strtotime($schedrow['quiz_date'])).
          "&emsp;-&emsp;".date('g:i a', strtotime($schedrow['quiz_time'])); ?></p>
        </div>

        <div class="col-sm text-center" style="margin:auto;">
            <?php 
            if ($schedrow['status'] != "finished"){ ?>
              <button type="button" class="btn btn-dark" id="<?php echo $schedrow['quiz_code']; ?>" disabled><i class="fas fa-play-circle"></i>&emsp;Launch quiz</button>
            <?php } else { ?>
              <a href="view-quiz.php?next=<?php echo $schedrow['quiz_code'];?>"><button type="button" class="btn btn-dark">View Quiz</button></a>
            <?php } ?>
        
        </div>
      </div><br>

      <?php } } }?>
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