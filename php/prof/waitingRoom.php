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

    <div class="container waiting" id="waiting">
      <div class="row">
        <div class="col-sm text-center p-3">
          <img src="../../img/undraw_team_up_ip2x.svg" alt="icon-team" height="280px">
          
          <?php while ($row = mysqli_fetch_array($results)) {?>
            <h3 class="p-3"><?php echo $row['quiz_name'];?></h3>

          <?php
            $sql = "SELECT * FROM scheduledquizzes WHERE quiz_code = '$id'";
            $s_query = mysqli_query($conn, $sql);
              while ($s_row = mysqli_fetch_array($s_query)) {
          ?>
          
            <div class="row">
              <div class="col">
              <p>Room: <?php echo $s_row['quiz_roomcode'];?> <br>
              Schedule: <?php echo $s_row['quiz_date'] . "/" . $s_row['quiz_time']; }?></p>
              </div>
              <div class="col">
                <form action="launch-quiz.php" method="post">
                  <input type="hidden" name="quizcode" value="<?php echo $row['quiz_code'];?>">
                  <input type="hidden" name="qroom" value="<?php echo $row['quiz_roomcode'];?>">
                  <input type="hidden" name="quizname" value="<?php echo $row['quiz_name'];?>">
                  <input type="hidden" name="status" value="on-going">
                  
                  <button type="submit" name="startquiz" class="btn btn-outline-dark"
                  style="margin-top:20px;"><i class="fas fa-play-circle"></i>&emsp;START QUIZ</button>
                </form>
              </div>
            </div>
        </div>
    
        <div class="col-sm text-center p-3" id="load_posts">
        <!-- Refresh this Div content every second!-->
        <!-- For Refresh Div content every second we use setInterval() !-->
        </div>
      </div>
      

  <?php } ?> 
      </div>

    <!--Bootstrap Bundle-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
      let header1 = document.getElementById('navhead');
        header1.classList.add("bg-color");
    </script>

    <script>
      setInterval(function(){
        $('#load_posts').load("waitingDisplay.php").fadeIn("slow");
        }, 1000);
    </script>
  
  </body>

</html>