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
        echo __CLASS__.'::'.__METHOD__.'<br/>';
        return true;
    }
}