<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Blood Donation Center</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <header>
        <h1>Blood Donation Center</h1>
    </header>

    <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="POST"> 
    <div class="form-group">
        <label for="center_id">Center ID:</label>
        <input type="text" id="center_id" name="center_id" required>
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" class="btn">Login</button>
</form>
    </div>

    <?php
session_start();

// Database connection information
$host = 'localhost';
$dbname = 'bloodbank';
$username = 'root';
$db_password = '';

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $db_password);
    // Set error mode
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve username and password sent via POST method
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $center_id = $_POST['center_id'];
        $password = $_POST['password'];

        // Query with username and password
        $query = "SELECT * FROM Center WHERE center_ID = :center_id AND password = :password";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':center_id', $center_id);
        $statement->bindParam(':password', $password);
        $statement->execute();

        // Check if there is a matching user
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            // Set session variable if login is successful
            $_SESSION['center_id'] = $center_id;
            // Redirect to the welcome page
            header("Location: welcome.php");
            exit;
        } else {
            // Show error message if login fails
            echo '<p style="color: red;">Incorrect Center ID or Password!</p>';
        }
    }
} catch(PDOException $e) {
    die("Database connection error: " . $e->getMessage());
}
?>

    <footer>
        <p>&copy; 2024 Blood Donation Center - All Rights Reserved</p>
    </footer>
</body>
</html>
