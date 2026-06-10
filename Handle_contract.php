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

/*
  Verifies that:
  The exchange exists
  The logged-in user is the requested user (skill owner)
*/
$check = $conn->prepare("
    SELECT e.id
    FROM exchanges e
    JOIN skills s ON e.skill_id = s.id
    WHERE e.id = ? AND s.user_id = ? AND e.status = 'pending'
");
$check->bind_param("ii", $exchange_id, $user_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows === 0) {
    // Not authorized or already handled
    header("Location: Contracts.php");
    exit;
}

//ACTION HANDLING
if ($action === 'accept') {

    $stmt = $conn->prepare("
        UPDATE exchanges
        SET status = 'ongoing'
        WHERE id = ?
    ");
    $stmt->bind_param("i", $exchange_id);
    $stmt->execute();

} elseif ($action === 'reject') {

    $stmt = $conn->prepare("
        DELETE FROM exchanges
        WHERE id = ?
    ");
    $stmt->bind_param("i", $exchange_id);
    $stmt->execute();

}

header("Location: Contracts.php");
exit;
