<?php
session_start();
include 'php/include/config.php';

if(isset ($_POST['login'])){
  $email = mysqli_real_escape_string($conn, $_POST["email"]);  
  $password = mysqli_real_escape_string($conn, $_POST["pass"]);  
    $query = "SELECT * FROM users WHERE uEmail = '$email'";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
        if(password_verify($password, $row["uPassword"])){
          if ($row['uRole'] == "professor"){
            $_SESSION['role'] = $row['uRole'];
            $_SESSION['id'] = $row['ID'];
            header('Location:php/prof/profHome.php');
          }
        else{
          $_SESSION['role'] = $row['uRole'];
          $_SESSION['id'] = $row['ID'];
          header('Location:php/student/studHome.php');
        }
      }
      else{
        header("Location: index.php?error=Incorrect password.");
      }
    }
  }
    else{
      header("Location: index.php?error=Your email isn't registered yet.");
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
    <link rel="stylesheet" type="text/css" href="css/styles.css">

  </head>
  <body>
    <header class="header sticky-top" id="navhead">
      <nav class="navbar sticky-top navbar-expand-lg navbar-light scrolling-navbar">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"><img class="logo" src="img/logo.png"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" data-target = "Sticky-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link rounded" aria-current="page" href="#home">Home</a>
          </li>
            <li class="nav-item nav-link-color">
            <a class="nav-link rounded" aria-current="page" href="#features">Features</a>
          </li>
          <li class="nav-item nav-link-color">
            <a class="nav-link rounded" aria-current="page" href="#footer">About us</a>
          </li>
          <li class="nav-item nav-link-color">
            <a data-bs-target="#loginModal" data-bs-toggle="modal" class="btn btn-dark" href="#loginModal">Login</a>
          </li>
        </ul> 
      </div>
      </div>
    </nav>
  </header>

  <div class="container p-3" style="width:350px;" id="error">
  <?php if (isset($_GET['error'])) { ?>
          <div class="alert alert-danger d-flex align-items-center fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i>&emsp;
            <?php echo $_GET['error']; ?>
          </div>
  <?php } ?>
  </div>

<!-----------Welcome------------------------------------ -->	
  <div class="grid-container-2" id="home">
    <div class="grid-item-2">
      <div class="content">
        <div class="content-row">         
            <div class="content-column">
              <h1 style="margin-bottom: 25px;">Room for <br>all your quiz!</h1> 
              <p style="font-size: 20px; color:#34325e;">A place where students and professors collaborate together in a room to perform a real time quiz in the class.
              <strong> Study hard</strong> and be on <strong>TOP</strong> of the <strong>leaderboard.</strong>
              <br>Register now and have fun learning!</p>
            <!-- Button trigger modal -->
            <a href="signup.php"><button type="button" class="btn btn-warning" style="color:white; margin:0; width:150px; font-size:20px; border-radius:10px;">Click Here</button></a>
          </div>
        </div>
      </div>
    </div>
      <div class="grid-item-2">
        <div class="content-column" id="animate-1">
          <img class="box img-1" src="img/undraw_book_lover_mkck.svg">
        </div>
      </div>
  </div>

<!-- Modal -->
<div id="loginModal" class="modal fade">
	<div class="modal-dialog modal-login">
		<div class="modal-content">
			<div class="modal-header">				
				<h4 class="modal-title">LOGIN</h4>
			</div>
			<div class="modal-body">
				<form action="index.php" method="post">
					<div class="form-group">
						<i class="fa fa-user"></i>
						<input type="text" class="form-control" name="email" placeholder="Email" required>
					</div><br>
					<div class="form-group">
						<i class="fa fa-lock"></i>
						<input type="password" class="form-control" name="pass" placeholder="Password" required>					
					</div>

					<div class="form-group text-center">
            <p style="text-align: right; margin-bottom:30px; font-size: 13px;"><a href="forgotpass.php">Forgot Password?</a></p>
						<input style="width:200px; margin-bottom:20px;" type="submit" name="login" class="btn btn-dark" value="SUBMIT">
					</div>
				</form>
			</div>
			<div class="modal-footer"> Doesn't have an account?<a href="signup.php">Register</a></div>
		</div>
	</div>
</div>
<br>

<div class="container" id="features">
  
  <div class="row">
    <div class="col-sm" style="padding:20px 0 0 20px; margin-top: 80px;">
      <p class="text-center texts">Create a room</p>
      <p>Join a virtual room created by your professor to access all of your quizzess. Its customizable and you can create as many room as you want for free.</p>
    </div>
    <div class="col-sm text-center" style="padding:30px;">
      <img src="img/undraw_teaching_f1cm.svg" alt="room" height="250px" width="250px">
    </div>
  </div>

  <div class="row">
    <div class="col-sm text-center" style="padding:30px;">
      <img src="img/undraw_Questions_re_1fy7.svg" alt="room" height="250px" width="250px">
    </div>
    <div class="col-sm" style="padding:20px 0 0 20px; margin-top: 80px;">
      <p class="text-center texts">Take the quiz</p>
      <p>Test your knowledge through online quizzess. Having slow connections? Don't worry you can ask your professor to wait for you.</p>
    </div>
  </div>

  <div class="row">
    <div class="col-sm" style="padding:20px 0 0 20px; margin-top: 80px;">
      <p class="text-center texts">Track your progress</p>
      <p>All your quizzess store in one place. A progress page that records all of your score is also available so you would know what subject to focus more.</p>
    </div>
    <div class="col-sm text-center" style="padding:30px;">
      <img src="img/undraw_personal_file_222m.svg" alt="room" height="250px" width="250px">
    </div>
  </div>

</div>

<!-- Footer -->
<footer class="page-footer font-small mdb-color pt-4 bg-dark text-white" id="footer">

  <div class="container text-center text-md-left">
    <div class="row text-center text-md-left mt-3 pb-3">
      <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
        <h5 class="text-uppercase mb-4 font-weight-bold">The Studious</h5>
        <p class="text-white">An interactive online quiz platform that helps students and professor on managing quizzess for their subjects.</p>
      </div>

      <hr class="w-100 clearfix d-md-none">
      <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
        <h5 class="text-uppercase mb-4 font-weight-bold">Products</h5>
        <p><a href="https://getbootstrap.com/" class="text-warning" target="_blank">Bootstrap</a></p>
        <p><a href="https://fontawesome.com/" class="text-warning" target="_blank">Font Awesome</a></p>
        <p><a href="https://undraw.co/" class="text-warning" target="_blank">Undraw.co</a></p>
      </div>

      <hr class="w-100 clearfix d-md-none">
      <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
        <h5 class="text-uppercase mb-4 font-weight-bold">Contact</h5>
        <p class="text-white"><i class="fas fa-home mr-3"></i>&ensp;Bulacan State University PH</p>
        <p class="text-white"><i class="fas fa-envelope mr-3"></i>&ensp;thestudious@gmail.com</p>
        <p class="text-white"><i class="fas fa-phone mr-3"></i>&ensp;+639 123 456 789</p>
      </div>
    </div>
<hr>
    <div class="row d-flex align-items-center">
      <div class="col-md-7 col-lg-8">
        <p class="text-center text-md-left text-white">© 2020 Copyright:
          <a href="#" class="text-warning">
            <strong> studious.com</strong>
          </a>
        </p>
      </div>
      <div class="col-md-5 col-lg-4 ml-lg-0">
        <!-- Social buttons -->
        <div class="text-center text-md-right">
          <ul class="list-unstyled list-inline">
            <li class="list-inline-item">
              <a class="btn-floating btn-sm rgba-white-slight mx-1 text-warning">
                <i class="fab fa-facebook-f"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a class="btn-floating btn-sm rgba-white-slight mx-1 text-warning">
                <i class="fab fa-twitter"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a class="btn-floating btn-sm rgba-white-slight mx-1 text-warning">
                <i class="fab fa-instagram"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a class="btn-floating btn-sm rgba-white-slight mx-1 text-warning">
                <i class="fab fa-google-plus-g"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</footer>

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
    };
  </script>
  </body>
</html>