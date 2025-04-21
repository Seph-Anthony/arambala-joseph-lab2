<?php

require_once 'vendor/autoload.php';

use Aries\Dbmodel\Models\User;

session_start();

// Usage example
$user = new User();


if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user_info = $user->login([
        'username' => $username,
    ]);

    

    if ($user_info && isset($user_info['password'])) {
        
        
        if (password_verify($password, $user_info['password'])) {
            $_SESSION['user'] = $user_info;
            header('Location: blog.php'); // Redirect to blog.php after successful login
            exit;
        } else {
            $message = 'Invalid username or password';
        }
    } else {
        $message = 'Invalid username or password'; // User not found case
    }
}

if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    header('Location: blog.php'); // Redirect to blog.php if already logged in
    exit;
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
            font-family: sans-serif;
            background-color: #f0fff0; /* Light green background */
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column; /* Arrange form and button vertically */
        }

        form {
            background-color: #e0f2e7; /* Slightly darker green form background */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            margin-bottom: 20px; /* Add some space below the form */
        }

        h1 {
            color: #388e3c; /* Darker green heading */
            margin-bottom: 20px;
        }

        input[type="username"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #a5d6a7; /* Light green border */
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50; /* Green submit button */
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #43a047; /* Darker green on hover */
        }

        .error-message {
            color: #d32f2f; /* Red error message */
            margin-top: 10px;
        }

        .back-button {
            display: inline-block;
            padding: 10px 15px;
            text-decoration: none;
            color: white;
            background-color: #66bb6a; /* Another shade of green for back button */
            border-radius: 5px;
            font-size: 16px;
        }

        .back-button:hover {
            background-color: #388e3c; /* Darker shade on hover */
        }
    </style>
</head>
<body>
    <form method="POST" action="login.php">
        <h1>Login</h1>
        <?php if (isset($message)): ?>
            <p class="error-message"><?php echo $message; ?></p>
        <?php endif; ?>
        <input type="username" name="username" id="" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <input type="submit" name="submit" value="Submit">
    </form>
    <a href="index.php" class="back-button">Back</a>
</body>
</html>