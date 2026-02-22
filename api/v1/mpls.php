<?php // RECEIVES MPL NOTIFS FROM WMS

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

    $mpl = get_mpl_by_reference($connection, $reference_number);

    if (!$mpl)  {
        http_response_code(404);
        echo json_encode(['error' => 'MPL not found']);
        exit;
    }

    // "The CMS API updates its MPL status to 'confirmed' and moves each unit's location to 'warehouse'"

    if ($action === 'confirm') {
        update_mpl_status($connection, $reference_number, 'confirmed');

        $unit_ids = get_mpl_units($connection, $mpl['mpl_id']);

        foreach ($unit_ids as $unit_id) {
            update_inventory_location($connection, 'warehouse', $unit_id);
        }

        http_response_code(200);
        echo json_encode([
            'success' => true,
            'action' => $action,
            'reference_number' => $reference_number,
            'units_updated' => count($unit_ids)
        ]);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid action']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
}

