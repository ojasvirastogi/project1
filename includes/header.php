<?php require_once __DIR__ . '/init.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'JobYaari Blogs') ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
<header class="site-header">
    <nav class="nav">
        <a class="brand" href="index.php">JobYaari Blogs</a>
        <div class="nav-links">
            <a href="index.php">Blogs</a>
            <a href="admin/login.php">Admin</a>
        </div>
    </nav>
</header>
<main>
