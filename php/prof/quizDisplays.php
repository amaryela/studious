<?php
include '../include/config.php';

// MULTIPLE CHOICE
if(isset($_POST['edit_id'])){
    $id = $_POST['edit_id'];

    $sql = "SELECT * FROM multiplechoice WHERE item_number = '$id'";
    $result = mysqli_query($conn, $sql);
    while ($mc = mysqli_fetch_array($result)){
?>

        <div class="modal-info">
        <input type="hidden" name="edit_id" value="<?php echo $mc['item_number']; ?>">
        <div class="tempIMG mb-4 p-3">
            <div class="row">
                <div class="col-sm">
                    <?php if(($mc['item_img']) != "../../img/questPics/"){ ?>
                        <img src="<?php echo $mc['item_img']; ?>" width="100px;" height="100px;" alt="itemImage">
                    <?php } ?>
                </div>
                
                <div class="col-sm">
                    <label>Change image</label>
                    <input type="file" name="new_imgMC" accept="image/*">
                    <input type="hidden" name="old_imgMC" value="<?php echo $mc['item_img']; ?>">
                </div>
            </div>
        </div>

        <textarea name="mcQuest" required style="margin: auto;"><?php echo $mc['item_question'];?></textarea>
        </div>

        <div class="modal-choices" style="text-align:left;">
        <input type="radio" name="mcAns" required value="a" <?php if ($mc['item_answer'] == "a") {echo "checked";}?>>&nbsp;&nbsp;
        a. <input type="text" name="mcChoiceA" required value="<?php echo $mc['item_a']; ?>"><br>

        <input type="radio" name="mcAns" value="b" <?php if ($mc['item_answer'] == "b") {echo "checked";}?>>&nbsp;&nbsp;
        b. <input type="text" name="mcChoiceB" required value="<?php echo $mc['item_b']; ?>"><br>

        <?php if(!empty($mc['item_c'])){ ?>
            <input type="radio" name="mcAns" value="c" <?php if ($mc['item_answer'] == "c") {echo "checked";}?>>&nbsp;&nbsp;
            c. <input type="text" name="mcChoiceC" value="<?php echo $mc['item_c']; ?>"><br>
        <?php } else { ?>
            <div class="mcOptionCdiv" style="display:none;">
                <input type="radio" name="mcAns" value="c">&nbsp;&nbsp;
                c. <input type="text" name="mcChoiceC" placeholder="Type options here"><br>
            </div>
        <?php } ?>

        <?php if(!empty($mc['item_d'])){ ?>
            <input type="radio" name="mcAns" value="d" <?php if ($mc['item_answer'] == "d") {echo "checked";}?>>&nbsp;&nbsp;
            d. <input type="text" name="mcChoiceD" value="<?php echo $mc['item_d']; ?>"><br>
        <?php } else { ?>
            <div class="mcOptionDdiv" style="display:none;">
                <input type="radio" name="mcAns" value="d">&nbsp;&nbsp;
                d. <input type="text" name="mcChoiceD" placeholder="Type options here"><br>
            </div>
        <?php } ?>

        <?php if(!empty($mc['item_e'])){ ?>
            <input type="radio" name="mcAns" value="e" <?php if ($mc['item_answer'] == "e") {echo "checked";}?>>&nbsp;&nbsp;
            e. <input type="text" name="mcChoiceE" value="<?php echo $mc['item_e']; ?>"><br>
        <?php } else { ?>
            <div class="mcOptionEdiv mb-5" style="display:none;">
                <input type="radio" name="mcAns" value="e">&nbsp;&nbsp;
                e. <input type="text" name="mcChoiceE" placeholder="Type options here"><br>
            </div>
        <?php } ?>
        
        </div>

        <div class="modal-choices" style="text-align:right;">
        <p>Set Time: 
            <select name="mcTime" required>
                <option value="<?php echo $mc['item_timer']; ?>"><?php echo $mc['item_timer']; ?> seconds</option>
                <option value="5">5 seconds</option>
                <option value="10">10 seconds</option>
                <option value="15">15 seconds</option>
                <option value="20">20 seconds</option>
                <option value="25">25 seconds</option>
                <option value="30">30 seconds</option>
            </select>
        </p>
        <p>Set Point: <input type="number" name="mcPnt" value="<?php echo $mc['item_point']; ?>" required></p><br>
        </div>
<?php
}
}
?>

