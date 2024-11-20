<?php
$hn = 'localhost';
$db = 'bcs350su24';
$un = 'usersu24'; 
$pw = 'pwdsu24'; 

//I certify this is my own original work 

// establish connection
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// create product_inventory table
$query = "CREATE TABLE IF NOT EXISTS product_inventory (
    item_id VARCHAR(10),
    item_name VARCHAR(25),
    price VARCHAR(7),
    quantity_in_stock INT(4),
    shelf_location VARCHAR(50),
    INDEX(item_name(15)),
    INDEX(shelf_location(15)),
    PRIMARY KEY (item_id)
)";
$result = $conn->query($query);
if (!$result) {
    die("Table creation failed: " . $conn->error);
}
echo "Table 'product_inventory' created successfully<br>";

//insert data into product_inventory table
$query = "INSERT INTO product_inventory VALUES
    
    ('73477', 'Red Skirt', '$65.00', '110', 'Shelf 11d'),
    ('70587', 'Blue Jeans', '$70.00', '150', 'Shelf 15a')";
$result = $conn->query($query);
if (!$result) {
    die("Insertion into product_inventory table failed: " . $conn->error);
}
echo "Sample data inserted into 'product_inventory' table successfully<br>";

// create users table
$query = "CREATE TABLE IF NOT EXISTS users (
    user_name VARCHAR(128),
    password VARCHAR(128),
    email VARCHAR(128),
    first_name VARCHAR(128),
    last_name VARCHAR(128),
    INDEX(email(20)),
    INDEX(first_name(20)),
    INDEX(last_name(20)),
    PRIMARY KEY (user_name)
)";


$result = $conn->query($query);
if (!$result) {
    die("Table creation failed: " . $conn->error);
}
echo "Table 'users' created successfully<br>";

//insert sample data into users table
$query = "INSERT INTO users VALUES
    ('User12q', 'Testing12', 'usertest12@gmail.com', 'TestTwelve', 'UserTwelve')";
$result = $conn->query($query);
if (!$result) {
    die("Insertion into users table failed: " . $conn->error);
}
echo "Sample data inserted into 'users' table successfully<br>";

// close connection
$conn->close();
?>