<?php
 require_once './lib/sku.php';

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
if ($id) {
    delete_sku($connection, $id);
}
header("Location: ../idm250-sir/index.php?view=sku");
exit;

 