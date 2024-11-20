
<?php
session_start();

//I certify this is my own personal work 

if (!isset($_SESSION['username'])) {
    header("Location: userLogin.php"); // redirects back to login page when not logged in
    exit();
}
$user_name = $_SESSION['username'];

$hn = 'localhost';
$db = 'bcs350su24';
$un = 'usersu24'; 
$pw = 'pwdsu24'; 


$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
session_unset();    
session_destroy();  

// redirect to login page
header("Location: userLogin.php");
exit();
?>

  



