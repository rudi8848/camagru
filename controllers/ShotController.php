<?php

class ShotController
{

    public function actionNew()
    {
      $data = [];
      $data['title'] = 'New post';
      try {

          if (empty($_SESSION['user']['id']) ||  Profile::isValid() == false){
              Helper::redirect();
          }
          if (!empty($_POST)){//var_dump($_POST);exit;
                $inp = str_replace(' ', '+', $_POST['image']);
                $inp = str_replace('data:image/png;base64,', '', $inp);
//var_dump($inp);exit;
                $shot = new Shot($inp);


            echo json_encode(['result' => 'Post added successfully!']);
            exit;

//        var_dump([strlen($bin), $imgSize, $img]);exit;


        }
//          if (!empty($_FILES['image'])) {
//
////              if (!is_uploaded_file($_FILES['image']['tmp_name'])) throw new Exception('File upload error');
//
////              if (filesize($_FILES['image']['tmp_name']) > 2 * 1024 * 1024) throw new Exception('File size is more than 2 Mb');
//
//              $shot = new Shot($_FILES['image']);
//              $data['image'] = $shot->getImage();
//              echo json_encode(['result' => 'Post added successfully!']);
//              exit;
//          }
//          if(!empty($_FILES) ) {
//              if (filesize($_FILES['loadedImage']['tmp_name']) > 2 * 1024 * 1024) throw new Exception('File size is more than 2 Mb');
//
//              $shot = new Shot($_FILES['loadedImage']);
//              $data['image'] = $shot->getImage();
//          }
          $data['frames'] = Shot::getFrames();

      } catch (Exception $e) {

          echo 'Error!!!'.$e->getMessage();
          $data['error'] = $e->getMessage();
      }
      finally {
          $view = new View();
          $view->render('new.php', $data);
      }


      return true;
    }
}
