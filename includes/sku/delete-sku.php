<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];

    $stmt = $connection->prepare("DELETE FROM idm250_sku WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../idm250-sir/index.php?view=sku");
    exit;
    }
?>