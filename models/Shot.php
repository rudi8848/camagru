<?php

/**
 *
 */
class Shot
{
  private $name;
  private $tmpName;
  private $path;

  function __construct($image)
  {
    $this->name = $image['name'];
    $this->tmpName = $image['tmp_name'];
    $this->path = 'uploads/'.$this->name;

    $this->makeMagic();
    $this->saveToDatabase();
  }

  public function getImage()
  {
    return $this->path;
  }

  private function makeMagic()
  {

  }

  private function saveToDatabase()
  {
    move_uploaded_file($this->tmpName, $this->path);
  }

}


?>
