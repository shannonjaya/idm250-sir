<?php

ob_start();

define('API_REQUEST', true);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-API-Key');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once "../lib/db-connect.php";
require_once "../lib/auth.php";
require_once "../lib/functions.php";

ob_end_clean();

check_api_key($env);

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $raw_input = file_get_contents('php://input');

    $data = json_decode($raw_input, true);

    $action = $data['action'] ?? '';
    $reference_number = $data['reference_number'] ?? '';

    if (empty($action)) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing action']);
        exit;
    }

    if (empty($reference_number)) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing reference number']);
        exit;
    }

    echo json_encode([
        'action' => $action,
        'reference_number' => $reference_number
    ]);
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
}

