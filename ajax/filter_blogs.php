<?php
require_once __DIR__ . '/../includes/init.php';

$search = trim($_GET['search'] ?? '');
$category = trim($_GET['category'] ?? '');
$date = trim($_GET['date'] ?? '');

$sql = 'SELECT id, title, content, category, image, created_at FROM blogs WHERE 1=1';
$types = '';
$params = [];

if ($search !== '') {
    $sql .= ' AND (title LIKE ? OR content LIKE ?)';
    $like = '%' . $search . '%';
    $types .= 'ss';
    $params[] = $like;
    $params[] = $like;
}

if ($category !== '') {
    $sql .= ' AND category = ?';
    $types .= 's';
    $params[] = $category;
}

if ($date !== '') {
    $sql .= ' AND DATE(created_at) = ?';
    $types .= 's';
    $params[] = $date;
}

$sql .= ' ORDER BY created_at DESC';
$stmt = db()->prepare($sql);

if ($types !== '') {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$blogs = $stmt->get_result();

if ($blogs->num_rows === 0): ?>
    <div class="empty">No blogs found for the selected filters.</div>
<?php endif; ?>

<?php while ($blog = $blogs->fetch_assoc()): ?>
    <article class="blog-card">
        <img src="uploads/<?= e($blog['image'] ?: 'placeholder.svg') ?>" alt="<?= e($blog['title']) ?>">
        <div class="blog-card-body">
            <span class="category"><?= e($blog['category']) ?></span>
            <h2><?= e($blog['title']) ?></h2>
            <div class="meta"><?= date('d M Y', strtotime($blog['created_at'])) ?></div>
            <p><?= e(excerpt($blog['content'])) ?></p>
            <a class="read-more" href="blog-detail.php?id=<?= (int) $blog['id'] ?>">Read full blog</a>
        </div>
    </article>
<?php endwhile; ?>
