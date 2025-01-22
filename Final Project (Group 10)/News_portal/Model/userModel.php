<?php
function getConnection(){
    $conn = mysqli_connect('127.0.0.1', 'root', '', 'member');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}


/////////login
// Login function for regular users
function login($email, $password) {
    
    $conn = getConnection();  
    $sql = "SELECT * FROM user WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {
        return 'user';  
    }
    return false;
}

// Login function for admin users
function adminlogin($email, $password) {
    
    $conn = getConnection();
    $sql = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {
        return 'admin';  
    }
    return false;
}

// Login function for editor users
function editorlogin($email, $password) {
  
    $conn = getConnection();
    $sql = "SELECT * FROM editor WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {
        return 'editor';  // 'editor' role 
    }
    return false;
}





/*--------------------------------------------------------------*/

/////////////USER///////////////

function addUser($username,$email,$phone, $password){
    $conn = getConnection();
    $sql ="INSERT INTO user (username, email, phone, password) VALUES ('{$username}', '{$email}', '{$phone}', '{$password}')";
    if(mysqli_query($conn, $sql)){
        return true;
    }else{
        return false;
    }
}

function getUsers() {
    $conn = getConnection();
    $sql = "SELECT * FROM user"; 
    $result = mysqli_query($conn, $sql) or die("Error: " . mysqli_error($conn));
    $users = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
    }
    mysqli_close($conn);
    return $users;
}
$users = getUsers();



function deleteUser($user_id) {
    $conn = getConnection();

    // First,  user preferences 
    $sql_preferences = "DELETE FROM user_preferences WHERE user_id = '{$user_id}'";
    if (!mysqli_query($conn, $sql_preferences)) {
        return false; // Return false if there's an error deleting the preferences
    }

    // Now, delete the user
    $sql_user = "DELETE FROM user WHERE user_id = '{$user_id}'";
    if (mysqli_query($conn, $sql_user)) {
        return true;
    } else {
        return false;
    }
}

/*--------------------------------------------------------------*/

//////////////////////editor////////

function addEditor($username, $email, $phone, $password) {
    $conn = getConnection();
    $sql = "INSERT INTO editor (username, email, phone, password) VALUES ('{$username}', '{$email}', '{$phone}', '{$password}')";
    
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false;
    }
}

// Function to fetch data from the editor table
function getEditors() {
    $conn = getConnection(); 
    $sql = "SELECT * FROM editor"; 
    $result = mysqli_query($conn, $sql) or die("Error: " . mysqli_error($conn));

    $editors = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $editors[] = $row;
        }
    }
    mysqli_close($conn);
    return $editors;
}


$editors = getEditors();




function updateEditor($editor_id, $username, $email, $phone, $password){
    $conn = getConnection();
    $sql = "UPDATE editor SET username = '{$username}', email = '{$email}', phone = '{$phone}', password = '{$password}' WHERE editor_id = '{$editor_id}'";

    
    if(mysqli_query($conn, $sql)){
        return true;
    }else{
        return false;
    }
}


// Function to delete an editor by editor_id
function deleteEditor($editor_id) {
    $conn = getConnection();
    $sql = "DELETE FROM editor WHERE editor_id = '{$editor_id}'";
    
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false;
    }
}


//////////////////////////category////////////////


// Function to add a category to the database
function addCategory($category_name) {
    $conn = getConnection();
    $sql = "INSERT INTO category (category_name) VALUES ('{$category_name}')";
    return mysqli_query($conn, $sql);
}


function getCategories() {
    $conn = getConnection();
    $sql = "SELECT * FROM category"; // Fetch all categories
    $result = mysqli_query($conn, $sql);
    $categories = [];

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row; 
        }
    }
    mysqli_close($conn);
    return $categories; // Return the array of categories
}
$categories = getCategories();



function getCategoryDetails($category_id) {
    $conn = getConnection();
    $sql = "SELECT * FROM category WHERE category_id = {$category_id}"; 
    $result = mysqli_query($conn, $sql);
    $category_details = [];

    if ($result && mysqli_num_rows($result) > 0) {
        $category_details = mysqli_fetch_assoc($result); // add category details
    }

    mysqli_close($conn);
    return $category_details;
}



///////////////////////////////////post////////////////////////////////////////

function getPosts() {
    $conn = getConnection();
    $sql = "SELECT * FROM post ORDER BY post_date DESC";
    $result = mysqli_query($conn, $sql);
    $posts = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $posts[] = $row;
        }
    }
    mysqli_close($conn);
    return $posts;
}

function getPostsByCategory($category_id) {
    $conn = getConnection();
    $sql = "SELECT * FROM post WHERE category_id = $category_id ORDER BY post_date DESC";
    $result = mysqli_query($conn, $sql);
    $posts = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $posts[] = $row;
        }
    }
    mysqli_close($conn);
    return $posts;
}


///////////////////profile////////////////


function getUserIdByEmail($email) {
    $conn = getConnection();
    $sql = "SELECT user_id FROM user WHERE email = '{$email}'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return isset($user['user_id']) ? $user['user_id'] : null; 
}



