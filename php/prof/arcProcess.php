<?php
include '../include/config.php';

$arc_id = $_POST['arc_id'];
$stat = $_POST['status'];
    
    $run = "UPDATE room SET `status`='$stat' WHERE `id`='$arc_id'";
    $result = mysqli_query($conn, $run);
?>

<?php
$draft_id = $_POST['draft_id'];

    $go = "DELETE FROM quiz WHERE quiz_code = '$draft_id'";
    $show = mysqli_query($conn, $go);

    if($show){
        $go2 = "DELETE FROM questions WHERE quiz_code = '$draft_id'";
        $show2 = mysqli_query($conn, $go2);
    }

?>


