<?php
session_start();
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$viewer_id = $_SESSION['user_id'];


$sql = "
    SELECT 
        skills.id,
        skills.title,
        skills.description,
        skills.user_id,
        users.username
    FROM skills
    JOIN users ON skills.user_id = users.id
    WHERE users.id != $viewer_id
";
$skillsResult = $conn->query($sql);


$userRequests = [];
$requestRes = $conn->query("
    SELECT skill_id
    FROM exchanges
    WHERE requester_id = $viewer_id
    AND status != 'completed'
");

while ($r = $requestRes->fetch_assoc()) {
    $userRequests[] = (int)$r['skill_id'];
}
?>

<h1>Borrow My Skill Marketplace</h1>

<div class="skills-container">

    <?php if ($skillsResult->num_rows > 0): ?>
        <?php while ($row = $skillsResult->fetch_assoc()): ?>
            <?php $alreadyRequested = in_array($row['id'], $userRequests); ?>

            <div class="skill-card">

                <h3><?= htmlspecialchars($row['title']); ?></h3>

                <p><?= htmlspecialchars($row['description']); ?></p>

                <span>
                    By
                    <a href="profile.php?user_id=<?= $row['user_id']; ?>"
                       class="userbutton">
                        <?= htmlspecialchars($row['username']); ?>
                    </a>
                </span>

                <?php if ($alreadyRequested): ?>
                    <span style="
                        display:inline-block;
                        margin-top:10px;
                        padding:10px 16px;
                        background-color:#999;
                        color:white;
                        border-radius:5px;
                        font-weight:600;
                        cursor:not-allowed;
                    ">
                        Requested
                    </span>
                <?php else: ?>
                    <a href="request_skill.php?skill_id=<?= $row['id']; ?>"
                       class="request-btn"
                       style="margin-top:10px;">
                        Request Skill
                    </a>
                <?php endif; ?>

            </div>

        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center; color:#777;">
            No skills available at the moment.
        </p>
    <?php endif; ?>

</div>
