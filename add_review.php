
<?php
session_start();
include 'includes/db.php';

if(!isset($_SESSION['user_id'])) header("Location: login.php");

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $exchange_id = $_POST['exchange_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO reviews (exchange_id, user_id, rating, comment) VALUES (?,?,?,?)");
    $stmt->bind_param("iiis", $exchange_id, $user_id, $rating, $comment);
    $stmt->execute();

    echo "Review added!";
}