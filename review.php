<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* =========================
   HANDLE FORM SUBMISSION
   ========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $exchange_id = intval($_POST['exchange_id']);
    $rating = intval($_POST['rating']);
    $comment = trim($_POST['comment']);

    if ($rating < 1 || $rating > 5) {
        header("Location: Completed_contacts.php");
        exit;
    }

    /* Verify user belongs to completed exchange */
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

    /* Insert review (unique constraint prevents duplicates) */
    $stmt = $conn->prepare("
        INSERT INTO reviews (exchange_id, user_id, rating, comment)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->bind_param("iiis", $exchange_id, $user_id, $rating, $comment);
    $stmt->execute();

    header("Location: Completed_contacts.php");
    exit;
}

/* =========================
   SHOW REVIEW FORM (GET)
   ========================= */

if (!isset($_GET['exchange_id'])) {
    header("Location: Completed_contacts.php");
    exit;
}

$exchange_id = intval($_GET['exchange_id']);

/* Verify exchange + not already reviewed */
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

/* Prevent duplicate review */
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .review-container {
            max-width: 450px;
            margin: 80px auto;
            background: #ffffff;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .review-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
            color: #444;
        }

        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        textarea {
            resize: vertical;
            min-height: 90px;
        }

        input[type="number"]:focus,
        textarea:focus {
            outline: none;
            border-color: #4a90e2;
        }

        button {
            width: 100%;
            background: #4a90e2;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        button:hover {
            background: #357abd;
        }

        .rating-hint {
            font-size: 12px;
            color: #777;
            margin-bottom: 10px;
        }
    </style>
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
        