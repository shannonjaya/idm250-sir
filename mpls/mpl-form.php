<?php require_once './lib/functions.php';

$mpl_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$mpl = $mpl_id ? get_mpl($connection, $mpl_id) : [];

$all_inventory = get_all_inventory_units($connection);

if ($_POST) {
    $selected_units = $_POST['unit_ids'] ?? [];
} else {
    $selected_units = $mpl_id ? get_mpl_units($connection, $mpl_id) : [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reference_number'])) {
    $reference_number = $_POST['reference_number'] ?? "";
    $trailer_number = $_POST['trailer_number'] ?? "";
    $expected_arrival = $_POST['expected_arrival'] ?? "";
    $selected_units = $_POST['unit_ids'] ?? [];

    if (!empty($selected_units) && (!$mpl_id || (!empty($reference_number) && !empty($trailer_number) && !empty($expected_arrival)))) {
        $data = [
            'reference_number' => $reference_number,
            'trailer_number' => $trailer_number,
            'expected_arrival' => $expected_arrival,
            'status' => 'draft'
        ];
        
        if ($mpl_id) {
            edit_mpl($connection, $mpl_id, $data, $selected_units);
        } else {
            create_mpl($connection, $data, $selected_units);
        }
        header("Location: index.php?view=mpls");
        exit;
    }
}
?>

<header class="main-header">
    <h1 class="main-heading"><?php echo $mpl_id ? 'Edit' : 'Create'; ?> Material Packing List</h1>
</header>

<form method="post">

    <fieldset class="row">
        <legend>MPL Details</legend>

        <div class="form-item">
            <label for="reference_number">Reference Number</label>
            <input type="text" id="reference_number" name="reference_number" placeholder="000000" value="<?= ($mpl['reference_number']) ?? ''; ?>" required>
        </div>

        <div class="form-item">
            <label for="trailer_number">Trailer Number</label>
            <input type="text" id="trailer_number" name="trailer_number" placeholder="000000" value="<?= ($mpl['trailer_number']) ?? ''; ?>" required>
        </div>

        <div class="form-item">
            <label for="expected_arrival">Expected Arrival</label>
            <input type="date" id="expected_arrival" name="expected_arrival" value="<?= ($mpl['expected_arrival']) ?? ''; ?>" required>
        </div>
    </fieldset>

    <fieldset class="row">
        <div class="form-item">
            <h2 class="label">Inventory Units</h2>
            <?php if (!empty($all_inventory)): ?>
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
                                <td><input type="checkbox" class="unit-checkbox" name="unit_ids[]" value="<?=$unit['unit_id']; ?>" <?php if (in_array($unit['unit_id'], $selected_units)) echo 'checked'; ?>></td>
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
                    </tbody>
                </table>
            <?php else: ?>
                <p>No inventory units available.</p>
            <?php endif; ?>
        </div>
    </fieldset>

    <div class="btn-wrapper">
        <a href="index.php?view=mpls" class="primary-btn">Cancel</a>
        <button type="submit" class="primary-btn"><?php echo $mpl_id ? 'Update' : 'Create'; ?> MPL</button>
    </div>

</form>
