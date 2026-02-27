<?php
require_once '/lib/api-client.php';
require_once '/lib/log.php';

$mpl_id = isset($_POST['mpl_id']) ? intval($_POST['mpl_id']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $mpl_id) {
    $result = send_mpl($connection, $mpl_id);
    
    if (isset($result['success']) && $result['success']) {
        log_event("MPL {$mpl_id} sent successfully");
        update_mpl_status($connection, $mpl_id, 'sent');
        $_SESSION['toast'] = ['message' => "MPL sent successfully", 'type' => 'success'];
    } else {
        $error_msg = $result['error'] ?? 'Unknown error';
        log_event("MPL {$mpl_id} send failed: " . json_encode($result));
        $_SESSION['toast'] = ['message' => $error_msg, 'type' => 'error'];
    }
}

header("Location: index.php?view=mpls");
exit;
