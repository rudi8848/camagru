<?php

/**
 *
 */
class Profile
{

  public static function signUp($name, $email, $password)
  {

      $db = DB::getConnection();
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $users = $db->query('SELECT * FROM users WHERE username = "'.'$name'.'" LIMIT 1');

      try {
        $user = $users->fetchAll();

        if (empty($user)) {

          $q = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
          $newUser = $db->prepare($q);
          $newUser->execute(['username' => $name, 'email' => $email, 'password' => $password]);

          $userId = $db->lastInsertId();
          echo 'Your id is '.$userId;
          $_SESSION['user']['id'] = $userId;
          $_SESSION['user']['name'] = $name;
        }


      }catch(PDOException $e) {
          echo $e->getMessage();
      }

  }

}
