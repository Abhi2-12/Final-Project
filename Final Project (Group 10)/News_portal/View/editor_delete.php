<?php
require_once '../Model/userModel.php';

// Set header for JSON response
header('Content-Type: application/json');

if (isset($_POST['editor_id'])) {
    $editor_id = $_POST['editor_id'];

    // Call deleteEditor function
    if (deleteEditor($editor_id)) {
        echo json_encode(['success' => true, 'message' => 'Editor deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete editor.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid editor ID.']);
}
