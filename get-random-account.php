<?php

$EXCLUDED_IDS_PARAM = "excluded-ids";
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

# get data
$accounts = json_decode(file_get_contents("accounts.json"), true);

# get list of excluded IDs
$excluded = [];
if(isset($_GET) && isset($_GET[$EXCLUDED_IDS_PARAM])) {
  $excluded = explode(',', $_GET[$EXCLUDED_IDS_PARAM]);
}

# make sure not every account is excluded
if(count($excluded) >= count($accounts)) {
  http_response_code(400);
  echo json_encode([ "message" => "Too many excluded IDs.", "code" => "too-many-excluded" ]);
} else {
  # get random account and return
  $account = [];
  do {
    $account = $accounts[array_rand($accounts, 1)];
  } while (in_array($account["id"], $excluded));
  echo json_encode($account);
}

?>