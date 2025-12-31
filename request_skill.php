<?php
session_start();
include 'includes/db.php';

// Check login
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(isset($_GET['skill_id'])){
    $skill_id = intval($_GET['skill_id']);
    $user_id = $_SESSION['user_id'];

    // Prevent duplicate requests
    $stmt = $conn->prepare("SELECT * FROM exchanges WHERE skill_id=? AND requester_id=? AND status='pending'");
    $stmt->bind_param("ii", $skill_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        header("Location: index.php?request=already");
        exit();
    }

    // Insert exchange request
    $stmt = $conn->prepare("INSERT INTO exchanges (skill_id, requester_id, status) VALUES (?,?, 'pending')");
    $stmt->bind_param("ii", $skill_id, $user_id);
    $stmt->execute();

    header("Location: index.php?request=success");
    exit();
}
?>
