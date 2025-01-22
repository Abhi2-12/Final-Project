<?php
session_start();
include('../model/userModel.php');

// Check if the user is logged in (i.e., session has user_id)
if (!isset($_SESSION['user_id'])) {
    header('Location: ../view/login.html'); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION['user_id']; // Get the logged-in user_id from session
$user = getUserProfile($user_id); // Fetch user profile from database

// Fetch saved articles for the user
$conn = getConnection();
$sql_saved_articles = "SELECT post_id FROM saved_articles WHERE user_id = $user_id";
$result_saved_articles = mysqli_query($conn, $sql_saved_articles);

$saved_articles = [];
if ($result_saved_articles) {
    while ($row = mysqli_fetch_assoc($result_saved_articles)) {
        // Instead of querying the posts table, just store the post IDs
        $saved_articles[] = $row['post_id'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 60%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        p {
            font-size: 1.1em;
            color: #555;
            margin-bottom: 15px;
        }

        strong {
            color: #333;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .profile-info {
            margin-bottom: 20px;
        }

        .profile-info p {
            font-size: 1.2em;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            margin: 10px 0;
        }

        .profile-info strong {
            color: #007bff;
        }
    </style>
</head>

<body>
    <?php include('header.php'); ?>
    <div class="container">
        <h1>User Profile</h1>
        <div class="profile-info">
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
            <p><strong>Saved Articles:</strong>
                <?php
                if (!empty($saved_articles)) {
                    echo implode(', ', $saved_articles); // Display post IDs instead of titles
                } else {
                    echo "No articles saved.";
                }
                ?>
            </p>
        </div>

        <!-- Button that links to the profile update page -->
        <a href="user_update.php" class="btn">Edit Profile</a>
        <a href="logout.php" class="btn">Logout</a>
        <a href="subscription.php" class="btn">Subscription</a>
    </div>
</body>

</html>
