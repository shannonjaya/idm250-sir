<?php

require_once 'lib/protect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> SIR Manufacturing CMS</title>
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
                case 'sku-form':
                    include 'sku/sku-form.php';
                    break;
                case 'delete-sku':
                    include 'sku/delete-sku.php';
                    break;
                case 'sku-demo':
                    include 'sku-demo.php';
                    break;
                case 'inventory':
                    include 'inventory/index.php';
                    break;
                case 'warehouse':
                    include 'inventory/warehouse.php';
                    break;
                case 'mpls':
                    include 'mpls/index.php';
                    break;
                case 'mpl-form':
                    include 'mpls/mpl-form.php';
                    break;
                case 'delete-mpl':
                    include 'mpls/delete-mpl.php';
                    break;
                case 'send-mpl':
                    include 'mpls/send-mpl.php';
                    break;
                case 'orders':
                    include 'orders/index.php';
                    break;
                case 'order-form':
                    include 'orders/order-form.php';
                    break;
                case 'delete-order':
                    include 'orders/delete-order.php';
                    break;
                case 'send-order':
                    include 'orders/send-order.php';
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
