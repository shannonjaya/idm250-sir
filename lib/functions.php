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

// GET ALL INVENTORY UNITS

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

// GET INVENTORY UNIT BY ID
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
    "SELECT m.*, COUNT(mi.unit_id) as total_units
        FROM idm250_mpls m
        LEFT JOIN idm250_mpl_items mi ON m.mpl_id = mi.mpl_id
        GROUP BY m.mpl_id"
);
    $stmt->execute();
    $result = $stmt->get_result();
    $mpls = $result->fetch_all(MYSQLI_ASSOC);

    return $mpls;
}

// GET MPL BY ID
function get_mpl($connection, $mpl_id) {
    $stmt = $connection->prepare(
    "SELECT m.*, COUNT(mi.unit_id) as total_units
        FROM idm250_mpls m
        LEFT JOIN idm250_mpl_items mi ON m.mpl_id = mi.mpl_id
        WHERE m.mpl_id = ?
        GROUP BY m.mpl_id"
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
        $stmt->bind_param("ii", $mpl_id, $unit_id);
        $stmt->execute();
    }
}

// DELETE MPL
function delete_mpl($connection, $mpl_id) {
    $stmt = $connection->prepare("DELETE FROM idm250_mpl_items WHERE mpl_id = ?");
    $stmt->bind_param("i", $mpl_id);
    $stmt->execute();
    
    $stmt = $connection->prepare("DELETE FROM idm250_mpls WHERE mpl_id = ? LIMIT 1");
    $stmt->bind_param("i", $mpl_id);
    if ($stmt->execute()) {
        return true;
    }
    return false;
}

// EDIT MPL
function edit_mpl($connection, $mpl_id, $data, $unit_ids) {
    $check = $connection->prepare("SELECT mpl_id FROM idm250_mpls WHERE mpl_id = ? AND status = 'draft'");
    $check->bind_param("i", $mpl_id);
    $check->execute();
    $result = $check->get_result();
    
    if ($result->num_rows === 0) {
        return false;
    }
    

    $stmt = $connection->prepare("UPDATE idm250_mpls SET reference_number = ?, trailer_number = ?, expected_arrival = ? WHERE mpl_id = ? LIMIT 1");
    $stmt->bind_param("sssi", $data['reference_number'], $data['trailer_number'], $data['expected_arrival'], $mpl_id);
    $stmt->execute();
    

    $stmt = $connection->prepare("DELETE FROM idm250_mpl_items WHERE mpl_id = ?");
    $stmt->bind_param("i", $mpl_id);
    $stmt->execute();
    

    $stmt = $connection->prepare("INSERT INTO idm250_mpl_items (mpl_id, unit_id) VALUES (?, ?)");
    foreach ($unit_ids as $unit_id) {
        $unit_id = intval($unit_id);
        $stmt->bind_param("ii", $mpl_id, $unit_id);
        $stmt->execute();
    }
    
    return true;
}

// GET MPL INVENTORY UNITS
function get_mpl_units($connection, $mpl_id) {
    $stmt = $connection->prepare("SELECT unit_id FROM idm250_mpl_items WHERE mpl_id = ?");
    $stmt->bind_param("i", $mpl_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $unit_ids = [];
    while ($row = $result->fetch_assoc()) {
        $unit_ids[] = $row['unit_id'];
    }
    return $unit_ids;
}