<?php
include '../../include/config.php';
session_start();
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

$userid = $_SESSION['id'];
$quiz_code = $_SESSION["theCode"];
$shced_id = $_SESSION['sched_id'];
$question_id = $_SESSION['qstn_id'];

$statusUpdate = mysqli_query($conn, "SELECT * FROM `questions` WHERE id ='$question_id'");
    while ($stts_up = mysqli_fetch_array($statusUpdate)) {
        $status = $stts_up['status']; 

        if($status == "finished") {
            echo "<script>window.location='s-quiz-room.php?next=$shced_id';</script>"; 
        } 
    }
?>