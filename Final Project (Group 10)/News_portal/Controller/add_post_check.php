<?php
require_once '../Model/userModel.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $post_date = date('Y-m-d H:i:s');
    $post_img = '';

    // Image upload
    if (!empty($_FILES['post_img']['name'])) {
        $target_dir = "../uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Create the uploads directory
        }

        $post_img = $target_dir . basename($_FILES['post_img']['name']);
        if (!move_uploaded_file($_FILES['post_img']['tmp_name'], $post_img)) {
            echo json_encode(['success' => false, 'message' => 'Failed to upload image.']);
            exit();
        }
    }

    // Insert post into the database
    $conn = getConnection();
    $stmt = mysqli_prepare($conn, "INSERT INTO post (title, description, category_id, post_date, post_img) VALUES (?, ?, ?, ?, ?)");

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ssiss', $title, $description, $category_id, $post_date, $post_img);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true, 'message' => 'Post added successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: ' . mysqli_error($conn)]);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error preparing statement: ' . mysqli_error($conn)]);
    }

    mysqli_close($conn);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
