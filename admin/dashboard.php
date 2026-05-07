<?php
require_once __DIR__ . '/auth.php';
require_admin();

$blogs = db()->query('SELECT id, title, category, image, created_at FROM blogs ORDER BY created_at DESC');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=admin-font-2">
</head>
<body>
<main class="admin-shell">
    <div class="page-heading">
        <div>
            <h1>Manage Blogs</h1>
            <p>Logged in as <?= e($_SESSION['admin_username']) ?></p>
        </div>
        <div class="actions">
            <a class="btn" href="blog-form.php">Add Blog</a>
            <a class="btn secondary" href="../index.php">View Site</a>
            <a class="btn danger" href="logout.php">Logout</a>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Category</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($blog = $blogs->fetch_assoc()): ?>
                <tr>
                    <td><img src="<?= e(str_starts_with(blog_image_src($blog['image'], $blog['category']), 'http') ? blog_image_src($blog['image'], $blog['category']) : '../' . blog_image_src($blog['image'], $blog['category'])) ?>" alt="" style="width: 84px; height: 54px; object-fit: cover; border-radius: 6px;"></td>
                    <td><?= e($blog['title']) ?></td>
                    <td><?= e($blog['category']) ?></td>
                    <td><?= date('d M Y', strtotime($blog['created_at'])) ?></td>
                    <td>
                        <div class="actions">
                            <a class="btn secondary" href="blog-form.php?id=<?= (int) $blog['id'] ?>">Edit</a>
                            <a class="btn danger" href="delete-blog.php?id=<?= (int) $blog['id'] ?>" onclick="return confirm('Delete this blog?')">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>
</body>
</html>
