<?php

class Profile
{

  public static function signUp($name, $email, $password)
  {
      try {
//          $adminEmail = getenv('ADMIN_EMAIL');

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

          $message = '<p>Hello '.$name.'!<br/>
                      Thanks for registration at <a href="'.getenv('SERVER_NAME').'">Camagru</a>.
                      <br/>To complete registration please follow <a href="'.
                      getenv('SERVER_NAME').'/confirmation/'.$token.'">this link</a></p>';
          Helper::sendEmail($email, 'Camagru registration', $message);

        } else {

            throw new Exception('This name is already in use. Please choose the another one.');
        }


      }catch(Exception $e) {
          throw $e;
      }

  }

  public static function login()
  {

    if (isset($_SESSION['user']['id'])) throw new Exception('You have an active session');

    if (!empty($_POST)) {

        if (empty(trim($_POST['login']))) throw new Exception('Empty login');
        if (empty(trim($_POST['password']))) throw new Exception('Empty password');

      $name = htmlspecialchars(trim($_POST['login']));
//      $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
      $password = trim($_POST['password']);


      $db = DB::getConnection();
      $q = 'SELECT * FROM users WHERE username="'.$name.'"';
      $res = $db->query($q, PDO::FETCH_ASSOC);

      $users = $res->fetchAll();
      if (empty($users)) throw new Exception('No such user');
      $user = $users[0];

      if (!password_verify($password, $user['password'])) {

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
      try {
          $db = DB::getConnection();
          $q = 'SELECT * FROM users WHERE user_id="' . $id . '"';
          $res = $db->query($q, PDO::FETCH_ASSOC);

          $user = $res->fetch();
          if (empty($user)) throw new Exception('No such user');

          return $user;
      } catch (Exception $e)
      {
          throw $e;
      }
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

  public static function resetPassword(string $email)
  {
      try {

          $db = DB::getConnection();

          $adminEmail = getenv('ADMIN_EMAIL');

          $selector = bin2hex(random_bytes(8));
          $token = random_bytes(32);

          $url = getenv('SERVER_NAME').'/create-new-password/'.$selector.'/'.bin2hex($token);
          $expires = new DateTime('now');
          $expires->setTimezone(new DateTimeZone('Europe/Kiev'));
          $expires->modify('+ 1 hour');
          $exp = $expires->format('d.m.Y H:i');

          $res = $db->prepare('SELECT * FROM users WHERE email=:email');
          $res->execute(['email' => $email]);

          $users = $res->fetchAll(PDO::FETCH_ASSOC);
          if (count($users) != 1) throw  new Exception('Error getting users');

          $user = $users[0];

          $name = $user['username'];

          $q = $db->prepare('DELETE FROM password_reset WHERE email=:email');
          $q->execute(['email' => $email]);


          $row = $db->prepare('INSERT INTO password_reset (email, selector, token, expires) 
                                VALUES (:email, :selector, :token, :expires)');
          $row->execute(['email' => $email,
              'selector' => $selector,
              'token' => password_hash($token, PASSWORD_DEFAULT),
              'expires' => $expires->format('Y-m-d H:i:s')]);

          $message = "<p>Hello $name!</p>
                      <p>To recover your password please follow <a href='$url'>this link</a>!<br/>
                      <small>The link will be active till $exp</small></p>";
          Helper::sendEmail($email, 'Camagru password recovery', $message);

      } catch (Exception $e) {
            throw $e;
      }
      return true;
  }

  public static function setNewPassword(string $selector, string $token, string $password)
  {
      try {

          $db = DB::getConnection();

          $q = $db->prepare("SELECT * FROM password_reset WHERE selector=:selector");
          $q->execute([
              'selector' => $selector
          ]);
          $res = $q->fetchAll(PDO::FETCH_ASSOC);

          $row = $res[0];

          $tokenBin = hex2bin($token);

          if (password_verify($tokenBin, $row['token']) == false) throw new Exception('Password recovery error');

          $exp = new DateTime($row['expires']);
          $now = new DateTime('now');
          $now->setTimezone(new DateTimeZone('Europe/Kiev'));
          if ($exp < $now) throw new Exception('The link is expired');

          $q = $db->query("SELECT * FROM users WHERE email='{$row['email']}'");
          $user = $q->fetchAll(PDO::FETCH_ASSOC);

          $q = $db->prepare('UPDATE users SET password=:password WHERE user_id=:userId');
          $q->execute([
              'password' => $password,
              'userId' => $user[0]['user_id']
          ]);
          return ['success' => true, 'name' => $user[0]['username']];

      } catch (Exception $e) {
            throw $e;
      }
  }


  public static function changeUserPicture(array $file)
  {
      if (empty($_SESSION['user']['id'])) throw new Exception('Not authorized');
      if (filesize($file['tmp_name']) > 2 * 1024 * 1024) throw new Exception('File size is more than 2 mb');
      $info = new SplFileInfo($file['name']);
      $ext = $info->getExtension();
      if (!in_array($ext, ['png', 'jpeg', 'jpg', 'gif'])) throw new Exception('Unsupported extension');

      $sourceProperties = getimagesize($file['tmp_name']);

      $dirPath = "/uploads/";

      $hash = sha1_file($file['tmp_name']);
      $newFileName = substr_replace($hash, '/', 2, 0);
      $newFileName = substr_replace($newFileName, '/', 5, 0);

      $imageType = $sourceProperties[2];

      $fullName = $dirPath.$newFileName.'.'.$ext;
      $dir = dirname(ROOT.$fullName);

      if (!file_exists($dir)) {
          mkdir($dir, 0755, true);
      }

      switch ($imageType) {

          case IMAGETYPE_PNG:
              $imageSrc = imagecreatefrompng($file['tmp_name']);
              $tmp = Helper::imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1]);
//              imagepng($tmp,$dirPath. $newFileName. "_thump.". $ext);
              imagepng($tmp, ROOT.$fullName, 90);
              break;

          case IMAGETYPE_JPEG:
              $imageSrc = imagecreatefromjpeg($file['tmp_name']);
              $tmp = Helper::imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1]);
//              imagejpeg($tmp,$dirPath. $newFileName. "_thump.". $ext);
              imagejpeg($tmp,ROOT.$fullName, 90);
              break;

          case IMAGETYPE_GIF:
              $imageSrc = imagecreatefromgif($file['tmp_name']);
              $tmp = Helper::imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1]);
