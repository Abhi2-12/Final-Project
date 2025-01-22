<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts List</title>
    <style>
        /* Basic CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .post-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .delete-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .delete-btn:hover {
            background-color: darkred;
        }

        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .back-btn:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function deletePost(postId) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete_post.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Send the post_id to the server
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert(response.message);
                        document.getElementById('post-' + postId).remove(); // Remove post from the UI
                    } else {
                        alert("Error: " + response.message);
                    }
                }
            };
            xhr.send("post_id=" + postId);
        }
    </script>
</head>
<body>

<?php
require_once '../Model/userModel.php';  // Include the user model where database functions are defined

// Fetch the posts (with only post_id and title)
$posts = getPostTitles();  // Now calling the correct function to get posts

// Check if any posts are found
if (!empty($posts)) {
    foreach ($posts as $post) {
        echo "<div class='post-container' id='post-" . $post['post_id'] . "'>";
        echo "ID: " . $post['post_id'] . "<br>";
        echo "Title: " . $post['title'] . "<br>";
        // Add a delete button next to the post title
        echo "<button class='delete-btn' onclick='deletePost(" . $post['post_id'] . ")'>Delete</button><br><br>";
        echo "</div>";
    }
} else {
    echo "No posts found.";
}
?>

<!-- Back button -->
<a href="../view/home.php" class="back-btn">Back to Home</a>

</body>
</html>
