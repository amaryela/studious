<?php
session_start();
include '../include/config.php';

$userid = $_SESSION['id'];

if (empty($_SESSION['id'])){
  header('Location: ../../index.php');
}

$schedule = $_SESSION['sched_id'];
$quiz_code = $_SESSION["theCode"];

$sheesh = $_SESSION["status"]; 
$rcode = $_SESSION["room_code"];

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
      <div class="col-sm">
        <img src="../../img/undraw_winners_ao2o.svg" alt="icon-team" height="300px">
      </div>
      <div class="col p-3">
        <h2 class="p-2 mb-4">STUDENT SCORES</h2>

<?php
$query = "SELECT * FROM `quizaccess` WHERE q_code = '$quiz_code' ORDER BY `quizaccess`.`score` DESC" ;
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($result)){ ?>

        <!-- <p class="ms-5">Ana Marie - 50 points</p> -->
        <p class="ms-5"><?php echo $row["quiz_takerFName"] . " " . $row["quiz_takerLName"]; ?> - <?php echo $row["score"]; ?></p>

<?php }?>

      </div>
    </div>
  </div>

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