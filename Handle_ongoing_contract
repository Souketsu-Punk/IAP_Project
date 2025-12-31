<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (!isset($_POST['exchange_id'], $_POST['action'])) {
    header("Location: Contracts.php");
    exit;
}

$exchange_id = intval($_POST['exchange_id']);
$action = $_POST['action'];

/* Validate action */
$allowed_actions = ['complete', 'cancel'];
if (!in_array($action, $allowed_actions)) {
    exit('Invalid action');
}

/* Verify user is part of this ongoing contract */
$check = $conn->prepare("
    SELECT e.id
    FROM exchanges e
    JOIN skills s ON e.skill_id = s.id
    WHERE e.id = ?
      AND e.status = 'ongoing'
      AND (e.requester_id = ? OR s.user_id = ?)
");
$check->bind_param("iii", $exchange_id, $user_id, $user_id);
$check->execute();

if ($check->get_result()->num_rows === 0) {
    header("Location: Ongoing_contracts.php");
    exit;
}

//Update status based on action
if ($action === 'complete') {
    $stmt = $conn->prepare("UPDATE exchanges SET status = 'completed' WHERE id = ?");
    $stmt->bind_param("i", $exchange_id);
    $stmt->execute();
} else { 
    // cancel contract
    $stmt = $conn->prepare("UPDATE exchanges SET status = 'cancelled' WHERE id = ?");
    $stmt->bind_param("i", $exchange_id);
    $stmt->execute();
}

header("Location: Ongoing_contracts.php?msg=Contract+updated");
exit;
