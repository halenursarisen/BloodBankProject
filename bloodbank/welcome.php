<?php
session_start();

// Database connection information
$host = 'localhost';
$dbname = 'bloodbank';
$username = 'root';
$password = '';

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set error mode
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if center ID is in session variable
    if (isset($_SESSION['center_id'])) {
        // If user is logged in, get center ID from session variable
        $center_id = $_SESSION['center_id'];

        // Get stock information for logged-in user's center
        $query_user = "SELECT stock_id, center_name, stockBl_group, stockBl_qnty FROM Stock WHERE center_ID = :center_id";
        $statement_user = $pdo->prepare($query_user);
        $statement_user->bindParam(':center_id', $center_id);
        $statement_user->execute();
        $user_stocks = $statement_user->fetchAll(PDO::FETCH_ASSOC);

        // Get stock information for other centers
        $query_others = "SELECT stock_id, center_name, stockBl_group, stockBl_qnty FROM Stock WHERE center_ID != :center_id";
        $statement_others = $pdo->prepare($query_others);
        $statement_others->bindParam(':center_id', $center_id);
        $statement_others->execute();
        $other_stocks = $statement_others->fetchAll(PDO::FETCH_ASSOC);
    }

} catch(PDOException $e) {
    die("Database connection error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1, h2 {
            color: #333;
        }

        header {
            background-color: #ff0000;
            padding: 10px;
            color: white;
            text-align: center;
        }

        #logout-btn {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
            margin-top: -40px;
            margin-right: 20px;
        }

        #logout-btn:hover {
            background-color: #45a049;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

    </style>
</head>
<body>
<header>
    <h1>Management Panel</h1>
    <button id="logout-btn">Logout</button>
</header>

<?php if (isset($_SESSION['center_id'])): ?>
    <h2>Stock Information for Logged-in Center</h2>
    <table>
        <tr>
            <th>Stock ID</th>
            <th>Center Name</th>
            <th>Blood Group</th>
            <th>Stock Quantity</th>
        </tr>
        <?php foreach($user_stocks as $stock): ?>
        <tr>
            <td><?php echo $stock['stock_id']; ?></td>
            <td><?php echo $stock['center_name']; ?></td>
            <td><?php echo $stock['stockBl_group']; ?></td>
            <td><?php echo $stock['stockBl_qnty']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- Form for adding data -->
    <h2>Add New Stock</h2>
    <form action="add_stock.php" method="POST">
        <label for="stockBl_group">Blood Group:</label>
        <input type="text" id="stockBl_group" name="stockBl_group" required><br>
        <label for="stockBl_qnty">Stock Quantity:</label>
        <input type="number" id="stockBl_qnty" name="stockBl_qnty" required><br>
        <button type="submit">Add</button>
    </form>

    <!-- Form for updating and deleting data -->
    <form action="delete_stock.php" method="POST">
    <label for="delete_stock_id">Stock ID to Delete:</label>
    <input type="number" id="delete_stock_id" name="delete_stock_id" required><br>
    
    <label for="stock_quantity">Stock Quantity:</label>
    <input type="number" id="stock_quantity" name="stock_quantity"><br>
    
    <button type="submit">Delete</button>
</form>
<?php endif; ?>
<!-- Stock Information for Other Centers -->
<div>
    <?php if (!empty($other_stocks)): ?>
        <h2>Stock Information for Other Centers</h2>
        <table class="other-stocks">
            <tr>
                <th>Stock ID</th>
                <th>Center Name</th>
                <th>Blood Group</th>
                <th>Stock Quantity</th>
            </tr>
            <?php foreach($other_stocks as $stock): ?>
                <tr>
                    <td><?php echo $stock['stock_id']; ?></td>
                    <td><?php echo $stock['center_name']; ?></td>
                    <td><?php echo $stock['stockBl_group']; ?></td>
                    <td><?php echo $stock['stockBl_qnty']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

<script>
    document.getElementById("logout-btn").addEventListener("click", function() {
        window.location.href = "logout.php";
    });
</script>

</body>
</html>
