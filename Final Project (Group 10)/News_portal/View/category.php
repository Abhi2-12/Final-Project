<?php
session_start();
if (!isset($_COOKIE['status'])) {
    header('location: login.html');
    exit();
}
 
require_once '../Model/userModel.php';
require_once '../libs/fpdf.php';
 
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
 
// Handle Like functionality (AJAX)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['like_post_id'])) {
    $post_id = intval($_POST['like_post_id']);
    $sql_like = "UPDATE post SET likes = likes + 1 WHERE post_id = $post_id";
    if (mysqli_query($conn, $sql_like)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
    exit;
}
 
// Handle Comment functionality (AJAX)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_post_id'])) {
    $post_id = intval($_POST['comment_post_id']);
    $user_id = $_SESSION['user_id'];
    $comment_text = mysqli_real_escape_string($conn, $_POST['comment_text']);
 
    $sql_add_comment = "INSERT INTO comments (post_id, user_id, comment_text) VALUES ($post_id, $user_id, '$comment_text')";
    if (mysqli_query($conn, $sql_add_comment)) {
        $last_comment_id = mysqli_insert_id($conn);
        $sql_user = "SELECT username FROM user WHERE user_id = $user_id";
        $result_user = mysqli_query($conn, $sql_user);
        $user = mysqli_fetch_assoc($result_user);
        $response = [
            'status' => 'success',
            'username' => $user['username'],
            'comment_text' => nl2br($comment_text),
            'comment_id' => $last_comment_id
        ];
        echo json_encode($response);
    } else {
        echo json_encode(['status' => 'error']);
    }
    exit;
}
 
// Handle Save for Later functionality (AJAX)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_post_id'])) {
    $post_id = intval($_POST['save_post_id']);
    $user_id = $_SESSION['user_id'];
 
    $sql_save_article = "INSERT INTO saved_articles (user_id, post_id, title, content)
                         SELECT $user_id, post_id, title, description FROM post WHERE post_id = $post_id";
    if (mysqli_query($conn, $sql_save_article)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
    exit;
}
 
// Handle PDF download functionality (AJAX)
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
        exit;
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
 
                <div class="post-description" style="flex: 2;">
                    <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                    <p><?php echo htmlspecialchars($post['description']); ?></p>
                    <p>Posted on: <?php echo htmlspecialchars($post['post_date']); ?></p>
 
                    <!-- Like Button (AJAX) -->
                    <button onclick="likePost(<?php echo $post['post_id']; ?>)" class="btn-like" style="background-color: #007bff; color: #fff; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer;">
                        Like (<span id="likes-<?php echo $post['post_id']; ?>"><?php echo $post['likes']; ?></span>)
                    </button>
 
                    <!-- Download Button (AJAX) -->
                    <button onclick="downloadPost(<?php echo $post['post_id']; ?>)" class="btn-download" style="background-color: #ffc107; color: #fff; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer;">
                        Download PDF
                    </button>
 
                    <!-- Save for Later Button (AJAX) -->
                    <button onclick="saveForLater(<?php echo $post['post_id']; ?>)" class="btn-save-later" style="background-color: #28a745; color: #fff; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer;">
                        Save for Later
                    </button>
 
                    <!-- Share Button -->
                    <button onclick="showShareOptions('<?php echo $post['post_id']; ?>')" class="btn-share" style="margin-left: 10px; background-color: #17a2b8; color: #fff; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer;">Share</button>
 
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
                        <div id="comments-<?php echo $post['post_id']; ?>">
                            <!-- Comments will load here dynamically -->
                        </div>
 
                        <textarea id="comment-text-<?php echo $post['post_id']; ?>" placeholder="Add a comment..." required style="width: 100%; padding: 10px;"></textarea><br>
                        <button onclick="postComment(<?php echo $post['post_id']; ?>)" style="background-color: #007bff; color: #fff; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer;">Post Comment</button>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No posts available in this category.</p>
    <?php endif; ?>
</div>
 
<script>
    // AJAX for Like
    function likePost(postId) {
        fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `like_post_id=${postId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    let likesElement = document.getElementById(`likes-${postId}`);
                    likesElement.innerText = parseInt(likesElement.innerText) + 1;
                }
            });
    }
 
    // AJAX for Save for Later
    function saveForLater(postId) {
        fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `save_post_id=${postId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert("Article saved for later!");
                } else {
                    alert("Error saving article.");
                }
            });
    }
 
    // AJAX for Commenting
    function postComment(postId) {
        const commentText = document.getElementById(`comment-text-${postId}`).value;
        fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `comment_post_id=${postId}&comment_text=${commentText}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    let commentsDiv = document.getElementById(`comments-${postId}`);
                    commentsDiv.innerHTML = `<div><strong>${data.username}:</strong> ${data.comment_text}</div>` + commentsDiv.innerHTML;
                    document.getElementById(`comment-text-${postId}`).value = ''; // Clear comment text
                }
            });
    }
 
    // Show Share Options
    function showShareOptions(postId) {
        let shareOptions = document.getElementById(`share-options-${postId}`);
        shareOptions.style.display = shareOptions.style.display === 'block' ? 'none' : 'block';
    }
 
    // AJAX for PDF Download
    function downloadPost(postId) {
        window.location.href = `?download_id=${postId}`; // Forces download without reloading
    }
</script>
