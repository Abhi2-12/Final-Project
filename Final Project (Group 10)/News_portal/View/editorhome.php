<?php
    session_start();

    if (!isset($_COOKIE['status']) || $_SESSION['role'] !== 'editor') {
        header('location: login.html'); 
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }

        nav {
            background-color: #444;
            overflow: hidden;
        }

        nav a {
            float: left;
            display: block;
            color: white;
            padding: 14px 20px;
            text-align: center;
            text-decoration: none;
        }

        nav a:hover {
            background-color: #575757;
        }

        .container {
            display: flex;              
            padding: 20px;               
            justify-content: center;              
            height: 50vh;              

        .sidebar {
            width: 20%;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar h3 {
            text-align: center;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #333;
        }

        .main-content {
            width: 75%;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .main-content h2 {
            text-align: center;
        }

        .card {
            border: 1px solid #ddd;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #fafafa;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .card a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        footer {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <header>
        <h1>Editor Dashboard</h1>
    </header>

    <!-- Navigation Bar -->
    <nav>
        <a href="../View/home.php">Home</a>
        <a href="profile.html">Profile</a>
        <a href='logout.php'>logout </a>
    </nav>

    <!-- Main Container -->
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h3>Navigation</h3>
            <ul>
                <li><a href="../View/add_post.php">Create Article</a></li>
                <li><a href="../view/view_post.php">Manage Articles</a></li>
                <li><a href="../View/home.php">View Published Articles</a></li>
                
            </ul>
        </div>

        <!-- Main Content -->


    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 News Portal. All rights reserved.</p>
    </footer>

</body>
</html>
