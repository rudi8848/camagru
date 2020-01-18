<?php require_once 'header.php'?>

<?php if (!empty($data['error'])) : ?>
    <div class="error">
        <?=$data['error']?>
    </div>
<?php endif;?>
<?php if (!empty($data['success'])):?>
    <div class="success">
        Hello <?=$data['name']?>! <?=$data['success']?>
    </div>
<?php require_once 'login.php'?>
<?php else:?>

<div align="center">
    <div class="login-form">
        <form action="/create-new-password/<?=$data['selector']?>/<?=$data['token']?>" method="post">
            <span class="input-title"><label for="password1">New password</label></span>
            <input type="password" id="password1" name="password1" required>
            <br/>
            <span class="input-title"><label for="password2">Confirm the password</label></span>
            <input type="password" id="password2" name="password2" required>
<!--            <input type="hidden" name="selector">-->
<!--            <input type="hidden" name="validator">-->
            <br/>
            <button type="submit">Save</button>
        </form>
    </div>
</div>
<?php endif;?>
<?php require_once 'footer.php'?>
