<?php

namespace App\core;

trait uploads
{

  public function addPicture($inputName,  $imgID,  $userID)
  {
    if (isset($_FILES[$inputName])) {
      $info = getimagesize($_FILES[$inputName]['tmp_name']);

      $allowedTypes = [
        IMAGETYPE_JPEG => '.jpg',
        IMAGETYPE_PNG => '.png',
        IMAGETYPE_GIF => '.gif'
      ]; //accept jpg, png, gif

      if ($info === false) { 
        Application::$app->response->redirect('', ['errorW' => 'Bad file format']);
      } else if (!array_key_exists($info[2], $allowedTypes)) { 
        Application::$app->response->redirect('', ['errorW' => 'Not an accepted file type']);
      } else {
        //save the picture in the images folder
        $path = getcwd() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;

        $filename = uniqid() . $allowedTypes[$info[2]];
        //تابع uniqid() یک شناسه منحصربفرد بر اساس میکروتایم (زمان فعلی بر حسب میکروثانیه) ایجاد می کند.
        move_uploaded_file($_FILES[$inputName]['tmp_name'], $path . $filename);

        Application::$app->Connection->getMedoo()->update(
          'doctor_profile',
          [
            'url_picture' => $filename
          ],
          [
            'id' => $imgID
          ]
        );
        Application::$app->response->redirect('', ['success' => 'Picture added']);
      }
    } else {

      Application::$app->response->redirect('', ['errorW' => 'No file uploaded']);
    }
  }
}
