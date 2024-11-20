<?php
session_start();

//I certify this is my own personal work 

if (!isset($_SESSION['username'])) {
    header("Location: userLogin.php"); // redirects back to login page when not logged in
    exit();
}
$user_name = $_SESSION['username'];
?>

<!DOCTYPE html>
<head>
 <title>Main Menu</title>
</head>
<body>
    <h2>Main Menu</h2>
    <ul>
        <li><a href="listRecords.php">List Records</a></li>
        <li><a href="addDeleteRecords.php">Add / Delete Records</a></li>
        <li><a href="searchRecords.php">Search Records</a></li>
        <li><a href="userLogout.php">Logout</a></li> 
    </ul>
</body>
</html>