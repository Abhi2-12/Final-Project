<?php
session_start();

// Check if the user is logged in and redirect accordingly
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'user') {
        header("Location: userprofile.php");
        exit();
    } elseif ($_SESSION['role'] == 'admin') {
        header("Location: adminhome.php");
        exit();
    } elseif ($_SESSION['role'] == 'editor') {
        header("Location: editorhome.php");
        exit(); 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
</head>
<body>

<?php include('header.php'); ?>

<a href="logout.php">Logout</a> <!-- Link to logout -->

</body>
</html>
