<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch all skills
$sql = "SELECT skills.id, skills.title, skills.description, users.username 
        FROM skills 
        JOIN users ON skills.user_id = users.id
        WHERE users.id != $user_id";
$skillsResult = $conn->query($sql);

// Fetch all requests of the current user
$userRequests = [];
$requestRes = $conn->query("SELECT skill_id 
                                    FROM exchanges 
                                    WHERE requester_id = $user_id 
                                    AND status != 'completed'
      ");

while($r = $requestRes->fetch_assoc()){
    $userRequests[] = $r['skill_id'];
}
?>

<h1>Borrow My Skill Marketplace</h1>
<div class="skills-container">
    <?php while($row = $skillsResult->fetch_assoc()): ?>
        <?php
        // Check if user already requested this skill
        $alreadyRequested = in_array($row['id'], $userRequests);
        ?>

        <div class="skill-card">
            <h3><?= htmlspecialchars($row['title']); ?></h3>
            <p><?= htmlspecialchars($row['description']); ?></p>
            <p>By: <?= htmlspecialchars($row['username']); ?></p>

            <?php if($alreadyRequested): ?>
                <span style="display:inline-block; padding:10px 16px; background-color:grey; color:white; border-radius:5px; font-weight:600; cursor:not-allowed;">
                    Requested
                </span>
            <?php else: ?>
                <a href="request_skill.php?skill_id=<?= $row['id']; ?>" 
                   style="display:inline-block; background-color:black; color:white; padding:10px 16px; text-decoration:none; border-radius:5px; font-weight:600;">
                    Request Skill
                </a>
            <?php endif; ?>
        </div>

    <?php endwhile; ?>
</div>
