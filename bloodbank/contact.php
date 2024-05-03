<?php
// Necessary information for database connection
$host = 'localhost';
$dbname = 'bloodbank';
$username = 'root';
$password = '';

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set error mode
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch center information from the database
    $query = "SELECT * FROM Center";
    $statement = $pdo->query($query);
    $centers = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    // Show error message if there's an error
    die("Database connection error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Blood Donation Center</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="red-header">
        <h1>Blood Donation Center</h1>
        <nav>
            <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <section id="contact">
        <div class="container">
            <h2>Contact</h2>
            <p>You can reach us using the contact information below:</p>
            <table>
                <tr>
                    <th>Center Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                </tr>
                <?php foreach ($centers as $center): ?>
                <tr>
                    <td><?php echo $center['center_name']; ?></td>
                    <td><?php echo $center['phone']; ?></td>
                    <td><?php echo $center['email']; ?></td>
                    <td><?php echo $center['address']; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Blood Donation Center - All Rights Reserved</p>
    </footer>
</body>
</html>
