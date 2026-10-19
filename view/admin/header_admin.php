<?php
// Tự động nhận diện đường dẫn tài nguyên tĩnh
$admin_base_url = file_exists('../css/theme.css') ? '../' : (file_exists('view/css/theme.css') ? 'view/' : '../../view/');
$admin_ctrl_url = 'index.php?khu=admin';
$user_home_url = 'index.php?act=trangchu';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khu Vực Quản Trị Hệ Thống - ĐiệnThoạiZ Admin</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?=$admin_base_url?>css/theme.css">
    <style>
        .admin-sidebar {
            width: 260px;
            background: #111827;
            min-height: 100vh;
            color: #9ca3af;
        }
        .admin-sidebar .nav-link {
            color: #9ca3af;
            font-size: 0.9rem;
            padding: 10px 18px;
            border-radius: 8px;
            margin: 3px 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s;
        }
        .admin-sidebar .nav-link:hover, .admin-sidebar .nav-link.active {
            background-color: #0056b3;
            color: #ffffff;
        }
        .admin-sidebar .nav-header {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            color: #64748b;
            padding: 14px 20px 4px;
        }
        .admin-content {
            flex: 1;
            background-color: #f8fafc;
            min-height: 100vh;
            overflow-y: auto;
        }
    </style>
</head>
<body class="d-flex">
    <!-- SIDEBAR QUẢN TRỊ VIÊN -->
    <aside class="admin-sidebar d-flex flex-column flex-shrink-0">
        <!-- Logo Header -->
        <div class="p-3 border-bottom border-secondary d-flex align-items-center gap-2">
            <span class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fas fa-shield-alt"></i>
            </span>
            <div>
                <h6 class="text-white fw-bold mb-0">ĐiệnThoạiZ Admin</h6>
                <small class="text-secondary" style="font-size: 0.72rem;">Phân hệ Quản trị MVC</small>
            </div>
        </div>

        <!-- Menu Navigation 9 Trang Quản Trị A1 -> A8 -->
        <ul class="nav nav-pills flex-column mb-auto mt-2">
            
            <li class="nav-header">Nghiệp vụ Hàng hóa</li>
            <!-- [A1] Sản phẩm & Danh mục -->
            <li class="nav-item">
                <a href="<?=$admin_ctrl_url?>&act=sanpham" class="nav-link <?=($_GET['act'] ?? '') == 'sanpham' ? 'active' : ''?>">
                    <i class="fas fa-boxes"></i> [A1] Quản lý Sản phẩm
                </a>
            </li>
            <!-- [A6] Khuyến mãi & Hàng ế -->
            <li class="nav-item">
                <a href="<?=$admin_ctrl_url?>&act=khuyenmai" class="nav-link <?=($_GET['act'] ?? '') == 'khuyenmai' ? 'active' : ''?>">
                    <i class="fas fa-tags"></i> [A6] Khuyến mãi & Hàng ế
                </a>
            </li>
            <!-- [A5] Voucher mã giảm giá -->
            <li class="nav-item">
                <a href="<?=$admin_ctrl_url?>&act=voucher" class="nav-link <?=($_GET['act'] ?? '') == 'voucher' ? 'active' : ''?>">
                    <i class="fas fa-ticket-alt"></i> [A5] Quản lý Voucher
                </a>
            </li>

            <li class="nav-header">Khách hàng & Đơn hàng</li>
            <!-- [A7] Quản lý đơn hàng -->
            <li class="nav-item">
                <a href="<?=$admin_ctrl_url?>&act=donhang" class="nav-link <?=($_GET['act'] ?? '') == 'donhang' ? 'active' : ''?>">
                    <i class="fas fa-shipping-fast"></i> [A7] Quản lý Đơn hàng
                </a>
            </li>
            <!-- [A4] Khách hàng & Bom hàng -->
            <li class="nav-item">
                <a href="<?=$admin_ctrl_url?>&act=khachhang" class="nav-link <?=($_GET['act'] ?? '') == 'khachhang' ? 'active' : ''?>">
                    <i class="fas fa-users"></i> [A4] Quản lý Khách hàng
                </a>
            </li>
            <!-- [A3] Đánh giá & Khóa bình luận xấu -->
            <li class="nav-item">
                <a href="<?=$admin_ctrl_url?>&act=danhgia" class="nav-link <?=($_GET['act'] ?? '') == 'danhgia' ? 'active' : ''?>">
                    <i class="fas fa-star-half-alt"></i> [A3] Quản lý Đánh giá
                </a>
            </li>

            <li class="nav-header">Hệ thống & Báo cáo</li>
            <!-- [A2] Quản lý nhân viên -->
            <li class="nav-item">
                <a href="<?=$admin_ctrl_url?>&act=nhanvien" class="nav-link <?=($_GET['act'] ?? '') == 'nhanvien' ? 'active' : ''?>">
                    <i class="fas fa-user-tie"></i> [A2] Quản lý Nhân viên
                </a>
            </li>
            <!-- [A8] Thống kê doanh thu -->
            <li class="nav-item">
                <a href="<?=$admin_ctrl_url?>&act=doanhthu" class="nav-link <?=($_GET['act'] ?? '') == 'doanhthu' ? 'active' : ''?>">
                    <i class="fas fa-chart-line"></i> [A8] Thống kê Doanh thu
                </a>
            </li>
            <!-- [A9] Cấu hình Giao diện: Mùa, Font, Nền -->
            <li class="nav-item">
                <a href="<?=$admin_ctrl_url?>&act=giaodien" class="nav-link <?=($_GET['act'] ?? '') == 'giaodien' ? 'active' : ''?>">
                    <i class="fas fa-palette text-warning"></i> [A9] Giao diện (Mùa, Font, Nền)
                </a>
            </li>
            <!-- [A10] Đổi mật khẩu Quản trị -->
            <li class="nav-item">
                <a href="<?=$admin_ctrl_url?>&act=doimatkhau" class="nav-link <?=($_GET['act'] ?? '') == 'doimatkhau' ? 'active' : ''?>">
                    <i class="fas fa-key text-info"></i> [A10] Đổi Mật Khẩu Admin
                </a>
            </li>
        </ul>

        <!-- Bottom User Info & Logout -->
        <div class="p-3 border-top border-secondary">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div>
                        <div class="text-white small fw-bold"><?=$_SESSION['admin']['hoten'] ?? 'Quản Trị Viên'?></div>
                        <div class="text-success" style="font-size: 0.72rem;">● Đang online</div>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="<?=$user_home_url?>" class="btn btn-outline-light btn-sm flex-fill" style="font-size: 0.75rem;" title="Xem trang chủ bán hàng">
                    <i class="fas fa-store me-1"></i> Xem Shop
                </a>
                <a href="<?=$admin_ctrl_url?>&act=dangxuat" class="btn btn-danger btn-sm" style="font-size: 0.75rem;" title="Đăng xuất quản trị">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA WRAPPER -->
    <main class="admin-content">
        <!-- Top Navigation Bar trong Admin -->
        <nav class="navbar navbar-expand navbar-light bg-white border-bottom px-4 py-2 sticky-top">
            <div class="container-fluid p-0">
                <span class="navbar-text fw-bold text-dark">
                    <i class="fas fa-desktop text-primary me-2"></i> Bảng Điều Khiển Hệ Thống Bán Điện Thoại MVC
                </span>
                <div class="d-flex align-items-center gap-2">
                    <a href="<?=$admin_ctrl_url?>&act=giaodien" class="btn btn-warning btn-sm rounded-pill px-3 fw-bold text-dark shadow-sm">
                        <i class="fas fa-palette me-1 text-danger"></i> Đổi Giao Diện (Mùa/Font/Nền)
                    </a>
                    <span class="badge bg-primary rounded-pill px-3 py-2">
                        <i class="fas fa-calendar-alt me-1"></i> <?=date('d/m/Y')?>
                    </span>
                    <a href="<?=$user_home_url?>" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                        <i class="fas fa-external-link-alt me-1"></i> Về Giao Diện Khách Hàng
                    </a>
                </div>
            </div>
        </nav>
        <div class="p-4">

