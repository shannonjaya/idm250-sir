<?php
require_once 'lib/api-client.php';
require_once 'lib/log.php';

$order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $order_id) {
    $result = send_order($connection, $order_id);
    
    if (isset($result['success']) && $result['success']) {
        log_event("Order {$order_id} sent successfully");
        update_order_status($connection, $order_id, 'sent');
        $_SESSION['toast'] = ['message' => "Order sent successfully", 'type' => 'success'];
    } else {
        $_SESSION['toast'] = ['message' => $result['error'] ?? 'Send failed', 'type' => 'error'];
        log_event("Order {$order_id} send failed: " . ($_SESSION['toast']['message']));
    }
}

header("Location: index.php?view=orders");
exit;