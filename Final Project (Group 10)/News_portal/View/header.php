<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection and user model logic
require_once '../Model/userModel.php';

// Function to check for new posts
function hasNewNews($lastLogoutTime)
{
    
    $conn = new mysqli('localhost', 'root', '', 'member'); 
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to get the latest news timestamp
    $sql = "SELECT MAX(post_date) as latest_news_time FROM post";
    $result = $conn->query($sql);

    $latestNewsTime = null;
    if ($result && $row = $result->fetch_assoc()) {
        $latestNewsTime = $row['latest_news_time'];
    }

    $conn->close();

    // Compare with the user's last checked time
    return $latestNewsTime > $lastLogoutTime;
}

// Retrieve the last checked time
$lastChecked = isset($_SESSION['last_logout']) ? $_SESSION['last_logout'] : '1970-01-01 00:00:00';

// Check for new news and count new posts
$isNewNews = hasNewNews($lastChecked);
$newPostsCount = getNewPostsCount($lastChecked);

if ($isNewNews) {
    $_SESSION['last_logout'] = date("Y-m-d H:i:s"); // Update the last checked time
    $bellColor = 'red';
} else {
    $bellColor = 'green';
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['email']) || isset($_COOKIE['status']);

// Include the category fetching logic
require_once '../Model/userModel.php';
$categories = getCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        /* Global Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Top Bar */
        .top-bar {
            background-color: #444;
            color: white;
            padding: 8px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
        }

        .top-bar .left {
            display: flex;
            gap: 15px;
        }

        .top-bar .left a {
            text-decoration: none;
            color: #ff6347;
        } 
        
        


        .top-bar .search-bar {
            display: flex;
            align-items: center;
        }

        .top-bar .search-bar input[type="text"] {
            padding: 6px;
            border-radius: 20px;
            border: 1px solid #ccc;
            margin-right: 10px;
            outline: none;
        }

        .top-bar .search-bar input[type="submit"] {
            padding: 6px 12px;
            border: none;
            border-radius: 20px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        .top-bar .search-bar input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Main Header */
        .main-header {
            background-color: #222;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .main-header .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: #ff6347;
            text-transform: uppercase;
            flex: 1;
            text-align: center;
        }

        .main-header .logo a {
            text-decoration: none;
            color: #ff6347;
        }

        .main-header .nav-links {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .main-header .nav-links a {
            text-decoration: none;
            color: white;
            font-size: 1rem;
        }

        .main-header .nav-links a:hover {
            color: #ff6347;
        }

       

        /* Category Bar */
        .category-bar {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            width: 100%;
            background-color: #007bff;
            padding: 10px 0;
        }

        .category-bar a {
            text-decoration: none;
            color: white;
            font-size: 1rem;
            padding: 5px 15px;
            border-radius: 4px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .category-bar a:hover {
            background-color: rgb(179, 0, 0);
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="left">
            <a href="weather.php">Weather</a>
            <a href=" " id="news-alert">
                <i class="fas fa-bell" style="color: <?php echo $bellColor; ?>;"></i>
                <?php if ($newPostsCount > 0): ?>
                    <span class="badge" style="color: red;"><?php echo $newPostsCount; ?></span>
                <?php endif; ?>
            </a>
        </div>
        <div class="search-bar">
        
            <!--<form action="search.php" method="POST"> -->
               <!--- <input type="text" name="query" placeholder="Search..." required> --->
                <!--<input type="submit" value="Search"> --->
                <form action="search.php" method="get">
    
                <input type="submit" value="Search">

            </form>
        </div>
    </div>

    <!-- Main Header -->
    <header class="main-header">
        <div class="logo">
            <a href="home.php">News Portal</a>
        </div>
        <div class="nav-links">
            <a href="profile.php">Profile</a>
            <?php if ($isLoggedIn): ?>
                <a href="logout.php">Logout</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Category Bar -->
    <div class="category-bar">
        <?php foreach ($categories as $category): ?>
            <a href="category.php?id=<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></a>
        <?php endforeach; ?>
    </div>

    <!-- JavaScript for Popup -->
    <script>
        // Retrieve the number of new posts from PHP
        const newPostsCount = <?php echo $newPostsCount; ?>;

        // Display a popup message if there are new posts
        if (newPostsCount > 0) {
            alert(`You have ${newPostsCount} new post(s) since your last visit!`);
        }
    </script>
</body>
</html>