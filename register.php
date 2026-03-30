<?php
session_start();
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/db.php';

if (isset($_SESSION['user_id'])) header('Location: ' . SITE_URL . '/user/dashboard.php');

$error = $success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm'] ?? '';

    if (!$username || !$email || !$password) {
        $error = 'All fields are required.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } else {
        $check = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
        $check->bind_param('ss', $email, $username);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $error = 'Email or username already taken.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param('sss', $username, $email, $hash);
            if ($stmt->execute()) {
                $success = 'Account created! <a href="' . SITE_URL . '/login.php">Sign in now →</a>';
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
    }
}

$pageTitle = 'Register';
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>
<div class="form-page">
  <div class="form-card">
    <h1 class="form-title">Create account</h1>
    <p class="form-subtitle">Join the community and help reconnect lost items.</p>
    <?php if ($error): ?><div class="alert alert-error"><?= $error ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
    <?php if (!$success): ?>
    <form method="POST">
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" required placeholder="yourname">
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" required placeholder="you@example.com">
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" required placeholder="Min 6 chars">
        </div>
        <div class="form-group">
          <label>Confirm</label>
          <input type="password" name="confirm" required placeholder="Repeat password">
        </div>
      </div>
      <button type="submit" class="btn btn-primary form-submit">Create Account</button>
    </form>
    <?php endif; ?>
    <p class="form-footer">Already have an account? <a href="<?= SITE_URL ?>/login.php">Sign in</a></p>
  </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
