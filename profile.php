<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$viewer_id = $_SESSION['user_id'];
$profile_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : $viewer_id;



$user = $conn->query("SELECT * FROM users WHERE id = $profile_id")->fetch_assoc();

if (!$user) {
    echo "<p style='text-align:center;'>User not found.</p>";
    exit;
}


$skills = $conn->query("SELECT * FROM skills WHERE user_id = $profile_id");


$Reviews = $conn->query("
    SELECT rating, comment, created_at AS Date
    FROM reviews
    WHERE user_id = $profile_id
");


$reviewData = [];
$totalRating = 0;

while ($r = $Reviews->fetch_assoc()) {
    $reviewData[] = $r;
    $totalRating += (int)$r['rating'];
}

$reviewCount = count($reviewData);
$averageRating = $reviewCount > 0 ? round($totalRating / $reviewCount, 1) : 0;
?>

<h2><?= htmlspecialchars($user['username']); ?>'s Profile</h2>

<?php if ($reviewCount > 0): ?>
    <p style="text-align:center; font-weight:600; margin-top:10px;">
            <?= $averageRating; ?> / 5
        <span style="color:#777;">(<?= $reviewCount; ?> reviews)</span>
    </p>
<?php endif; ?>

<?php if ($viewer_id === $profile_id): ?>
    <div style="text-align:center; margin:20px 0;">
        <button class="add-skill-btn" onclick="location.href='add_skill.php'">
            Add Skill
        </button>
    </div>
<?php endif; ?>

<h3>Skills</h3>

<div class="skills-container">
    <?php if ($skills->num_rows > 0): ?>
        <?php while ($skill = $skills->fetch_assoc()): ?>
            <div class="skill-card">
                <h3><?= htmlspecialchars($skill['title']); ?></h3>
                <p><?= htmlspecialchars($skill['description']); ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="color:#777;">No skills added yet.</p>
    <?php endif; ?>
</div>

<h3>Reviews</h3>

<div class="reviews-section">
    <?php if ($reviewCount > 0): ?>
        <div class="reviews-list">
            <?php foreach ($reviewData as $review): ?>
                <div class="review-card">
                    <div class="review-rating">
                        <?= (int)$review['rating']; ?> / 5
                    </div>

                    <p class="review-comment">
                        <?= htmlspecialchars($review['comment']); ?>
                    </p>

                    <div class="review-date">
                        <?= date("F j, Y", strtotime($review['Date'])); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="no-reviews">No reviews yet.</p>
    <?php endif; ?>
</div>
