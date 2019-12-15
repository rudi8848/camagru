<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <link href="/views/styles/main.css" rel="stylesheet">
            <title><?=$data['title']?></title>
        </head>
        <body>
            <header>
              <nav class="main-menu">

                  <a href="/gallery">Gallery</a>
                <?php if (empty($_SESSION['user']['id'])) : ?>
                  <a href="/login">Login</a>
                  <a href="/signup">Sign Up</a>
                <?php else : ?>

                  <a href="/settings">Settings</a>
                  <a href="/logout">Logout</a>

                    <p class="username">Hello, <?=$_SESSION['user']['name']?></p>
                <?php endif; ?>

              </nav>

            </header>
            <?php if (!empty($_SESSION['user']['id'])) :?>
                <br/><a id="btn-new" href="/new">Upload new photo</a><br/>
            <?php endif; ?>
