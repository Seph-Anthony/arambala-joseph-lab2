<?php

require_once 'vendor/autoload.php';

use Aries\Dbmodel\Models\Post;
use Aries\Dbmodel\Models\User; // You might need the User model for user info

session_start();

$post = new Post();
$user = new User(); // Instantiate the User model if needed

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            position: relative; /* To position the logout button */
        }

        .logout-container {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .logout-button a {
            display: inline-block;
            padding: 8px 12px;
            text-decoration: none;
            color: white;
            background-color: #f44336; /* Red logout button */
            border-radius: 4px;
            font-size: 14px;
        }

        .logout-button a:hover {
            background-color: #d32f2f; /* Darker red on hover */
        }

        .welcome-section {
            background-color: #e0f2e7; /* Light green background for welcome */
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            color: #388e3c; /* Darker green text for welcome */
        }

        .auth-buttons {
            margin-top: 10px;
        }

        .auth-buttons a {
            display: inline-block;
            padding: 8px 12px;
            margin-right: 5px;
            text-decoration: none;
            color: white;
            background-color: #4caf50; /* Green button background */
            border-radius: 4px;
            font-size: 14px;
        }

        .auth-buttons a:hover {
            background-color: #43a047; /* Darker green on hover */
        }

        .blog-posts-section {
            background-color: #f9fbe7; /* Very light green for blog posts */
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #c8e6c9; /* Light green border for blog posts */
        }

        h1 {
            color: #388e3c; /* Darker green heading for blog posts */
            text-align: center;
            margin-bottom: 15px;
        }

        h2 {
            color: #555;
            margin-bottom: 10px;
        }

        ul {
            padding-left: 0;
            list-style-type: none;
        }

        li {
            padding: 12px;
            background-color: #fff;
            margin-bottom: 8px;
            border-radius: 4px;
            border: 1px solid #e0e0e0;
        }

        li strong {
            color: #2e7d32; /* Even darker green for post title */
        }

        li small {
            color: #777;
            font-style: italic;
        }

        p {
            color: #555;
        }
    </style>
</head>
<body>
    <?php if (isset($_SESSION['user']['id'])): ?>
        <div class="logout-container">
            <div class="logout-button">
                <a href="logout.php">Logout</a>
            </div>
        </div>
    <?php endif; ?>

    <div class="welcome-section">
        <h2>Welcome <?php echo isset($_SESSION['user']['first_name']) ? htmlspecialchars($_SESSION['user']['first_name']) : 'Guest'; ?></h2>
        <?php if (!isset($_SESSION['user']['id'])): ?>
            <div class="auth-buttons">
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            </div>
        <?php endif; ?>
    </div>

    <div class="blog-posts-section">
        <h1>Recent Blog Posts</h1>
        <ul>
            <?php
                if (isset($_SESSION['user']['id'])) {
                    // User is logged in, show their posts
                    $user_id = $_SESSION['user']['id'];
                    $posts = $post->getPostsByLoggedInUser($user_id);
                    if (!empty($posts)) {
                        foreach ($posts as $p) {
                            echo '<li><strong>' . htmlspecialchars($p['title']) . '</strong><br>' . htmlspecialchars(substr($p['content'], 0, 100)) . '... <small>Created at: ' . htmlspecialchars($p['created_at']) . '</small></li>';
                        }
                    } else {
                        echo '<p>You haven\'t created any blog posts yet.</p>';
                    }
                } else {
                    // User is not logged in, show recent posts from all users
                    $recentPosts = $post->getRecentPosts();
                    if (!empty($recentPosts)) {
                        foreach ($recentPosts as $rp) {
                            // Assuming getRecentPosts now fetches author info
                            $authorName = isset($rp['first_name']) && isset($rp['last_name']) ? htmlspecialchars($rp['first_name'] . ' ' . $rp['last_name']) : 'Unknown Author';
                            echo '<li><strong>' . htmlspecialchars($rp['title']) . '</strong><br>' . htmlspecialchars(substr($rp['content'], 0, 100)) . '... <small>By: ' . $authorName . ' - Created at: ' . htmlspecialchars($rp['created_at']) . '</small></li>';
                        }
                    } else {
                        echo '<p>No blog posts available yet.</p>';
                    }
                }
            ?>
        </ul>
    </div>
</body>
</html>