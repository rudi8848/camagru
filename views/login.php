<?php require_once('header.php');?>

<div align="center">
    <div class="login-form">
        <form action="/login" method="post">

            <?php if (!empty($data['error'])) : ?>
                <div class="error">
                    <?=$data['error']?>
                </div>
            <?php endif; ?>
        <span class="input-title"> <label for="name">Name</label></span>
        <input type="text" id="name" name="login" value="<?=$data['name']?>" required>
<br/>
            <span class="input-title"><label for="password">Password</label></span>
        <input type="password" id="password" name="password" required>
        <br/>
        <button type="submit">Login</button>
        </form>

        <a href="/reset-password">I forgot my password</a>
    </div>
</div>
<?php require_once('footer.php');?>
