<?php require_once __DIR__ . '/db-connect.php';

// ------FUNCTIONS FOR SKU MANAGEMENT-----//

// GET ALL SKUS
function get_all_skus($connection) {
    $stmt = $connection->prepare("SELECT * FROM idm250_sku");
    $stmt->execute();
    $result = $stmt->get_result();
    $skus = $result->fetch_all(MYSQLI_ASSOC);

    return $skus;
}

// GET SKU BY ID
function get_sku($connection, $id) {
    $stmt = $connection->prepare("SELECT * FROM idm250_sku WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $sku = $result->fetch_assoc();
    
    return $sku;
}

// CREATE SKU
function create_sku ($connection, $sku, $description, $uom_primary, $pieces, $length, $width, $height, $weight) {
    $stmt = $connection->prepare("INSERT INTO idm250_sku (sku, description, uom_primary, pieces, length_inches, width_inches, height_inches, weight_lbs) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssiddd", $sku, $description, $uom_primary, $pieces, $length, $width, $height, $weight);
    if ($stmt->execute()) {
        return $connection->insert_id;
    } else {
        return false;
    }
}

// EDIT SKU
function edit_sku ($connection, $id, $sku, $description, $uom_primary, $pieces, $length, $width, $height, $weight) {
    $stmt = $connection->prepare("UPDATE idm250_sku SET sku = ?, description = ?, uom_primary = ?, pieces = ?, length_inches = ?, width_inches = ?, height_inches = ?, weight_lbs = ? WHERE id = ? LIMIT 1");
    $stmt->bind_param("isssidddi", $sku, $description, $uom_primary, $pieces, $length, $width, $height, $weight, $id);
    if ($stmt->execute()) {
        return true;
    }
    return false;
}

// DELETE SKU
function delete_sku ($connection, $id) {
    $stmt = $connection->prepare("DELETE FROM idm250_sku WHERE id = ? LIMIT 1"); 
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        return true;
    }
    return false;
}

// ------FUNCTIONS FOR INVENTORY MANAGEMENT-----//

// GET ALL INVENTORY UNITS (internal)

function get_all_inventory_units($connection) {
    $sql = "SELECT i.*, s.sku, s.description, s.uom_primary
            FROM idm250_inventory i
            JOIN idm250_sku s ON i.sku_id = s.id
            WHERE i.location = 'internal'";
    
    $stmt = $connection->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $inventory = $result->fetch_all(MYSQLI_ASSOC);
    
    return $inventory;

}

// GET INVENTORY UNIT BY ID (internal)
function get_inventory_unit($connection, $unit_id) {
    $sql = "SELECT i.*, s.sku, s.description, s.uom_primary
            FROM idm250_inventory i
            JOIN idm250_sku s ON i.sku_id = s.id
            WHERE i.location = 'internal' AND i.unit_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $unit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $unit = $result->fetch_assoc();
    
    return $unit;
}

// UPDATE INVENTORY LOCATION
function update_inventory_location($connection, $location, $unit_id) {
    $stmt = $connection->prepare("UPDATE idm250_inventory SET location = ? WHERE unit_id = ?");
    $stmt->bind_param('ss', $location, $unit_id);
    return $stmt->execute();
}

// ------FUNCTIONS FOR MPL MANAGEMENT-----//

// GET ALL MPLS
function get_all_mpls($connection) {
    $stmt = $connection->prepare(
    "SELECT mi.*, i.sku_id, s.sku, s.description
        FROM idm250_mpl_items mi
        JOIN idm250_inventory i ON mi.unit_id = i.unit_id
        JOIN idm250_sku s ON i.sku_id = s.id"
);
    $stmt->execute();
    $result = $stmt->get_result();
    $mpls = $result->fetch_all(MYSQLI_ASSOC);

    return $mpls;
}

// GET MPL BY ID
function get_mpl($connection, $mpl_id) {
    $stmt = $connection->prepare(
    "SELECT mi.*, i.sku_id, s.sku, s.description
        FROM idm250_mpl_items mi
        JOIN idm250_inventory i ON mi.unit_id = i.unit_id
        JOIN idm250_sku s ON i.sku_id = s.id
        WHERE mi.mpl_id = ?"
);
    $stmt->bind_param("i", $mpl_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $mpl = $result->fetch_assoc();
    
    return $mpl;
}

// CREATE MPL
function create_mpl($connection, $data, $unit_ids) {
    $stmt = $connection->prepare("INSERT INTO idm250_mpls (reference_number, trailer_number, expected_arrival, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $data['reference_number'], $data['trailer_number'], $data['expected_arrival'], $data['status']);
    $stmt->execute();
    
    $mpl_id = $connection->insert_id;
    $stmt = $connection->prepare("INSERT INTO idm250_mpl_items (mpl_id, unit_id) VALUES (?, ?)");

    foreach ($unit_ids as $unit_id) {
        $stmt->bind_param('is', $mpl_id, $unit_id);
        $stmt->execute();
    }

}

// EDIT MPL (ADD/REMOVE INVENTORY UNITS)
function edit_mpl($connection, $id, $unit_id) {
    $check = $connection->prepare("SELECT id FROM idm250_mpls WHERE id = ? AND status = 'draft'");
    $check->bind_param('i', $id);
    $check->execute();
    
    $stmt = $connection->prepare("DELETE FROM idm250_mpl_items WHERE mpl_id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();

    $stmt = $connection->prepare("INSERT INTO idm250_mpl_items (mpl_id, unit_id) VALUES (?, ?)");
    $stmt->bind_param('is', $id, $unit_id);
    $stmt->execute();
}

// UPDATE MPL STATUS
function update_mpl_status($connection, $id, $status) {
    $stmt = $connection->prepare("UPDATE idm250_mpls SET status = ? WHERE id = ?"); 
    $stmt->bind_param('si', $status, $id);
    $stmt->execute();
}
