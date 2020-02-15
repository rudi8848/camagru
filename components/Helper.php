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
                'visible' => UNLOGGED,
                'validOnly' => false
            ],
            1 => [
                'text' => 'Sign Up',
                'url' => '/signup',
                'visible' => UNLOGGED,
                'validOnly' => false
            ],
            2 => [
                'text' => 'Make new photo',
                'url' => '/new',
                'visible' => LOGGED,
                'validOnly' => true
            ],
            3 => [
                'text' => 'Gallery',
                'url' => '/gallery',
                'visible' => BOTH,
                'validOnly' => false
            ],
            4 => [
                'text' => 'Settings',
                'url' => '/settings',
                'visible' => LOGGED,
                'validOnly' => false
            ],
            5 => [
                'text' => 'Logout',
                'url' => '/logout',
                'visible' => LOGGED,
                'validOnly' => false
            ],
        ];

        $result = [];

        foreach ($menu as $key => $val) {

            if (isset($_SESSION['user']['id']) && $val['visible'] == LOGGED) {
                if ($val['validOnly'] && Profile::isValid() == false) {
                    continue;
                }
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

    public static function imageResize($imageSrc, $imageWidth, $imageHeight, $maxsize = 100)
    {
        if ($imageWidth > $imageHeight){
            $newImageWidth = $maxsize;
            $newImageHeight = round($newImageWidth * ($imageHeight / $imageWidth));
        } elseif ($imageHeight > $imageWidth) {
           $newImageHeight = $maxsize;
           $newImageWidth = round($newImageHeight * ($imageWidth / $imageHeight));
        } else {
            $newImageWidth = $newImageHeight = $maxsize;
        }

        $newImageLayer=imagecreatetruecolor($newImageWidth,$newImageHeight);
        $res = imagecopyresampled($newImageLayer,$imageSrc,0,0,0,0,$newImageWidth,$newImageHeight,$imageWidth,$imageHeight);
        if (res == false) throw new Exception('Resize error');
        return $newImageLayer;
    }
}