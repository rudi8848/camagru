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

          $token = bin2hex(random_bytes(20));
          $q = "INSERT INTO users (username, email, password, token) VALUES (:username, :email, :password, :token)";
          $newUser = $db->prepare($q);
          $newUser->execute(['username' => $name, 'email' => $email, 'password' => $password, 'token' => $token]);

          $userId = $db->lastInsertId();
//          echo 'Your id is '.$userId;
//          $_SESSION['user']['id'] = $userId;
//          $_SESSION['user']['name'] = $name;
//          $_SESSION['user']['pic'] = '';

          mail(
            $email,
            'Camagru registration',
            'Hello '.$name.'! Thanks for registration at '.getenv('SERVER_NAME').'. To complete registration please follow the link: '.
            getenv('SERVER_NAME').'/confirmation/'.$token,
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

      }elseif($user['verified'] == 0){
          throw new Exception('Please confirm your registration by following the link we sent to your email');
      } else {

        $_SESSION['user']['id'] = $user['user_id'];
        $_SESSION['user']['name'] = $user['username'];
        $_SESSION['user']['pic'] = $user['pic'];
      }
        return true;
    }
    return false;
  }

  public static function getProfile(int $id)
  {
      $db = DB::getConnection();
      $q = 'SELECT * FROM users WHERE user_id="'.$id.'"';
      $res = $db->query($q, PDO::FETCH_ASSOC);

      $users = $res->fetchAll();
      if (empty($users)) throw new Exception('No such user');

      return $users[0];
  }

  public static function getUserPosts()
  {

  }

  public static function confirmEmail(string $token)
  {
      try{

          $db = DB::getConnection();

          $q = 'SELECT * FROM users WHERE token="'.$token.'"';
          $res = $db->query($q, PDO::FETCH_ASSOC);

          $user = $res->fetchAll();
          if (count($user) == 1) {

              $userId = $user[0]['user_id'];

              $db->exec('UPDATE users SET token=NULL, verified=1 WHERE user_id='.$userId);

          } else {

              throw new Error("Token error");
          }

      }catch (Exception $e){

          throw $e;
      }
      return true;
  }

}
