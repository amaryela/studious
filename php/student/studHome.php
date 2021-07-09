<?php
session_start();
include '../include/config.php';

$userid = $_SESSION['id'];

if (empty($_SESSION['id'])){
  header('Location: ../../index.php');
}

if ($_SESSION['role'] != "student"){
  header('Location: ../../index.php');
}

if(isset($_POST['join'])){
  $code = $_POST['roomcode'];
  $fname = $_POST['firstname'];
  $lname = $_POST['lastname'];
  $email = $_POST['email'];
  $role = $_POST['role'];

  $get = "SELECT * FROM room WHERE roomCode = '$code'";
  $go = mysqli_query($conn, $get);

  if (mysqli_num_rows($go) > 0){
    $find = "SELECT * FROM enrolleduser WHERE roomID = '$code' AND enrolledUserID = '$userid'";
    $check = mysqli_query($conn,$find);
 
     if (mysqli_num_rows($check) > 0){
       header("Location: studHome.php?error=Room is already in your account.");
       exit();
     }

     else{
      $query = "INSERT INTO enrolleduser (roomID, enrolledUserID, enrolledUserFN, enrolledUserLN, enrolledEmail, enrolledRole) VALUES ('".$code."','".$userid."','".$fname."','".$lname."','".$email."','".$role."')";

        $check_reg = mysqli_query($conn,$query);
        if($check_reg){
          header('Location:studHome.php');
        }
    }
  }
    else{
      header("Location: studHome.php?error=Room code doesn't exist");
      exit();
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
              <div class="col-4">
                <h2 style="align-items:left;">Hi <?php echo $row['uFirstName']; ?>!</h2>
                <p style="font-size:15px;">Welcome to studious, want to join a room?</p>
              </div>

              <div class="col">
                <button type="button" class="btn btn-warning text-white me-3" data-bs-toggle="modal" data-bs-target="#joinRoomModal"><i class="fas fa-plus-circle"></i>&nbsp; Room</button>

                <a href="archives.php"><button type="button" class="btn btn-warning text-white"><i class="fas fa-archive"></i>&nbsp; Archives</button></a>
              </div>
            </div>  
      </section>

<div id="joinRoomModal" class="modal fade">
  <div class="modal-dialog modal-pop">
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title" style="font-weight:500;">JOIN ROOM</h4>
      </div>
      <div class="modal-body">
        <form action="studHome.php" method="post">
          <div class="form-group">
            <i class="fas fa-pen"></i>

            <input type="hidden" name="firstname" value="<?php echo $row['uFirstName']; ?>">
            <input type="hidden" name="lastname" value="<?php echo $row['uLastName']; ?>">
            <input type="hidden" name="email" value="<?php echo $row['uEmail']; ?>">
            <input type="hidden" name="role" value="<?php echo $row['uRole']; ?>">

            <input type="text" class="form-control" name="roomcode" placeholder="Enter Code" required>
          </div><br>

          <div class="text-center form-group">
            <input style="width:150px;" type="submit" name="join" class="btn btn-warning text-white" value="SUBMIT"><br><br>
          </div>
        <?php } ?>
        </form>
      </div>
  </div>
</div>       
</div>

      <section id="rooms">

<div class="container" style="width:350px;" id="error">
  <?php if (isset($_GET['error'])) { ?>
      <div class="alert alert-danger d-flex align-items-center fade show" role="alert">
        <i class="fas fa-exclamation-triangle"></i>&emsp;
        <?php echo $_GET['error']; ?>
      </div>
  <?php } ?>
</div>

        <div class="container">
          <?php 
              $join = "SELECT room.*, enrolleduser.* FROM room JOIN enrolleduser ON room.roomCode=enrolleduser.roomID WHERE enrolleduser.enrolledUserID='$userid' AND room.status = 'on'";
              $joins = mysqli_query($conn, $join);

              if (mysqli_num_rows($joins)==0) {?>

          <div class="text-center">
              <hr>
              <p style="font-size:20px;">No joined rooms.</p>
              <img src="../../img/undraw_Notify_re_65on (stud).svg" alt="icon-no-room" height="300px" style="margin-bottom:20px;">
            </div>
          <?php }
          else{
            while ($row = mysqli_fetch_array($joins)) { ?>
            <a href="studRoom.php?next=<?php echo $row['roomCode']; ?>">

            <div class="main-room m-2" style="border: 2px solid <?php echo $row['roomColor']; ?>; background: linear-gradient( <?php echo $row['roomColor']; ?> 70%, white 30%); ">

              <div class="main-info text-dark p-2">
                <span style="font-weight:600;"> <?php echo $row['roomName']; ?></span><br>
                <span style="font-size: 12px;">Room code:&nbsp;</span><span><?php echo $row['roomCode']; ?></span>
              </div>
            </div>

          </a>
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

    setTimeout(fade_out, 1500);
      function fade_out() {
      $("#error").fadeOut().empty();
      $("#success").fadeOut().empty();
    };
    </script>
  
  </body>

</html>