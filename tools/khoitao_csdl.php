<?php

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('Chi chay bang PHP CLI');
}
require_once dirname(__DIR__) . '/model/csdl.php';
try {
    $cfg = csdl::cauHinh();
    $pdo = new PDO("mysql:host={$cfg['host']};port={$cfg['port']};charset=utf8mb4", $cfg['user'], $cfg['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$cfg['dbname']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `{$cfg['dbname']}`");
    $pdo->exec(file_get_contents(dirname(__DIR__) . '/sql/schema.sql'));
    echo "Da khoi tao {$cfg['dbname']} tai {$cfg['host']}:{$cfg['port']}; giu nguyen du lieu cu.\n";
} catch (Throwable $e) {
    fwrite(STDERR, "Khong khoi tao duoc CSDL: {$e->getMessage()}\n");
    exit(1);
}
