<?php
session_start();
include '../include/config.php';

$userid = $_SESSION['id'];

if (empty($_SESSION['id'])){
  header('Location: ../../index.php');
}
if (isset($_GET['next'])) {
  $id = $_GET['next'];

  $find = "SELECT * FROM scheduledquizzes WHERE status = 'finished' AND quiz_roomcode = '$id' ORDER BY quiz_date DESC";
  $go = mysqli_query($conn, $find);
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
          <div class="col-5 text-end">
            <img src="../../img/undraw_collecting_fjjl.svg" alt="files" width="150">
          </div>
          <div class="col">
            <h2 class="mt-5 text-warning">QUIZ HISTORY</h2>
          </div>
        </div> 
      </div>

      <div class="container jumbotron" style="width:50%">
        
        <?php if (mysqli_num_rows($go)==0) { ?>
          <div class="col text-center">
            <p style="font-size:20px;">No finished quiz in this subject.</p>
          </div>
        <?php } else{ 
          while ($show = mysqli_fetch_array($go)) {?>

        <div class="row justify-content-md-center records">
          <div class="col-sm p-3 ms-3" style="margin:auto;">
            <h3><?php echo $show['quiz_name'];?></h3>
            <p class="m-0" style="font-size:15px;">Schedule: <?php echo date('F d, Y', strtotime($show['quiz_date'])). "&emsp;-&emsp;".date('g:i a', strtotime($show['quiz_time'])); ?></p>
          </div>
          <div class="col-sm m-auto">
            <a href="view-quiz.php?next=<?php echo $show['quiz_code'];?>"><button type="button" class="btn btn-dark mb-3">View Quiz</button></a>
          </div>
        </div><br>
        <?php } } ?> <!-- end row loop -->

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