<?php
session_start();
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/db.php';

if (isset($_SESSION['user_id'])) header('Location: ' . SITE_URL . '/user/dashboard.php');

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role']     = $user['role'];
        $redirect = $user['role'] === 'admin' ? '/admin/dashboard.php' : '/user/dashboard.php';
        header('Location: ' . SITE_URL . $redirect);
        exit;
    } else {
        $error = 'Invalid email or password.';
    }
}

$pageTitle = 'Login';
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>
<div class="form-page">
  <div class="form-card">
    <h1 class="form-title">Welcome back</h1>
    <p class="form-subtitle">Sign in to manage your reported items.</p>
    <?php if ($error): ?><div class="alert alert-error"><?= $error ?></div><?php endif; ?>
    <form method="POST">
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" required placeholder="you@example.com">
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required placeholder="••••••••">
        <a href="forgot_password.php">Forgot Password ?</a>
      </div>
      <button type="submit" class="btn btn-primary form-submit">Sign In</button>
    </form>
    <p class="form-footer">No account? <a href="<?= SITE_URL ?>/register.php">Register here</a></p>
  </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
