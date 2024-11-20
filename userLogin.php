<?php
require_once 'login.php';
session_start();

// I certify this is my own personal work 

$hn = 'localhost';
$db = 'bcs350su24';
$un = 'usersu24'; 
$pw = 'pwdsu24'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST['username'];
    $password = $_POST['password'];

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

    // sanitize inputs
    $user_name = $conn->real_escape_string($user_name);
    $password = $conn->real_escape_string($password);

    // check if username and password match
    $query = "SELECT * FROM users WHERE username = '$user_name'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $stored_password = $row['password'];

        // verify password
        if ($password === $stored_password) {           
            $_SESSION['username'] = $user_name;
            header("Location: mainMenu.php");
            exit();
        } else {
            $error_message = "Invalid username or password. Please try again.";
        }
    } else {
        $error_message = "Invalid username or password. Please try again.";
    }

    // close database connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Login</title>
    <style>
        .login {
            border: 1px solid #999999;
            font: normal 14px helvetica;
            color: #444444;
            width: 300px;
            margin: 0 auto;
            padding: 10px;
        }
        .error {
            color: red;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="login">
        <h2>Login</h2>
        <?php
        if (isset($error_message)) {
            echo '<p class="error">' . $error_message . '</p>';
        }
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Login">
        </form>
        <?php
        if (isset($_SESSION['username'])) {
            echo '<br><br><a href="userLogout.php">Logout</a>';
        }
        ?>
    </div>
</body>
</html>
