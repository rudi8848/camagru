<?php

/**
 *
 */
class Profile
{

  public static function signUp($name, $email, $password)
  {
      try {
          $adminEmail = getenv('ADMIN_EMAIL');

          $db = DB::getConnection();

          $users = $db->query('SELECT * FROM users WHERE username = "'.$name.'" LIMIT 1');

          $user = $users->fetchAll();

          $userEmails = $db->query('SELECT * FROM users WHERE email="'.$email.'"');
          $userEmail = $userEmails->fetchAll();

          if (!empty($userEmail)) throw new Exception('This email is already in use');

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
            'Hello '.$name.'! Thanks for registration at https://camagru.com!',
            join("\r\n", [
              "From: $adminEmail",
              "Reply-To: $adminEmail",
              "X-Mailer: PHP/".phpversion()
            ])
          );
        } else {

            throw new Exception('This name is already in use. Please choose the another one.');
        }


      }catch(Exception $e) {
          throw $e;
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
      if (empty($users)) throw new Exception('No such user');
      $user = $users[0];

      if ($user['password'] !== $password) {

        throw new Exception('Wrong password');

      } else {

        $_SESSION['user']['id'] = $user['user_id'];
        $_SESSION['user']['name'] = $user['username'];
      }
        return true;
    }
    return false;
  }

}
