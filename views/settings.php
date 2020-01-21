<?php require_once 'header.php'?>

<article>

    <div class="wrapper">
        <div class="settings-item">Change user picture</div>
        <div class="settings-item"><img src="<?=$data['settings']['pic']?>" width="100px"> </div>
        <div class="settings-item"><input type="file"></div>
        <div class="settings-item">Name</div>
        <div class="settings-item"><?=$_SESSION['user']['name']?></div>
        <div class="settings-item"><a href="">edit</a></div>

        <div class="settings-item">Email</div>
        <div class="settings-item"> <?=$data['settings']['email']?></div>
        <div class="settings-item"><a href="">edit</a></div>


        <div class="settings-item">Password</div>
        <div class="settings-item"></div>
        <div class="settings-item"><a href="">edit</a></div>
        <div class="settings-item">
            Receive notifications about new comments</div>
        <div class="settings-item"><input type="checkbox" <?php if($data['settings']['notifications'] == 1) echo "checked";?>>
        </div>
    </div>

</article>

<?php require_once 'footer.php'?>
