<?php
session_start();

// I certify this is my own personal work 


if (!isset($_SESSION['username'])) {
    header("Location: userLogin.php"); // redirect to login page 
    exit();
}
$hn = 'localhost';
$db = 'bcs350su24';
$un = 'usersu24'; 
$pw = 'pwdsu24'; 


$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// show product_inventory table
$query = "SELECT * FROM product_inventory";
$result = $conn->query($query);
if (!$result) {
    die("Query failed: " . $conn->error);
}

echo "<h2>Product Inventory</h2>";
echo "<table border='1'>
        <tr>
            <th>Item ID</th>
            <th>Item Name</th>
            <th>Price</th>
            <th>Quantity in Stock</th>
            <th>Shelf Location</th>
        </tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>" . htmlspecialchars($row['item_id']) . "</td>
            <td>" . htmlspecialchars($row['item_name']) . "</td>
            <td>" . htmlspecialchars($row['price']) . "</td>
            <td>" . htmlspecialchars($row['quantity_in_stock']) . "</td>
            <td>" . htmlspecialchars($row['shelf_location']) . "</td>
          </tr>";
}
echo "</table>";

// show users table
$query = "SELECT * FROM users";
$result = $conn->query($query);
if (!$result) {
    die("Query failed: " . $conn->error);
}

echo "<h2>Users</h2>";
echo "<table border='1'>
        <tr>
            <th>User Name</th>
            <th>Password</th>
            <th>Email</th>
            <th>First Name</th>
            <th>Last Name</th>
        </tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>" . htmlspecialchars($row['username']) . "</td>
            <td>" . htmlspecialchars($row['password']) . "</td>
            <td>" . htmlspecialchars($row['email']) . "</td>
            <td>" . htmlspecialchars($row['first_name']) . "</td>
            <td>" . htmlspecialchars($row['last_name']) . "</td>
          </tr>";
}
echo "</table>";

// close connection
$conn->close();
?>
<br><br>
    <a href="mainMenu.php">Back to Main Menu</a>
</body>
</html>
