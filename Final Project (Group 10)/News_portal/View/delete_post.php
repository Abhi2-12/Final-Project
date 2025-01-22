<?php
require_once '../Model/userModel.php';

if (isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
    
    // Calling deletePost function
    if (deletePost($post_id)) {
        //JSON show success
        echo json_encode(['success' => true, 'message' => 'Post deleted successfully!']);
    } else {
        // JSON show failure
        echo json_encode(['success' => false, 'message' => 'Failed to delete the post.']);
    }
} else {
    //post id missing
    echo json_encode(['success' => false, 'message' => 'Post ID is missing.']);
}
?>
