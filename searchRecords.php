
 <form action="searchRecords.php" method="post">
 
<label for="search_field">Select field to search:</label>
<select id="search_field" name="search_field">

<option value="item_id">Item ID</option>
<option value="item_name">Item Name</option>
<option value="price">Price</option>
<option value="quantity_in_stock">Quantity in Stock</option>
<option value="shelf_location">Shelf Location</option>
<option value="username">User Name</option>
<option value="email">Email</option>
<option value="first_name">First Name</option>
<option value="last_name">Last Name</option>
</select>
<input type="text" name="search_term" placeholder="Enter search term">
<input type="submit" name="search" value="Search">
    </form>
    <br>
    
<?php
require_once 'login.php';

// I certify this is my own personal work 

session_start();


if (!isset($_SESSION['username'])) {
    header("Location: userLogin.php"); // redirects back to login page when not logged in
    exit();
}
$user_name = $_SESSION['username'];

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die("Fatal Error");
    
    if (isset($_POST['search'])) {
        require_once 'login.php';
        $conn = new mysqli($hn, $un, $pw, $db);
        if ($conn->connect_error) die("Fatal Error");

        $search_field = $_POST['search_field'];
        $search_term = sanitizeMySQL($conn, $_POST['search_term']);

        // search based on selected search field
$query = "";
switch ($search_field) {
    case 'item_id':
    case 'item_name':
    case 'price':
    case 'quantity_in_stock':
    case 'shelf_location':
        
$query = "SELECT * FROM product_inventory WHERE $search_field LIKE '%$search_term%'";
break;
case 'username':
case 'email':
case 'first_name':
case 'last_name':
    
$query = "SELECT * FROM users WHERE $search_field LIKE '%$search_term%'";
break;
default:
echo "Invalid search field";
break;
    }

//  display results
if (!empty($query)) {
    $result = $conn->query($query);
if (!$result) die("Database access failed");

    $rows = $result->num_rows;

        if ($rows > 0) {
                echo "<h3>Search Results</h3>";
                echo "<table>
                        <tr>";
                
// table headers 
switch ($search_field) {
    
case 'item_id':
    echo "<th>Item ID</th>";
    break;
case 'item_name':
    echo "<th>Item Name</th>";
    break;
case 'price':
    echo "<th>Price</th>";
    break;
case 'quantity_in_stock':
    echo "<th>Quantity in Stock</th>";
    break;
case 'shelf_location':
    echo "<th>Shelf Location</th>";
    break;
case 'username':
    echo "<th>User Name</th>";
    break;
case 'email':
    echo "<th>Email</th>";
    break;
case 'first_name':
    echo "<th>First Name</th>";
    break;
case 'last_name':
    echo "<th>Last Name</th>";
    break;
default:
    echo "Invalid search field";
    break;
            }
                
echo "<th>Action</th></tr>";

// rows
while ($row = $result->fetch_assoc()) {
echo "<tr>";
foreach ($row as $key => $value) {
    echo "<td>" . htmlspecialchars($value) . "</td>";
    }
    echo "<td>
        <form action='deleteRecord.php' method='post'>
        <input type='hidden' name='delete' value='yes'>
        <input type='hidden' name='item_id' value='" . htmlspecialchars($row['item_id']) . "'>
        <input type='submit' value='DELETE RECORD'>
        </form>
        </td>";
    echo "</tr>";
    }

    echo "</table>";
    } else {
            echo "<p>No results found.</p>";
        }

    $result->close();
    }

    $conn->close();
    }

function sanitizeMySQL($conn, $var) {
    return $conn->real_escape_string($var);
    }
    ?>
</body>
</html>
<br><br>
    <a href="mainMenu.php">Back to Main Menu</a>
</body>
</html>