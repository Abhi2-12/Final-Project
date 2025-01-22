<?php
// Connect to the database
require_once '../Model/userModel.php';

// Assuming you are fetching the editor data from the database
$editors = getEditors();  // Example function to fetch editors
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor List</title>
    <link rel="stylesheet" href="../Style/styles.css">
    <style>
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color:rgb(255, 255, 255);
        }

        h1 {
            position: absolute;
            top: 20px; /* Distance from the top of the page */
            left: 50%; /* Center horizontally */
            transform: translateX(-50%); /* Adjust for exact centering */
            text-align: center;
            color:  #007BFF;
            font-size: 50px; /* Adjust size as needed */
            font-weight: bold;
        }

        /* Table Styling */
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007BFF;
            color: #fff;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        td a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }

        td a:hover {
            text-decoration: underline;
            color: #0056b3;
        }

        /* Back Button Design */
        .back-btn {
            text-align: center;
            margin-top: 20px;
        }

        .back-btn a {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .back-btn a:hover {
            background-color: #0056b3;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            table {
                width: 100%;
            }

            th, td {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <h1>Editor List</h1>

    <table>
        <tr>
            <th>id</th>
            <th>Username</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Password</th>
            <th>Action</th>
        </tr>
        <?php foreach ($editors as $editor) { ?>
            <tr id="editor-<?php echo $editor['editor_id']; ?>">
                <td><?php echo $editor['editor_id']; ?></td>
                <td><?php echo $editor['username']; ?></td>
                <td><?php echo $editor['email']; ?></td>
                <td><?php echo $editor['phone']; ?></td>
                <td><?php echo $editor['password']; ?></td>
                <td>
                    <a href="editor_update.php?editor_id=<?php echo $editor['editor_id']; ?>"> EDIT </a>
                    <a href="javascript:void(0);" onclick="deleteEditor(<?php echo $editor['editor_id']; ?>)"> DELETE </a>
                </td>
            </tr>
        <?php } ?>
    </table>

    <div class="back-btn">
        <a href="editor_add.php">Add Editor</a>
    </div>

    <div class="back-btn">
        <a href="../View/adminhome.php">Back</a>
    </div>

    <script>

        function deleteEditor(editorId) {
            if (confirm('Are you sure you want to delete this editor?')) {
                const xhttp = new XMLHttpRequest();
                xhttp.open('POST', 'editor_delete.php', true);
                xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        const response = JSON.parse(this.responseText);
                        if (response.success) {
                            // Remove the editor row from the table
                            document.getElementById('editor-' + editorId).remove();
                            alert(response.message);
                        } else {
                            alert('Failed to delete editor: ' + response.message);
                        }
                    }
                };
                xhttp.send('editor_id=' + editorId);
            }
        }

    </script>
</body>
</html>
