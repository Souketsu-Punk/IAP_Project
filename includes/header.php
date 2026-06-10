<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Borrow My Skill</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="assets/js/script.js" defer></script>
</head>
<body>
<header class="main-header">
    <nav class="navbar">
        <ul class="nav-links" style="display:flex; justify-content:center; list-style:none; padding:10px;">
            <?php if(isset($_SESSION['user_id'])): ?>
                <li style="margin:0 10px;"><a href="/index.php">Home</a></li>
                <li style="margin:0 10px;"><a href="/profile.php">Profile</a></li>
                <li style="margin:0 10px;"><a href="/Contracts.php">Contracts</a></li>
                <li style="margin:0 10px;"><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li style="margin:0 10px;"><a href="/login.php">Login</a></li>
                <li style="margin:0 10px;"><a href="/register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<main>
