<?php 
    session_start();
    include 'includes/db.php';
    include 'includes/header.php';
    if(!isset($_SESSION['user_id'])) header("Location: login.php");

    $user_id = $_SESSION["user_id"];
    $Pending = $conn->query("
    SELECT 
        e.id AS exchange_id,
        e.requester_id,
        u1.username AS requester,
        s.title AS skill,
        u2.id AS requested_id,
        u2.username AS requested,
        e.status
    FROM exchanges e
    JOIN skills s ON e.skill_id = s.id
    JOIN users u1 ON e.requester_id = u1.id
    JOIN users u2 ON s.user_id = u2.id
    WHERE e.status = 'pending'
      AND (u2.id = $user_id OR u1.id = $user_id)
");
?>

<ul class="contract-nav">
            <li><a href="/Contracts.php">Pending</a></li>
            <li><a href="/Ongoing_contracts.php">Ongoing</a></li>
            <li><a href="/Completed_contacts.php">Completed</a></li>
</ul>

<h2>Pending Contracts</h2>
<table>
<tr><th>Requester</th><th>Skill</th><th>Requested</th><th>Status/Action</th></tr>
<?php while($row = $Pending->fetch_assoc()): ?>
<tr>
    <td><?php echo htmlspecialchars($row['requester']); ?></td>
    <td><?php echo htmlspecialchars($row['skill']); ?></td>
    <td><?php echo htmlspecialchars($row['requested']); ?></td>
    <td><?php if ($row['requested_id'] == $user_id): ?>
            
            <form method="post" action="Handle_contract.php" style="display:inline;">
                <input type="hidden" name="exchange_id" value="<?= $row['exchange_id'] ?>">
                <button type="submit" name="action" value="accept">Accept</button>
            </form>

            <form method="post" action="Handle_contract.php" style="display:inline;">
                <input type="hidden" name="exchange_id" value="<?= $row['exchange_id'] ?>">
                <button type="submit" name="action" value="reject">Reject</button>
            </form>
        <?php else: ?>
            Pending
        <?php endif; ?></td>
</tr>
<?php endwhile; ?>
</table>