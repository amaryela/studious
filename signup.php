<?php
include 'php/include/config.php';

if(isset($_POST['register'])){
   $firstname 	= 	$_POST['firstname'];
   $lastname 	= 	$_POST['lastname'];
   $email 		= 	$_POST['email'];
   $password 	= 	$_POST['regpass'];
   $cpass 		= 	$_POST['conpass'];
   $role       =  $_POST['role'];
 
   $email_sql = "SELECT * FROM users WHERE uEmail = '$email'";
   $check_email = mysqli_query($conn,$email_sql);
 
     if (mysqli_num_rows($check_email) > 0){
       header("Location: signup.php?error=Email is already used");
       exit();
     }
     else{
       if($password == $cpass){
       $password   = password_hash($password, PASSWORD_DEFAULT);
       $reg_sql = "INSERT INTO users (uFirstName, uLastName, uEmail, uPassword, uRole)
       VALUES ('".$firstname."','".$lastname."','".$email."','".$password."','".$role."')";
       $check_reg = mysqli_query($conn,$reg_sql);
     
       if($check_reg){
         header("Location: signup.php?success=Succesfully registered, you can now login.");
         }
         else{
         header("Location: signup.php?error=Error saving the data");
         }
       }
         else{
           header("Location: signup.php?error=Password doesn't matched");
           exit();
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
    <link rel="stylesheet" type="text/css" href="css/styles.css">

  </head>
  <body>
  
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
            <p style="text-align: right; margin-bottom:30px; font-size: 13px;"><a href="forgotpass.php">Forgot Password?</a></p>
						<input style="width:200px; margin-bottom:20px;" type="submit" name="login" class="btn btn-dark" value="SUBMIT">
					</div>
				</form>
			</div>
			<div class="modal-footer"> Doesn't have an account?<a href="signup.php">Register</a></div>
		</div>
	</div>
</div> 

	<div class="wrap">
         <div class="text-center side" style="align-items: center;">
          <img src="img/undraw_exams_g4ow.svg" width="500px" style="margin-bottom:30px;">
              <p style="font-size:18;">By creating an account you agree to our <a href="#"
              style="text-decoration:none; color:#f5b606;">Terms & Privacy</a>.</p>
         </div>

		<div class="signup-content">
      <form action="signup.php" method="post">
         <div class="div text-center" style="margin-bottom:20px;">
                   <h5 style="color:#34325e; font-size:25px; margin-bottom:15px;">I want to register as:</h5>

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

                   <input type="radio" id="professor" name="role" value="professor" required>
                   <label for="professor">Professor</label>&nbsp;&nbsp;&nbsp;
                   <input type="radio" id="student" name="role" value="student" required>
                   <label for="student">Student</label>
         </div>

               <div class="input-div one">
                 <div class="i">
                    <i class="fas fa-user"></i>
                 </div>
                 <div class="div">
                    <p>First Name</p>
                    <input type="text" class="input" name="firstname" required>
                 </div>
              </div>

              <div class="input-div one">
                 <div class="i">
                    <i class="fas fa-user"></i>
                 </div>
                 <div class="div">
                    <p>Last Name</p>
                    <input type="text" class="input" name="lastname" required>
                 </div>
              </div>

           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-envelope"></i>
           		   </div>
           		   <div class="div">
           		   		<p>Email</p>
           		   		<input type="email" class="input" name="email" required>
           		   </div>
           		</div>
             
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<p>Password</p>
           		    	<input type="password" class="input" name="regpass" required>
            	   </div>
            	</div>
              <div class="input-div pass">
                 <div class="i">
                    <i class="fas fa-lock"></i>
                 </div>
                 <div class="div">
                    <p>Confirm Password</p>
                    <input type="password" class="input" name="conpass" required>
                 </div>
              </div> <br>

              <input type="submit" class="btn btn-warning" style="width:200px; color:white; margin:20px;" value="SUBMIT" name="register"/>
            </form>
        </div>
    </div>
    
    <!--Bootstrap Bundle-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script type="text/javascript">
    const inputs = document.querySelectorAll(".input");
      function addcl(){
	      let parent = this.parentNode.parentNode;
	      parent.classList.add("focus");
      }

      function remcl(){
	      let parent = this.parentNode.parentNode;
	      if(this.value == ""){
		   parent.classList.remove("focus");
	   }
   }
      inputs.forEach(input => {
	   input.addEventListener("focus", addcl);
	   input.addEventListener("blur", remcl);
   });

   
   setTimeout(fade_out, 1500);
   function fade_out() {
      $("#error").fadeOut().empty();
      $("#success").fadeOut().empty();
   };

    </script>

</body>
</html>