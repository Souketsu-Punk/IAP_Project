<?php
session_start();
include '../includes/db.php';

if(!isset($_SESSION['admin_id'])) header("Location: login.php");
?>
<head>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<h2>Admin Dashboard</h2>
<ul>
    <li><a href="users.php">Manage Users</a></li>
    <li><a href="skills.php">Manage Skills</a></li>
    <li><a href="exchanges.php">Manage Exchanges</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>
