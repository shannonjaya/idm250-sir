<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');  // allows everyone access to this route

require_once "../api/db-connect.php";
require_once "../api/auth.php";

check_api_key($env); // checks api key

$method = $_SERVER['REQUEST_METHOD'];
$id = intval($_GET['id']); // extracting id from url

if (!isset($_GET['id'])) {
    http_response_code(400); // if there is no id throw an error
    echo json_encode(['error' => 'Bad Request', 'details' => 'Missing SKU ID']);
    exit;
}

if ($method === 'GET') { // get sku by id

    $stmt = $connection->prepare("SELECT * FROM idm250_sku WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result(); // get the result of executing
    $sku = $result->fetch_assoc(); // the result stored as an associative array
    $stmt->close();

    if ($sku) {
        echo json_encode(['success' => true, 'data' => $sku]); //send it back
    } else { //if we did not find a sku with that id
        http_response_code(404); // not found
        echo json_encode(['error' => 'SKU not found']);
    }
}



