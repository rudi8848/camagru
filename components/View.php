<?php

class View
{

    public function render($path, $data)
    {
      $path = ROOT.'/views/'.$path;
        if (file_exists($path))
        {
            require_once($path);
        } else
        {
            die('File '.$this->path.' does not exist');
        }
    }
}
