<?php require_once('header.php') ?>

<?php if (!empty($data['error'])) : ?>
<div class="error">
    <?=$data['error']?>
</div>
<?php endif; ?>


<form action="/signup" method="post">
  <p>Name</p>
  <input type="text" name="username" required value="<?=$data['name']?>">

  <p>Email</p>
  <input type="text" name="email" value="<?=$data['email']?>" required>

  <p>Password</p>
  <input type="password" name="password1" required>

  <p>Repeat password</p>
  <input type="password" name="password2" required>

  <br/>
  <button type="submit">Submit</button>
</form>


<?php require_once('footer.php') ?>
