
<?php
require_once 'dbConfig.php';

// Get all customers from the database
function getAllCustomers($pdo) {
    $sql = "SELECT * FROM customers ORDER BY customer_id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get one customer using their ID
function getCustomerByID($pdo, $customer_id) {
    $sql = "SELECT * FROM customers WHERE customer_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$customer_id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Add a new customer
function insertCustomer($pdo, $customer_name, $contact_number) {
    $sql = "INSERT INTO customers (customer_name, contact_number)
            VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$customer_name, $contact_number]);
}

// Update customer information
function updateCustomer($pdo, $customer_id, $customer_name, $contact_number) {
    $sql = "UPDATE customers
            SET customer_name = ?, contact_number = ?
            WHERE customer_id = ?";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        $customer_name,
        $contact_number,
        $customer_id
    ]);
}

// Delete a customer
function deleteCustomer($pdo, $customer_id) {
    $sql = "DELETE FROM customers WHERE customer_id = ?";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$customer_id]);
}

// Get the rental records of a selected customer
function getRentalsByCustomer($pdo, $customer_id) {
    $sql = "SELECT * FROM rental_records
            WHERE customer_id = ?
            ORDER BY rental_id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$customer_id]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get one rental record
function getRentalByID($pdo, $rental_id) {
    $sql = "SELECT * FROM rental_records WHERE rental_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$rental_id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Add a rental record for a customer
function insertRental($pdo, $customer_id, $dress_name, $rental_date,
                      $return_date, $rental_fee, $status) {
    $sql = "INSERT INTO rental_records
            (customer_id, dress_name, rental_date, return_date, rental_fee, status)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        $customer_id,
        $dress_name,
        $rental_date,
        $return_date,
        $rental_fee,
        $status
    ]);
}

// Update a rental record
function updateRental($pdo, $rental_id, $dress_name, $rental_date,
                      $return_date, $rental_fee, $status) {
    $sql = "UPDATE rental_records
            SET dress_name = ?, rental_date = ?, return_date = ?,
                rental_fee = ?, status = ?
            WHERE rental_id = ?";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        $dress_name,
        $rental_date,
        $return_date,
        $rental_fee,
        $status,
        $rental_id
    ]);
}

// Delete a rental record
function deleteRental($pdo, $rental_id) {
    $sql = "DELETE FROM rental_records WHERE rental_id = ?";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$rental_id]);
}
?>
