<?php

const LOGGED = 0;
const UNLOGGED = 1;
const BOTH = 2;


class Helper
{


    public static function redirect($url = '/') : void
    {

        if (empty($url)) $url = '/';
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

    public static function getMenu() : array
    {


        $menu = [
            0 => [
                'text' => 'Login',
                'url' => '/login',
                'visible' => UNLOGGED
            ],
            1 => [
                'text' => 'Sign Up',
                'url' => '/signup',
                'visible' => UNLOGGED
            ],
            2 => [
                'text' => 'Make new photo',
                'url' => '/new',
                'visible' => LOGGED
            ],
            3 => [
                'text' => 'Gallery',
                'url' => '/gallery',
                'visible' => BOTH
            ],
            4 => [
                'text' => 'Settings',
                'url' => '/settings',
                'visible' => LOGGED
            ],
            5 => [
                'text' => 'Logout',
                'url' => '/logout',
                'visible' => LOGGED
            ],
        ];

        $result = [];

        foreach ($menu as $key => $val) {

            if (isset($_SESSION['user']['id']) && $val['visible'] == LOGGED) {
                $result [] = $val;
            } elseif (empty($_SESSION['user']['id']) && $val['visible'] == UNLOGGED) {
                $result [] = $val;
            } elseif($val['visible'] == BOTH) {
                $result [] = $val;
            }
        }

        return $result;
    }

    public static function sendEmail(string $email, string $subject, string $message)
    {

        $adminEmail = getenv('ADMIN_EMAIL');

        mail(
            $email,
            $subject,
            $message,
            join("\r\n", [
                "From: $adminEmail",
                "Reply-To: $adminEmail",
                "Content-type: text/html",
                "X-Mailer: PHP/".phpversion()
            ])
        );
    }

    public static function imageResize($imageSrc, $imageWidth, $imageHeight, $newImageWidth = 100, $newImageHeight=100)
    {

        $newImageLayer=imagecreatetruecolor($newImageWidth,$newImageHeight);
        imagecopyresampled($newImageLayer,$imageSrc,0,0,0,0,$newImageWidth,$newImageHeight,$imageWidth,$imageHeight);

        return $newImageLayer;
    }
}