<?php
session_start();
include '../includes/db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username=?");
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if($admin && password_verify($password, $admin['password'])){
        $_SESSION['admin_id'] = $admin['id'];
        header("Location: dashboard.php");
    } else {
        $error = "Invalid admin credentials.";
    }
}
?>

<?php include '../includes/header.php'; ?>

<h2 style="display:none;"></h2>

<div class="form-section">
    <h2>Admin Login</h2>

    <?php if(isset($error)): ?>
        <p class="error-msg"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit" style="background-color: red;">Login</button>
    </form>
</div>



<?php include '../includes/footer.php'; ?>
