<?php
session_start();
include '../include/config.php';

$userid = $_SESSION['id'];

if (empty($_SESSION['id'])){
  header('Location: ../../index.php');
}

if (isset($_GET['next'])) {
  $id = $_GET['next'];

$find = "SELECT * FROM quiz WHERE status = 'gen' AND quiz_owner = '$userid' AND quiz_roomcode = '$id'";
$result = mysqli_query($conn,$find);
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
    <link rel="stylesheet" type="text/css" href="../../css/rooms.css">

  </head>
  <body>
    <?php include('../include/nav-prof.php'); ?>

      <div class="container jumbotron">
        <div class="row">
          <div class="col-5 text-end">
            <img src="../../img/undraw_Resume_folder_re_e0bi.svg" alt="drafts" width="150">
          </div>
          <div class="col">
            <h2 class="mt-5 text-dark">QUIZ DRAFTS</h2>
          </div>
        </div> 
      </div>

      <div class="container jumbotron" style="width:50%">

        <?php if (mysqli_num_rows($result) == 0) { ?>
            <div class="col text-center">
              <p style="font-size:20px;">No drafts for this subject.</p>
            </div>
          <?php } else{
            while ($datas = mysqli_fetch_array($result)) { ?>

        <div class="row records p-2">
          <div class="col-sm ps-3 pt-3">
            <h5 class="text-dark" style="font-size:20px;"><?php echo $datas['quiz_name']; ?></h5>
          </div>
          <div class="col-sm text-center" style="margin:auto;">
            <a href="makeQuiz.php?next=<?php echo $datas['quiz_code']; ?>"><button type="button" class="btn btn-warning text-white" style="margin:5px;"><i class="fas fa-edit"></i>&ensp;Edit</button></a>
              
            <button type="button" data-bs-toggle="modal" data-bs-target="#draftModal" id="<?php echo $datas['quiz_code']; ?>" class="btn btn-danger text-white dDelete" style="margin:5px;"><i class="fas fa-trash-alt"></i>&ensp;Delete</button>
          </div>
        </div>
        <br>

          <?php } } ?>

<!-- DRAFT CONFIRM DELETE Modal -->
<div class="modal fade" id="draftModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form action="#" method="post" class="draftHere">
      <div class="modal-header border-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body text-center" id="display_draft"></div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
        <button type="submit" class="btn btn-outline-danger draftDone">Yes</button>
      </div>
    </form>
    </div>
  </div>
</div>
      
      
      </div><!-- end of the 2nd container div -->

  <!--Bootstrap Bundle-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
      let header1 = document.getElementById('navhead');
        header1.classList.add("bg-color");
    </script>
    
    <script>
     // DELETING QUIZ DRATFS  
     $(document).on('click','.dDelete', function(e){
        e.preventDefault();
          var draft_id = $(this).attr('id');
          $.ajax({
              url:"arcDone.php",
              type:"post",
              data:{draft_id:draft_id},
              success: function(data){
                  $("#display_draft").html(data);
                  $("#draftModal").modal('show');
              }
          });
      });

      $(document).on('click','.draftDone', function(e){
        e.preventDefault();
          $.ajax({
              url:"arcProcess.php",
              type:"post",
              data:$(".draftHere").serialize(),
              success:function(data){
                  $("#draftModal").modal('hide');
                  location.reload();
              }
          });
      });
    </script>
  
  </body>

</html>