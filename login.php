<?php
session_start();
include 'includes/db.php';

$error = '';

// login form submission
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if($user && password_verify($password, $user['password'])){
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="form-section">
    <h2>User Login</h2>

    <?php if($error): ?>
        <p class="error-msg"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit">Login</button>
    </form>

    <p class="form-text">
        Don't have an account?
        <a href="register.php">Register here</a>
    </p>

    <p class="form-text">
        Are you an admin?
        <a href="admin/login.php">Login here</a>
    </p>
</div>


<?php include 'includes/footer.php'; ?>
