<?php
include '../include/config.php';
session_start();
$userid = $_SESSION['id'];
$quiz_code = $_SESSION["theCode"];
?>

<h2 class="text-warning">PARTICIPANTS</h2>

		<?php
		$query = "SELECT * FROM quizaccess WHERE q_code = '$quiz_code'" ;
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result)){
		?>

	<div id="waitingroom" style="list-style-type: none; display: flex; justify-content: center; flex-wrap: wrap;">
		<p><?php echo $row["quiz_takerFName"] . " " . $row["quiz_takerLName"]; ?></p>
	</div>

<?php } ?> 