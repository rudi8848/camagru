<?php

/**
 *
 */
class Shot
{
  private $name;
  private $tmpName;
  private $path;
  private $fullpath;
  private $description;

  function __construct($image)
  {

    try {
      $this->name = $image['name'];
      $this->tmpName = $image['tmp_name'];
      $this->path = '/uploads/' . $this->getFilename();
      $this->fullpath = ROOT . $this->path;

      if (!empty($_POST['description'])) {
        $this->description = htmlspecialchars(trim($_POST['description']));
      }


      $this->makeMagic();
      $this->saveToDatabase();
    } catch (Exception $e) {
      throw $e;
    }
  }

  private function getFilename() {
      $hash = sha1_file($this->tmpName);

      $name = substr_replace($hash, '/', 2, 0);
      $name = substr_replace($name, '/', 5, 0);

      $info = new SplFileInfo($this->name);

      $ext = $info->getExtension();

      return $name.'.'.$ext;
  }


  public function getImage()
  {
    return $this->path;
  }

  private function makeMagic()
  {
//      $im = imagecreatefromstring($this->tmpName);
//      var_dump($im);
  }

  private function saveToDatabase()
  {
    try {
      $dir = dirname($this->fullpath);
//    echo $dir;exit;

      if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
      }
      move_uploaded_file($this->tmpName, $this->fullpath);

      $db = DB::getConnection();
      $params = [
          'path' => $this->path,
          'author' => (int)$_SESSION['user']['id'],
          'description' => $this->description
      ];
      $q = $db->prepare('INSERT INTO posts (image_path, author, description)
            VALUES (:path, :author, :description)');

      $q->execute($params);
    } catch (Exception $e) {
      throw $e;
    }
  }

  public static function getFrames()
  {
      $db = DB::getConnection();
      $res = $db->query('SELECT * FROM frames', PDO::FETCH_ASSOC);

      $likes = $res->fetchAll();

      return $likes;

  }

}


?>
