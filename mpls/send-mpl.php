<?php
require_once 'lib/api-client.php';

$mpl_id = isset($_POST['mpl_id']) ? intval($_POST['mpl_id']) : 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $mpl_id) { 
    
    $result = send_mpl($connection, $mpl_id);
    
    echo "<pre>" . print_r($result, true) . "</pre>";
    exit; // test printing result
}

header("Location: ../index.php?view=mpls");
exit;
