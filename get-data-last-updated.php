<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

$last_updated = date(DATE_ATOM, filemtime('accounts.json'));
echo json_encode(["lastUpdated" => $last_updated]);

?>