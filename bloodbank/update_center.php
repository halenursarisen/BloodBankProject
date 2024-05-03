<?php
session_start();

// If user is logged in and session variable is set
if (isset($_SESSION['center_id'])) {
    // Get the center ID stored in the session variable
    $center_id = $_SESSION['center_id'];

    // Get data from the form
    $updated_center_name = $_POST['center_name'];
    $updated_city = $_POST['city'];
    $password = $_POST['password'];

    // Database connection information
    $host = 'localhost';
    $dbname = 'bloodbank';
    $username = 'root';
    $db_password = ''; // Renamed to avoid conflict with variable

    try {
        // Connect to the database
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $db_password);
        // Set error mode
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Validate user's password
        $query = "SELECT * FROM Center WHERE center_ID = :center_id AND password = :password";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':center_id', $center_id);
        $statement->bindParam(':password', $password);
        $statement->execute();

        // If password is correct, update center information
        if ($statement->rowCount() > 0) {
            $query = "UPDATE Center SET center_name = :center_name, city = :city WHERE center_ID = :center_id";
            $statement = $pdo->prepare($query);
            $statement->bindParam(':center_name', $updated_center_name);
            $statement->bindParam(':city', $updated_city);
            $statement->bindParam(':center_id', $center_id);
            $statement->execute();

            echo "Center information updated successfully.";
        } else {
            echo "Incorrect password. Center information could not be updated.";
        }

    } catch(PDOException $e) {
        die("Database connection error: " . $e->getMessage());
    }
} else {
    // If user is not logged in, redirect to the login page
    header("Location: login.html");
    exit;
}
?>
