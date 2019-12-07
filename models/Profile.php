<?php

/**
 *
 */
class Profile
{

  public static function signUp($name, $email, $password)
  {

      $db = DB::getConnection();

      $users = $db->query('SELECT * FROM users WHERE username = "'.'$name'.'" LIMIT 1');

      try {
        $user = $users->fetchAll();

        if (empty($user)) {

          $q = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
          $newUser = $db->prepare($q);
          $newUser->execute(['username' => $name, 'email' => $email, 'password' => $password]);

          $userId = $db->lastInsertId();
//          echo 'Your id is '.$userId;
          $_SESSION['user']['id'] = $userId;
          $_SESSION['user']['name'] = $name;

          mail(
            $email,
            'Camagru registration',
            'Hello! Nice to see you!',
            join("\r\n", [
              "From: webmaster@camagru",
              "Reply-To: webmaster@camagru",
              "X-Mailer: PHP/".phpversion()
            ])
          );
        }


      }catch(PDOException $e) {
          echo $e->getMessage();
      }

  }

  public static function login()
  {
    if (!empty($_POST)) {

      $name = strip_tags($_POST['login']);
      $password = md5($_POST['password']);


      $db = DB::getConnection();
      $q = 'SELECT * FROM users WHERE username="'.$name.'"';
      $res = $db->query($q, PDO::FETCH_ASSOC);

      $users = $res->fetchAll();
      $user = $users[0];

      if ($user['password'] !== $password) {

        die ('Wrong password');

      } else {



        $_SESSION['user']['id'] = $user['user_id'];
        $_SESSION['user']['name'] = $user['username'];
      }

    }
  }

}
