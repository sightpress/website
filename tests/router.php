<?php

// Serves public/ (or WEBSITE_ROOT) like Amplify does: folders answer with their index.html, and a missing page gets
// 404.html.
$root = getenv('WEBSITE_ROOT') ?: __DIR__ . '/../public';
$path = rawurldecode((string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$file = $root . $path;
if (is_dir($file)) {
    if (!str_ends_with($path, '/')) {
        header('Location: ' . $path . '/', true, 301);
        return true;
    }
    $file .= 'index.html';
}
if (is_file($file)) {
    if (str_ends_with($file, '.md')) {
        header('Content-Type: text/markdown; charset=utf-8');
        readfile($file);
        return true;
    }
    if (str_ends_with($file, '.html')) {
        header('Content-Type: text/html; charset=utf-8');
        readfile($file);
        return true;
    }
    $types = ['css' => 'text/css', 'js' => 'text/javascript', 'svg' => 'image/svg+xml', 'xml' => 'application/xml',
        'txt' => 'text/plain; charset=utf-8', 'png' => 'image/png', 'jpg' => 'image/jpeg', 'ico' => 'image/x-icon',
        'woff2' => 'font/woff2', 'webmanifest' => 'application/manifest+json'];
    header('Content-Type: ' . ($types[pathinfo($file, PATHINFO_EXTENSION)] ?? 'application/octet-stream'));
    readfile($file);
    return true;
}
http_response_code(404);
header('Content-Type: text/html; charset=utf-8');
readfile($root . '/404.html');
return true;
