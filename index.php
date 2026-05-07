<?php
$pageTitle = 'Blogs';
$bodyClass = 'home-page';
require_once __DIR__ . '/includes/header.php';
?>
<section class="travel-shell">
    <form id="filterForm">
        <input type="hidden" name="category" id="categoryInput" value="">

        <section class="showcase">
            <nav class="showcase-nav">
                <a class="showcase-brand" href="index.php">JobYaari</a>
                <div class="showcase-links">
                    <a href="index.php">Home</a>
                    <a href="#blogs">Blogs</a>
                    <a href="admin/login.php">Admin</a>
                </div>
                <div class="showcase-search">
                    <input type="search" name="search" placeholder="Search education updates">
                    <button type="submit" aria-label="Search">Search</button>
                </div>
            </nav>

            <div class="showcase-content">
                <span class="category hero-chip">Career Updates</span>
                <h1>Latest admit cards, results, job alerts, and exam updates</h1>
                <p>Find verified blog updates with dynamic search, category filtering, and date filtering.</p>
            </div>

            <div class="showcase-meta">
                <span>PHP + MySQL</span>
                <span>jQuery AJAX</span>
                <span>Admin CRUD</span>
            </div>
        </section>

        <section class="blog-panel" id="blogs">
            <div class="page-heading compact">
                <div>
                    <span class="eyebrow">Blog</span>
                    <h2>Browse Updates</h2>
                    <p>All posts are fetched from the database and filtered without reloading the page.</p>
                </div>
                <label class="date-filter">Filter by date
                    <input class="input" type="date" name="date">
                </label>
            </div>

            <div class="category-tabs" role="tablist" aria-label="Blog categories">
                <button type="button" class="category-tab active" data-category="">All</button>
                <?php foreach (categories() as $category): ?>
                    <button type="button" class="category-tab" data-category="<?= e($category) ?>"><?= e($category) ?></button>
                <?php endforeach; ?>
                <button class="category-tab reset-tab" type="button" id="resetFilters">Reset</button>
            </div>

            <div class="requirement-strip">
                <span>Responsive user side</span>
                <span>Blog detail pages</span>
                <span>Admin login</span>
                <span>Add, edit, delete blogs</span>
            </div>

            <div id="blogList" class="blog-grid">
                <?php include __DIR__ . '/ajax/filter_blogs.php'; ?>
            </div>
        </section>
    </form>
</section>
<script src="assets/js/blog-filter.js"></script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
