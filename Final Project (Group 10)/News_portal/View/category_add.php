<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <link rel="stylesheet" href="../Style/styles.css">
</head>
<body>
    <div>
        <h2>Add New Category</h2>
        <form method="POST" action="../Controller/category_add_check.php">
            <label for="category_name">Category Name</label>
            <input type="text" id="category_name" name="category_name" required />
            <input type="submit" value="Add Category" />
        </form>
        <div class="back-btn">
            <a href="home.php">Back to Home</a>
        </div>
    </div>
</body>
</html>
