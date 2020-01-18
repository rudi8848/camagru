<?php require_once 'header.php' ?>


<div align="center">
    <?php if (!empty($data['error'])) : ?>
        <div class="error">
            <?=$data['error']?>
        </div>
    <?php endif; ?>
    <p>Please enter your email, we will send you further instructions</p>



    <div class="login-form">
        <form action="/reset-password" method="post">
            <span class="input-title"> <label for="email">Email</label></span>
            <input type="text" id="email" name="email" value="<?=$data['email']?>" required><br/>
            <button type="submit">Reset password</button>
        </form>
    </div>
</div>

<?php require_once 'footer.php' ?>
