<?php
    session_start();

    // Check if the user is logged in and the 'status' cookie is set
    if (!isset($_COOKIE['status']) || $_SESSION['role'] !== 'admin') {
        header('location: login.html'); 
        exit();
    }

    include('../model/userModel.php');
  
    $totalPost = getTotalPost();    
    $totalUsers = getTotalUsers();
    $totalCategories = getTotalCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home - News Portal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        header {
            background-color: #333;
            color: white;
            padding: 1rem;
            text-align: center;
        }
        nav {
            background-color: #555;
            overflow: hidden;
        }
        nav a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }
        nav a:hover {
            background-color: #777;
        }
        .container {
            padding: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<header>
    <h1>Admin Dashboard</h1>
</header>

<nav>
    <a href="../view/home.php">Home</a>
    <a href="../view/view_post.php">Manage News</a>
    <a href="../view/category_add.php">Add Categories</a>
    <a href="../view/userlist.php">Users</a>
    <a href="../view/editorlist.php">Editor</a>
    <a href='logout.php'>Logout</a>
</nav>

<div class="container">
    <center><h2>Analytical Dashboard</h2>
    <div class="card">
        <h3>Total News Articles</h3>
        <p><?php echo $totalPost; ?></p>
    </div>
    <div class="card">
        <h3>Registered Users</h3>
        <p><?php echo $totalUsers; ?></p>
    </div>
    <div class="card">
        <h3>Categories</h3>
        <p><?php echo $totalCategories; ?></p>
    </div>
</div>



</body>
</html>
