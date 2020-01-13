<?php

class ShotController
{

    public function actionNew()
    {
      $data = [];
      $data['title'] = 'New post';
      try {
          if (empty($_SESSION['user']['id'])) {
              throw new Exception('Please login');
          }

          if (!empty($_FILES['image'])) {

              $shot = new Shot($_FILES['image']);
              $data['image'] = $shot->getImage();
              echo json_encode(['result' => 'Post added successfully!']);
              exit;
          }
          $data['frames'] = Shot::getFrames();

      } catch (Exception $e) {

          $data['error'] = $e->getMessage();
      } finally {
          $view = new View();
          $view->render('new.php', $data);
      }


      return true;
    }
}
