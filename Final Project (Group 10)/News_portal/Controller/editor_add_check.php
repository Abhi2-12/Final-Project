<?php
require_once '../Model/userModel.php';

// Set response header to JSON
header('Content-Type: application/json');

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputData = json_decode(file_get_contents('php://input'), true);  // Get JSON data

    if (isset($inputData['username'], $inputData['email'], $inputData['phone'], $inputData['password'])) {
        $username = $inputData['username'];
        $email = $inputData['email'];
        $phone = $inputData['phone'];
        $password = $inputData['password'];

        // Add editor to the database
        if (addEditor($username, $email, $phone, $password)) {
            // Success response
            echo json_encode(['success' => true, 'message' => 'Editor added successfully.']);
        } else {
            // Failure response
            echo json_encode(['success' => false, 'message' => 'Failed to add editor.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
