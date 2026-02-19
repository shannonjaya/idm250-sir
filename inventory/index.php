<?php
require_once './lib/functions.php';
$inventory = get_all_inventory_units($connection);
?>

<header class="main-header">
    <h1 class="main-heading">Inventory Management</h1>
</header>

<form id="mpl-form" method="post" action="?view=create-mpl">
    <table>
        <thead>
            <tr>
                <th>Unit ID</th>
                <th>SKU</th>
                <th>Description</th>
                <th>UOM</th>
                <th>Location</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($inventory as $unit): ?>
                <tr>
                    <td><?=$unit['unit_id']; ?></td>
                    <td><?=$unit['sku']; ?></td>
                    <td><?=$unit['description']; ?></td>
                    <td>
                        <p class="highlight<?php 
                            if ($unit['uom_primary'] === 'PALLET') { echo "-green"; }
                        ?>">
                            <?=$unit['uom_primary']; ?>
                        </p>
                    </td>
                    <td>
                        <p class="highlight<?php 
                            if ($unit['location'] === 'internal') { echo "-yellow"; }?>">
                            <?=$unit['location']; ?>
                        </p>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</form>
