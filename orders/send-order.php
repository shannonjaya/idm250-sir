<?php
require_once 'lib/api-client.php';

$order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $order_id) {
    
    $result = send_order($connection, $order_id);
    
    echo "<pre>" . print_r($result, true) . "</pre>";
    exit; // test printing result
}

header("Location: ../index.php?view=orders");
exit;
