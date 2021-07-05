<header class="header sticky-top" id="navhead">
      <nav class="navbar sticky-top navbar-expand-lg navbar-light scrolling-navbar"> <!-- style="background-color:#b8b7d8;" -->
        <div class="container-fluid">
          <a class="navbar-brand" href="#"><img class="logo" src="../../img/logo.png" height="50px" width="150px" alt="studious-logo"></a>
        <div class="d-flex align-items-center">
          <a class="text-reset me-3" href="studHome.php" style=" margin:5px;">
            <i class="fas fa-home circle-icon"></i>
          </a>
           <a class="text-reset me-3" href="notifs.php" style=" margin:5px;">
           <i class="fas fa-bell circle-icon"><span class="num-notif">
            <?php
              $today = date("Y-m-d");
              $join = mysqli_query($conn,"SELECT room.*, enrolleduser.*, scheduledquizzes.* FROM room JOIN enrolleduser ON room.roomCode=enrolleduser.roomID JOIN scheduledquizzes ON scheduledquizzes.quiz_roomcode = enrolleduser.roomID WHERE enrolleduser.enrolledUserID = '$userid' AND scheduledquizzes.quiz_date = '$today' AND room.status = 'on'");
              
              $num_rows = mysqli_num_rows($join);
              echo $num_rows;
            ?>
            </span></i>
          </a>
          <a data-bs-target="#logoutModal" data-bs-toggle="modal" class="text-reset me-3" style="margin:5px;" href="#logoutModal">
            <i class="fas fa-sign-out-alt circle-icon"></i>
          </a>
        </div>
        </div>
      </nav>
    </header>

<!-- LOGOUT Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header border-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
          <h5 class="modal-title" style="margin-bottom:20px;">LOGOUT</h5>
          <p style="font-size:18px;">Are you sure you want to logout?</p>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
        <a href="../include/logout.php"><button type="submit" class="btn btn-outline-danger">Yes</button></a>
      </div>
    </div>
  </div>
</div>