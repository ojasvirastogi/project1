<?php
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function excerpt(string $content, int $limit = 150): string
{
    $plain = trim(strip_tags($content));
    if (strlen($plain) <= $limit) {
        return $plain;
    }

    return substr($plain, 0, $limit) . '...';
}

function categories(): array
{
    return ['Admit Card', 'Result', 'Job Alert', 'Syllabus', 'Answer Key'];
}

function upload_blog_image(array $file, ?string $oldImage = null): ?string
{
    if (!isset($file['tmp_name']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return $oldImage;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Image upload failed.');
    }

    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $mime = mime_content_type($file['tmp_name']);

    if (!isset($allowed[$mime])) {
        throw new RuntimeException('Only JPG, PNG, and WEBP images are allowed.');
    }

    if ($file['size'] > 2 * 1024 * 1024) {
        throw new RuntimeException('Image size must be under 2 MB.');
    }

    $uploadDir = dirname(__DIR__) . '/uploads';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0775, true);
    }

    $filename = uniqid('blog_', true) . '.' . $allowed[$mime];
    $destination = $uploadDir . '/' . $filename;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        throw new RuntimeException('Unable to save uploaded image.');
    }

    if ($oldImage) {
        $oldPath = $uploadDir . '/' . basename($oldImage);
        if (is_file($oldPath)) {
            unlink($oldPath);
        }
    }

    return $filename;
}
