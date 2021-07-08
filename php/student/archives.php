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
    <style>
      #navhead.cus-nav .circle-icon{
        background-color: #FCDE88;
        padding: 10px;
        border-radius: 50%;
        color: white;
        font-size: 18px;
      }
    </style>
  </head>

  <body style="background-image:url('../../img/waveSTD.svg');">
    <?php include('../include/nav-stud.php'); ?>

    <div class="container-fluid">
      <section class="jumbotron" id="info">
        <?php $sql=mysqli_query($conn,"SELECT * from users where ID = '$userid'");
          while($row=mysqli_fetch_array($sql)){ ?>
            <div class="row">
              <div class="col">
                <h2 style="align-items:left;">Hi <?php echo $row['uFirstName']; ?>!</h2>
                <p style="font-size:15px;">Here are the rooms that your professor archived.</p>
              </div>
            </div>  
      </section>
      <?php } ?>

      <section id="rooms">
        <div class="container">
          <?php 
              $join = "SELECT room.*, enrolleduser.* FROM room JOIN enrolleduser ON room.roomCode=enrolleduser.roomID WHERE enrolleduser.enrolledUserID='$userid' AND room.status = 'off'";
              $joins = mysqli_query($conn, $join);

              if (mysqli_num_rows($joins)==0) {?>

          <div class="text-center">
              <hr>
              <p style="font-size:20px;">No rooms in archive.</p>
              <img src="../../img/undraw_Notify_re_65on (stud).svg" alt="icon-no-room" height="300px" style="margin-bottom:20px;">
            </div>
          <?php }
          else{
            while ($row = mysqli_fetch_array($joins)) { ?>

            <div class="main-room m-2" style="border: 2px solid <?php echo $row['roomColor']; ?>; background: linear-gradient( <?php echo $row['roomColor']; ?> 70%, white 30%); ">
              <div class="main-info text-dark p-2">
                <a class="text-dark" href="viewArchives.php?next=<?php echo $row['roomCode']; ?>">
                <span style="font-weight:600;"> <?php echo $row['roomName']; ?></span><br>
                <span style="font-size: 12px;">Room code:&nbsp;</span><span><?php echo $row['roomCode']; ?></span>
                <a>
              </div>
            </div>
        <?php } } ?>
      </div>
      </section>

</div>


    <!--Bootstrap Bundle-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
      window.addEventListener("scroll", function(){
        let header1 = document.getElementById('navhead');

        if (window.pageYOffset > 0){
          header1.classList.add("cus-nav");
        }else{
          header1.classList.remove("cus-nav")
        }
      });
    </script>
  
  </body>

</html>