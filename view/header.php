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
</head>
<body>
    <!-- THANH CÔNG CỤ TÙY BIẾN GIAO DIỆN THEO MÙA, FONT & BACKGROUND [17/6] [24/6] -->
    <div class="theme-toolbar py-1">
        <div class="container d-flex flex-wrap justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <span class="small d-none d-md-inline"><i class="fas fa-headset me-1 text-warning"></i> Hotline: <strong>1800.6868</strong> (Miễn phí)</span>
                <span class="small d-none d-lg-inline"><i class="fas fa-truck-fast me-1 text-info"></i> Giao siêu tốc 1h</span>
            </div>
            <div class="d-flex align-items-center gap-2 small">
                <!-- Bộ chọn Chủ đề Mùa -->
                <label for="seasonSelect" class="d-none d-sm-inline"><i class="fas fa-palette me-1"></i> Mùa:</label>
                <select id="seasonSelect" onchange="changeThemeSeason(this.value)">
                    <option value="default">🔵 Xanh Samsung/TGDD</option>
                    <option value="theme-spring">🌸 Xuân Tài Lộc</option>
                    <option value="theme-summer">☀️ Hạ Sôi Động</option>
                    <option value="theme-autumn">🍂 Thu Quý Phái</option>
                    <option value="theme-winter">❄️ Đông Băng Tuyết</option>
                </select>

                <!-- Bộ chọn Font chữ -->
                <label for="fontSelect" class="d-none d-md-inline ms-2"><i class="fas fa-font me-1"></i> Font:</label>
                <select id="fontSelect" onchange="changeFontFamily(this.value)">
                    <option value="font-segoe">Segoe UI</option>
                    <option value="font-bevietnam">Be Vietnam Pro</option>
                    <option value="font-roboto">Roboto</option>
                    <option value="font-montserrat">Montserrat</option>
                </select>

                <!-- Bộ chọn Nền -->
                <label for="bgSelect" class="d-none d-md-inline ms-2"><i class="fas fa-fill-drip me-1"></i> Nền:</label>
                <select id="bgSelect" onchange="changeBackgroundMode(this.value)">
                    <option value="bg-light-gray">Xám nhạt</option>
                    <option value="bg-white-pure">Trắng tinh</option>
                    <option value="bg-soft-blue">Xanh pastel</option>
                </select>
            </div>
        </div>
    </div>
    </div>