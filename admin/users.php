<?php
session_start();
include '../includes/db.php';
if(!isset($_SESSION['admin_id'])) header("Location: login.php");

$users = $conn->query("SELECT * FROM users");
?>

<head>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<h2>All Users</h2>
<table>
<tr><th>ID</th><th>Username</th><th>Email</th></tr>
<?php while($row = $users->fetch_assoc()): ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo htmlspecialchars($row['username']); ?></td>
    <td><?php echo htmlspecialchars($row['email']); ?></td>
</tr>
<?php endwhile; ?>
</table>
