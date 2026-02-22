<?php // RECEIVES ORDER NOTIFS FROM WMS

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
    $order_number = $data['order_number'] ?? '';
    $shipped_at = $data['shipped_at'] ?? '';

    if (empty($action)) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing action']);
        exit;
    }

    if (empty($order_number)) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing order number']);
        exit;
    }

    if (empty($shipped_at)) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing shipped date']);
        exit;
    }

    $order = get_order_by_number($connection, $order_number);

    if (!$order)  {
        http_response_code(404);
        echo json_encode(['error' => 'Order not found']);
        exit;
    }

    // "The CMS API updates its order status to 'confirmed', sets the shipped date, and deletes the units from CMS inventory"

    if ($action === 'ship') { 
        update_order_status($connection, $order_number, 'confirmed');

        update_order_shipped_at($connection, $order_number, $shipped_at);

        $order_items = get_order_items($connection, $order['order_id']);

        foreach ($order_items as $item) {
            delete_inventory_unit($connection, $item['unit_id']);
        }
    }
    echo json_encode([
        'success' => true,
        'action' => $action,
        'order_number' => $order_number,
        'shipped_at' => $shipped_at,
        'units_deleted' => count($order_items)
    ]);
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
}
