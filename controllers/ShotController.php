<?php

class ShotController
{

    public function actionNew()
    {
      $data = [];
      if (!empty($_FILES['image'])) {

        $shot = new Shot($_FILES['image']);
        $data['image'] = $shot->getImage();

        if (!empty($_POST['description']))

          $description = strip_tags($_POST['description']);
          $data['description'] = $description;
      }

      $view = new View();
      $view->render('new.php', $data);

      return true;
    }
}
