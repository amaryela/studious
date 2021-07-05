<?php
include '../../include/config.php';
session_start();
$userid = $_SESSION['id'];
$quiz_code = $_SESSION["theCode"];
$shced_id = $_SESSION['sched_id'];
?>
<?PHP
$statusUpdate = mysqli_query($conn, "SELECT * FROM `scheduledquizzes` WHERE id ='$shced_id'");
        while ($stts_up = mysqli_fetch_array($statusUpdate)) {
        $_SESSION["status"] = $stts_up['status']; 
                if ($_SESSION["status"] == "waiting"){?>

                <!-- <div class="text-center">
                        <img class="text-center" src="../../img/Ellipsis-2s-200px.svg" alt="loading">
                        <h1>Waiting for prof to start the quiz</h1>
                </div> -->

<?php }
if ($_SESSION["status"] == "on-going") { ?>
<!-- ongoing na -->
<?php echo "<script>window.location='s-quiz-room.php?next=$shced_id';</script>";
}
}
?>