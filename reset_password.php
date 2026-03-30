<?php

session_start();
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/db.php';

$message = '';
$success = false;

if(isset($_POST['password'])){

$email = $_SESSION['email'];
$new_password = $_POST['password'];

$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
$stmt->bind_param("ss", $hashed_password, $email);

if($stmt->execute()){
    
    $message = "Password reset successful. Redirecting to login...";
    $success = true;
    
unset($_SESSION['otp']);
unset($_SESSION['email']);
unset($_SESSION['otp_expiry']);
session_destroy();
    
}else{
    
    $message = "Error resetting password";
}

}

$pageTitle = "Reset Password";
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<div class="form-page">
  <div class="form-card">
    <h1 class="form-title">Reset Password</h1>

    <?php if($message): ?>
      <div class="alert <?= $success ? 'alert-success' : 'alert-error' ?>">
        <?= $message ?>
      </div>
    <?php endif; ?>

    <?php if(!$success): ?>
    <form method="POST">
      <div class="form-group">
        <label>New Password</label>
        <input type="password" name="password" required placeholder="Enter new password">
      </div>

      <button type="submit" class="btn btn-primary form-submit">
        Reset Password
      </button>
    </form>
    <?php endif; ?>

  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>


<?php if($success): ?>
<script>
setTimeout(function(){
    window.location.href = "<?= SITE_URL ?>/login.php";
}, 3000);
</script>
<?php endif; ?>