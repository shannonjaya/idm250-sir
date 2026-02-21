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
    $stmt->bind_param("ssssiddd", $sku, $description, $uom_primary, $pieces, $length, $width, $height, $weight);
    if ($stmt->execute()) {
        return $connection->insert_id;
    } else {
        return false;
    }
}

// EDIT SKU
function edit_sku ($connection, $id, $sku, $description, $uom_primary, $pieces, $length, $width, $height, $weight) {
    $stmt = $connection->prepare("UPDATE idm250_sku SET sku = ?, description = ?, uom_primary = ?, pieces = ?, length_inches = ?, width_inches = ?, height_inches = ?, weight_lbs = ? WHERE id = ? LIMIT 1");
    $stmt->bind_param("ssssidddi", $sku, $description, $uom_primary, $pieces, $length, $width, $height, $weight, $id);
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

// GET MPL UNITS
function get_mpl_units($connection, $mpl_id) {
    $stmt = $connection->prepare("SELECT unit_id FROM idm250_mpl_items WHERE mpl_id = ?");
    $stmt->bind_param("i", $mpl_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $units = [];
    while ($unit = $result->fetch_assoc()) {
        $units[] = $unit['unit_id'];
    }
    return $units;
}

// GET MPL DATA FOR API (HEADER + ITEMS)
function get_mpl_data($connection, $mpl_id) {
    $stmt = $connection->prepare(
        "SELECT m.*, mi.*, i.*, s.*
        FROM idm250_mpls m
        JOIN idm250_mpl_items mi ON m.mpl_id = mi.mpl_id
        JOIN idm250_inventory i ON mi.unit_id = i.unit_id
        JOIN idm250_sku s ON i.sku_id = s.id
        WHERE m.mpl_id = ?"
    );
    $stmt->bind_param("i", $mpl_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_all(MYSQLI_ASSOC);
}

// UPDATE MPL STATUS
function update_mpl_status($connection, $mpl_id, $status) {
    $stmt = $connection->prepare("UPDATE idm250_mpls SET status = ? WHERE mpl_id = ? LIMIT 1");
    $stmt->bind_param("si", $status, $mpl_id);
    return $stmt->execute();
}

// ------FUNCTIONS FOR ORDER MANAGEMENT-----//

// GET ALL ORDERS
function get_all_orders($connection) {
    $stmt = $connection->prepare("SELECT * FROM idm250_orders");
    $stmt->execute();
    $result = $stmt->get_result();
    $orders = $result->fetch_all(MYSQLI_ASSOC);

    return $orders;
}

// CREATE ORDER
function create_order($connection, $data, $unit_ids) {
    $stmt = $connection->prepare("INSERT INTO idm250_orders (order_number, ship_to_company, ship_to_street, ship_to_city, ship_to_state, ship_to_zip, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $data['order_number'], $data['ship_to_company'], $data['ship_to_street'], $data['ship_to_city'], $data['ship_to_state'], $data['ship_to_zip'], $data['status']);
    $stmt->execute();
    
    $order_id = $connection->insert_id;
    $stmt = $connection->prepare("INSERT INTO idm250_order_items (order_id, unit_id) VALUES (?, ?)");

    foreach ($unit_ids as $unit_id) {
        $stmt->bind_param("ii", $order_id, $unit_id);
        $stmt->execute();
    }
}

function delete_order($connection, $order_id) {
    $stmt = $connection->prepare("DELETE FROM idm250_order_items WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    
    $stmt = $connection->prepare("DELETE FROM idm250_orders WHERE order_id = ? LIMIT 1");
    $stmt->bind_param("i", $order_id);
    if ($stmt->execute()) {
        return true;
    }
    return false;
}

function edit_order($connection, $order_id, $data, $unit_ids) {
    $check = $connection->prepare("SELECT order_id FROM idm250_orders WHERE order_id = ? AND status = 'draft'");
    $check->bind_param("i", $order_id);
    $check->execute();
    $result = $check->get_result();
    
    if ($result->num_rows === 0) {
        return false;
    }
    

    $stmt = $connection->prepare("UPDATE idm250_orders SET order_number = ?, ship_to_company = ?, ship_to_street = ?, ship_to_city = ?, ship_to_state = ?, ship_to_zip = ? WHERE order_id = ? LIMIT 1");
    $stmt->bind_param("ssssssi", $data['order_number'], $data['ship_to_company'], $data['ship_to_street'], $data['ship_to_city'], $data['ship_to_state'], $data['ship_to_zip'], $order_id);
    $stmt->execute();
    

    $stmt = $connection->prepare("DELETE FROM idm250_order_items WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    

    $stmt = $connection->prepare("INSERT INTO idm250_order_items (order_id, unit_id) VALUES (?, ?)");
    foreach ($unit_ids as $unit_id) {
        $unit_id = intval($unit_id);
        $stmt->bind_param("ii", $order_id, $unit_id);
        $stmt->execute();
    }
    
    return true;
}