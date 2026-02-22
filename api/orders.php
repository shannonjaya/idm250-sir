<?php // TEMPORARY TEST FILE

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

    $order_number = $data['order_number'] ?? '';
    $items = $data['items'] ?? [];

    if (empty($order_number)) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing order number']);
        exit;
    }

    if (empty($items)) {
        http_response_code(400);
        echo json_encode(['error' => 'No units selected']);
        exit;
    }

    echo json_encode([
        'success' => true,
        'message' => 'Order received',
        'order_number' => $order_number,
        'items' => $items
    ]);
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
}

