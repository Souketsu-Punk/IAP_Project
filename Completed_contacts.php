<?php 
    session_start();
    include 'includes/db.php';
    include 'includes/header.php';
    if(!isset($_SESSION['user_id'])) header("Location: login.php");

    $user_id = $_SESSION["user_id"];
    $Completed = $conn ->query("SELECT 
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
    WHERE (e.status = 'completed' or e.status = 'cancelled')
      AND (u2.id = $user_id OR u1.id = $user_id)
");
?>



<ul class="contract-nav">
            <li><a href="/Contracts.php">Pending</a></li>
            <li><a href="/Ongoing_contracts.php">Ongoing</a></li>
            <li><a href="/Completed_contacts.php">Completed</a></li>
</ul>

<h2>Completed Contracts</h2>
<table>
<tr><th>Requester</th><th>Skill</th><th>Requested</th><th>Status</th></tr>
<?php
$reviewCheck = $conn->prepare("
    SELECT id FROM reviews
    WHERE exchange_id = ? AND user_id = ?
");
?>
<?php while($row = $Completed->fetch_assoc()): ?>
<tr>
    <td><?php echo htmlspecialchars($row['requester']); ?></td>
    <td><?php echo htmlspecialchars($row['skill']); ?></td>
    <td><?php echo htmlspecialchars($row['requested']); ?></td>
    <td><?php
        $reviewCheck->bind_param("ii", $row['exchange_id'], $user_id);
        $reviewCheck->execute();
        $hasReviewed = $reviewCheck->get_result()->num_rows > 0;

        if (!$hasReviewed):
            $reviewedUser =
                ($row['requester_id'] == $user_id)
                ? $row['requested_id']
                : $row['requester_id'];
        ?>
            <form method="get" action="review.php">
                <input type="hidden" name="exchange_id" value="<?= $row['exchange_id'] ?>">
                <input type="hidden" name="reviewed_user_id" value="<?= $reviewedUser ?>">
                <button>Leave Review</button>
            </form>
        <?php else: ?>
            Reviewed
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</table>