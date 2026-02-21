<?php
require_once './lib/functions.php';

$order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $order_id) {
    delete_order($connection, $order_id);
}
header("Location: index.php?view=orders");
exit;
