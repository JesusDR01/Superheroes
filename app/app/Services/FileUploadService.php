<?php
namespace App\Services;

class FileUploadService {

  private static $dirUpload = IMG_DIRECTORY;
  private static $maxSize = 10309088;
  private static $allowedExts = array("gif", "jpeg", "jpg", "png");
  private static $allowedFormat = array("image/gif", "image/jpeg", "image/jpg", "image/jpeg", "image/x-png", "image/png");
  public static $uploadedFile;
  public static function saveImg($files) {
    print_r($files);
    if (isset($files['file']['name'])) {
      echo "hola";
      print_r($files);
      $extension = strtolower(pathinfo($files['file']['name'], PATHINFO_EXTENSION));
    }

    if (
      isset($files['file']['name']) &&
      ($files["file"]["size"] < self::$maxSize) &&
      in_array($files["file"]["type"], self::$allowedFormat)  &&
      in_array($extension, self::$allowedExts)
    ) {
      echo "hola2";
      if (!$files["file"]["error"] > 0) {
        $filename = $files["file"]["name"];
        $filename = uniqid() . '.' . pathinfo($filename, PATHINFO_EXTENSION);
        if (!file_exists(self::$dirUpload . $filename)) {
          move_uploaded_file($files["file"]["tmp_name"], self::$dirUpload . $filename);
          self::$uploadedFile = $filename;
          return true;
        }
      } else {
        return false;
      }
    } else {
      return false;
    }
  }
}
