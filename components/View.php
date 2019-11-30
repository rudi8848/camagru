<?php

class View
{
    private $path;
    private $data;

    public function __construct(string $path, array $output)
    {
        $this->path = ROOT.'/views/'.$path;
        $this->data = $output;
    }

    public function render()
    {
        if (file_exists($this->path))
        {
            require_once($this->path);
        } else
        {
            die('File '.$this->path.' does not exist');
        }
    }
}