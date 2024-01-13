<link rel="stylesheet" href="Stylesheet/styler.css">

<header>
    <h1>Task Management </h1>
    <div id="Navigator">
        <nav>
            <ul>
                <li><button id="Page1"><a href="index.php">Home</a></button></li>
                <li>
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        echo '<a href="logout.php">Logout</a>';
                    }
                    ?>
                </li>
            </ul>
        </nav>
    </div>
    <div id="user_detail">
        <table>
            <thead>
                <tr>
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        // Assuming you have a users table where user details are stored
                        $user_id = $_SESSION['user_id'];
                        $user_query = "SELECT * FROM users WHERE id = '$user_id'";
                        $user_result = $conn->query($user_query);

                        if ($user_result->num_rows > 0) {
                            $user_data = $user_result->fetch_assoc();
                            echo '<strong style="font-size: 1.2em;">Welcome, ' . $user_data['username'] . '</strong>';
                        }
                    }
                    ?>
                </tr>
            </thead>
        </table>
    </div>
</header>
