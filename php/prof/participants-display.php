<?php
include '../include/config.php';
session_start();
$userid = $_SESSION['id'];
$quiz_code = $_SESSION["theCode"];
?>

<h5 class="text-warning mb-3" style="font-size:1.8vw;">PARTICIPANTS</h5>

<?php
$query = "SELECT * FROM `quizaccess` WHERE q_code = '$quiz_code' ORDER BY `quizaccess`.`score` DESC " ;
$result = mysqli_query($conn, $query);
	while($row = mysqli_fetch_array($result)){

	if ($row["status"] == "done"){?>
		<div class="row border">
			<div class="col text-center bg-warning">
				<?php echo $row["quiz_takerFName"] . " " . $row["quiz_takerLName"]; ?><br>
				<?php echo $row["score"]; ?> points<br>
			</div>
		</div>

	<?php } else{ ?> 
		<div class="row border">
				<div class="col text-center">
					<?php echo $row["quiz_takerFName"] . " " . $row["quiz_takerLName"]; ?><br>
					<?php echo $row["score"]; ?> points<br>
				</div>
			</div>

<?php } } ?> 