<?php
if(isset($_POST['del_id'])){
    $id = $_POST['del_id'];

    $sql = "SELECT * FROM multiplechoice WHERE item_number = '$id'";
    $result = mysqli_query($conn, $sql);
    while ($mc = mysqli_fetch_array($result)){
?>
    <h5 class="modal-title" style="margin-bottom:20px;">CONFIRM DELETE</h5>
    <p style="font-size:18px;">Are you sure you want to delete this item?</p>
    <input type="number" name="del_id" value="<?php echo $mc['item_number'];?>">

<?php
}
}
?>


<!-- IDENTIFICATION -->
<?php
if(isset($_POST['edit_iden_id'])){
    $id = $_POST['edit_iden_id'];

    $sql = "SELECT * FROM identification WHERE item_number = '$id'";
    $result = mysqli_query($conn, $sql);
    while ($iden = mysqli_fetch_array($result)){
?>
    <div class="modal-info">
        <input type="hidden" name="edit_iden_id" value="<?php echo $iden['item_number']; ?>">
        <div class="tempIMG mb-4 p-3">
            <div class="row">
                <div class="col-sm">
                    <?php if(($iden['item_img']) != "../../img/questPics/"){ ?>
                        <img src="<?php echo $iden['item_img']; ?>" width="100px;" height="100px;" alt="itemImage">
                    <?php } ?>
                </div>
                
                <div class="col-sm">
                    <label>Change image</label>
                    <input type="file" name="new_imgIDEN" accept="image/*">
                    <input type="hidden" name="old_imgIDEN" value="<?php echo $iden['item_img']; ?>">
                </div>
            </div>
        </div>

        <textarea name="idenQuest" required style="margin: auto;"><?php echo $iden['item_question'];?></textarea>
    </div>

    <div class="modal-choices" style="text-align:left;">
        <p style="font-size:23px;">Answer: <input type="text" name="idenAns" required value="<?php echo $iden['answer_a']; ?>"></p>
    </div>

    <div class="modal-choices" style="text-align:right;">
        <p>Set Time: 
            <select name="idenTime" required>
                <option value="<?php echo $iden['item_timer']; ?>"><?php echo $iden['item_timer']; ?> seconds</option>
                <option value="5">5 seconds</option>
                <option value="10">10 seconds</option>
                <option value="15">15 seconds</option>
                <option value="20">20 seconds</option>
                <option value="25">25 seconds</option>
                <option value="30">30 seconds</option>
            </select>
        </p>
        <p>Set Point: <input type="number" name="idenPnt" value="<?php echo $iden['item_point']; ?>" required></p><br>
    </div>
<?php
}
}
?>

<?php
if(isset($_POST['del_iden_id'])){
    $idi = $_POST['del_iden_id'];

    $sql = "SELECT * FROM identification WHERE item_number = '$idi'";
    $result = mysqli_query($conn, $sql);
    while ($iden = mysqli_fetch_array($result)){
?>
    <h5 class="modal-title" style="margin-bottom:20px;">CONFIRM DELETE</h5>
    <p style="font-size:18px;">Are you sure you want to delete this item?</p>
    <input type="number" name="del_iden_id" value="<?php echo $iden['item_number'];?>">

<?php
}
}
?>


