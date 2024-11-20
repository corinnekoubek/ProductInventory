<?php
require_once 'login.php';

// I certify this is my own personal work 

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die("Fatal Error");

// sanitize input
function sanitizeInput($conn, $input) {
    return $conn->real_escape_string(trim($input));
}

// form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = sanitizeInput($conn, $_POST['username']);
    $password = sanitizeInput($conn, $_POST['password']);
    $confirm_password = sanitizeInput($conn, $_POST['confirm_password']);
    $email = sanitizeInput($conn, $_POST['email']);
    $first_name = sanitizeInput($conn, $_POST['first_name']);
    $last_name = sanitizeInput($conn, $_POST['last_name']);
    
    // input validation
    if (empty($user_name) || empty($password) || empty($confirm_password) || empty($email) || empty($first_name) || empty($last_name)) {
        die("Please fill in all fields.");
    }
    
    if ($password != $confirm_password) {
        die("Passwords do not match. Please re-enter your password.");
    }
    
    // check if username is availiable
    $check_query = "SELECT username FROM users WHERE username = '$user_name'";
    $check_result = $conn->query($check_query);
    if ($check_result->num_rows > 0) {
        die("Username '$user_name' is already taken. Please choose a different username.");
    }
    
    // salt and hash password
    //$salt = random_bytes(16);
    //$hashed_password = password_hash($password . $salt, PASSWORD_DEFAULT);
    
    // insert into users table
    $query = "INSERT INTO users (username, password, email, first_name, last_name)
              VALUES (?, ?, ?, ?, ?)";
              //VALUES ('$user_name', '$password', '$email', '$first_name', '$last_name')";
    
    // prepared statement
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
    } else {
        // parameter binding
        $stmt->bind_param("sssss", $user_name, $password, $email, $first_name, $last_name);
        
        if ($stmt->execute()) {
            echo "User registered successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup Form</title>
    <style>
        .signup {
            border: 1px solid #999999;
            font: normal 14px helvetica;
            color: #444444;
        }
    </style>
    <script>
        function validate(form) {
            var fail = "";
            fail += validateUsername(form.username.value);
            fail += validatePassword(form.password.value, form.confirm_password.value);
            fail += validateEmail(form.email.value);
            fail += validateFirstname(form.first_name.value);
            fail += validateLastname(form.last_name.value);
            
            if (fail == "") return true;
            else {
                alert(fail);
                return false;
            }
        }

        function validateFirstname(field) {
            return (field == "") ? "No First Name was entered.\n" : "";
        }

        function validateLastname(field) {
            return (field == "") ? "No Last Name was entered.\n" : "";
        }

        function validateUsername(field) {
            if (field == "") return "No Username was entered.\n";
            else if (field.length < 5)
                return "Usernames must be at least 5 characters.\n";
            else if (/[^a-zA-Z0-9_-]/.test(field))
                return "Only a-z, A-Z, 0-9, - and _ allowed in Usernames.\n";
            return "";
        }

        function validatePassword(password, confirmPassword) {
            if (password == "") return "No Password was entered.\n";
            else if (password.length < 6)
                return "Passwords must be at least 6 characters.\n";
            else if (!/[a-z]/.test(password) ||
                     !/[A-Z]/.test(password) ||
                     !/[0-9]/.test(password))
                return "Passwords require one each of a-z, A-Z and 0-9.\n";
            else if (password != confirmPassword)
                return "Passwords do not match.\n";
            return "";
        }

        function validateEmail(field) {
            if (field == "") return "No Email was entered.\n";
            else if (!((field.indexOf(".") > 0) &&
                       (field.indexOf("@") > 0)) ||
                     /[^a-zA-Z0-9.@_-]/.test(field))
                return "The Email address is invalid.\n";
            return "";
        }
    </script>
</head>
<body>
    <table class="signup" border="0" cellpadding="2" cellspacing="5" bgcolor="#eeeeee">
        <th colspan="2" align="center">Signup Form</th>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validate(this)">
            <tr><td>Username</td>
                <td><input type="text" maxlength="128" name="username"></td></tr>
            <tr><td>Password</td>
                <td><input type="password" maxlength="128" name="password"></td></tr>
            <tr><td>Confirm Password</td>
                <td><input type="password" maxlength="128" name="confirm_password"></td></tr>
            <tr><td>Email</td>
                <td><input type="text" maxlength="128" name="email"></td></tr>
            <tr><td>First Name</td>
                <td><input type="text" maxlength="128" name="first_name"></td></tr>
            <tr><td>Last Name</td>
                <td><input type="text" maxlength="128" name="last_name"></td></tr>
           
            <tr><td colspan="2" align="center"><input type="submit" value="Signup"></td></tr>
        </form>
    </table>
</body>
</html>


