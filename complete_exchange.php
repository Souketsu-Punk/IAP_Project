<?php
session_start();
include 'includes/db.php';

if(!isset($_SESSION['user_id'])) header("Location: login.php");

if(isset($_GET['exchange_id'])){
    $exchange_id = intval($_GET['exchange_id']);

    $stmt = $conn->prepare("UPDATE exchanges SET status='completed' WHERE id=?");
    $stmt->bind_param("i", $exchange_id);
    $stmt->execute();

    echo "Exchange marked as completed!";
}
