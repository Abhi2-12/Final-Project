<?php
session_start();
include('../model/userModel.php');

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the JSON data from the Ajax request
    $inputData = json_decode(file_get_contents('php://input'), true);

    // Get updated user details from the form
    $userId = getUserIdByEmail($_SESSION['email']);
    $username = $inputData['username'];
    $email = $inputData['email']; // Email should be readonly, no change
    $phone = $inputData['phone'];
    $password = $inputData['password'];
    $preferences = isset($inputData['preferences']) ? $inputData['preferences'] : []; // Array of category IDs from the form

    // Validate the form fields
    if (empty($username) || empty($phone) || empty($password) || empty($email)) {
        echo json_encode(['success' => false, 'message' => 'Null username/password/email']);
        exit();
    }

    // Update user information in the database
    $updateStatus = updateUser($userId, $username, $email, $phone, $password);

    if ($updateStatus) {
        // If preferences are provided, first delete the old preferences, then save the new ones
        if (!empty($preferences)) {
            // First, remove old preferences
            deleteUserPreferences($userId);

            // Save new preferences
            saveUserPreferences($userId, $preferences);
        }

        // Return success response
        echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
    } else {
        // Return failure response
        echo json_encode(['success' => false, 'message' => 'Failed to update profile']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
