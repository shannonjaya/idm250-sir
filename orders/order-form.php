<?php require_once './lib/functions.php';

$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$order = $order_id ? get_order($connection, $order_id) : [];

$all_inventory = get_all_inventory_units($connection);

if ($_POST) {
    $selected_units = $_POST['unit_ids'] ?? [];
} else {
    $selected_units = $order_id ? get_order_units($connection, $order_id) : [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_number = $_POST['order_number'] ?? "";
    $ship_to_company = $_POST['ship_to_company'] ?? "";
    $ship_to_street = $_POST['ship_to_street'] ?? "";
    $ship_to_city = $_POST['ship_to_city'] ?? "";
    $ship_to_state = $_POST['ship_to_state'] ?? "";
    $ship_to_zip = $_POST['ship_to_zip'] ?? "";

    if (!empty($order_number) && !empty($ship_to_company) && !empty($ship_to_street) && !empty($ship_to_city) && !empty($ship_to_state) && !empty($ship_to_zip)) {
        if (empty($selected_units)) {
            $unit_error = "Please select at least one warehouse unit.";
        } else {
            $data = [
                'order_number' => $order_number,
                'ship_to_company' => $ship_to_company,
                'ship_to_street' => $ship_to_street,
                'ship_to_city' => $ship_to_city,
                'ship_to_state' => $ship_to_state,
                'ship_to_zip' => $ship_to_zip,
                'status' => 'draft'
            ];
            
            try {
            if ($order_id) {
                edit_order($connection, $order_id, $data, $selected_units);
                } else {
                    create_order($connection, $data, $selected_units);
                }
                } catch (mysqli_sql_exception $e) { // ref must be unique
                    if ($e->getCode() === 1062) {
                        $order_error = "That order number already exists.";
                        } else {
                            throw $e;
                        }
                }
            }
            if (!isset($order_error) && !isset($unit_error)) {
                header("Location: index.php?view=orders");
                exit;
            }
        }
    }
?>

<header class="main-header">
    <h1 class="main-heading"><?php echo $order_id ? 'Edit' : 'Create'; ?> Order</h1>
</header>

<form method="post">

    <fieldset class="row">
        <legend>Order Details</legend>

        <div class="form-item">
            <label for="order_number">Order Number</label>
            <input type="number" id="order_number" name="order_number" placeholder="000000" value="<?= ($order['order_number']) ?? ''; ?>" required>
            <?php if (isset($order_error)): ?>
                <p class="error"><?= htmlspecialchars($order_error) ?></p>
            <?php endif; ?>
        </div>
         <div class="form-item">
            <label for="ship_to_company">Company</label>
            <input type="text" id="ship_to_company" name="ship_to_company" placeholder="Enter company name" value="<?= ($order['ship_to_company']) ?? ''; ?>" required>
        </div>
    </fieldset>

    <fieldset class="row">
        <div class="form-item">
            <label for="ship_to_street">Street</label>
            <input type="text" id="ship_to_street" name="ship_to_street" placeholder="Enter street address" value="<?= ($order['ship_to_street']) ?? ''; ?>" required>
        </div>

        <div class="form-item">
             <label for="ship_to_city">City</label>
            <input type="text" id="ship_to_city" name="ship_to_city" placeholder="Enter city" value="<?= ($order['ship_to_city']) ?? ''; ?>" required>
        </div>
        <div class="form-item">
             <label for="ship_to_state">State</label>
            <input type="text" id="ship_to_state" name="ship_to_state" placeholder="Enter state" value="<?= ($order['ship_to_state']) ?? ''; ?>" required>
        </div>
        <div class="form-item">
             <label for="ship_to_zip">Zip Code</label>
            <input type="text" id="ship_to_zip" name="ship_to_zip" placeholder="Enter zip code" value="<?= ($order['ship_to_zip']) ?? ''; ?>" required>
        </div>
    </fieldset>


    <fieldset class="row">
        <div class="form-item">
            <h2 class="label">Available Warehouse Units <?php if (isset($unit_error)): ?>
                <p class="error"><?= htmlspecialchars($unit_error) ?></p>
            <?php endif; ?></h2>
                <table class="select-inventory-unit-table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all" onchange="document.querySelectorAll('.unit-checkbox').forEach(c => c.checked = this.checked)"></th>
                            <th>Unit ID</th>
                            <th>SKU</th>
                            <th>Description</th>
                            <th>UOM</th>
                            <th>Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($all_inventory as $unit): ?>
                            <tr>
                                <td><input type="checkbox" class="unit-checkbox" name="unit_ids[]" value="<?=$unit['unit_id']; ?>" <?php if (in_array($unit['unit_id'], $selected_units)) { echo 'checked'; } ?>></td>
                                <td><?=$unit['unit_id']; ?></td>
                                <td><?=$unit['sku']; ?></td>
                                <td><?=$unit['description']; ?></td>
                                <td>
                                    <p class="highlight<?php
                                        if ($unit['uom_primary'] === 'PALLET') { echo "-green"; }?>">
                                        <?= $unit['uom_primary']?>
                                    </p>
                                </td>
                                <td>
                                    <p class="highlight<?php
                                    if ($unit['location'] === 'internal') { echo "-yellow"; }?>">
                                    <?=$unit['location']; ?>
                            </p></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($inventory)): ?>
                            <tr>
                                <td colspan="5" class="empty-table" style="padding: 2rem;">
                                    <svg width="72" height="72" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <mask id="mask0_119_89" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="72" height="72">
                                            <rect width="72" height="72" fill="currentColor"/>
                                        </mask>
                                        <g mask="url(#mask0_119_89)">
                                            <path d="M15 12V30.9983V30.9233V60V12ZM16.8465 63C15.4655 63 14.3125 62.5375 13.3875 61.6125C12.4625 60.6875 12 59.5345 12 58.1535V13.8465C12 12.4655 12.4625 11.3125 13.3875 10.3875C14.3125 9.4625 15.4655 9 16.8465 9H38.4863C39.1498 9 39.782 9.13075 40.383 9.39225C40.984 9.65375 41.5018 10.0018 41.9363 10.4363L52.5638 21.0637C52.9983 21.4982 53.3463 22.016 53.6078 22.617C53.8693 23.218 54 23.8502 54 24.5137V30.5363C54 30.9673 53.856 31.3223 53.568 31.6013C53.28 31.8798 52.9233 32.019 52.4978 32.019C52.0723 32.019 51.7163 31.8753 51.4298 31.5878C51.1433 31.3003 51 30.944 51 30.519V24H41.3993C40.7188 24 40.1488 23.77 39.6893 23.31C39.2298 22.85 39 22.28 39 21.6V12H16.8465C16.3845 12 15.9613 12.1923 15.5768 12.5768C15.1923 12.9613 15 13.3845 15 13.8465V58.1535C15 58.6155 15.1923 59.0388 15.5768 59.4233C15.9613 59.8078 16.3845 60 16.8465 60H32.481C32.906 60 33.2623 60.144 33.5498 60.432C33.8373 60.72 33.981 61.0768 33.981 61.5023C33.981 61.9278 33.8373 62.2838 33.5498 62.5703C33.2623 62.8568 32.906 63 32.481 63H16.8465ZM55.4888 55.4768C57.1118 53.8463 57.9233 51.8503 57.9233 49.4888C57.9233 47.1273 57.1078 45.1348 55.4768 43.5113C53.8463 41.8883 51.8503 41.0768 49.4888 41.0768C47.1273 41.0768 45.1348 41.8923 43.5113 43.5233C41.8883 45.1538 41.0768 47.1498 41.0768 49.5113C41.0768 51.8728 41.8923 53.8653 43.5233 55.4888C45.1538 57.1118 47.1498 57.9233 49.5113 57.9233C51.8728 57.9233 53.8653 57.1078 55.4888 55.4768ZM64.8038 66.2828C64.3743 66.2828 64.0193 66.1423 63.7388 65.8613L56.469 58.5345C55.496 59.3115 54.4163 59.9038 53.2298 60.3113C52.0433 60.7193 50.8 60.9233 49.5 60.9233C46.327 60.9233 43.63 59.8125 41.409 57.591C39.1875 55.37 38.0768 52.673 38.0768 49.5C38.0768 46.327 39.1875 43.63 41.409 41.409C43.63 39.1875 46.327 38.0768 49.5 38.0768C52.673 38.0768 55.37 39.1875 57.591 41.409C59.8125 43.63 60.9233 46.327 60.9233 49.5C60.9233 50.8 60.7193 52.0433 60.3113 53.2298C59.9038 54.4163 59.3115 55.496 58.5345 56.469L65.8613 63.7388C66.1423 64.0158 66.2828 64.3688 66.2828 64.7978C66.2828 65.2263 66.1438 65.5808 65.8658 65.8613C65.5878 66.1423 65.2338 66.2828 64.8038 66.2828Z" fill="currentColor"/>
                                        </g>
                                    </svg>
                                    <p>No warehouse units available.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
        </div>
    </fieldset>

    <div class="btn-wrapper">
        <a href="index.php?view=mpls" class="primary-btn">Cancel</a>
        <button type="submit" class="primary-btn"><?php echo $order_id ? 'Update' : 'Create'; ?> Order</button>
    </div>

</form>
