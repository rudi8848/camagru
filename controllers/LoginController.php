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

            if (!empty($_POST)) {
                //var_dump($_POST);exit;
                $username = strip_tags($_POST['username']);
                $data['name'] = $username;

                $email = $_POST['email'];

                if (!\Helper::validateEmail($email)) throw new Exception('Email is invalid');
                $data['email'] = $email;


                $profile = new Profile();
                if ($_POST['password1'] === $_POST['password2']) {

                    $password = md5($_POST['password1']);

                } else {
                    throw new Exception('Password is not confirmed');
                }
                $profile->signUp($username, $_POST['email'], $password);
                \Helper::redirect();
            }

        } catch (Exception $e) {

            $data['error'] = $e->getMessage();

        } finally {


            $view = new View();
            $view->render('signup.php', $data);
        }
        return true;
    }
}
