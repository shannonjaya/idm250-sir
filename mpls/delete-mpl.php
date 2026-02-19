<?php
require_once './lib/functions.php';

$mpl_id = isset($_POST['mpl_id']) ? intval($_POST['mpl_id']) : 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $mpl_id) {
    delete_mpl($connection, $mpl_id);
}
header("Location: ../idm250-sir/index.php?view=mpls");
exit;
