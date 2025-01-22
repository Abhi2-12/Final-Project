<?php
require_once '../Model/userModel.php';

// Fetch categories from the database
$conn = getConnection();
$sql = "SELECT * FROM category";
$result = mysqli_query($conn, $sql);
$categories = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link rel="stylesheet" href="../Style/styles.css">
</head>
<body>
    <h1>Signup Page</h1>
    <form id="signupForm">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required /> <br>

        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" required /><br>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required /> <br>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required /> <br>

        <label>Select Your Preferences:</label><br>
        <?php foreach ($categories as $category): ?>
            <input type="checkbox" name="preferences[]" value="<?= $category['category_id']; ?>"> <?= $category['category_name']; ?><br>
        <?php endforeach; ?>

        <button type="button" onclick="submitForm()" style="background-color: #4CAF50; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; width: 100%;">submit</button>
    </form>

    <p id="responseMessage"></p>

    <div class="back-btn">
        <a href="../View/login.html">Login</a>
    </div>

    <script>
        function validateForm(data) {
            const { username, phone, email, password } = data;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const phonePattern = /^[0-9]{11}$/;
            const passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;

            if (!username || !phone || !email || !password) {
                return "All fields are required.";
            }
            if (!emailPattern.test(email)) {
                return "Invalid email format.";
            }
            if (!phonePattern.test(phone)) {
                return "Phone number must be 11 digits.";
            }
            if (!passwordPattern.test(password)) {
                return "Password must be at least 8 characters and include one number, one uppercase, and one lowercase letter.";
            }
            return null;
        }

        function submitForm() {
            const form = document.getElementById('signupForm');
            const data = {
                username: form.username.value,
                phone: form.phone.value,
                email: form.email.value,
                password: form.password.value,
                preferences: Array.from(form.querySelectorAll('input[name="preferences[]"]:checked')).map(el => el.value),
            };

            const validationError = validateForm(data);
            if (validationError) {
                document.getElementById('responseMessage').innerText = validationError;
                return;
            }

            const xhttp = new XMLHttpRequest();
            xhttp.open('POST', '../Controller/regCheck.php', true);
            xhttp.setRequestHeader('Content-Type', 'application/json');
            xhttp.onreadystatechange = function () {
                if (this.readyState === 4) {
                    const response = JSON.parse(this.responseText);
                    document.getElementById('responseMessage').innerText = response.message;
                    if (response.success) {
                        window.location.href = '../View/login.html';
                    }
                }
            };
            xhttp.send(JSON.stringify(data));
        }
    </script>
</body>
</html>
