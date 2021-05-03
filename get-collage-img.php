<?php

$accounts = json_decode(file_get_contents('./accounts.json'), true);
$imgsidelen = 424;
$sidelen = 4;
$img = imagecreate($sidelen * $imgsidelen, $sidelen * $imgsidelen);
$img = imagecreatetruecolor($sidelen * $imgsidelen, $sidelen * $imgsidelen);
$bg = imagecolorallocate ( $img, 255, 255, 255 );
imagefilledrectangle($img,0,0,$sidelen * $imgsidelen, $sidelen * $imgsidelen,$bg);

$n = 0;
foreach($accounts as $account) {
  if($n >= $sidelen * $sidelen) {
    break;
  }
  $img_path = './images/' . md5($account['pictureURL']) . '.jpg';
  if(file_exists($img_path)) {
    list($width, $height) = getimagesize($img_path);
    if($width >= $imgsidelen && $height >= $imgsidelen) {
      $account_img = imagecreatefromjpeg($img_path);
      imagecopy($img, $account_img, ($n % $sidelen) * $imgsidelen, (floor($n / $sidelen)) * $imgsidelen,0,0,$imgsidelen, $imgsidelen);
      imagedestroy($account_img);
      $n++;
    }
  }
}
$final_size = 500;
$img = imagescale ($img, $final_size, $final_size);
header("Content-type: image/jpeg");
imagejpeg($img);
imagedestroy($img);

?>