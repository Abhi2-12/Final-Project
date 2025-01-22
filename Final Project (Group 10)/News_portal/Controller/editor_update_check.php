<?php
require_once '../Model/userModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and retrieve POST data
    if (isset($_POST['editor_id'], $_POST['username'], $_POST['email'], $_POST['phone'], $_POST['password'])) {
        $editor_id = $_POST['editor_id'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];

        // Call the updateEditor function
        if (updateEditor($editor_id, $username, $email, $phone, $password)) {
            header('Location: ../View/editorlist.php'); // Redirect on success
            exit;
        } else {
            echo "Failed to update editor.";
        }
    } else {
        echo "All fields are required.";
    }
} else {
    echo "Invalid request method.";
}

?>