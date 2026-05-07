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

function blog_image_src(?string $image, string $category = ''): string
{
    if ($image) {
        if (preg_match('/^https?:\/\//', $image)) {
            return $image;
        }

        return 'uploads/' . rawurlencode($image);
    }

    $fallbacks = [
        'Admit Card' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=1200&q=80',
        'Result' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?auto=format&fit=crop&w=1200&q=80',
        'Job Alert' => 'https://images.unsplash.com/photo-1521791136064-7986c2920216?auto=format&fit=crop&w=1200&q=80',
        'Syllabus' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80',
        'Answer Key' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=1200&q=80',
    ];

    return $fallbacks[$category] ?? 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=1200&q=80';
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
