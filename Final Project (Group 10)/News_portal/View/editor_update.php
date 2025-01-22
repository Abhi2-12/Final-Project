<?php
// Connect to the database
require_once '../Model/userModel.php';

// Fetch the editor's current data using the editor_id
if (isset($_GET['editor_id'])) {
    $editor_id = $_GET['editor_id'];
    $conn = getConnection();
    $sql = "SELECT * FROM editor WHERE editor_id = '{$editor_id}'";
    $result = mysqli_query($conn, $sql);
    $editor = mysqli_fetch_assoc($result);
    
    if (!$editor) {
        echo "Editor not found.";
        exit;
    }
} else {
    echo "Editor ID is required.";
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Editor</title>
    <link rel="stylesheet" href="../Style/styles.css">
</head>
<body>
    <div class="container">
        <h1>Update Editor</h1>
        <form method="post" action="../Controller/editor_update_check.php">
            <input type="hidden" name="editor_id" value="<?php echo $editor['editor_id']; ?>">
            
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo $editor['username']; ?>" required />

            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" value="<?php echo $editor['phone']; ?>" required />

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $editor['email']; ?>" required />

            <label for="password">Password</label>
            <input type="password" id="password" name="password" value="<?php echo $editor['password']; ?>" required />

            <input type="submit" value="Update Editor" />
        </form>
        <div class="back-link">
            <a href="editorlist.php">Back to Editor List</a>
        </div>
    </div>
</body>
</html>




