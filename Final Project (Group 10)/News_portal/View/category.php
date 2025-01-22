<?php
session_start();
if (!isset($_COOKIE['status'])) {
    header('location: login.html');
    exit();
}

require_once '../Model/userModel.php';
require_once '../libs/fpdf.php'; // Ensure FPDF is properly downloaded and placed in the correct directory.

$conn = getConnection();

// Get the category ID from the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $category_id = intval($_GET['id']);
} else {
    die("Category ID is missing or invalid!");
}

// Fetch category details
$sql_category = "SELECT * FROM category WHERE category_id = $category_id";
$result_category = mysqli_query($conn, $sql_category);
if (!$result_category) {
    die("Error fetching category: " . mysqli_error($conn));
}
$category_details = mysqli_fetch_assoc($result_category);
if (!$category_details) {
    die("No category found with the provided ID.");
}

// Fetch posts for the category
$sql_posts = "SELECT * FROM post WHERE category_id = $category_id";
$result_posts = mysqli_query($conn, $sql_posts);
if (!$result_posts) {
    die("Error fetching posts: " . mysqli_error($conn));
}

// Handle Like functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['like_post_id'])) {
    $post_id = intval($_POST['like_post_id']);
    $sql_like = "UPDATE post SET likes = likes + 1 WHERE post_id = $post_id";
    if (!mysqli_query($conn, $sql_like)) {
        echo "Error updating likes: " . mysqli_error($conn);
    }
}

// Handle Comment functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_post_id'])) {
    $post_id = intval($_POST['comment_post_id']);
    $user_id = $_SESSION['user_id']; // Use the logged-in user's ID
    $comment_text = mysqli_real_escape_string($conn, $_POST['comment_text']);

    $sql_add_comment = "INSERT INTO comments (post_id, user_id, comment_text) VALUES ($post_id, $user_id, '$comment_text')";
    if (!mysqli_query($conn, $sql_add_comment)) {
        echo "Error adding comment: " . mysqli_error($conn);
    }
}

// Handle Save for Later functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_post_id'])) {
    $post_id = intval($_POST['save_post_id']);
    $user_id = $_SESSION['user_id']; // Use the logged-in user's ID

    $sql_save_article = "INSERT INTO saved_articles (user_id, post_id, title, content) 
                         SELECT $user_id, post_id, title, description FROM post WHERE post_id = $post_id";
    if (!mysqli_query($conn, $sql_save_article)) {
        echo "Error saving article: " . mysqli_error($conn);
    }
}

// Handle PDF download functionality
if (isset($_GET['download_id']) && is_numeric($_GET['download_id'])) {
    $post_id = intval($_GET['download_id']);
    $sql_post = "SELECT * FROM post WHERE post_id = $post_id";
    $result_post = mysqli_query($conn, $sql_post);

    if ($result_post && mysqli_num_rows($result_post) > 0) {
        $post = mysqli_fetch_assoc($result_post);

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(0, 10, $post['title'], 0, 1, 'C');
        $pdf->Ln(10);
        $pdf->SetFont('Times', '', 12);
        $pdf->MultiCell(0, 10, $post['description']);
        $pdf->Output('D', 'Article-' . $post_id . '.pdf');
        exit();
    } else {
        die("Error fetching post or post does not exist.");
    }
}
?>

<?php include('header.php'); ?>

<!-- Display Category Details -->
<div class="category-details">
    <center>
        <h2><?php echo htmlspecialchars($category_details['category_name']); ?></h2>
    </center>
</div>

