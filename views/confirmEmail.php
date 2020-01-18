<?php require_once 'header.php'?>

<?php if (!empty($data['error'])):?>
    <div class="error"><?=$data['error']?></div>
<?php else:?>
    <div class="success">Email successfully confirmed</div>
    <?php require_once 'login.php'?>
<?php endif;?>

<?php require_once 'footer.php'?>
