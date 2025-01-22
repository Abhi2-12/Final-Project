<?php
session_start();
include('../model/userModel.php');

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$email = $_SESSION['email']; // Get the logged-in user's email

// Fetch current user details
$userId = getUserIdByEmail($email); // Get the user_id using the function you provided
$user = getUserById($userId); // Function to get user data by user_id

if (!$user) {
    die("User not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        /* Add styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 60%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
            color: #333;
        }
        input[type="text"], input[type="email"], input[type="phone"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        #responseMessage {
            margin-top: 10px;
            color: red;
        }
    </style>
</head>
<body>

<?php include('header.php'); ?>

<div class="container">
    <h1>Edit Profile</h1>
    
    <form id="editProfileForm">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required readonly>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="text" id="password" name="password" value="<?php echo htmlspecialchars($user['password']); ?>" required>
        </div>
        <div>
        <label>Select Your Preferences:</label><br>
            <?php foreach ($categories as $category): ?>
                <input type="checkbox" name="preferences[]" value="<?= $category['category_id']; ?>"> <?= $category['category_name']; ?><br>
            <?php endforeach; ?>
        </div>

        <button type="button" onclick="submitProfileUpdate()" class="btn">Update Profile</button>
        <div id="responseMessage"></div>
    </form>
</div>

<script>
    // Form validation and AJAX submission
    function validateForm() {
        const username = document.getElementById('username').value;
        const phone = document.getElementById('phone').value;
        const password = document.getElementById('password').value;

        if (!username || !phone || !password) {
            document.getElementById('responseMessage').innerText = "All fields are required.";
            return false;
        }

        return true;
    }

    function submitProfileUpdate() {
        if (!validateForm()) return;

        const formData = {
            username: document.getElementById('username').value,
            email: document.getElementById('email').value,
            phone: document.getElementById('phone').value,
            password: document.getElementById('password').value,
            preferences: Array.from(document.querySelectorAll('input[name="preferences[]"]:checked')).map(checkbox => checkbox.value)
        };

        const xhttp = new XMLHttpRequest();
        xhttp.open("POST", "../Controller/user_update_check.php", true);
        xhttp.setRequestHeader("Content-Type", "application/json");

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                const response = JSON.parse(this.responseText);
                document.getElementById('responseMessage').innerText = response.message;
                if (response.success) {
                    window.location.href = "profile.php"; // Redirect to profile page after update
                }
            }
        };

        xhttp.send(JSON.stringify(formData));
    }
</script>

</body>
</html>
