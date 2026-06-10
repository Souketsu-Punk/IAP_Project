<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

// Fetch all skills
$sql = "SELECT skills.id, skills.title, skills.description, users.username 
        FROM skills 
        JOIN users ON skills.user_id = users.id";
$result = $conn->query($sql);
?>

<h1>Borrow My Skill Marketplace</h1>
<div class="skills-container">
    <?php while($row = $result->fetch_assoc()): ?>
        <div class="skill-card">
            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
            <p><?php echo htmlspecialchars($row['description']); ?></p>
            <p>By: <?php echo htmlspecialchars($row['username']); ?></p>
            <a href="request_skill.php?skill_id=<?php echo $row['id']; ?>" 
            style="display:inline-block;
            background-color:black;
            color:white;
            padding:10px 16px;
            text-decoration:none;
            border-radius:5px;
            font-weight:600;">Request Skill</a>
        </div>
    <?php endwhile; ?>
</div>

<?php include 'includes/footer.php'; ?>
