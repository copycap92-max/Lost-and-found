<?php

session_start();
require_once __DIR__ . '/config/config.php';

$pageTitle = "Forgot Password";

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';

?>

<div class="form-page">
  <div class="form-card">
    <h1 class="form-title">Forgot Password</h1>
    <p class="form-subtitle">Enter your email to receive OTP</p>

    <form method="POST" action="send_otp.php">
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" required placeholder="you@example.com">
      </div>

      <button type="submit" class="btn btn-primary form-submit">
        Send OTP
      </button>
    </form>

    <p class="form-footer">
      Remember your password?
      <a href="<?= SITE_URL ?>/login.php">Login</a>
    </p>

  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>