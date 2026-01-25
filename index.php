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
    <?php include_once 'includes/db.php'; ?>
    <main class="main-content">
         <?php
            $view = $_GET['view'] ?? 'sku';
            switch ($view) {
                case 'sku':
                    include 'includes/sku/index.php';
                    break;
                case 'create-sku':
                    include 'includes/sku/create-sku.php';
                    break;
                case 'edit-sku':
                    include 'includes/sku/edit-sku.php';
                    break;
                case 'delete-sku':
                    include 'includes/sku/delete-sku.php';
                    break;
                case 'inventory':
                    include 'includes/inventory/index.php';
                    break;
                case 'inventory-warehouse':
                    include 'includes/inventory/warehouse.php';
                    break;
                case 'mpl':
                    include 'includes/mpl/index.php';
                    break;
                case 'create-mpl':
                    include 'includes/mpl/create-mpl.php';
                    break; 
                case 'orders':
                    include 'includes/orders/index.php';
                    break;
                case 'create-order':
                    include 'includes/orders/create-order.php';
                    break;
                default:
                    include 'includes/sku/index.php';
            }
        ?>

    </main>
    <?php include 'includes/sidebar.php'; ?>
    <?php include_once 'includes/close-db.php'; ?>
</body>
</html>