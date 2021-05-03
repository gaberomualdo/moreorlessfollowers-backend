<?php

include('./auth-token.php');

if(isset($_SERVER['HTTP_X_AUTH_TOKEN']) && $_SERVER['HTTP_X_AUTH_TOKEN'] == $auth_token) {
  $images_to_keep = json_decode(file_get_contents('php://input'), true);
  $image_filenames_to_keep = [];
  foreach ($images_to_keep as $url) {
    array_push($image_filenames_to_keep, md5($url) . '.jpg');
  }

  $path = "./images/";
  if ($handle = opendir($path)) {
    while (false !== ($file = readdir($handle))) {
      if ('.' === $file) continue;
      if ('..' === $file) continue;
      if (in_array($file, $image_filenames_to_keep)) continue;
      unlink('./images/' . $file);
    }
    closedir($handle);
  }
  echo json_encode([ "message" => "Success." ]);
} else {
  http_response_code(401);
  echo json_encode([ "message" => "Missing or bad authorization token." ]);
}

?>