
<?php
// Connect to the database and load the functions
require_once 'core/models.php';

// Check if a valid customer ID was provided
if (!isset($_GET['customer_id']) || !is_numeric($_GET['customer_id'])) {
    header("Location: index.php");
    exit();
}

// Get the selected customer's information
$customer_id = (int) $_GET['customer_id'];
$customer = getCustomerByID($pdo, $customer_id);

// Return to the customer list if the customer does not exist
if (!$customer) {
    header("Location: index.php");
    exit();
}

// Get all rental records belonging to this customer
$rentals = getRentalsByCustomer($pdo, $customer_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Rentals</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <header>
        <h1>Customer Rentals</h1>
        <p>Rental records for <?php echo htmlspecialchars($customer['customer_name']); ?></p>
    </header>

    <section class="form-card">
        <h2>Add Rental Record</h2>

        <!-- Form for adding a rental under the selected customer -->
        <form action="core/handleForms.php" method="POST">

            <!-- Pass the customer ID to the form handler -->
            <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">

            <label for="dress_name">Dress Name</label>
            <input type="text" id="dress_name" name="dress_name" required>

            <label for="rental_date">Rental Date</label>
            <input type="date" id="rental_date" name="rental_date" required>

            <label for="return_date">Return Date</label>
            <input type="date" id="return_date" name="return_date" required>

            <label for="rental_fee">Rental Fee (₱)</label>
            <input type="number" id="rental_fee" name="rental_fee" min="0" step="0.01" required>

            <label for="status">Status</label>
            <select id="status" name="status" required>
                <option value="Rented">Rented</option>
                <option value="Returned">Returned</option>
                <option value="Overdue">Overdue</option>
            </select>

            <!-- Submit the new rental record -->
            <button type="submit" name="insertRentalBtn">Add Rental</button>
        </form>
    </section>

    <section class="table-card">
        <h2>Rental Records</h2>

        <?php if (count($rentals) > 0) { ?>
            <!-- Display the customer's rental records in a table -->
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Rental ID</th>
                            <th>Dress Name</th>
                            <th>Rental Date</th>
                            <th>Return Date</th>
                            <th>Rental Fee</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rentals as $rental) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($rental['rental_id']); ?></td>
                                <td><?php echo htmlspecialchars($rental['dress_name']); ?></td>
                                <td><?php echo htmlspecialchars($rental['rental_date']); ?></td>
                                <td><?php echo htmlspecialchars($rental['return_date']); ?></td>
                                <td>₱<?php echo number_format((float) $rental['rental_fee'], 2); ?></td>
                                <td><?php echo htmlspecialchars($rental['status']); ?></td>
                                <td class="actions">

                                    <!-- Open the page for editing this rental -->
                                    <a class="edit-btn" href="editrental.php?rental_id=<?php echo $rental['rental_id']; ?>">
                                        Edit
                                    </a>

                                    <!-- Open the page for deleting this rental -->
                                    <a class="delete-btn" href="deleterental.php?rental_id=<?php echo $rental['rental_id']; ?>&customer_id=<?php echo $customer_id; ?>">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>

            <!-- Show a message when the customer has no rentals yet -->
            <p class="empty-message">No rental records yet. Add the customer's first rental above.</p>

        <?php } ?>
    </section>

    <!-- Return to the main customer list -->
    <p><a class="view-btn" href="index.php">← Back to Customer List</a></p>
</div>

</body>
</html>
