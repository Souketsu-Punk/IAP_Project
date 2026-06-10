<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username,email,password) VALUES (?,?,?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit;
    } else {
        $error = "Registration failed.";
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="form-section">
    <h2>Register</h2>

    <?php if (isset($error)): ?>
        <div class="error-msg"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Create Account</button>
    </form>

    <p class="form-text">
        Already have an account? <a href="login.php">Login</a>
    </p>
</div>

<?php include 'includes/footer.php'; ?>
