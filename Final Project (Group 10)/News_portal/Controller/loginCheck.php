<?php
session_start();
include('../model/userModel.php');

// Initialize response array
$response = array();

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $response['status'] = 'error';
        $response['message'] = 'Null email/password!';
    } else {
        // Check if it's a regular user
        $role = login($email, $password);
        if ($role) {
            $_SESSION['email'] = $email;
            $_SESSION['user_id'] = getUserIdByEmail($email);
            $_SESSION['role'] = $role;
            setcookie('status', 'true', time() + 3000, '/');
            
            $response['status'] = 'success';
            $response['redirectUrl'] = '../view/home.php'; // User home page
        } else {
            // Check for admin login
            $role = adminlogin($email, $password);
            if ($role) {
                $_SESSION['email'] = $email;
                $_SESSION['role'] = $role;
                setcookie('status', 'true', time() + 3000, '/');
                
                $response['status'] = 'success';
                $response['redirectUrl'] = '../view/adminhome.php'; // Admin home page
            } else {
                // Check for editor login
                $role = editorlogin($email, $password);
                if ($role) {
                    $_SESSION['email'] = $email;
                    $_SESSION['role'] = $role;
                    setcookie('status', 'true', time() + 3000, '/');
                    
                    $response['status'] = 'success';
                    $response['redirectUrl'] = '../view/editorhome.php'; // Editor home page
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'Invalid user!';
                }
            }
        }
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request!';
}

// Return JSON response
echo json_encode($response);
?>
