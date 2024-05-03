<?php
session_start();

// Database connection
$host = 'localhost';
$dbname = 'bloodbank';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Check the data from the form and if center_id exists in session
    if (isset($_SESSION['center_id']) && isset($_POST['stockBl_group']) && isset($_POST['stockBl_qnty'])) {
        $stockBl_group = $_POST['stockBl_group'];
        $stockBl_qnty = $_POST['stockBl_qnty'];
        $center_id = $_SESSION['center_id']; // ID of the logged-in center

        // Check if the blood group exists for this center in the database
        $query = "SELECT * FROM Stock WHERE stockBl_group = :stockBl_group AND center_ID = :center_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':stockBl_group', $stockBl_group);
        $stmt->bindParam(':center_id', $center_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // If the blood group already exists, update the stock quantity
        if ($result) {
            $newQuantity = $result['stockBl_qnty'] + $stockBl_qnty;
            $updateQuery = "UPDATE Stock SET stockBl_qnty = :stockBl_qnty WHERE stockBl_group = :stockBl_group AND center_ID = :center_id";
            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->bindParam(':stockBl_qnty', $newQuantity);
            $updateStmt->bindParam(':stockBl_group', $stockBl_group);
            $updateStmt->bindParam(':center_id', $center_id);
            $updateStmt->execute();
        } else {
            // If the blood group doesn't exist, insert a new record
            $insertQuery = "INSERT INTO Stock (center_ID, stockBl_group, stockBl_qnty) VALUES (:center_id, :stockBl_group, :stockBl_qnty)";
            $insertStmt = $pdo->prepare($insertQuery);
            $insertStmt->bindParam(':center_id', $center_id);
            $insertStmt->bindParam(':stockBl_group', $stockBl_group);
            $insertStmt->bindParam(':stockBl_qnty', $stockBl_qnty);
            $insertStmt->execute();
        }

        // Redirect the user to another page after the operation
        header('Location: welcome.php');
    } else {
        throw new Exception("Not logged in or missing form data.");
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
