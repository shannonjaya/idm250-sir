<?php

// GET ALL MPLS
function get_all_mpls($connection) {
    $stmt = $connection->prepare("
        SELECT 
            m.*,
            COUNT(mi.id) AS total_units
        FROM idm250_mpls m
        LEFT JOIN idm250_mpl_items mi ON mi.mpl_id = m.id
        GROUP BY m.id
        ORDER BY m.id DESC
    ");
    $stmt->execute();
    $result = $stmt->get_result();
    $mpls = $result->fetch_all(MYSQLI_ASSOC);

    return $mpls;
}

// GET MPL BY ID
function get_mpl($connection, $id) {
    $stmt = $connection->prepare("SELECT * FROM idm250_mpl WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $mpl = $result->fetch_assoc();

    return $mpl;
}

// DELETE MPL (draft only)
function delete_mpl($connection, $id) {

    // confirm it exists + is draft
    $stmt = $connection->prepare("SELECT status FROM idm250_mpl WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $mpl = $result->fetch_assoc();

    if (!$mpl || $mpl['status'] !== 'draft') {
        return false;
    }

    // delete line items first
    $stmt = $connection->prepare("DELETE FROM idm250_mpl_items WHERE mpl_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // delete mpl record
    $stmt = $connection->prepare("DELETE FROM idm250_mpl WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        return true;
    }
    return false;
}
