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

        input[type="text"],
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

        input[type="text"]:focus,
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