<?php
session_start();
include '../include/config.php';

$userid = $_SESSION['id'];

if (empty($_SESSION['id'])){
  header('Location: ../../index.php');
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
    <link rel="stylesheet" type="text/css" href="../../css/homes.css">

  </head>
  <body>
    <?php include('../include/nav-stud.php'); ?>

    <div class="container-fluid">
      <div class="row p-5">
        <div class="col">
          <img src="../../img/undraw_Updated_re_u4yh.svg" alt="notification" width="500">
        </div>
        <div class="col">
          <h1 class="p-3">Notifications</h1>

          <?php if(mysqli_num_rows($join) == 0) { ?>
            <p class="border p-2 rounded m-3"><i class="fas fa-exclamation-circle"></i>&emsp;You don't have a scheduled quiz.</p>

          <?php } else {
            while ($data = mysqli_fetch_array($join)) {
          ?>

          <div class="row border p-2 rounded m-3">
            <p class="m-0"><i class="fas fa-exclamation-circle"></i>&emsp;The <strong>
              <a class="text-warning" href="studRoom.php?next=<?php echo $data['roomCode']; ?>">
                <?php echo $data['quiz_name'];?></strong>
              </a> is scheduled today at 
            <?php echo date('g:i a', strtotime($data['quiz_time'])); ?></p>
          </div>

          <?php } } ?>
          
        </div>
      </div>
    </div>
    

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