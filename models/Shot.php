<?php

class Shot
{
  private $name;
  private $tmpName;
  private $redacted;
  private $path;
  private $fullpath;
  private $description;
  private $ext;

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

      $this->ext = $info->getExtension();

      if (!in_array($this->ext, ['png', 'jpeg', 'jpg', 'gif'])) throw new Exception('Unsupported extension');
      return $name.'.'.$this->ext;
  }


  public function getImage()
  {
    return $this->path;
  }

  private function makeMagic()
  {

      switch ($this->ext){
        case 'png':
          $srcIm = imagecreatefrompng($this->tmpName);
          break;
        case 'jpeg':
        case 'jpg':
        $srcIm = imagecreatefromjpeg($this->tmpName);
          break;
        case 'gif':
          $srcIm = imagecreatefromgif($this->tmpName);
          break;
      }

      list($width, $height) = getimagesize($this->tmpName);
      if ($width > 2000 || $height > 2000) throw new Exception('Too large image');

      if ($width > $height) {
        $newWidth = 640;
        $newHeight = round($newWidth * ($height / $width));
      } else {
        $newHeight = 480;
        $newWidth = round($newHeight * ($width / $height));
      }

    $this->redacted = imagecreatetruecolor($newWidth, $newHeight);
    $res = imagecopyresampled($this->redacted,$srcIm,0,0,0,0,$newWidth,$newHeight,$width,$height);

    $frame = imagecreatefrompng('views/styles/frames/fire.png');
    imagealphablending($frame, false);
    imagesavealpha($frame, true);
    imagecopy($this->redacted, $frame, 0, 0, 0, 0, $newWidth, $newHeight);

    if ($res == false) throw new Exception('Image upload error');

    $dir = dirname($this->fullpath);

    if (!file_exists($dir)) {
      mkdir($dir, 0755, true);
    }

    switch ($this->ext){
      case 'png':
        imagepng($this->redacted, $this->fullpath);
        break;
      case 'jpeg':
      case 'jpg':
        imagejpeg($this->redacted, $this->fullpath);
        break;
      case 'gif':
        imagegif($this->redacted, $this->fullpath);
        break;
    }
  }

  private function saveToDatabase()
  {
    try {
//      $dir = dirname($this->fullpath);
//
//      if (!file_exists($dir)) {
//        mkdir($dir, 0755, true);
//      }
//      move_uploaded_file($this->tmpName, $this->fullpath);
//      move_uploaded_file($this->redacted, $this->fullpath);

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

      return $res->fetchAll();

  }

}


?>
