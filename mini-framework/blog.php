<?php

require_once 'vendor/autoload.php';

use Aries\Dbmodel\Models\Post;

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user']['id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

// Usage example
$post = new Post();

// checks if the button is clicked AND the form is submitted on blog.php
if(isset($_POST['submit']) && $_SERVER['PHP_SELF'] == '/arambala-joseph-lab2/mini-framework/blog.php') {
    $post->addPost([
        'title' => $_POST['title'],
        'content' => $_POST['content'],
        'author_id' => $_SESSION['user']['id'] // Use the logged-in user's ID from the session
    ]);

    // Optionally, you can redirect the user after successfully adding a post
    header('Location: index.php'); // Or wherever you want to redirect after posting
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a Blog Post</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f0fff0; /* Light green background */
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column; /* Arrange content vertically */
        }

        form {
            background-color: #e0f2e7; /* Slightly darker green form background */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 400px; /* Increased width for better layout */
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            color: #388e3c; /* Darker green heading */
            margin-bottom: 20px;
        }

        input[type="text"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #a5d6a7; /* Light green border */
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        textarea {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #a5d6a7; /* Light green border */
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
            min-height: 150px; /* Give some initial height */
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

        .greeting {
            color: #388e3c; /* Darker green text */
            margin-bottom: 10px;
            font-size: 18px;
        }

        .logout-button {
            display: inline-block;
            padding: 10px 15px;
            text-decoration: none;
            color: white;
            background-color: #d32f2f; /* Red logout button */
            border-radius: 5px;
            font-size: 16px;
            margin-top: 10px;
        }

        .logout-button:hover {
            background-color: #b71c1c; /* Darker red on hover */
        }
    </style>
</head>
<body>
    <p class="greeting">Hello, <?php echo htmlspecialchars($_SESSION['user']['first_name']); ?></p>
    <h1>Add a Blog Post</h1>
    <form method="POST" action="blog.php">
        <input type="text" name="title" placeholder="Title">
        <textarea name="content" placeholder="Content"></textarea>
        <input type="submit" name="submit" value="Publish Post">
    </form>
    <a href="logout.php" class="logout-button">Logout</a>
</body>
</html>