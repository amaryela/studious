<?php
ob_start();
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
    <?php include('../include/nav-stud.php'); ?>

    <div class="container jumbotron">
      <div class="row">
        <div class="col-sm text-center" style="margin-bottom:20px;">
          <img src="../../img/undraw_online_test_gba7.svg" height="150px" alt="design-icon">
        </div>

        <div class="col-sm">
          <?php while ($row = mysqli_fetch_array($results)) {?>
          
          <h1 style="text-transform:uppercase;"><?php echo $row['roomName']; ?></h1>
          
          <?php
            $prof = $row['owner'];
            $p_query ="SELECT * FROM users WHERE ID = '$prof'";
            $p_results = mysqli_query($conn, $p_query);  
              while ($p_row = mysqli_fetch_array($p_results)) {
          ?>

          <p>Professor: <?php echo $p_row['uFirstName'] . " " . $p_row['uLastName']; }?></p>
          <a href="studProgress.php?next=<?php echo $id; ?>"><button type="button" class="btn btn-dark">
          <i class="fas fa-check-double"></i>&ensp;Quiz History</button></a>
        </div>
      </div>
      <br>

      <div class="row border border-3 border-warning rounded p-2">
      <?php
          $count = mysqli_query($conn, "SELECT * FROM records WHERE room_code = '$id' AND user_id = '$userid'");
          $num_total = mysqli_num_rows($count);
          $show = mysqli_fetch_array($count);

          // $count = mysqli_query($conn, "SELECT * FROM scheduledquizzes WHERE quiz_roomcode = '$id' AND status = 'finished'");
          // $num_total = mysqli_num_rows($count);

          $miss = mysqli_query($conn, "SELECT * FROM quizaccess WHERE q_roomcode = '$id' AND quiz_takerID = '$userid'");
          $num_miss = mysqli_num_rows($miss);

          if ($num_miss < $num_total){
            $miss_total = $num_total - $num_miss;
          }
          else{
            $miss_total = 0;
          }
          // $miss = mysqli_query($conn, "SELECT * FROM quizaccess WHERE q_roomcode = '$id' AND score = '' AND quiz_takerID = '$userid'");
          // $num_miss = mysqli_num_rows($miss);
      ?>

        <div class="col-sm text-center">
          <h2><?php echo $miss_total;?></h2>
          <h5>Missed</h5>
        </div>

        <div class="col-sm text-center">
          <h2><?php echo $num_total;?></h2>
          <h5>Total Quiz</h5>
        </div>

        <?php if (empty($show['percentage'])){ ?>
          <div class="col-sm text-center">
          <h2>0</h2>
          <h5>Average Grade</h5>
        </div>

        <?php } else { ?>
         <div class="col-sm text-center">
          <h2><?php echo $show['percentage'];?></h2>
          <h5>Average Grade</h5>
        </div>
        <?php } ?>

      </div>
    </div>


    <div class="container jumbotron" style="width:50%;">

    <?php 
        $rcodes = $row['roomCode'];
        //joing two tables
        $go = "SELECT room.*, enrolleduser.*, scheduledquizzes.* FROM room JOIN enrolleduser ON room.roomCode=enrolleduser.roomID JOIN scheduledquizzes ON scheduledquizzes.quiz_roomcode = enrolleduser.roomID WHERE enrolleduser.enrolledUserID = '$userid' AND room.roomCode = '$rcodes' AND scheduledquizzes.status !='finished'";
        $join = mysqli_query($conn, $go);

        if (mysqli_num_rows($join) == 0) { ?>
          <div class="text-center">
            <p style="font-size:20px;">No scheduled quiz yet. Browse quiz history.</p>
            <img src="../../img/undraw_Notify_re_65on (stud).svg" alt="icon-no-room" height="300px">
          </div>
        <?php } else {
          while ($data = mysqli_fetch_array($join)) { ?>

        <div class="row records">
          <div class="col-sm ps-3 pt-3">
            <h3><?php echo $data['quiz_name']; ?></h3>
            <p style="font-size:15px;"><?php echo date('F d, Y', strtotime($data['quiz_date'])).
            "&emsp;-&emsp;".date('g:i a', strtotime($data['quiz_time'])); ?></p>
          </div>
          
<?php
if(isset($_POST['takequiz'])){
	$quiz_code = $_POST['qcode'];
	$room_code = $_POST['rcode'];
	$user_id =  $_POST['user'];
	$sq_id =  $_POST['schedID'];
	
  $_SESSION['sched_id'] = $sq_id;
	$_SESSION['room_code'] = $room_code;
	$_SESSION["theCode"] = $quiz_code;


		
		$checkExist = mysqli_query($conn, "SELECT * FROM  `quizaccess` WHERE quiz_takerID = '$user_id' AND q_code = '$quiz_code'");
		if ($ce = mysqli_num_rows($checkExist) == 1){
			echo "<script>window.location='s-quiz-room.php?next=$sq_id';</script>";
		}	
	  else {
      $resultU = "SELECT * FROM `users` WHERE `ID` = '$user_id'";
      $check_u = mysqli_query($conn, $resultU);
      $rowu = mysqli_fetch_array($check_u);
      $uFName =  $rowu['uFirstName'];
      $uLName = $rowu['uLastName']; 
      $uE = $rowu['uEmail'];
      
      $score = 0;
      $status = "none";
          
    $resultQA = "INSERT INTO `quizaccess`(`q_code`, `q_roomcode`, `quiz_takerID`, `quiz_takerFName`, `quiz_takerLName`, `quiz_takerEmail`, `score`, `status`) VALUES ('".$quiz_code."','".$room_code."','".$user_id."','".$uFName."','".$uLName."',  '".$uE."',  '".$score."',  '".$status."')";
    $check_QA = mysqli_query($conn , $resultQA);
    
    if($check_QA){
      echo "<script>window.location='s-quiz-room.php?next=$sq_id';</script>";
    }
  }
}
?>
  
          <div class="col-sm text-center" style="margin:auto;">
            <form  method="post">
              <input type="hidden" name="qcode" value="<?php echo $data['quiz_code']; ?>">
              <input type="hidden" name="user" value="<?php echo $userid; ?>">
              <input type="hidden" name="schedID" value="<?php echo $data['id']; ?>">
              <input type="hidden" name="rcode" value="<?php echo $row['roomCode']; ?>">
  
  
              <?php if ($data['status'] != "finished"){ ?>
                <button type="submit" class="btn btn-dark" name="takequiz" <?php if ($data['status'] == "set"){ ?> disabled <?php } ?> ><i class="fas fa-play-circle"></i>&ensp;Take quiz</button>
              <?php } ?>
  
              <!-- <button type="submit" class="btn btn-dark" name="takequiz"><i class="fas fa-play-circle"></i>&ensp;Take quiz</button> -->
            </form>
          </div>
  
        </div><br>
        <?php  } } ?>

</div>

<?php } ?> <!-- end for while above quizDB -->




    <!--Bootstrap Bundle-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
      let header1 = document.getElementById('navhead');
        header1.classList.add("bg-color-stud");
    </script>

  </body>

</html>
