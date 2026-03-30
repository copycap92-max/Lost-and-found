<?php
session_start();
require_once 'config/config.php';
require_once 'config/db.php';

$uid = $_SESSION['user_id'];

$conn->query("UPDATE notifications SET is_read=1 WHERE user_id=$uid");

$notifs = $conn->query("SELECT * FROM notifications WHERE user_id=$uid ORDER BY created_at DESC");

include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="container">
<h2>Notifications</h2>

<?php while($n = $notifs->fetch_assoc()): ?>

<div class="item-card">
<a href="<?= $n['link'] ?>">
<?= htmlspecialchars($n['message']) ?>
</a>
</div>

<?php endwhile; ?>

</div>

<?php include 'includes/footer.php'; ?>