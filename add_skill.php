<?php
session_start();
include 'includes/db.php';

if(!isset($_SESSION['user_id'])) header("Location: login.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_POST['title'], $_POST['description'], $_POST['category'])) {
        die("Missing form data");
    }

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("
        INSERT INTO skills (user_id, title, description, category)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->bind_param("isss", $user_id, $title, $description, $category);
    $stmt->execute();

    echo "Skill added!";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add a Skill</title>
</head>
<body>
<div class="review-container">
    <h2>Add SKill</h2>

    <form method="post" action="add_skill.php">

    <label for="title">Add Skill</label>
    <div class="rating-hint">Choose a title for the skill</div>
    <input type="text" id="title" name="title" required>

    <label for="description">Description</label>
    <input type="text" id="description" name="description" required
           placeholder="Write a brief description of what you do">

    <label for="category">Category</label>
    <input type="text" id="category" name="category" required>

    <button type="submit">Add Skill</button>
</form>

</div>
</body>
</html>