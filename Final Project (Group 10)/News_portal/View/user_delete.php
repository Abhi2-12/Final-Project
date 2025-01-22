<?php

require_once '../Model/userModel.php';

// Establish connection to the database (add this line)
$conn = getConnection(); // This assumes that getConnection() returns a valid mysqli connection object

// user_id is GET request
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    
    // First, delete all saved articles related to this user
    $deleteArticlesQuery = "DELETE FROM saved_articles WHERE user_id = ?";
    $stmt = $conn->prepare($deleteArticlesQuery); // Use $conn here to prepare the query
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Then, delete the user
    if (deleteUser($user_id)) {
        // Redirect to the user list page after successful deletion
        header('Location: ../View/userlist.php');
        exit;
    } else {
        echo "Failed to delete user.";
    }
} else {
    echo "Invalid user ID.";
}
?>
