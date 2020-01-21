<?php

class LoginController
{
    public function actionLogin()
    {
        $ret = false;
        $data = [];
        $data['title'] = 'Log in';
        $data['name'] = '';

        try {
            $ret = Profile::login();
        }
        catch (Exception $e) {
            $data['error'] = $e->getMessage();
            $data['name'] = $_POST['login'];
        } finally {
            $view = new View();
            $view->render('login.php', $data);

        }
        if ($ret === true) \Helper::redirect();
        return true;
    }

    public function actionLogout()
    {
        unset(
          $_SESSION['user']['id'],
          $_SESSION['user']['name']
        );
        \Helper::redirect();
        return true;
    }

    public function actionSignup()
    {
        $data = [];

        $data['name'] = '';
        $data['email'] = '';
        $data['title'] = "Sign Up";

        try {

            if (isset($_SESSION['user']['id'])) throw new Exception('You have an active session');

            if (!empty($_POST)) {
                //var_dump($_POST);exit;
                if (empty(trim($_POST['username']))) throw new Exception('Empty name');
                if (empty(trim($_POST['email']))) throw new Exception('Empty email');
                if (empty(trim($_POST['password1'])) || empty(trim($_POST['password2']))) throw new Exception('Empty password');
                if (mb_strlen(trim($_POST['password1'])) < 6) {

                    throw new Exception('Password minimal length must be 6 characters');
                }
                $username = htmlspecialchars(trim($_POST['username']));
                $data['name'] = $username;

                $email = htmlspecialchars(trim($_POST['email']));

                if (!\Helper::validateEmail($email)) throw new Exception('Email is invalid');
                $data['email'] = $email;


                $profile = new Profile();
                if (trim($_POST['password1']) === trim($_POST['password2'])) {

                    $password = password_hash(trim($_POST['password1']), PASSWORD_DEFAULT);

                } else {
                    throw new Exception('Password is not confirmed');
                }
                $profile->signUp($username, $email, $password);
//                \Helper::redirect();
                $data['success'] = 'Registration is successful. Please confirm your registration by following the link we sent to your email';

            }

        } catch (Exception $e) {

            $data['error'] = $e->getMessage();

        } finally {


            $view = new View();
            $view->render('signup.php', $data);
        }
        return true;
    }

    public static function actionConfirm(string $token)
    {
        $data = [];

        $data['title'] = 'Email confirmation';
        $data['name'] = '';
        $data['email'] = '';

        $token = strip_tags(htmlspecialchars($token));
        try {

            Profile::confirmEmail($token);

        } catch (Exception $e) {

            $data['error'] = 'Confirmation error';

        } finally {

            $view = new View();
            $view->render('confirmEmail.php', $data);
        }
        return true;
    }

    public static function actionResetPassword()
    {
        $data = [];
        $data['title'] = "Reset password";
        $data['email'] = '';

        try {

            if (isset($_SESSION['user']['id'])) throw new Exception('You have an active session');

            if (!empty($_POST)) {
                if (empty($_POST['email'])) throw new Exception('Email must not be empty');

                $email = htmlspecialchars(trim($_POST['email']));

                if (!\Helper::validateEmail($email)) throw new Exception('Email is invalid');

                $res = Profile::resetPassword($email);
                if ($res == true){
                    $data['success'] = "Email was successfully sent";
                }
            }

        } catch (Exception $e) {

            $data['error'] = $e->getMessage();

        } finally {

            $view = new View();
            $view->render('resetPassword.php', $data);
        }

        return true;
    }

    public static function actionNewPassword($selector, $token)
    {
        $res = false;
        $data = [];
        $data['title'] = "New password";

        $data['selector'] = $selector;
        $data['token'] = $token;

        try {

            if ( !(ctype_xdigit($selector) && ctype_xdigit($token))) throw new Exception('Invalid link');

            if (!empty($_POST)) {

                if (empty(trim($_POST['password1'])) || empty(trim($_POST['password2']))) {

                    throw new Exception('Password must not be empty');
                }
                if (trim($_POST['password1'] )!== trim($_POST['password2'])){

                    throw new Exception('Password is not confirmed');
                }
                if (mb_strlen(trim($_POST['password1'])) < 6) {

                    throw new Exception('Password minimal length must be 6 characters');
                }

                $res = Profile::setNewPassword($selector, $token, password_hash(trim($_POST['password1']), PASSWORD_DEFAULT));
                if (!empty($res)) {
                    $data['name'] = $res['name'];
                    $data['success'] = 'Password successfully recovered, now you can login';
                }
            }

        } catch (Exception $e) {

            $data['error'] = $e->getMessage();
        } finally {

            $view = new View();
            $view->render('newPassword.php', $data);
        }



        return true;
    }
}
