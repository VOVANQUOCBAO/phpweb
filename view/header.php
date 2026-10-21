<?php
// Tự động nhận diện đường dẫn tương đối tùy theo vị trí gọi view
if (!isset($base_url)) {
    if (file_exists('view/css/theme.css')) {
        $base_url = 'view';
    } elseif (file_exists('../view/css/theme.css')) {
        $base_url = '../view';
    } else {
        $base_url = '../../view';
    }
}

// Tải cấu hình giao diện do Quản trị viên thiết lập từ Admin
$theme_file = dirname(__DIR__) . '/support/config/theme.json';
$theme_cfg = ['season' => 'default', 'font' => 'font-segoe', 'bg' => 'bg-light-gray'];
if (is_file($theme_file)) {
    $theme_saved = json_decode((string)file_get_contents($theme_file), true);
    if (is_array($theme_saved)) {
        $theme_cfg = array_merge($theme_cfg, $theme_saved);
    }
}

// Chỉ Quản trị viên (Admin) mới có quyền xem thử mùa qua tham số GET (?season=theme-spring, summer, autumn, winter)
if (!empty($_GET['season']) && isset($_SESSION['admin'])) {
    $s = trim($_GET['season']);
    if (!str_starts_with($s, 'theme-') && $s !== 'default') {
        $s = 'theme-' . $s;
    }
    if (in_array($s, ['default', 'theme-spring', 'theme-summer', 'theme-autumn', 'theme-winter'], true)) {
        $theme_cfg['season'] = $s;
    }
}

$body_classes = [];
if (!empty($theme_cfg['season']) && $theme_cfg['season'] !== 'default') {
    $body_classes[] = htmlspecialchars($theme_cfg['season']);
}
if (!empty($theme_cfg['font'])) {
    $body_classes[] = htmlspecialchars($theme_cfg['font']);
}
if (!empty($theme_cfg['bg'])) {
    $body_classes[] = htmlspecialchars($theme_cfg['bg']);
}
$body_class_attr = !empty($body_classes) ? ' class="' . implode(' ', $body_classes) . '"' : '';

// Huy hiệu trực quan theo mùa
$seasonBadges = [
    'theme-spring' => '<span class="badge bg-danger text-white rounded-pill px-2 py-1 shadow-sm"><i class="fas fa-spa me-1"></i> 🌸 Xuân Hoa Mai Vàng (Đỏ Tết)</span>',
    'theme-summer' => '<span class="badge bg-info text-white rounded-pill px-2 py-1 shadow-sm"><i class="fas fa-umbrella-beach me-1"></i> ☀️ Hạ Sôi Động & Cây Dừa</span>',
    'theme-autumn' => '<span class="badge bg-warning text-dark rounded-pill px-2 py-1 shadow-sm"><i class="fas fa-leaf me-1"></i> 🍂 Thu Lá Phong Rơi</span>',
    'theme-winter' => '<span class="badge bg-primary text-white rounded-pill px-2 py-1 shadow-sm"><i class="fas fa-snowflake me-1"></i> ❄️ Đông Tuyết & Tuần Lộc Noel</span>',
];
$activeSeasonBadge = $seasonBadges[$theme_cfg['season'] ?? ''] ?? '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ĐiệnThoạiZ - Thế Giới Smartphone Chính Hãng Giá Tốt</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?=$base_url?>/image/favicon.ico">
    <!-- Nhúng Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Nhúng FontAwesome Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Nhúng CSS tùy chỉnh (theme.css) -->
    <link rel="stylesheet" href="<?=$base_url?>/css/theme.css">
    <!-- Nhúng CSS Hiệu Ứng 4 Mùa Đẹp Mắt (Hoa Đào, Bãi Biển Cây Dừa, Lá Phong, Tuyết & Ông Già Noel) -->
    <link rel="stylesheet" href="<?=$base_url?>/css/season_effects.css">
</head>
<body<?=$body_class_attr?>>
    <!-- THANH TIỆN ÍCH TRÊN CÙNG (DÀNH CHO KHÁCH HÀNG & PHÍM TẮT QUẢN TRỊ ADMIN) -->
    <div class="theme-toolbar py-1 bg-dark text-white-50">
        <div class="container d-flex flex-wrap justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <span class="small"><i class="fas fa-headset me-1 text-warning"></i> Hotline: <strong class="text-white">1800.6868</strong> (Miễn phí)</span>
                <span class="small d-none d-md-inline"><i class="fas fa-truck-fast me-1 text-info"></i> Giao siêu tốc 1h</span>
                <span class="small d-none d-lg-inline"><i class="fas fa-shield-alt me-1 text-success"></i> 100% Chính hãng VN/A</span>
                <?php if (!empty($activeSeasonBadge)): ?>
                    <span class="d-none d-sm-inline ms-1"><?=$activeSeasonBadge?></span>
                <?php endif; ?>
            </div>
            <div class="d-flex align-items-center gap-2 small">
                <?php if (isset($_SESSION['admin'])): ?>
                    <!-- Nút quản trị dành riêng cho tài khoản Admin khi duyệt giao diện người dùng -->
                    <a href="index.php?khu=admin&act=giaodien" class="badge bg-warning text-dark text-decoration-none py-1 px-2 fw-bold shadow-sm">
                        <i class="fas fa-palette me-1 text-danger"></i> Tùy biến giao diện (Admin)
                    </a>
                <?php else: ?>
                    <span class="small text-white-50 d-none d-sm-inline">
                        <i class="fas fa-certificate text-warning me-1"></i> Hệ thống bán lẻ điện thoại uy tín hàng đầu
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>