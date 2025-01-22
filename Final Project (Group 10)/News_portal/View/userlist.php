<?php
    session_start();
    if(!isset($_COOKIE['status'])){
        header('location: login.html'); 
    }

    // Include database functions
    require_once '../Model/userModel.php';

    // Fetch all users using getUsers function from userModel
    
    
    // Fetch all users
    
?>

<html>
<head>
    <title>View Users</title>
    <style>
        /* General Page Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color:rgb(255, 252, 252);
        }

        h1 {
            text-align: center;
            background-color:rgb(80, 196, 224);
            color: #333;
            margin-top: 50px;
            padding: 30px 0;
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

        /* Responsive Design */
        @media (max-width: 768px) {
            table {
                width: 100%;
            }

            th, td {
                font-size: 14px;
            }
        }

        .button {
            display: inline-block; 
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .button:hover {
            background-color: #45a049;
            text-decoration: none;
        }

    </style>
</head>
<body>
        <h1>User List</h1>
        
        <br>

        <table border=1>
            <tr>
                <th>id</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Password</th>
                <th>Action</th>
            </tr>
            <?php 
                foreach($users as $user){
            ?>
            <tr>
                <td><?php echo $user['user_id']; ?></td>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['phone']; ?></td>
                <td><?php echo $user['password']; ?></td>
                <td>
                <a href='user_delete.php?user_id=<?php echo $user['user_id']; ?>'> DELETE </a> 
                </td>
            </tr>
            <?php } ?>
        </table>
        <a href="home.php" class="button">Back</a>

</body>
</html>
