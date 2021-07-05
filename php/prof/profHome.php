<?php
session_start();
include '../include/config.php';

$userid = $_SESSION['id'];

if (empty($_SESSION['id'])){
  header('Location: ../../index.php');
}

if ($_SESSION['role'] != "professor"){
  header('Location: ../../index.php');
}

if(isset($_POST['crtroom'])){

 $user  = $_POST['profuser'];
 $roomn = $_POST['roomname'];
 $code  = $_POST['gencode'];
 $color = $_POST['color'];
 $stat = "on";

$sql = "INSERT INTO room (roomName , roomCode , roomColor , owner, status) VALUES ('".$roomn."','".$code."', '".$color."','".$user."','".$stat."')";

  $check_reg = mysqli_query($conn,$sql);
    if($check_reg){
      header('Location:profHome.php');
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
        background-color: #b8b7d8;
        padding: 10px;
        border-radius: 50%;
        color: white;
        font-size: 18px;
      }
    </style>
  </head>
  
  <body style="background-image:url('../../img/wavePRF.svg');">
    <?php include('../include/nav-prof.php'); ?>

    <div class="container-fluid">
      <section class="jumbotron" id="info">
        <?php $sql=mysqli_query($conn,"SELECT * from users where ID = '$userid'");
          while($row=mysqli_fetch_array($sql)){ ?>
            <div class="row">
              <div class="col-4">
                <h2 style="align-items:left;">Hi Prof. <?php echo $row['uFirstName']; ?>!</h2>
                <p style="font-size:15px;">Welcome to studious, want to create a room?</p>
              </div>
              <div class="col">
                <button type="button" class="btn btn-dark me-3" data-bs-toggle="modal" data-bs-target="#createRoomModal"><i class="fas fa-plus-circle"></i>&nbsp; Room</button>
                <a href="archives.php"><button type="button" class="btn btn-dark"><i class="fas fa-archive"></i>&nbsp; Archives</button></a>
              </div>
            </div>    
      </section>

<div id="createRoomModal" class="modal fade">
  <div class="modal-dialog modal-pop">
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title" style="font-weight:500;">CREATE ROOM</h4>
      </div>
      <div class="modal-body">
        <form action="profHome.php" method="post">
          <div class="form-group">
            <i class="fas fa-pen"></i>

            <input type="hidden" name="profuser" value="<?php echo $userid; ?>">
            <input type="hidden" name="gencode" value="<?php echo rand(10000,50000);?>">
            <input type="text" class="form-control" name="roomname" placeholder="Room Name" maxlength="20" required><br>
          </div>

          <div  class="form-group">
            <i class="fas fa-palette"></i>
            <label for="color" style="margin: 5px 0px 0px 40px;">Select room color &nbsp;</label>
            <input type="color" name="color">
         </div><br><br>

          <div class="text-center form-group">
            <input style="width:150px;" type="submit" name="crtroom" class="btn btn-dark" value="SUBMIT"><br><br>
          </div>
        <?php } ?>
        </form>
      </div>
  </div>
</div>       
</div>

      <section id="rooms">
        <div class="container">
          <?php 
            $query = "SELECT * FROM room WHERE owner = '$userid' AND status='on'";
            $results = mysqli_query($conn, $query);

            if (mysqli_num_rows($results)==0) {?>

            <div class="text-center">
              <hr>
              <p style="font-size:20px;">No joined rooms.</p>
              <img src="../../img/undraw_Notify_re_65on.svg" alt="icon-no-room" height="300px" style="margin-bottom:20px;">
            </div>
          <?php }
          else{
            while ($row = mysqli_fetch_array($results)) {?>

            <div class="main-room m-2" style="border: 2px solid <?php echo $row['roomColor']; ?>; background: linear-gradient( <?php echo $row['roomColor']; ?> 70%, white 30%); ">

              <div class="main-icon p-2">
                <a href="#archiveModal" id="<?php echo $row['id']; ?>" data-bs-toggle="modal" class="text-dark archive" data-toggle="tooltip" data-placement="top" title="Archive"><i class="fas fa-archive"></i></a>
              </div>

              <div class="main-info p-2">
                <a class="text-dark" href="profRoom.php?next=<?php echo $row['roomCode']; ?>">
                  <span style="font-weight:600;"><?php echo $row['roomName']; ?></span><br>
                  <span style="font-size:12px;">Room code:&nbsp;</span>
                  <span><?php echo $row['roomCode']; ?></span>
                </a>
              </div>
  
            </div>
            <?php } } ?>
      </div>
      </section>

<!-- ARCHIVES Modal -->
<div class="modal fade" id="archiveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form action="#" method="post" class="archiveHere">
      <div class="modal-header border-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body text-center" id="display_arc">
        </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
        <button type="submit" class="btn btn-outline-danger archiveDone">Yes</button>
      </div>
    </form>
    </div>
  </div>
</div>



</div><!-- closing for container fluid -->


    <!--Bootstrap Bundle-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
      window.addEventListener("scroll", function(){
        let header1 = document.getElementById('navhead');

        if (window.pageYOffset > 0){
          header1.classList.add("cus-nav")
        } else{
          header1.classList.remove("cus-nav")
        }
      });

      // ARCHIVING ROOM   
      $(document).on('click','.archive', function(e){
          e.preventDefault();
          var arc_id = $(this).attr('id');
          $.ajax({
              url:"arcDone.php",
              type:"post",
              data:{arc_id:arc_id},
              success: function(data){
                  $("#display_arc").html(data);
                  $("#archiveModal").modal('show');
              }
          });
      });

      $(document).on('click','.archiveDone', function(e){
        e.preventDefault();
          $.ajax({
              url:"arcProcess.php",
              type:"post",
              data:$(".archiveHere").serialize(),
              success:function(data){
                  $("#archiveModal").modal('hide');
                  location.reload();
              }
          });
      });

    </script>
  
  </body>

</html>