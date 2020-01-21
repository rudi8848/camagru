<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <link href="/views/styles/main.css" rel="stylesheet">
            <title><?=$data['title']?></title>
        </head>
        <body>
            <header>
                <?php if (!empty($_SESSION['user']['id'])) :?>
                    <p class="username">Hello, <?=$_SESSION['user']['name']?> <a href="/profile/<?=$_SESSION['user']['id']?>">(view my profile)</a></p>
                <?php endif; ?>
                <a href="/" id="to-the-main-page">
                    <img src="/views/styles/pic/fotic.png"  class="logo-img">
                    <span class="logo">Camagru</span>
                </a>
              <nav class="main-menu" align="center">
                  <?php $menu = Helper::getMenu();?>

                  <?php foreach ($menu as $menuItem):?>
                    <a href="<?=$menuItem['url']?>"><?=$menuItem['text']?></a>
                  <?php endforeach;?>
<!--                --><?php //if (empty($_SESSION['user']['id'])) : ?>
<!--                    <a href="/login"><span class="menu-pic login-pic"></span>Login</a>-->
<!--                    <a href="/signup"><span class="menu-pic login-pic"></span>Sign Up</a>-->
<!--                --><?php //else : ?>
<!---->
<!--                    <a href="/logout"><span class="menu-pic logout-pic"></span>Logout</a>-->
<!--                    <a href="/settings"><span class="menu-pic settings-pic"></span>Settings</a>-->
<!---->
<!--                --><?php //endif; ?>
<!--                  <a href="/gallery"><span class="menu-pic gallery-pic"></span>Gallery</a>-->
              </nav>

            </header>

            <main>

