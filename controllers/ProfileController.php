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

            if (empty($_SESSION['user']['id'])){
                Helper::redirect();
            }


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
        try {
            if (!empty($_POST)) {

                if (empty(trim($_POST['name']))) throw new Exception('Empty name');
                Profile::changeUsername(htmlspecialchars(trim($_POST['name'])));
                Helper::redirect('/settings');
            }
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
        return true;
    }

    public function actionChangePicture()
    {

        try {
            if (!empty($_POST) && !empty($_FILES)) {

//                var_dump($_FILES['image']);

                $file = $_FILES['image'];
                if (!is_uploaded_file($file['tmp_name'])) throw new Exception('File upload error');
                Profile::changeUserPicture($file);

                Helper::redirect('/settings');
            }
        }
        catch (Exception $e){
            echo $e->getMessage();
        }

        return true;
    }

    public function actionChangeEmail()
    {
        try {
            if (!empty($_POST)) {

                if (empty(trim($_POST['email']))) throw new Exception('Empty email');
                Profile::changeEmail(htmlspecialchars(trim($_POST['email'])));
                Helper::redirect('/settings');
            }
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
        return true;
    }

    public function actionChangePassword()
    {
        try{

            if (!empty($_POST)){
                if (empty(trim($_POST['oldPassword'])) ||
                empty(trim($_POST['newPassword1'])) ||
                empty(trim($_POST['newPassword2']))) throw new Exception('Empty password');

             if (trim($_POST['newPassword1']) !== trim($_POST['newPassword2'])) throw new Exception('Password is not confirmed');
             if (mb_strlen(trim($_POST['newPassword1'])) < 6) throw new Exception('Too short password');

                $oldPassword = trim($_POST['oldPassword']);
                $newPassword = password_hash(trim($_POST['newPassword1']), PASSWORD_DEFAULT);

                Profile::changePassword($oldPassword, $newPassword);
                Helper::redirect('/settings');
            }
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
        return true;
    }

    public function actionNotifications()
    {
        try {
            if (!empty($_POST)) {

                if (empty($_POST['notifications'])) throw new Exception('Notifications error');
                $notifications = $_POST['notifications'] == 'true' ? 1 : 0;
//                echo $notifications;
                Profile::changeNotificationsSettings($notifications);
                echo json_encode(['success' => true]);
            }
        }
        catch (Exception $e){
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }

        return true;
    }

    public static function actionBlock(int $userId)
    {
        var_dump($userId);
        try{

            if ($_SESSION['user']['role'] != 1) throw new Exception('Not authorized');
            Profile::blockUser($userId);
        } catch (Exception $e){

            echo $e->getMessage();
        }
        return true;
    }
}