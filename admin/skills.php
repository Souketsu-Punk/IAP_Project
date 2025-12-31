<?php
session_start();
include '../includes/db.php';
if(!isset($_SESSION['admin_id'])) header("Location: login.php");

$skills = $conn->query("SELECT skills.id, skills.title, users.username 
                        FROM skills JOIN users ON skills.user_id = users.id");
?>
<head>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<h2>All Skills</h2>
<table>
<tr><th>ID</th><th>Skill</th><th>User</th></tr>
<?php while($row = $skills->fetch_assoc()): ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo htmlspecialchars($row['title']); ?></td>
    <td><?php echo htmlspecialchars($row['username']); ?></td>
</tr>
<?php endwhile; ?>
</table>
