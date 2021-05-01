<?php

include('./auth-token.php');

if(isset($_SERVER['HTTP_X_AUTH_TOKEN']) && $_SERVER['HTTP_X_AUTH_TOKEN'] == $auth_token) {
  $new_accounts = json_decode(file_get_contents('php://input'), true);
  file_put_contents('accounts.json', json_encode($new_accounts));
} else {
  http_response_code(401);
  echo json_encode([ "message" => "Missing or bad authorization token." ]);
}

?>