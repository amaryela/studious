<?php 
include 'php/include/config.php';

if(!isset($_GET["code"])) {
  echo "<img src='img/undraw_page_not_found_su7k.svg' alt='error 404'>";
	exit();
}

$code = $_GET["code"];
$getEmailQuery = mysqli_query($conn, "SELECT email FROM resetpasswords WHERE code='$code'");
if(mysqli_num_rows($getEmailQuery) == 0){
	  echo '<div style="background-color:#FFCCCB; margin:100px auto; width:30%; padding:100px; text-align:center; color: #8B0000; font-family:Helvetica; border-radius:10px; border: #8B0000 solid 1px;">'."Can't find page. <br><br><br><br> Back to <a href='index.php' style='text-decoration:none;'>Home page</a>.".'</div>';
	exit();
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
<header class="header sticky-top bg-light" id="navhead">
      <nav class="navbar sticky-top navbar-expand-lg navbar-light scrolling-navbar">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"><img class="logo" src="img/logo.png"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" data-target = "Sticky-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active nav-link-color" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item nav-link-color">
            <a data-bs-target="#loginModal" data-bs-toggle="modal" class="btn btn-dark" href="#loginModal">Login</a>
          </li>
        </ul> 
      </div>
      </div>
    </nav>
  </header><br><br>

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
            <p style="text-align: right; margin-bottom:30px; font-size: 13px;"><a href="#">Forgot Password?</a></p>
						<input style="width:200px; margin-bottom:20px;" type="submit" name="login" class="btn btn-dark" value="SUBMIT">
					</div>
				</form>
			</div>
			<div class="modal-footer"> Doesn't have an account?<a href="signup.php">Register</a></div>
		</div>
	</div>
</div>

<div class="container jumbotron p-2">
    <div class="text-center">
      <h1 class="text-warning">CREATE NEW PASSWORD</h1>
      <img class="mt-3 mb-3" src="img/undraw_my_password_d6kg.svg" alt="forgot-pass" height="150px">
    </div>

<?php
  if(isset($_POST["submit"])){
    $pw1 = $_POST["pass1"];
    $pw2 = $_POST["pass2"];
    $pw2 = password_hash($pw2, PASSWORD_DEFAULT);
  if ($_POST['pass1'] != $_POST['pass2']) {
    echo '<div style="color: red;">'. "Password did not match". '</div>';
  } else{

  $row = mysqli_fetch_array($getEmailQuery);
  $email = $row["email"];

  $query = mysqli_query($conn, "UPDATE users SET uPassword='$pw2' WHERE uEmail='$email'");

  if ($query){
    $query = mysqli_query($conn, "DELETE  FROM resetpasswords WHERE code = '$code'");
    echo '<div style="background-color:#90EE90; margin:20px auto; width:100%; padding:100px; text-align:center; color: #3A5311; font-family:Helvetica; border-radius:10px; border: #3A5311 solid 1px;">'."Password updated successfully! You can now login to your account. <br><br><br><br> Back to <a href='index.php' style='text-decoration:none;'>Home page</a>.".'</div>';
    exit();
  }else{
      echo '<div style="background-color:#FFCCCB; margin:100px auto; width:30%; padding:100px; text-align:center; color: #8B0000; font-family:Helvetica; border-radius:10px; border: #8B0000 solid 1px;">'."Something went wrong".'</div>';
    exit();
  }
}
}
?>   
      <div class="text-center">
        <form method="post">
          <p style="font-size:20px; margin-bottom:3px;">Enter your new password</p>
          <input type="password" name="pass1" required style="width:300px; height:35px; margin-bottom:10px;">

          <p style="font-size:20px; margin-bottom:3px;">Retype password</p>
          <input type="password" name="pass2" required style="width:300px; height:35px;">
      </div>
      <div class="text-center mt-5">
          <input class="btn btn-dark" style="width:150px;" type="submit" name="submit" value="PROCEED">
        </form>
      </div>

 </div>

<!--Bootstrap Bundle-->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
     setTimeout(fade_out, 1500);
     function fade_out() {
      $("#error").fadeOut().empty();
      $("#success").fadeOut().empty();
   };
  </script>

  </body>

</html>
