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
                    <p class="username">Hello, <?=$_SESSION['user']['name']?>
                        <?php if (Profile::isValid() == false) :?>
                            (not active)
                        <?php else: ?>
                            <a href="/profile/<?=$_SESSION['user']['id']?>">(view my profile)</a>
                        <?php endif; ?>
                    <?php if ($_SESSION['user']['role'] == 1):?>
                    <a href="/users">List all users</a>
                    <?php endif; ?>
                    </p>
                <?php endif; ?>
                <a href="/" id="to-the-main-page">
                    <img src="/views/styles/pic/fotic.png"  class="logo-img">
                    <span class="logo">Camagru</span>
                </a>
                <div align="center">
              <nav class="main-menu" align="center">
                  <?php $menu = Helper::getMenu();?>

                  <?php foreach ($menu as $menuItem):?>
                    <a href="<?=$menuItem['url']?>"><?=$menuItem['text']?></a>
                  <?php endforeach;?>
              </nav>
                </div>
            </header>

            <main>

