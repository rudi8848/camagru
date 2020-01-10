<?php

class Helper
{
    public static function redirect() : void
    {
        $args = func_get_args();

        $url = $args[0];
        if (empty($url)) $url = getenv('SERVER_NAME');
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