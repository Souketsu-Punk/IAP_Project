<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $exchange_id = intval($_POST['exchange_id']);
    $rating = intval($_POST['rating']);
    $comment = trim($_POST['comment']);

    if ($rating < 1 || $rating > 5) {
        header("Location: Completed_contacts.php");
        exit;
    }

    
    $check = $conn->prepare("
        SELECT e.id
        FROM exchanges e
        JOIN skills s ON e.skill_id = s.id
        WHERE e.id = ?
          AND e.status = 'completed'
          AND (e.requester_id = ? OR s.user_id = ?)
    ");
    $check->bind_param("iii", $exchange_id, $user_id, $user_id);
    $check->execute();

    if ($check->get_result()->num_rows === 0) {
        exit;
    }

    // Prevent duplicate
    $stmt = $conn->prepare("
        INSERT INTO reviews (exchange_id, user_id, rating, comment)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->bind_param("iiis", $exchange_id, $user_id, $rating, $comment);
    $stmt->execute();

    header("Location: Completed_contacts.php");
    exit;
}


    //Show review form

if (!isset($_GET['exchange_id'])) {
    header("Location: Completed_contacts.php");
    exit;
}

$exchange_id = intval($_GET['exchange_id']);

// Verify exchange and not already reviewed
$check = $conn->prepare("
    SELECT e.id
    FROM exchanges e
    JOIN skills s ON e.skill_id = s.id
    WHERE e.id = ?
      AND e.status = 'completed'
      AND (e.requester_id = ? OR s.user_id = ?)
");
$check->bind_param("iii", $exchange_id, $user_id, $user_id);
$check->execute();

if ($check->get_result()->num_rows === 0) {
    header("Location: Completed_contacts.php");
    exit;
}

// Prevent duplicate review
$reviewCheck = $conn->prepare("
    SELECT id FROM reviews
    WHERE exchange_id = ? AND user_id = ?
");
$reviewCheck->bind_param("ii", $exchange_id, $user_id);
$reviewCheck->execute();

if ($reviewCheck->get_result()->num_rows > 0) {
    header("Location: Completed_contacts.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Leave a Review</title>
</head>
<body>
<div class="review-container">
    <h2>Leave a Review</h2>

    <form method="post" action="review.php">
        <input type="hidden" name="exchange_id" value="<?= $exchange_id ?>">

        <label for="rating">Rating</label>
        <div class="rating-hint">Choose a rating from 1 (worst) to 5 (best)</div>
        <input type="number" id="rating" name="rating" min="1" max="5" required>

        <label for="comment">Comment</label>
        <textarea id="comment" name="comment" placeholder="Write your experience (optional)"></textarea>

        <button type="submit">Submit Review</button>
    </form>
</div>
</body>
</html>

</html>
