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

    $this->name = $image['name'];
    $this->tmpName = $image['tmp_name'];
    $this->path = '/uploads/'.$this->getFilename();
    $this->fullpath = ROOT.$this->path;

    if (!empty($_POST['description'])) {
      $this->description = $_POST['description'];
    }


    $this->makeMagic();
    $this->saveToDatabase();
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
    $dir = dirname($this->fullpath);
//    echo $dir;exit;

      if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
      }
      move_uploaded_file($this->tmpName, $this->fullpath);

    $db = DB::getConnection();
    $q = 'INSERT INTO posts (image_path, author, description)
            VALUES ("'.$this->path.'", "'.$_SESSION['user']['id'].'", "'.$this->description.'")';
    $db->exec($q);
  }

}


?>
