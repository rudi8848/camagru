<?php require_once('header.php') ?>

<?php if (!empty($data['error'])) : ?>
<div class="error">
    <?=$data['error']?>
</div>
<?php endif; ?>

<?php if (!empty($data['success'])): ?>
<div class="success">
    <?=$data['success']?>
</div>
<?php else: ?>
<div align="center">
    <div class="login-form">
        <form action="/signup" method="post">
            <span class="input-title"><label for="username">Name</label></span>
            <input type="text" name="username" id="username" required value="<?=$data['name']?>">
            <br/>
            <span class="input-title"><label for="email">Email</label></span>
            <input type="text" name="email" id="email" value="<?=$data['email']?>" required>
            <br/>
            <span class="input-title"><label for="password1">Password</label></span>
            <input type="password" name="password1" id="password1" required>
            <br/>
            <span class="input-title"><label for="password2">Repeat password</label></span>
            <input type="password" name="password2" required>
            <br/>
            <button type="submit">Submit</button>
        </form>
    </div>
</div>
<?php endif;?>
<?php require_once('footer.php') ?>
