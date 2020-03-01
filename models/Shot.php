<?php

class Shot
{
//  private $name;
//  private $tmpName;
  private $redacted;
  private $path;
  private $fullpath;
  private $description;
  private $ext;
  private $mime;
  private $resource;
  private $frame;
  private $imgSize;
  private $srcStr;

  const TYPE_MAP = [
      'image/jpeg' => 'jpeg',
      'image/png' => 'png',
      'image/gif' => 'gif'
  ];

//1 які властивості є у ресурса,  2 якщо я передала вже готовий ресурс, як дізнатися розширення (!getimagesize[mime])

  function __construct($image)
  {

    try {

//      $this->name = $image['name'];
      $this->srcStr = $image;
      $bin = base64_decode($image);

      $img = imagecreatefromstring($bin);//resource or false
      $this->imgSize = getimagesizefromstring($bin);

      if ($img == false || $this->imgSize == false) throw new Exception('Error: invalid image');
      if (strlen($bin) > 2 * 1024 * 1024) throw new Exception('File size is more than 2 Mb');
      $this->resource = $img;
      $this->mime = $this->imgSize['mime'];
//      $this->tmpName = $image['tmp_name'];
      $this->path = '/uploads/' . $this->getFilename();
      $this->fullpath = ROOT . $this->path;

      if (!empty($_POST['description'])) {
        $this->description = htmlspecialchars(trim($_POST['description']));
      }

      $this->frame = $this->getFrameName();

      $this->makeMagic();
      $this->saveToDatabase();
    } catch (Exception $e) {
      throw $e;
    }
  }

  private function getFilename() {
//      $hash = sha1_file($this->tmpName);
      $hash = hash('sha256', $this->srcStr);

      $name = substr_replace($hash, '/', 2, 0);
      $name = substr_replace($name, '/', 5, 0);

//      $info = new SplFileInfo($this->name);

//      $this->ext = $info->getExtension();
      $this->ext = $this->getExtension();

      if (!in_array($this->ext, ['png', 'jpeg', 'jpg', 'gif'])) throw new Exception('Unsupported extension');
      return $name.'.'.$this->ext;
  }


  public function getImage()
  {
    return $this->path;
  }

  private function makeMagic()
  {

//      switch ($this->ext){
//        case 'png':
//          $srcIm = imagecreatefrompng($this->tmpName);
//          break;
//        case 'jpeg':
//        case 'jpg':
//        $srcIm = imagecreatefromjpeg($this->tmpName);
//          break;
//        case 'gif':
//          $srcIm = imagecreatefromgif($this->tmpName);
//          break;
//      }
$srcIm = $this->resource;
//      list($width, $height) = getimagesize($this->tmpName);
//      list($width, $height) = getimagesizefromstring($this->resource);
    $width = $this->imgSize[0];
    $height = $this->imgSize[1];
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

    $frame = imagecreatefrompng(ROOT.$this->frame);
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

  public static function getFrames() : array
  {

      $db = DB::getConnection();
      $res = $db->query('SELECT * FROM frames', PDO::FETCH_ASSOC);

      return $res->fetchAll();

  }

  private  function getExtension(): string
  {
    $type = $this->mime;

    if ($type == false) throw new Exception('Error: invalid image');

    if (empty(self::TYPE_MAP[$this->mime])) throw new Exception('Error: image type not supported');

    return self::TYPE_MAP[$this->mime];
  }

  private function getFrameName()
  {
    if (!empty($_POST['frame'])) {
      $frameId = $_POST['frame'];

      if (empty($frameId)) throw new Exception('Frame is not valid');

      $pos = strrpos($frameId, '-');

      $frameId = (int)substr($frameId, $pos + 1);

      if ($frameId <= 0) throw new Exception('Frame is not valid');

      $db = DB::getConnection();

      $params = ['id' => $frameId];
      $frames = $db->prepare('SELECT path FROM frames WHERE frame_id = :id');

      $frames->execute($params);

      $frame = $frames->fetch(PDO::FETCH_ASSOC);

      if (empty($frame['path'])) throw new Exception('Frame is not valid');
//      print_r($frame);
      return $frame['path'];
    } else {
      throw new Exception('No frame chosen');
    }
  }

}


?>
