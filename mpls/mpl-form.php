<?php
require_once './lib/inventory.php';

$selected_units = $_POST['unit_ids'] ?? [];
$units = [];

// FETCH SELECTED INVENTORY UNITS (for display)
if (!empty($selected_units)) {
    $placeholders = implode(',', array_fill(0, count($selected_units), '?'));
    $types = str_repeat('i', count($selected_units));

    $stmt = $connection->prepare("SELECT * FROM idm250_inventory WHERE id IN ($placeholders)");
    $stmt->bind_param($types, ...$selected_units);
    $stmt->execute();

    $result = $stmt->get_result();
    $units = $result->fetch_all(MYSQLI_ASSOC);
}

// HANDLE FORM SUBMIT (CREATE MPL + LINE ITEMS)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reference_number'])) {
    $reference_number = $_POST['reference_number'] ?? "";
    $trailer_number = $_POST['trailer_number'] ?? "";
    $expected_arrival_date = $_POST['expected_arrival_date'] ?? "";
    $selected_units = $_POST['unit_ids'] ?? [];

    if (!empty($reference_number) && !empty($trailer_number) && !empty($expected_arrival_date) && !empty($selected_units)) {

        // INSERT MPL RECORD
        $stmt = $connection->prepare("INSERT INTO idm250_mpl (reference_number, trailer_number, expected_arrival_date, status) VALUES (?, ?, ?, 'draft')");
        $stmt->bind_param("sss", $reference_number, $trailer_number, $expected_arrival_date);

        if ($stmt->execute()) {
            $mpl_id = $connection->insert_id;

            // INSERT MPL LINE ITEMS
            $stmt_items = $connection->prepare("INSERT INTO idm250_mpl_items (mpl_id, inventory_id) VALUES (?, ?)");
            foreach($selected_units as $inventory_id) {
                $inventory_id = intval($inventory_id);
                $stmt_items->bind_param("ii", $mpl_id, $inventory_id);
                $stmt_items->execute();
            }

            header("Location: index.php?view=mpl");
            exit;
        }
    }
}
?>

<header class="main-header">
    <h1 class="main-heading">Create Material Packing List</h1>
</header>

<?php if (!empty($units)): ?>

    <form method="post">

        <fieldset class="row">
            <legend>MPL Details</legend>

            <div class="form-item">
                <label for="reference_number">Reference #</label>
                <input type="text" id="reference_number" name="reference_number" placeholder="REF-0001" required>
            </div>

            <div class="form-item">
                <label for="trailer_number">Trailer Number</label>
                <input type="text" id="trailer_number" name="trailer_number" placeholder="TR-0001" required>
            </div>

            <div class="form-item">
                <label for="expected_arrival_date">Expected Arrival</label>
                <input type="date" id="expected_arrival_date" name="expected_arrival_date" required>
            </div>
        </fieldset>

        <?php foreach($selected_units as $id): ?>
            <input type="hidden" name="unit_ids[]" value="<?=$id; ?>">
        <?php endforeach; ?>

        <table>
            <thead>
                <tr>
                    <th>Unit ID</th>
                    <th>SKU</th>
                    <th>Description</th>
                    <th>UOM</th>
                    <th>Date Received</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($units as $unit): ?>
                    <tr>
                        <td><?=$unit['unit_id']; ?></td>
                        <td><?=$unit['sku']; ?></td>
                        <td><?=$unit['description']; ?></td>
                        <td>
                            <p class="highlight<?php 
                                if ($unit['uom'] === 'PALLET') { echo "-green"; } 
                                elseif ($unit['uom'] === 'BUNDLE') { echo "-blue"; }
                                elseif ($unit['uom'] === 'PC') { echo "-gray"; }
                            ?>">
                                <?= $unit['uom'] === 'PC' ? 'PIECE' : $unit['uom']; ?>
                            </p>
                        </td>
                        <td><?=$unit['date_received']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="btn-wrapper">
            <button type="submit" class="primary-btn">Save MPL (Draft)</button>
        </div>

    </form>

<?php else: ?>
    <p>No inventory units selected.</p>
<?php endif; ?>
