<?php

class LoginController
{
    public function actionLogin()
    {
        $data = [];

        Profile::login();
        $view = new View();
        $view->render('login.php', $data);
        return true;
    }

    public function actionLogout()
    {
        unset(
          $_SESSION['user']['id'],
          $_SESSION['user']['name'],
        );

        return true;
    }

    public function actionSignup()
    {
        $data = [];

        if (!empty($_POST)) {
          //var_dump($_POST);exit;
          $data['name'] = strip_tags($_POST['username']);
          $profile = new Profile();
          if ($_POST['password1'] === $_POST['password2']) {

            $sault = new DateTime('now');
            $sault = $sault->format('YmdHis');
            $password = md5($_POST['password1']);


          }
          $profile->signUp($_POST['username'],$_POST['email'], $password);

        }

        $view = new View();
        $view->render('signup.php', $data);

        return true;
    }
}
