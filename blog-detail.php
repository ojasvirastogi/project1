<?php
$pageTitle = 'Blog Detail';
require_once __DIR__ . '/includes/header.php';

$id = (int) ($_GET['id'] ?? 0);
$stmt = db()->prepare('SELECT * FROM blogs WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$blog = $stmt->get_result()->fetch_assoc();
?>
<section class="container detail">
    <?php if (!$blog): ?>
        <div class="empty">Blog not found.</div>
    <?php else: ?>
        <a class="read-more" href="index.php">&larr; Back to blogs</a>
        <h1><?= e($blog['title']) ?></h1>
        <div class="meta"><?= e($blog['category']) ?> &middot; <?= date('d M Y', strtotime($blog['created_at'])) ?></div>
        <img class="detail-hero" src="<?= e(blog_image_src($blog['image'], $blog['category'])) ?>" alt="<?= e($blog['title']) ?>">
        <div class="detail-content"><?= nl2br(e($blog['content'])) ?></div>
    <?php endif; ?>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
