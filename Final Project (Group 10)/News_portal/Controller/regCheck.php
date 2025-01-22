<?php
session_start();
require_once('../Model/userModel.php');

// Read JSON input
$input = file_get_contents('php://input');
$data = json_decode($input, true);

$response = ["success" => false, "message" => "Invalid request"];

if (isset($data['username'], $data['email'], $data['phone'], $data['password'])) {
    $username = trim($data['username']);
    $email = trim($data['email']);
    $phone = trim($data['phone']);
    $password = trim($data['password']);
    $preferences = isset($data['preferences']) ? $data['preferences'] : [];

    if ($username && $phone && $email && $password) {
        $status = addUser($username, $email, $phone, $password);

        if ($status) {
            $userId = getUserIdByEmail($email);

            if ($userId && !empty($preferences)) {
                saveUserPreferences($userId, $preferences);
            }

            $response = ["success" => true, "message" => "Registration successful!"];
        } else {
            $response["message"] = "Failed to register user. Please try again.";
        }
    } else {
        $response["message"] = "All fields are required.";
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>
