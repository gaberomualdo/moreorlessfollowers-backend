<?php

include('./auth-token.php');

header("Content-type: application/json");

if(isset($_SERVER['HTTP_X_AUTH_TOKEN']) && $_SERVER['HTTP_X_AUTH_TOKEN'] == $auth_token) {
  // some code used 2021-05-02 from https://github.com/restyler/inwidget/blob/master/imgproxy.php
  $url = isset($_GET['url']) ? $_GET['url'] : null;

  $image_download_path = './images/' . md5($url) . '.jpg';

  if(file_exists($image_download_path)) {
    echo json_encode([ "message" => "Success; image already exists." ]);
    exit(0);
  }
  
  $image_info = getimagesize( $url );
  
  if (stripos($image_info['mime'], 'image/') === false) {
    echo json_encode([ "message" => "Invalid image file." ]);
    exit(0);
  }
  
  header("Content-type: ".$image_info['mime']);
  $image = imagecreatefromjpeg( $url );
  
  $targetPixelCount = 180000;
  if($image_info[0] * $image_info[1] > $targetPixelCount){
    $scaleFactor = ($image_info[0] * $image_info[1] / $targetPixelCount) ** 0.5;
    $image = imagescale($image, round($image_info[0] / $scaleFactor));
  }
  imagejpeg($image, $image_download_path, 20);
  imagedestroy($image);
  echo json_encode([ "message" => "Success." ]);
} else {
  http_response_code(401);
  echo json_encode([ "message" => "Missing or bad authorization token." ]);
}


?>