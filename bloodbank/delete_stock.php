<?php
session_start();

// Check if the user is logged in and in the correct center
if (!isset($_SESSION['center_id'])) {
    // Redirect to the login page if the user is not logged in or does not have a center ID
    header('Location: login.php');
    exit();
}

// Database connection
$host = 'localhost';
$dbname = 'bloodbank';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_stock_id']) && isset($_POST['stock_quantity'])) {
        // Get stock ID and quantity from the form
        $stock_id = $_POST['delete_stock_id'];
        $stock_quantity = $_POST['stock_quantity'];
        $center_id = $_SESSION['center_id'];  // ID of the logged-in center

        // Query for the stock ID, quantity, and center ID in the database
        $query = "SELECT stockBl_qnty FROM Stock WHERE stock_id = :stock_id AND center_ID = :center_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':stock_id', $stock_id);
        $stmt->bindParam(':center_id', $center_id);
        $stmt->execute();
        $stock = $stmt->fetch(PDO::FETCH_ASSOC);

        // If stock exists and the quantity is sufficient, perform the deletion operation
        if ($stock && $stock['stockBl_qnty'] >= $stock_quantity) {
            $newQuantity = $stock['stockBl_qnty'] - $stock_quantity;
            if ($newQuantity > 0) {
                // Update quantity
                $updateQuery = "UPDATE Stock SET stockBl_qnty = :newQuantity WHERE stock_id = :stock_id AND center_ID = :center_id";
                $updateStmt = $pdo->prepare($updateQuery);
                $updateStmt->bindParam(':newQuantity', $newQuantity);
                $updateStmt->bindParam(':stock_id', $stock_id);
                $updateStmt->bindParam(':center_id', $center_id);
                $updateStmt->execute();
            } else {
                // Delete all stock
                $deleteQuery = "DELETE FROM Stock WHERE stock_id = :stock_id AND center_ID = :center_id";
                $deleteStmt = $pdo->prepare($deleteQuery);
                $deleteStmt->bindParam(':stock_id', $stock_id);
                $deleteStmt->bindParam(':center_id', $center_id);
                $deleteStmt->execute();
            }

            // Redirect the user if the operation is successful
            header('Location: welcome.php');
        } else {
            // Display error message if stock is insufficient or not found
            die("Insufficient stock quantity or stock not found.");
        }
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
