<?php
session_start();
require_once '../Model/userModel.php'; // Include database connection logic


?>

<!DOCTYPE html>
<html>
<head>
    <title>Alerts</title>
</head>
<body>

<h1>Alerts</h1>
<p><?php echo $message; ?></p>

</body>
</html>
