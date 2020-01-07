<?php

class Helper
{
    public static function redirect(string $url = 'https://camagru.com/gallery') : void
    {
        ob_start();
        header('Location: '.$url);
        ob_end_flush();
        die();
    }

    public static function validateEmail(string $email) : bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) return true;
        return false;
    }
}