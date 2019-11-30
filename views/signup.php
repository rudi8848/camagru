<?php require_once('header.php') ?>

<?php if (empty($data['name'])) : ?>

<form action="/signup" method="post">
  <p>Name</p>
  <input type="text" name="username" required>

  <p>Email</p>
  <input type="text" name="email">

  <p>Password</p>
  <input type="password" name="password1" required>

  <p>Repeat password</p>
  <input type="password" name="password2" required>

  <br/>
  <button type="submit">Submit</button>
</form>
<?php else : ?>
  <h2><?=$data['name']?></h2>
<?php endif ; ?>

<?php require_once('footer.php') ?>
