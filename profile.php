<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}

$user_id = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM users WHERE id=$user_id")->fetch_assoc();
$skills = $conn->query("SELECT * FROM skills WHERE user_id=$user_id");
?>

<h2><?php echo htmlspecialchars($user['username']); ?>'s Profile</h2>
<style>
    .add-skill-btn {
        display: inline-block;
        background: linear-gradient(135deg, #084488ff, #357abd);
        color: white;
        border: none;
        padding: 12px 24px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 8px;
        cursor: pointer;
        transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.2s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        margin-top: 10px;
    }

    .add-skill-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.2);
        background: linear-gradient(135deg, #5aa0f0, #3f86d6);
    }

    .add-skill-btn:active {
        transform: translateY(0);
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
    }
</style>
<h3>Your Skills</h3>
<ul>
<?php while($row = $skills->fetch_assoc()): ?>
    <li><?php echo htmlspecialchars($row['title']); ?> - <?php echo htmlspecialchars($row['description']); ?></li>
<?php endwhile; ?>
</ul>

<button class="add-skill-btn" onclick="location.href='add_skill.php'">Add Skill</button>
        
