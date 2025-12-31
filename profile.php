<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM users WHERE id=$user_id")->fetch_assoc();
$skills = $conn->query("SELECT * FROM skills WHERE user_id=$user_id");
?>

<h2 style="text-align:center;"><?= htmlspecialchars($user['username']); ?>'s Profile</h2>

<h3>Your Skills</h3>

<?php if($skills->num_rows > 0): ?>
<table style="width:100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th style="border: 1px solid #ddd; padding: 10px; text-align:left;">Title</th>
            <th style="border: 1px solid #ddd; padding: 10px; text-align:left;">Description</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $skills->fetch_assoc()): ?>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px;"><?= htmlspecialchars($row['title']); ?></td>
            <td style="border: 1px solid #ddd; padding: 10px;"><?= htmlspecialchars($row['description']); ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
    <p>No skills added yet.</p>
<?php endif; ?>

<button class="add-skill-btn" onclick="location.href='add_skill.php'">Add Skill</button>
