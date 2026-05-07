<?php
require_once __DIR__ . '/auth.php';
require_admin();

$id = (int) ($_GET['id'] ?? 0);
$isEdit = $id > 0;
$error = '';
$blog = ['title' => '', 'content' => '', 'category' => categories()[0], 'image' => null];

if ($isEdit) {
    $stmt = db()->prepare('SELECT * FROM blogs WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $found = $stmt->get_result()->fetch_assoc();
    if (!$found) {
        header('Location: dashboard.php');
        exit;
    }
    $blog = $found;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $category = trim($_POST['category'] ?? '');

    try {
        if ($title === '' || $content === '' || $category === '') {
            throw new RuntimeException('Title, content, and category are required.');
        }

        $image = upload_blog_image($_FILES['image'] ?? [], $blog['image'] ?? null);

        if ($isEdit) {
            $stmt = db()->prepare('UPDATE blogs SET title = ?, content = ?, category = ?, image = ? WHERE id = ?');
            $stmt->bind_param('ssssi', $title, $content, $category, $image, $id);
        } else {
            $stmt = db()->prepare('INSERT INTO blogs (title, content, category, image) VALUES (?, ?, ?, ?)');
            $stmt->bind_param('ssss', $title, $content, $category, $image);
        }

        $stmt->execute();
        header('Location: dashboard.php');
        exit;
    } catch (RuntimeException $exception) {
        $error = $exception->getMessage();
        $blog = ['title' => $title, 'content' => $content, 'category' => $category, 'image' => $blog['image'] ?? null];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isEdit ? 'Edit Blog' : 'Add Blog' ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<main class="admin-shell">
    <div class="page-heading">
        <div>
            <h1><?= $isEdit ? 'Edit Blog' : 'Add Blog' ?></h1>
            <p>Manage title, content, category, and image.</p>
        </div>
        <a class="btn secondary" href="dashboard.php">Back</a>
    </div>

    <div class="panel">
        <?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
        <form method="post" enctype="multipart/form-data" class="form-grid">
            <label class="label">Title
                <input class="input" type="text" name="title" value="<?= e($blog['title']) ?>" required>
            </label>
            <label class="label">Category
                <select class="select" name="category" required>
                    <?php foreach (categories() as $category): ?>
                        <option value="<?= e($category) ?>" <?= $blog['category'] === $category ? 'selected' : '' ?>><?= e($category) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label class="label">Content
                <textarea class="textarea" name="content" required><?= e($blog['content']) ?></textarea>
            </label>
            <label class="label">Image
                <input class="input" type="file" name="image" accept="image/jpeg,image/png,image/webp">
            </label>
            <?php if (!empty($blog['image'])): ?>
                <img src="../uploads/<?= e($blog['image']) ?>" alt="" style="width: 180px; border-radius: 8px;">
            <?php endif; ?>
            <button class="btn" type="submit"><?= $isEdit ? 'Update Blog' : 'Create Blog' ?></button>
        </form>
    </div>
</main>
</body>
</html>
