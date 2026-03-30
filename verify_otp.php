<?php

session_start();
require_once __DIR__ . '/config/config.php';

$error = '';

if(isset($_POST['otp'])){

if(time() > $_SESSION['otp_expiry']){
$error = "OTP expired. Please resend.";
}
elseif($_POST['otp'] == $_SESSION['otp']){
header("Location: reset_password.php");
exit();
}else{
$error = "Invalid OTP";
}

}

$pageTitle = "Verify OTP";

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';

?>

<div class="form-page">
  <div class="form-card">
    <h1 class="form-title">Verify OTP</h1>
    <p class="form-subtitle">Enter the OTP sent to your email</p>

    <?php if($error): ?>
      <div class="alert alert-error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="form-group">
        <label>OTP</label>
        <input type="text" name="otp" required placeholder="Enter OTP">
      </div>

      <button type="submit" class="btn btn-primary form-submit">
        Verify OTP
      </button>
    </form>

    <p class="form-footer">
      Didn't receive OTP?
      <a href="resend_otp.php">Resend</a>
    </p>

  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>