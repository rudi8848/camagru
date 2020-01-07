<?php require_once('header.php');?>

<form action="/login" method="post">



    <?php if (!empty($data['error'])) : ?>
    <div class="error">
        <?=$data['error']?>
    </div>
    <?php endif; ?>

<input type="text" name="login" value="<?=$data['name']?>" required>

<p>Password</p>
<input type="password" name="password" required>

<button type="submit">Login</button>
</form>

<a href="#">I forgot my password</a>
<?php require_once('footer.php');?>
