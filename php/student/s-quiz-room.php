<?php
include '../include/config.php';
include '../q-functions.php';
session_start();
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

$userid = $_SESSION['id'];

if (empty($_SESSION['id'])){
  header('Location: ../../index.php');
}

if (isset($_GET['next'])) {
  $id = $_GET['next'];
  $_SESSION['sched_id'] =$id;

  $statusUpdate = mysqli_query($conn, "SELECT * FROM `scheduledquizzes` WHERE id ='$id'");
  while ($stts_up = mysqli_fetch_array($statusUpdate)) {
  $_SESSION["status"] = $stts_up['status']; 

          if ($_SESSION["status"] == "finished"){ 
            echo "<script>window.location='top-participants.php';</script>";
          }

          if ($_SESSION["status"] == "waiting"){ ?>

                  <script>
                  schedUpdate();
                  </script><?php 
          } 

          if ($_SESSION["status"] == "on-going"){ ?>

                  <script>
                  stopReloadSched();
                  </script>
          <?php

              $in = $_SESSION['qstn_id'];
              $statusUpdate = mysqli_query($conn, "SELECT * FROM `questions` WHERE id ='$in'");
                      while ($stts_row = mysqli_fetch_array($statusUpdate)){
                      $question_status = $stts_row['status']; 
                       
              if($question_status == "done"){ ?> 
                      <script>
                      stopDoneStatus();
                      </script>
              <?php } else{ ?>
                      <script>
                      doneUpdate();
                      </script>
              <?php }
      }
    } 
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
    <link rel="stylesheet" type="text/css" href="../../css/quiz.css">
    </head>

    <body class="bg-dark text-white">
      <div id="status_update"><!-- waiting/not for the quiz to start --></div>
        <div class="container-fluid p-4">

          <!-- quiz questions status update reason kung bakit di nag auto refresh sa question sa DONE na id-->
          <div class="aaa" id="done"></div>

          <div class="row gx-5">

            <div class="col-10">
              <div class="quiz rounded bg-light text-dark mt-3" id="waiting"></div><!-- display questions -->
            </div>

            <div class="col-2">
              <div class="rank mt-3" id="load_posts"></div><!-- display participants -->
            </div>

          </div>
        </div><!-- container fluid end tag -->

<!--Bootstrap Bundle-->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
  quizLoad();
  schedFinished();

  // readyUpdate();
  // finishedStatus();
</script>

<script>
function loadXMLDoc() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("load_posts").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("GET", "loaders/participants-display.php", true);
  xhttp.send();
}
setInterval(function(){
  loadXMLDoc();
  // 1sec
},1000);

window.onload = loadXMLDoc;
</script>

  </body>

</html>