<?php 
include 'php/include/config.php';
require 'php/phpmailer/PHPMailerAutoload.php';

if (isset($_POST["email"])){
      $emailTo = $_POST['email'];
      $code = uniqid(true);


      $checkEmail = "SELECT uEmail FROM users WHERE uEmail = '$emailTo'";
      $checkEmailRun = mysqli_query($conn, $checkEmail);

      if(mysqli_num_rows($checkEmailRun) > 0){

        $row = mysqli_fetch_array($checkEmailRun);
        $get_email = $row['uEmail'];

        if ($emailTo == $get_email) {
        $query = mysqli_query($conn,"INSERT into resetpasswords(code, email) VALUES('$code', '$emailTo')");

$mail = new PHPMailer;
$mail->isSMTP(); //remove this line for live hosting
$mail->Host='smtp.gmail.com';
$mail->Port=587;
$mail->SMTPAuth=true;
$mail->SMTPSecure='tls';

$mail->Username='thestudious.com@gmail.com';
$mail->Password='Studiouspass';


$mail->setFrom('thestudious.com@gmail.com', 'Studious');
$mail->addAddress($get_email);
$mail->addReplyTo('thestudious.com@gmail.com');


$url =  "https://". $_SERVER["HTTP_HOST"].dirname($_SERVER["PHP_SELF"])."/resetpass.php?code=$code";
$mail->isHTML(true);
$mail->Subject='Reset your password';
$mail->Body="<h3>You requested password reset</h3>
                Click this <a href='$url'>This link</a> to update your password.";

if(!$mail->send()){
  header("Location: forgotpass.php?error=A problem occured, message cannot be sent to your email.");
}
else{
  header("Location: forgotpass.php?success=Reset password link has been sent to your email.");
}
  exit();
}}
  header("Location: forgotpass.php?error=Email isn't registered yet.");
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

    <title>studious | Room for all your quizzes</title>
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
            <a class="nav-link rounded" aria-current="page" href="index.php">Home</a>
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


<div class="container">
 <section class="jumbotron text-center mt-3" id="landing">

    <h1 class="text-warning">RESET PASSWORD</h1>
    <img src="img/undraw_authentication_fsn5.svg" alt="forgot-pass" height="200px">
    <form method="post">

      <div class="email-span">
        <p style="font-size:20px;">Please enter the email you register</p>

        <div class="container" style="width:350px;" id="error">
          <?php if (isset($_GET['error'])) { ?>
              <div class="alert alert-danger d-flex align-items-center fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i>&emsp;
                <?php echo $_GET['error']; ?>
              </div>
          <?php } ?>
        </div>

        <div class="container" style="width:350px;" id="success">
          <?php if (isset($_GET['success'])) { ?>
              <div class="alert alert-success d-flex align-items-center fade show" role="alert">
                <i class="fas fa-check-circle"></i>&emsp;
                <?php echo $_GET['success']; ?>
              </div>
          <?php } ?>
        </div>

      </div>
      
      <input style="width:40%; height:40px;" type="email" name="email" required><br><br>
      <input class="btn btn-dark" style="width:100px;" type="submit" name="submit" value="PROCEED">

    </form>
  </section>
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