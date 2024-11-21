<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location:./logindecorated.php");
    exit;
}
$errors = [];
$success = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($username)) {
        $errors[] = "Username is required.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    // If there are no validation errors
    if (empty($errors)) {
        // Connect to the database
//        $servername = "localhost";
//        $dbUsername = "dbuser";
//        $dbPassword = "agrawal@2002";
//        $dbname = "inventorymanagement";
//
//        $connection = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
//
//        // Check connection
//        if ($connection->connect_error) {
//            die("Connection failed: " . $connection->connect_error);
//        }
        require "functions.php";
        $connection=connect();

        // Prepare and bind
        $stmt = $connection->prepare("SELECT * FROM userlogin WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Verify password
            if (hash('sha256', $password) === $row['password']) {
                $_SESSION['username'] = $row['username'];
                $success = "Login successful!";
                header("Location: inventory.php");
                exit;
            } else {
                $errors[] = "Incorrect password.";
            }
        } else {
            $errors[] = "No user found with that username.";
        }

        // Close connection
        $stmt->close();
        $connection->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
<h2>Login Form</h2>
<?php if (!empty($errors)): ?>
    <div class="error">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<?php if (!empty($success)): ?>
    <div class="success">
        <?php echo htmlspecialchars($success); ?>
    </div>
<?php endif; ?>
<form method="POST" action="logindecorated.php">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <br>
    <button type="submit">Login</button>
</form>
</body>
</html>

