<?php
include '../include/config.php';
session_start();

$userid = $_SESSION['id'];

if (empty($_SESSION['id'])){
  header('Location: ../../index.php');
}

    if (isset($_GET['next'])) {
        $id = $_GET['next'];
        
        $sql = "SELECT * FROM scheduledquizzes WHERE id = '$id'";
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
    <link rel="stylesheet" type="text/css" href="../../css/quiz.css">
    </head>

  <body class="bg-dark text-white">
    <div class="container-fluid p-4">
      
      <div class="row gx-3">
        <div class="col-10">
          <div class="quiz rounded bg-light text-dark mt-3" id="waiting"><!-- load question -->
            <img class="m-2" src="../../img/logo.png" alt="imgDes" height="50px"><br>
          </div>
        </div>

        <div class="col-2">
          <div class="rank mt-3" id="load_posts"><!-- load participants -->

          </div>
        </div>
        
      </div>
    </div>


    <!--Bootstrap Bundle-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
      function loadXMLDoc() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("load_posts").innerHTML =
            this.responseText;
          }
        };
        xhttp.open("GET", "participants-display.php", true);
        xhttp.send();
      }
      setInterval(function(){
        loadXMLDoc();
        // 1sec
      },1000);

      window.onload = loadXMLDoc;
    </script>

    <script type="text/javascript">
      $(document).ready(function(){
      $("#waiting").load("quiz-display.php").fadeIn("slow") });
    </script>

  </body>

</html>