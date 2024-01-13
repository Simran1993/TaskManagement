<?php
include 'connect.php';
require_once('header.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email=$_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);


    $sql = "INSERT INTO users (username, email, password) VALUES ('$username','$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>

</head>
<body id="res_form">
    <br>
    <h2>User Registration</h2>

    <div class="container">
        <img src="Stylesheet/Images/Res_BI.jpg" alt="Italian Trulli">
        <div id="res_innerForm">
        <form method="post" action="" >
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Register">
            <a href="login.php">Already have an account? Login here.</a>
            </form>
</div>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>

