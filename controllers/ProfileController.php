<?php

class ProfileController
{
    public function actionUser(string $id)
    {
        $data = [];
        $id = (int)$id;

        $page = 0;

        $args = func_get_args();

        if (!empty($args[2])){

            $page = (int)$args[2];
            if ($page > 0) $page -= 1;
            $page = abs($page);
        }

        $totalPages = Gallery::getPagesTotalNumber($id);
        if ($page > ( $totalPages - 1 )) $page = 0;
        $profileData = \Profile::getProfile($id);
        $userPosts = \Gallery::getPicturesList($page, $id);

        $comments  = [];
        foreach ($userPosts as $post) {
            $comments[] = $post['post_id'];

        }
        $data['comments'] = Gallery::getPostsComments($comments);

        $data['posts'] = $userPosts;
        $data['title'] = $profileData['username'].'\'s profile';
        $data['currentPage'] = $page + 1;
        $data['totalPages'] = $totalPages;
        $view = new View();
        $view->render('index.php', $data);
        return true;
    }

    public function actionSettings()
    {
        $data = [];
        $data['title'] = 'Settings';

        try {

            if (empty($_SESSION['user']['id'])) throw new Exception('Session is not active');

            $data['settings'] = Profile::getProfile((int)$_SESSION['user']['id']);
        }
        catch (Exception $e)
        {
            $data['error'] = $e->getMessage();

        } finally {

            $view = new View();
            $view->render('settings.php', $data);
        }

        return true;
    }

    public function actionChangeName()
    {
        if (!empty($_POST)){

        }
        return true;
    }

    public function actionChangePicture()
    {
        if (!empty($_POST)){

        }
        return true;
    }

    public function actionChangeEmail()
    {
        if (!empty($_POST)){

        }
        return true;
    }

    public function actionChangePassword()
    {
        if (!empty($_POST)){

        }
        return true;
    }

    public function actionNotifications()
    {
        if (!empty($_POST)){

        }
        return true;
    }
}