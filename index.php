<?php
$pageTitle = 'Blogs';
require_once __DIR__ . '/includes/header.php';
?>
<section class="container">
    <div class="page-heading">
        <div>
            <h1>Latest Blogs</h1>
            <p>Browse updates, results, admit cards, and job alerts in one place.</p>
        </div>
    </div>

    <form id="filterForm" class="filters">
        <input class="input" type="search" name="search" placeholder="Search by title or content">
        <select class="select" name="category">
            <option value="">All categories</option>
            <?php foreach (categories() as $category): ?>
                <option value="<?= e($category) ?>"><?= e($category) ?></option>
            <?php endforeach; ?>
        </select>
        <input class="input" type="date" name="date">
        <button class="btn secondary" type="button" id="resetFilters">Reset</button>
    </form>

    <div id="blogList" class="blog-grid">
        <?php include __DIR__ . '/ajax/filter_blogs.php'; ?>
    </div>
</section>
<script src="assets/js/blog-filter.js"></script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
