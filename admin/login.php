<?php
require_once __DIR__ . '/../includes/init.php';

if (!empty($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = db()->prepare('SELECT id, username, password_hash FROM admins WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $admin = $stmt->get_result()->fetch_assoc();

    if ($admin && password_verify($password, $admin['password_hash'])) {
        $_SESSION['admin_id'] = (int) $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        header('Location: dashboard.php');
        exit;
    }

    $error = 'Invalid username or password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=admin-font-2">
</head>
<body>
<main class="admin-shell">
    <div class="panel" style="max-width: 430px; margin: 8vh auto;">
        <h1>Admin Login</h1>
        <?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
        <form method="post" class="form-grid">
            <label class="label">Username
                <input class="input" type="text" name="username" required>
            </label>
            <label class="label">Password
                <input class="input" type="password" name="password" required>
            </label>
            <button class="btn" type="submit">Login</button>
            <a class="read-more" href="../index.php">Back to website</a>
        </form>
    </div>
</main>
</body>
</html>
