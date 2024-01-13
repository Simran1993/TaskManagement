<?php
session_start();

include 'connect.php';
require_once('header.php');

$errors = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Server-side validation
    if (empty($username)) {
        $errors['username'] = "Username cannot be empty.";
    } elseif (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
        $errors['username'] = "Invalid characters in username. Only letters, numbers, and underscores are allowed.";
    }

    if (strlen($password) < 3) {
        $errors['password'] = "Password should be at least 3 characters long.";
    }

    if (empty($errors)) {
        // Proceed with database query only if validation passes
        $sql = "SELECT id, username, password FROM users WHERE username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // Login successful
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                header('Location: index.php'); // Redirect to the main page after successful login
                exit;
            } else {
                $errors['password'] = "Invalid password.";
            }
        } else {
            $errors['username'] = "User not found.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
   
</head>
<body>
    <br>
    <h2>User Login</h2>

    <div class="container">
        <img src="Stylesheet/Images/Res_BI.jpg" alt="Italian Trulli">
        <div id="Login_innerForm">
            <form method="post" action="">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <?php if (isset($errors['username'])) {
                    echo "<p style='color: red;'>{$errors['username']}</p>";
                } ?>
                <br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <?php if (isset($errors['password'])) {
                    echo "<p style='color: red;'>{$errors['password']}</p>";
                } ?>
                <br>

                <input type="submit" value="Login">
                <a href="credential.php">Don't have an account? Register here.</a>
            </form>
        </div>
    </div>
    <br>
    <?php include('footer.php'); ?>
</body>
</html>
