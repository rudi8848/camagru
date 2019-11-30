<style>
  .header {
    min-height: 100px;
    background-color: gray;
  }
</style>

<div class="header">
  <ul class="main-menu">

    <?php if (empty($_SESSION['user']['id'])) : ?>
      <li><a href="/login">Login</a></li>
      <li><a href="/signup">Sign Up</a></li>
    <?php else : ?>
      <p class="username">Hello, <?=$_SESSION['user']['name']?></p>
      <li><a href="/settings">Settings</a></li>
      <li><a href="/logout">Logout</a></li>
    <?php endif; ?>

  </ul>
</div>
