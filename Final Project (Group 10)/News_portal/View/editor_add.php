<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Editor</title>
    <link rel="stylesheet" href="../Style/styles.css">
</head>
<body>
    <div class="container">
        <h1>Add Editor</h1>
        <form id="addEditorForm">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required />

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required />

            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" required />

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required />

            <button type="button" onclick="submitEditorForm()">Add Editor</button>
        </form>

        <div id="responseMessage"></div>

        <div class="back-btn">
            <a href="../View/editorlist.php">Back</a>
        </div>
    </div>

    <script>
        // Validation function for client-side checks
            function validateForm() {
            const username = document.getElementById('username').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;
            const password = document.getElementById('password').value;

            // Basic checks for empty fields
            if (!username || !email || !phone || !password) {
                document.getElementById('responseMessage').innerText = "All fields are required.";
                return false;
            }

            // Phone number validation (must be 11 digits)
            if (!/^\d{11}$/.test(phone)) {
                document.getElementById('responseMessage').innerText = "Phone number must be 11 digits.";
                return false;
            }

            // Email format validation
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(email)) {
                document.getElementById('responseMessage').innerText = "Please enter a valid email address.";
                return false;
            }

            // Password length validation (minimum 8 characters)
            if (password.length < 8) {
                document.getElementById('responseMessage').innerText = "Password must be at least 8 characters.";
                return false;
            }

            // Clear the response message if validation passes
            document.getElementById('responseMessage').innerText = "";
            return true;
        }

        function submitEditorForm() {
            if (!validateForm()) return;

            const formData = {
                username: document.getElementById('username').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                password: document.getElementById('password').value,
            };

            // AJAX request
            const xhttp = new XMLHttpRequest();
            xhttp.open('POST', '../Controller/editor_add_check.php', true);
            xhttp.setRequestHeader('Content-Type', 'application/json');
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    const response = JSON.parse(this.responseText);
                    document.getElementById('responseMessage').innerText = response.message;
                    if (response.success) {
                        window.location.href = '../View/editorlist.php';
                    }
                }
            };
            xhttp.send(JSON.stringify(formData));
        }
    </script>
</body>
</html>
