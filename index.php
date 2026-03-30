<?php
session_start();
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/db.php';

$pageTitle = 'Home';

// Search & filter
$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

$where = ['i.is_resolved = 0', 'i.is_approved = 1'];
$params = [];
$types  = '';

if ($search) {
    $where[] = '(i.title LIKE ? OR i.description LIKE ? OR i.location LIKE ?)';
    $s = "%$search%";
    $params = array_merge($params, [$s, $s, $s]);
    $types .= 'sss';
}
if ($status === 'lost' || $status === 'found') {
    $where[] = 'i.status = ?';
    $params[] = $status;
    $types .= 's';
}
if ($category) {
    $where[] = 'i.category = ?';
    $params[] = $category;
    $types .= 's';
}

$sql = "SELECT i.*, u.username FROM items i JOIN users u ON i.user_id = u.id";
if ($where) $sql .= ' WHERE ' . implode(' AND ', $where);
$sql .= ' ORDER BY i.created_at DESC';

$stmt = $conn->prepare($sql);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<main>
  <section class="hero">
    <p class="hero-eyebrow">Community Lost &amp; Found Platform</p>
    <h1>Lost Something?<br><em>Find It Here.</em></h1>
    <p>Browse items reported lost or found in your community. Help reunite people with their belongings.</p>
    <div class="hero-cta">
      <a href="<?= SITE_URL ?>/user/add_item.php" class="btn btn-primary">+ Report an Item</a>
      <a href="#items" class="btn btn-outline">Browse Items ↓</a>
    </div>
  </section>

  <section class="section" id="items">
    <!-- Search -->
    <form method="GET" action="<?= SITE_URL ?>/index.php">
      <div class="search-bar" style="max-width:560px;margin:0 auto 1.5rem">
        <input type="text" name="q" placeholder="Search by keyword, location…" value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Search</button>
      </div>
      <!-- Filter tabs -->
      <div class="filter-tabs">
        <button type="submit" name="status" value="" class="filter-tab <?= !$status ? 'active' : '' ?>">All</button>
        <button type="submit" name="status" value="lost" class="filter-tab <?= $status==='lost' ? 'active' : '' ?>">Lost</button>
        <button type="submit" name="status" value="found" class="filter-tab <?= $status==='found' ? 'active' : '' ?>">Found</button>
        <?php foreach (['Electronics','Wallet','Keys','Bag','Clothing','Pet','Other'] as $cat): ?>
          <button type="submit" name="category" value="<?= $cat ?>" class="filter-tab <?= $category===$cat ? 'active' : '' ?>"><?= $cat ?></button>
        <?php endforeach; ?>
      </div>
    </form>

    <div class="section-heading">
      <h2><?= count($items) ?> Item<?= count($items)!==1?'s':'' ?> <?= $status ? ucfirst($status) : '' ?></h2>
      <?php if ($search || $status || $category): ?>
        <a href="<?= SITE_URL ?>/index.php" class="btn btn-outline btn-sm">Clear filters</a>
      <?php endif; ?>
    </div>

    <?php if (empty($items)): ?>
      <div class="empty-state">
        <div class="empty-icon">🔍</div>
        <h3>No items found</h3>
        <p>Try a different search or <a href="<?= SITE_URL ?>/user/add_item.php">report an item</a>.</p>
      </div>
    <?php else: ?>
      <div class="items-grid">
        <?php foreach ($items as $item): ?>
          <div class="item-card">
            <div class="item-card-img">
              <?php if ($item['image'] && file_exists(UPLOAD_DIR . $item['image'])): ?>
                <img src="<?= UPLOAD_URL . htmlspecialchars($item['image']) ?>" alt="">
              <?php else: ?>
                <?= $item['status']==='lost' ? '🔎' : '📦' ?>
              <?php endif; ?>
            </div>
            <div class="item-card-body">
              <span class="item-badge badge-<?= $item['status'] ?>"><?= strtoupper($item['status']) ?></span>
              <h3><?= htmlspecialchars($item['title']) ?></h3>
              <p style="font-size:.84rem;color:#7a7880;margin-top:4px"><?= htmlspecialchars(substr($item['description'],0,90)) ?><?= strlen($item['description'])>90?'…':'' ?></p>
              <div class="item-card-meta">
                <?php if ($item['location']): ?><span>📍 <?= htmlspecialchars($item['location']) ?></span><?php endif; ?>
                <?php if ($item['date_reported']): ?><span>🗓 <?= date('M j, Y', strtotime($item['date_reported'])) ?></span><?php endif; ?>
                <span>👤 <?= htmlspecialchars($item['username']) ?></span>
                <?php if(!empty($item['contact'])): ?>
<span>📞 <?= htmlspecialchars($item['contact']) ?></span>
<?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
