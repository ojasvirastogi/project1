<?php
require_once __DIR__ . '/auth.php';
require_admin();

$id = (int) ($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = db()->prepare('SELECT image FROM blogs WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $blog = $stmt->get_result()->fetch_assoc();

    $stmt = db()->prepare('DELETE FROM blogs WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();

    if (!empty($blog['image'])) {
        $path = __DIR__ . '/../uploads/' . basename($blog['image']);
        if (is_file($path)) {
            unlink($path);
        }
    }
}

header('Location: dashboard.php');
exit;
