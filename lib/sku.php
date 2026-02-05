<?php

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
function create_sku ($connection, $ficha, $sku, $description, $uom, $pieces, $length, $width, $height, $weight) {
    $stmt = $connection->prepare("INSERT INTO idm250_sku (ficha, sku, description, uom, pieces, length_inches, width_inches, height_inches, weight_lbs) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssidddd", $ficha, $sku, $description, $uom, $pieces, $length, $width, $height, $weight);
    if ($stmt->execute()) {
        return $connection->insert_id;
    } else {
        return false;
    }
}

// EDIT SKU
function edit_sku ($connection, $id, $ficha, $sku, $description, $uom, $pieces, $length, $width, $height, $weight) {
    $stmt = $connection->prepare("UPDATE idm250_sku SET ficha = ?, sku = ?, description = ?, uom = ?, pieces = ?, length_inches = ?, width_inches = ?, height_inches = ?, weight_lbs = ? WHERE id = ? LIMIT 1");
    $stmt->bind_param("isssiddddi", $ficha, $sku, $description, $uom, $pieces, $length, $width, $height, $weight, $id);
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