// fetch user by user_id
function getUserById($userId) {
    $conn = getConnection();
    $sql = "SELECT * FROM user WHERE user_id = '{$userId}'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result); // Return user data
    } else {
        return null; // Return null if no user is found
    }
}


// Function to fetch user profile by user_id
function getUserProfile($user_id) {
    $conn = getConnection();
    $sql = "SELECT * FROM user WHERE user_id = {$user_id}"; // Query to fetch user profile
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $user;
}


function updateUser($userId, $username, $email, $phone, $password) {
    $conn = getConnection();

    // updating user details
    $sql = "UPDATE user SET username = '{$username}', email = '{$email}', phone = '{$phone}', password = '{$password}' WHERE user_id = '{$userId}'";

    if (mysqli_query($conn, $sql)) {
        return true;  
    } else {
        return false; 
    }
}


//////////////////////count//////////////////////////

// Function to get the total number of news articles
function getTotalPost() {
    $conn = getConnection();
    $sql = "SELECT COUNT(*) AS total FROM post"; 
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);
    return $data['total']; 
}

// Function to get the total number of registered users
function getTotalUsers() {
    $conn = getConnection();
    $sql = "SELECT COUNT(*) AS total FROM user"; 
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);
    return $data['total']; // Return the count of users
}

// Function to get the total number of categories
function getTotalCategories() {
    $conn = getConnection();
    $sql = "SELECT COUNT(*) AS total FROM category"; 
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);
    return $data['total']; // Return the count of categories
}



//////////////////pefer////
function saveUserPreferences($user_id, $preferences) {
    $conn = getConnection();

    
    foreach ($preferences as $category_id) {
        $sql = "INSERT INTO user_preferences (user_id, category_id) VALUES ('{$user_id}', '{$category_id}')";
        if (!mysqli_query($conn, $sql)) {
            echo "Error saving preference: " . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
}


// Function to delete old preferences of a user before updating
function deleteUserPreferences($userId) {
    $conn = getConnection();
    $sql = "DELETE FROM user_preferences WHERE user_id = '{$userId}'";
    return mysqli_query($conn, $sql);
}


// Fetch user's preferences
function getUserPreferences($userId) {
    $conn = getConnection();
    $sql = "SELECT category_id FROM user_preferences WHERE user_id = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $userId);  // Bind $userId as an integer
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $preferences = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $preferences[] = $row['category_id'];
        }
        
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($conn);
    return $preferences;
}


/*function getUserIdByEmail($email) {
    $conn = getConnection();
    $sql = "SELECT user_id FROM user WHERE email = '{$email}'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return isset($user['user_id']) ? $user['user_id'] : null; // Return the user_id or null if not found
}*/


function getNewsByCategories($preferences) {
    $conn = getConnection();

    // Ensure the preferences are not empty
    if (empty($preferences)) {
        return [];  // Return an empty array if no preferences
    }

    // Convert preferences to comma-separated string
    $categoryIds = implode(",", $preferences);

    
    

    $sql = "SELECT * FROM post WHERE category_id IN ($categoryIds) ORDER BY post_date DESC";
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if (!$result) {
        echo "Error with query: " . mysqli_error($conn);  // Display any errors with the query
        return [];
    }

    // Initialize array to store posts
    $preferredNews = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $preferredNews[] = $row;  // Add each post to the array
    }

    mysqli_close($conn);
    return $preferredNews;
}




/////////////////////////delete post


function deletePost($post_id) {
    $conn = getConnection();  // Get the database connection

    // SQL query to delete the post from the 'post' table based on the post_id
    $sql = "DELETE FROM post WHERE post_id = '{$post_id}'";

    // Execute the query and return true if successful, 
    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);  
        return true;
    } else {
        mysqli_close($conn);  
        return false;
    }
}

// Function to fetch only the post_id and title from the posts
function getPostTitles() {
    $conn = getConnection();  // Establish database connection
    $sql = "SELECT post_id, title FROM post";  // Query to fetch only post_id and title
    $result = mysqli_query($conn, $sql);  // Execute the query
    
    $posts = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $posts[] = $row;  // Add each post to the $posts array
        }
    }
    
    mysqli_close($conn);  // Close the database connection
    return $posts;  // Return the array of posts
}


/////////////// trending news ///////////////////////
function getLatestPost() {
    $conn = getConnection();
    $sql = "SELECT title FROM post ORDER BY post_date DESC LIMIT 1"; // recv the latest post by date
    $result = mysqli_query($conn, $sql);
 
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['title'];
    } else {
        return null; 
    }
 
    mysqli_close($conn);
}
 
$latestPostTitle = getLatestPost();


function getNewPostsCount($lastLogoutTime)
{
    $conn = new mysqli('localhost', 'root', '', 'member'); // Update with actual credentials

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT COUNT(*) as new_posts_count FROM post WHERE post_date > ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $lastLogoutTime);
    $stmt->execute();
    $result = $stmt->get_result();

    $newPostsCount = 0;
    if ($result && $row = $result->fetch_assoc()) {
        $newPostsCount = $row['new_posts_count'];
    }

    $stmt->close();
    $conn->close();

    return $newPostsCount;
}

?>


