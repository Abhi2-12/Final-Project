<?php
require_once '../Model/userModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['category_name'])) {
        $category_name = $_POST['category_name'];

        // Add category to the database
        if (addCategory($category_name)) {
            header('Location: ../View/adminhome.php');
            exit;
        } else {
            echo "Failed to add category.";
        }
    } else {
        echo "Category name is required.";
    }
}


?>