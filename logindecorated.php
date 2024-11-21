<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location:./homepage.php");
    exit;
}


if(isset($_POST['username']) && isset($_POST['password'])){
    $user_name = $_POST['username'];
    $password1 = $_POST['password'];

    $servername = "localhost";
    $username = "dbuser";
    $password = "agrawal@2002";
    $dbname = "inventorymanagement";
    $connection = new mysqli($servername, $username, $password, $dbname);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $sql = "SELECT * FROM userlogin WHERE username='$user_name'";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            //if ($row["password"] ==  $password1) {
              //  $_SESSION['username'] = $row["username"];
                //header("Location: ./homepage.php");
               // exit;
            //} else {
               // $error_message = "Login failed. Invalid username or password.";
            //}
        
        $_SESSION['username'] = $row["username"];
    }
    } else {
        $error_message = "Login failed. Invalid username or password.";
    }
    $connection->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        }

        .login-container {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .login-container h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .login-container input[type="submit"] {
            background: #6a11cb;
            color: #fff;
            padding: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease;
        }

        .login-container input[type="submit"]:hover {
            background: #2575fc;
        }

        .login-container p {
            margin-top: 20px;
            color: #666;
        }

        .login-container a {
            color: #2575fc;
            text-decoration: none;
        }

        .login-container a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h1>Login</h1>
    <?php if(isset($error_message)): ?>
        <p class="error-message"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form method="POST" action="logindecorated.php">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
    </form>

</div>
</body>
</html>

