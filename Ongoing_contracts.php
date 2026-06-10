<?php 
session_start();
include 'includes/db.php';
include 'includes/header.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit;
}

$user_id = $_SESSION["user_id"];

$stmt = $conn->prepare("
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
    WHERE e.status = 'ongoing'
      AND (u2.id = ? OR u1.id = ?)
");
$stmt->bind_param("ii", $user_id, $user_id);
$stmt->execute();
$Ongoing = $stmt->get_result();
?>

<ul class="contract-nav">
            <li><a href="/Contracts.php">Pending</a></li>
            <li><a href="/Ongoing_contracts.php">Ongoing</a></li>
            <li><a href="/Completed_contacts.php">Completed</a></li>
</ul>

<h2>Ongoing Contracts</h2>
<table>
<tr><th>Requester</th><th>Skill</th><th>Requested</th><th>Actions</th></tr>

<?php while($row = $Ongoing->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($row['requester']); ?></td>
    <td><?= htmlspecialchars($row['skill']); ?></td>
    <td><?= htmlspecialchars($row['requested']); ?></td>
    <td>
        <form method="post" action="Handle_ongoing_contract.php" style="display:inline;">
            <input type="hidden" name="exchange_id" value="<?= $row['exchange_id'] ?>">
            <button type="submit" name="action" value="complete">Complete</button>
        </form>

        <form method="post" action="Handle_ongoing_contract.php" style="display:inline;">
            <input type="hidden" name="exchange_id" value="<?= $row['exchange_id'] ?>">
            <button type="submit" name="action" value="cancel">Cancel</button>
        </form>
    </td>
</tr>
<?php endwhile; ?>
</table>
