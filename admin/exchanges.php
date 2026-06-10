<?php
session_start();
include '../includes/db.php';
if(!isset($_SESSION['admin_id'])) header("Location: login.php");

$exchanges = $conn->query("SELECT e.id, u1.username AS requester, s.title as skill, u2.username as requested, e.status from exchanges e
							join skills s on e.skill_id = s.id
							join users u1 on e.requester_id = u1.id
							join users u2 on s.user_id = u2.id;");
?>
<head>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<h2>All Exchanges</h2>
<table>
<tr><th>ID</th><th>Requester</th><th>Skill</th><th>Requested</th><th>Status</th></tr>
<?php while($row = $exchanges->fetch_assoc()): ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo htmlspecialchars($row['requester']); ?></td>
    <td><?php echo htmlspecialchars($row['skill']); ?></td>
    <td><?php echo htmlspecialchars($row['requested']); ?></td>
    <td><?php echo htmlspecialchars($row['status']); ?></td>
</tr>
<?php endwhile; ?>
</table>
