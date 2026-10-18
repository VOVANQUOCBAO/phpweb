<?php

if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__);
}

$khu = $_GET['khu'] ?? '';
if ($khu === 'admin') {
    require __DIR__ . '/controller/admin/index.php';
    return;
}

// Diem vao User dung dung controller/index.php theo bai Lab.
$query = $_GET;
unset($query['khu']);
header('Location: controller/index.php' . ($query ? '?' . http_build_query($query) : ''));
exit;