<!-- Display Posts -->
<div class="posts">
    <?php if (mysqli_num_rows($result_posts) > 0): ?>
        <?php while ($post = mysqli_fetch_assoc($result_posts)): ?>
            <div class="post" style="display: flex; margin-bottom: 20px; border: 1px solid #ddd; padding: 10px; border-radius: 8px;">
                <!-- Left Section (Image) -->
                <div class="post-image" style="flex: 1; margin-right: 20px;">
                    <?php
                    $img_path = "../uploads/" . basename($post['post_img']);
                    if (file_exists($img_path)) {
                        echo "<img src='$img_path' alt='" . htmlspecialchars($post['title']) . "' style='width: 100%; height: auto; max-width: 300px;'>";
                    } else {
                        echo "<img src='default.jpg' alt='Default Image' style='width: 100%; height: auto; max-width: 300px;'>";
                    }
                    ?>
                </div>

                <!-- Right Section (Description) -->
                <div class="post-description" style="flex: 2;">
                    <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                    <p><?php echo htmlspecialchars($post['description']); ?></p>
                    <p>Posted on: <?php echo htmlspecialchars($post['post_date']); ?></p>

                    <!-- Like Form -->
                    <form action="" method="POST" style="display:inline;">
                        <input type="hidden" name="like_post_id" value="<?php echo $post['post_id']; ?>">
                        <button type="submit" class="btn-like" style="background-color: #007bff; color: #fff; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer;">
                            Like (<?php echo $post['likes']; ?>)
                        </button>
                    </form>

                    <!-- Download Button -->
                    <a href="?id=<?php echo $category_id; ?>&download_id=<?php echo $post['post_id']; ?>" class="btn-download" style="margin-left: 10px; background-color: #ffc107; color: #fff; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none;">
                        Download
                    </a>

                    <!-- Save for Later Button -->
                    <form action="" method="POST" style="display:inline; margin-left: 10px;">
                        <input type="hidden" name="save_post_id" value="<?php echo $post['post_id']; ?>">
                        <button type="submit" class="btn-save-later" style="background-color: #28a745; color: #fff; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer;">
                            Save for Later
                        </button>
                    </form>

                    <!-- Share Button -->
                    <button onclick="showShareOptions('<?php echo $post['post_id']; ?>')" class="btn-share" style="margin-left: 10px; background-color: #17a2b8; color: #fff; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer;">Share</button>

                    <!-- Share Options -->
                    <div id="share-options-<?php echo $post['post_id']; ?>" style="display: none; margin-top: 10px;">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('https://yourwebsite.com/post.php?id=' . $post['post_id']); ?>" target="_blank">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook" style="width: 40px; height: 40px; margin-right: 10px; cursor: pointer;">
                        </a>
                        <a href="https://wa.me/?text=<?php echo urlencode('Check out this post: https://yourwebsite.com/post.php?id=' . $post['post_id']); ?>" target="_blank">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" style="width: 40px; height: 40px; margin-right: 10px; cursor: pointer;">
                        </a>
                        <a href="https://www.instagram.com/" target="_blank">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" alt="Instagram" style="width: 40px; height: 40px; cursor: pointer;">
                        </a>
                    </div>

                    <!-- Comment Section -->
                    <div class="comments-section">
                        <h4>Comments:</h4>

                        <!-- Display Comments -->
                        <?php
                        $sql_comments = "SELECT c.comment_text, u.username 
                                         FROM comments c 
                                         JOIN user u ON c.user_id = u.user_id 
                                         WHERE c.post_id = {$post['post_id']} 
                                         ORDER BY c.comment_date DESC";
                        $result_comments = mysqli_query($conn, $sql_comments);

                        if (mysqli_num_rows($result_comments) > 0) {
                            while ($comment = mysqli_fetch_assoc($result_comments)) {
                                echo "<div class='comment'>";
                                echo "<p><strong>" . htmlspecialchars($comment['username']) . ":</strong> " . nl2br(htmlspecialchars($comment['comment_text'])) . "</p>";
                                echo "</div>";
                            }
                        } else {
                            echo "<p>No comments yet.</p>";
                        }
                        ?>

                        <!-- Add New Comment -->
                        <form action="" method="POST" style="margin-top: 10px;">
                            <input type="hidden" name="comment_post_id" value="<?php echo $post['post_id']; ?>">
                            <textarea name="comment_text" placeholder="Add a comment..." required style="width: 100%; padding: 10px;"></textarea><br>
                            <button type="submit" style="background-color: #007bff; color: #fff; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer;">Post Comment</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No posts available in this category.</p>
    <?php endif; ?>
</div>

<script>
    function showShareOptions(postId) {
        document.querySelectorAll('[id^="share-options-"]').forEach(element => {
            element.style.display = 'none';
        });

        const shareOptions = document.getElementById('share-options-' + postId);
        if (shareOptions.style.display === 'none') {
            shareOptions.style.display = 'block';
        } else {
            shareOptions.style.display = 'none';
        }
    }
</script>
