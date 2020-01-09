<?php

class ProfileController
{
    public function actionUser(string $id)
    {
        $data = [];
        $id = (int)$id;

        $profileData = \Profile::getProfile($id);
        $userPosts = \Gallery::getPicturesList($id);

        $data['posts'] = $userPosts;
        $data['title'] = $profileData['username'].'\'s profile';
        $view = new View();
        $view->render('index.php', $data);
        return true;
    }

    public function actionSettings()
    {
        echo __CLASS__.'::'.__METHOD__.'<br/>';
        return true;
    }
}