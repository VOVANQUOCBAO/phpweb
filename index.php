<?php
// File gốc: Tự động chuyển hướng vào controller/index.php (Theo đúng sơ đồ cây thư mục trang 2 PDF)
$query = !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '';
header("Location: controller/index.php" . $query);
exit();
?>