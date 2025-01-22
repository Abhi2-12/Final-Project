<?php
    session_start();
    if(!isset($_COOKIE['status'])){
        header('location: login.html'); 
    }
?>

<?php

require_once '../Model/userModel.php';

if (isset($_SESSION['email'])) {
    // Get the logged-in user's ID
    $userId = getUserIdByEmail($_SESSION['email']);
    
    // Check if user ID is valid
    if ($userId) {
        // Fetch the user's preferences (category IDs)
        $preferences = getUserPreferences($userId);
        
        // Check if the user has preferences
        if (!empty($preferences)) {
            // Fetch preferred news based on user's preferences
            $preferredNews = getNewsByCategories($preferences);
        } else {
            $preferredNews = [];
        }
    } else {
        // Handle the case where the user is not found
        $preferredNews = [];
    }
} else {
    $preferredNews = [];
}


   $categories = getCategories();
?>

<?php include('header.php'); ?>
<style>
 
    .breaking-news {
        background-color: rgb(255, 102, 0); /* Dark orange background */
        color: #fff; /* White text */
        padding: 10px 20px; /* Increased padding for better spacing */
        display: flex; /* Flexbox for layout */
        align-items: center; /* Vertically center items */
        font-size: 18px; /* Adjusted font size */
    }
 
    .breaking-news span {
        font-weight: bold; /* Bold text for the "Breaking News" label */
        margin-right: 15px; /* Space between label and scrolling text */
        flex-shrink: 0; /* Prevent the label from shrinking */
    }
 
    .breaking-news-slider {
        flex-grow: 1; /* Allow the slider to take up available space */
        overflow: hidden; /* Prevent content overflow */
    }
 
    .breaking-news-slider marquee {
        font-size: 16px; /* Adjust font size for readability */
        white-space: nowrap; /* Prevent text wrapping */
        color: rgb(238, 242, 247); /* Golden-like text color */
    }
 
        /* Preferred News Section */
    .preferred-news {
        padding: 20px;
        background-color: #f9f9f9; /* Light grey background */
        border-radius: 8px; /* Rounded corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        margin-top: 20px;
    }
 
    .preferred-news h2 {
        font-size: 24px;
        color: #333; /* Darker color for the heading */
        margin-bottom: 20px;
        font-weight: bold;
    }
 
    .news-item {
        background-color: #fff;
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 15px; /* Spacing between news items */
        transition: background-color 0.3s ease; /* Smooth transition effect */
    }
 
    .news-item:hover {
        background-color: #f1f1f1; /* Highlight news item on hover */
    }
 
    .news-item h3 {
        font-size: 20px;
        color: #007bff; /* Blue color for titles */
        margin-bottom: 10px;
    }
 
    .news-item p {
        font-size: 14px;
        color: #555; /* Lighter grey for description */
        margin-bottom: 10px;
        line-height: 1.5;
    }
 
    .news-item a {
        font-size: 14px;
        color: #007bff; /* Blue color for the link */
        text-decoration: none;
    }
 
    .news-item a:hover {
        text-decoration: underline; /* Underline the link on hover */
    }
 
       
   
</style>
 
 
<!----><div class="breaking-news">
    <span>Trending News:</span>
    <div class="breaking-news-slider">
        <marquee behavior="scroll" direction="left">
            <?php
            if ($latestPostTitle) {
                echo htmlspecialchars($latestPostTitle); // Sanitize the output
            } else {
                echo "No breaking news available at the moment.";
            }
            ?>
        </marquee>
    </div>
</div>


        <div class="preferred-news">
            <h2>News based on interest</h2>
            <?php
            if (!empty($preferredNews)) {
                foreach ($preferredNews as $news) {
                    echo "<div class='news-item'>";
                    echo "<h3>" . htmlspecialchars($news['title']) . "</h3>";
                    echo "<p>" . htmlspecialchars(substr($news['description'], 0, 100)) . "...</p>";
                    echo "<a href='category.php?id=" . htmlspecialchars($news['category_id']) . "'>See more....</a>";
                    echo "</div>";
                }
            } else {
                echo "<p>No preferred news available.</p>";
            }
            ?>
        </div>