<!-- ENUMERATION -->
<?php
if(isset($_POST['edit_enu_id'])){
    $ide = $_POST['edit_enu_id'];

    $sql = "SELECT * FROM enumeration WHERE item_number = '$ide'";
    $result = mysqli_query($conn, $sql);
    while ($enu = mysqli_fetch_array($result)){
?>
    
    <div class="modal-info">
        <input type="hidden" name="edit_enu_id" value="<?php echo $enu['item_number']; ?>">

        <div class="tempIMG mb-4 p-3">
            <div class="row">
                <div class="col-sm">
                    <?php if(($enu['item_img']) != "../../img/questPics/"){ ?>
                        <img src="<?php echo $enu['item_img']; ?>" width="100px;" height="100px;" alt="itemImage">
                    <?php } ?>
                </div>
                
                <div class="col-sm">
                    <label>Change image</label>
                    <input type="file" name="new_imgENU" accept="image/*">
                    <input type="hidden" name="old_imgENU" value="<?php echo $enu['item_img']; ?>">
                </div>
            </div>
        </div>

            <textarea name="enuQuest" required style="margin:auto;"><?php echo $enu['item_question'];?></textarea><br>
        </div>

        <div class="modal-choices" style="text-align:left;">

            <input class="check-not1" type="hidden" value="not" name="enu1">

            <?php if ($enu['check_a'] == 'correct'){ ?>
                <input class="check1" type="checkbox" name="enu1" value="correct" checked>
            <?php } else { ?>
                <input class="check1" type="checkbox" name="enu1" value="correct" unchecked>
            <?php } ?>
            &nbsp;&nbsp;<input type="text" name="e1" value="<?php echo $enu['choice_a']; ?>"><br>

            <?php if ($enu['check_b'] == 'correct'){ ?>
                <input class="check2" type="checkbox" name="enu2" value="correct" checked>
            <?php } else { ?>
                <input class="check2" type="checkbox" name="enu2" value="correct" unchecked>
            <?php } ?>
            &nbsp;&nbsp;<input type="text" name="e2" value="<?php echo $enu['choice_b']; ?>"><br>

            <?php if(!empty($enu['choice_c'])){ ?>
            <?php if ($enu['check_c'] == 'correct'){ ?>
                <input class="check3" type="checkbox" name="enu3" value="correct" checked>
            <?php } else { ?>
                <input class="check3" type="checkbox" name="enu3" value="correct" unchecked>
            <?php } ?>
            &nbsp;&nbsp;<input type="text" name="e3" value="<?php echo $enu['choice_c']; ?>"><br>

            <?php } else {  ?>
                <div class="enuOptionCdiv" style="display:none;">
                    <input class="optHidden3" type="hidden" value="not" name="enu3">
                    <input class="opt3" type="checkbox" value="correct" name="enu3">&nbsp;&nbsp;
                    <input type="text" name="e3">
                </div>
            <?php } ?>

            <?php if(!empty($enu['choice_d'])){ ?>
            <?php if ($enu['check_d'] == 'correct'){ ?>
                <input class="check4" type="checkbox" name="enu4" value="correct" checked>
            <?php } else { ?>
                <input class="check4" type="checkbox" name="enu4" value="correct" unchecked>
            <?php } ?>
            &nbsp;&nbsp;<input type="text" name="e4" value="<?php echo $enu['choice_d']; ?>"><br>

            <?php } else {  ?>
                <div class="enuOptionDdiv" style="display:none;">
                    <input class="optHidden4" type="hidden" value="not" name="enu4">
                    <input class="opt4" type="checkbox" value="correct" name="enu4">&nbsp;&nbsp;
                    <input type="text" name="e4">
                </div>
            <?php } ?>

            <?php if(!empty($enu['choice_e'])){ ?>
            <?php if ($enu['check_e'] == 'correct'){ ?>
                <input class="check5" type="checkbox" name="enu5" value="correct" checked>
            <?php } else { ?>
                <input class="check5" type="checkbox" name="enu5" value="correct" unchecked>
            <?php } ?>
            &nbsp;&nbsp;<input type="text" name="e5" value="<?php echo $enu['choice_e']; ?>"><br>

            <?php } else {  ?>
                <div class="enuOptionEdiv" style="display:none;">
                    <input class="optHidden5" type="hidden" value="not" name="enu5">
                    <input class="opt5" type="checkbox" value="correct" name="enu5">&nbsp;&nbsp;
                    <input type="text" name="e5">
                </div>
            <?php } ?>
        </div>

        <div class="modal-choices" style="text-align:right;">
        <p>Set Time: 
            <select name="enuTime" required>
                <option value="<?php echo $enu['item_timer']; ?>"><?php echo $enu['item_timer']; ?> seconds</option>
                <option value="5">5 seconds</option>
                <option value="10">10 seconds</option>
                <option value="15">15 seconds</option>
                <option value="20">20 seconds</option>
                <option value="25">25 seconds</option>
                <option value="30">30 seconds</option>
            </select>
        </p>
        <p>Set Point: <input type="number" name="enuPnt" value="<?php echo $enu['item_point']; ?>" required></p><br>
        </div>
<?php
    }
}
?>

<?php
if(isset($_POST['del_enu_id'])){
    $idi = $_POST['del_enu_id'];

    $sql = "SELECT * FROM enumeration WHERE item_number = '$idi'";
    $result = mysqli_query($conn, $sql);
    while ($enu = mysqli_fetch_array($result)){
?>
    <h5 class="modal-title" style="margin-bottom:20px;">CONFIRM DELETE</h5>
    <p style="font-size:18px;">Are you sure you want to delete this item?</p>
    <input type="number" name="del_enu_id" value="<?php echo $enu['item_number'];?>">

<?php
    }
}
?>