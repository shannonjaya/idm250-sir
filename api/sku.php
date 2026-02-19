<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once "../lib/db-connect.php";
require_once "../lib/auth.php";
require_once "../lib/functions.php";

check_api_key($env);

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $skus = get_all_skus($connection);

    if ($skus) {
        echo json_encode(['success' => true, 'data' => $skus]);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'SKUs not found']);
    }
}

