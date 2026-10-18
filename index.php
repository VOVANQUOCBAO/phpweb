<?php

if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__);
}

$khu = $_GET['khu'] ?? '';
if ($khu === 'admin') {
    require __DIR__ . '/controller/admin/index.php';
    return;
}

// Điểm vào User dùng đúng controller/index.php theo bài Lab
$query = $_GET;
unset($query['khu']);
$target = 'controller/index.php' . ($query ? '?' . http_build_query($query) : (!empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : ''));
header('Location: ' . $target);
exit;
