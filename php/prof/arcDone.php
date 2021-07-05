<?php
include '../include/config.php';

if(isset($_POST['arc_id'])){
  $id = $_POST['arc_id'];

  $sql = "SELECT * FROM room WHERE id = '$id'";
  $result = mysqli_query($conn, $sql);
  while ($show = mysqli_fetch_array($result)){

?>
  <h5 class="modal-title" style="margin-bottom:20px;">ARCHIVE ROOM</h5>
  <p style="font-size:18px;">You cannot add another quiz in this room if you archive it, do you still want to proceed?</p>
  
  <input type="hidden" name="arc_id" value="<?php echo $show['id'];?>">
  <input type="hidden" name="status" value="off">

<?php } } ?>

<?php
if(isset($_POST['draft_id'])){
  $id = $_POST['draft_id'];

  $find = "SELECT * FROM quiz WHERE quiz_code = '$id'";
  $go = mysqli_query($conn, $find);
  while ($data = mysqli_fetch_array($go)){
?>

  <h5 class="modal-title" style="margin-bottom:20px;">DELETE THIS QUIZ DRAFT</h5>
  <p style="font-size:18px;">Deleting would remove all your input question for this quiz, do you want to proceed?</p>
  
  <input type="hidden" name="draft_id" value="<?php echo $data['quiz_code'];?>">
<?php } } ?>




