<?php
 require_once './lib/functions.php';

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
    delete_sku($connection, $id);
}
header("Location: index.php?view=sku");
exit;
