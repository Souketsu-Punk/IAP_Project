<?php
session_start();
include 'includes/db.php';

if(!isset($_SESSION['user_id'])) header("Location: login.php");

if(isset($_GET['exchange_id'], $_GET['action'])){
    $exchange_id = intval($_GET['exchange_id']);
    $action = $_GET['action'];

    if($action === 'accept'){
        $status = 'accepted';
    } else {
        $status = 'declined';
    }

    $stmt = $conn->prepare("UPDATE exchanges SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $exchange_id);
    $stmt->execute();

    echo "Exchange $status!";
}
