<?php
require_once 'lib/protect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CA Manufacturing CMS</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="./assets/logo-dark.svg" type="image/svg+xml">
</head>
<body>
    <?php include_once 'lib/db-connect.php'; ?>
    <main class="main-content">
         <?php
            $view = $_GET['view'] ?? 'sku';
            switch ($view) {
                case 'sku':
                    include 'sku/index.php';
                    break;
                case 'create-sku':
                    include 'sku/create-sku.php';
                    break;
                case 'edit-sku':
                    include 'sku/edit-sku.php';
                    break;
                case 'delete-sku':
                    include 'sku/delete-sku.php';
                    break;
                case 'inventory':
                    include 'inventory/index.php';
                    break;
                case 'inventory-warehouse':
                    include 'inventory/warehouse.php';
                    break;
                case 'mpl':
                    include 'mpl/index.php';
                    break;
                case 'create-mpl':
                    include 'mpl/create-mpl.php';
                    break; 
                case 'orders':
                    include 'orders/index.php';
                    break;
                case 'create-order':
                    include 'orders/create-order.php';
                    break;
                default:
                    include 'sku/index.php';
            }
        ?>

    </main>
    <?php include 'includes/sidebar.php'; ?>
    <?php include_once 'lib/db-close.php'; ?>
</body>
</html>
