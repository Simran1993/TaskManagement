<?php
session_start();
include 'connect.php';
require_once('header.php');


// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch tasks from the database for the logged-in user
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM tasks WHERE user_id = '$user_id'";
$result = $conn->query($sql);

// Fetch Tasks from database to check the the similar search title.
$search_title = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT * FROM tasks WHERE user_id = '$user_id' AND title LIKE '%$search_title%'";
$result = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management</title>
    </head>
    <body>
    <h2>Task List</h2>
    
    <form method="GET" action="">
        <label for="search">Search by Title:</label>
        <input type="text" id="search" name="search" value="<?= htmlspecialchars($search_title) ?>">
        <button type="submit">Search</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['title']}</td>";
                    echo "<td>{$row['description']}</td>";
                    echo "<td>{$row['status']}</td>";
                    echo "<td><a href='edit.php?id={$row['id']}'>Edit</a> | <a href='delete.php?id={$row['id']}'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No tasks found.</td></tr>";
            }
            ?>
            <tr>
            <td><p><button><a href="create.php">Add Task</a></button></p> </td>
            <tr>
        </tbody>
    </table>
    <?php include('footer.php'); ?>
    </body>
</html>

<?php
 // Close the database connection
    $conn->close();

?>