<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Post - News Portal</title>
    <link rel="stylesheet" href="../Style/styles.css">
    <script>
        // Validate the form before submission
        function validateForm() {
            const title = document.getElementById('title').value.trim();
            const description = document.getElementById('description').value.trim();
            const category = document.getElementById('category_id').value;
            const image = document.getElementById('post_img').files[0];

            if (title.length < 5) {
                alert("Title must be at least 5 characters long.");
                return false;
            }

            if (description.length < 20) {
                alert("Description must be at least 20 characters long.");
                return false;
            }

            if (!category) {
                alert("Please select a category.");
                return false;
            }

            if (image && !['image/jpeg', 'image/png', 'image/gif'].includes(image.type)) {
                alert("Only JPEG, PNG, or GIF files are allowed for the image.");
                return false;
            }

            return true;
        }

        // Submit form using AJAX
        function submitForm(event) {
            event.preventDefault();

            if (!validateForm()) return;

            const formData = new FormData(document.getElementById('addPostForm'));

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../Controller/add_post_check.php', true);

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert(response.message);
                        window.location.href = '../view/home.php'; // Redirect after success
                    } else {
                        alert("Error: " + response.message);
                    }
                }
            };

            xhr.send(formData);
        }
    </script>
</head>
<body>
    <h1>Add Post</h1>
    <form id="addPostForm" enctype="multipart/form-data" onsubmit="submitForm(event)">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br>

        <label for="category_id">Category:</label>
        <select id="category_id" name="category_id" required>
            <option value="">Select Category</option>
            <?php
            require_once '../Model/userModel.php'; 
            $categories = getCategories();
            foreach ($categories as $category) {
                echo "<option value='{$category['category_id']}'>{$category['category_name']}</option>";
            }
            ?>
        </select><br>

        <label for="post_img">Image:</label>
        <input type="file" id="post_img" name="post_img" accept="image/*"><br>

        <button type="submit">Add Post</button>
    </form>

    <div class="back-btn">
        <a href="../view/home.php">Back to Home</a>
    </div>
</body>
</html>