//              imagegif($tmp,$dirPath. $newFileName. "_thump.". $ext);
              imagegif($tmp,ROOT.$fullName, 90);
              break;

          default:
              throw new Exception("Invalid Image type");
              break;
      }


      $db = DB::getConnection();
      $db->exec("UPDATE users SET pic='$fullName' WHERE user_id={$_SESSION['user']['id']}");
      $_SESSION['user']['pic'] = $fullName;
  }


  public static function changeUsername(string $name)
  {
      try{

          if (empty($_SESSION['user']['id'])) throw new Exception('Not authorized');

          $db = DB::getConnection();
          $q = $db->prepare('UPDATE users SET username=:username WHERE user_id=:id');
          $q->execute([
              'username' => $name,
              'id' => (int)$_SESSION['user']['id']
          ]);

          $_SESSION['user']['name'] = $name;
      }
      catch (Exception $e) {
          throw $e;
      }
  }

  public static function changeEmail(string $email)
  {
      try{

          if (empty($_SESSION['user']['id'])) throw new Exception('Not authorized');
          if (!\Helper::validateEmail($email)) throw new Exception('Email is invalid');

          $db = DB::getConnection();
          $q = $db->prepare('UPDATE users SET email=:email WHERE user_id=:id');
          $q->execute([
              'email' => $email,
              'id' => (int)$_SESSION['user']['id']
          ]);
      }
      catch (Exception $e) {
          throw $e;
      }
  }


  public static function changePassword(string $oldPassword, string $newPassword)
  {
      try{

          if (empty($_SESSION['user']['id'])) throw new Exception('Not authorized');
          $db = DB::getConnection();

          $q = "SELECT * FROM users WHERE user_id={$_SESSION['user']['id']}";
          $res = $db->query($q, PDO::FETCH_ASSOC);

          $user = $res->fetch();
          if (empty($user)) throw new Exception('No such user');

          if (!password_verify($oldPassword, $user['password'])) throw new Exception('Wrong password');

          $db->exec("UPDATE users SET password='$newPassword' WHERE user_id={$_SESSION['user']['id']}");

      } catch (Exception $e){
            throw $e;
      }
  }


  public static function changeNotificationsSettings(int $notifications)
  {
      try {
          if (empty($_SESSION['user']['id'])) throw new Exception('Not authorized');
          $db = DB::getConnection();
          $db->exec("UPDATE users SET notifications='$notifications' WHERE user_id={$_SESSION['user']['id']}");
      }
      catch (Exception $e){
          throw $e;
      }
  }
}
