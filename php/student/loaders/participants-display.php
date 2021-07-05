<?php
include '../../include/config.php';
session_start();
$userid = $_SESSION['id'];

$quiz_code = $_SESSION["theCode"];
?>

<h3 class="text-warning mb-3">PARTICIPANTS</h3>

<?php
$query = "SELECT * FROM `quizaccess` WHERE q_code = '$quiz_code' ORDER BY `quizaccess`.`score` DESC " ;
$result = mysqli_query($conn, $query);
	while($row = mysqli_fetch_array($result)){ ?>
	
	<div class="row border">
		<?php if ($row["status"] == "done"){ ?>
      <div class="col text-center bg-warning">
        <?php echo $row["quiz_takerFName"] . " " . $row["quiz_takerLName"]; ?>
        <?php echo $row["score"]; ?> points<br>
      </div>
		<?php } else{ ?> 
			<div class="col text-center">
        <?php echo $row["quiz_takerFName"] . " " . $row["quiz_takerLName"]; ?>
        <?php echo $row["score"]; ?> points<br>
      </div>
		<?php	} ?>
  </div>

<?php } ?> 