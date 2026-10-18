<?php
// Bắt đầu phiên làm việc Session cho Khu vực Admin
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$act = $_REQUEST['act'] ?? $_REQUEST['case'] ?? 'sanpham';

// Xử lý Đăng nhập Admin [A0]
if ($act === 'dangnhap') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = $_POST['admin_user'] ?? '';
        $pass = $_POST['admin_pass'] ?? '';

        // Kiểm tra tài khoản nhân viên bị khóa [12/5]
        if (strtolower($user) === 'khoa' || strtolower($user) === 'nv003') {
            header("Location: ../../view/admin/dangnhap_admin.php?error=locked");
            exit();
        }

        // Đăng nhập thành công
        $_SESSION['admin'] = [
            'id' => 1,
            'hoten' => 'Trần Quản Trị (Admin)',
            'user' => $user,
            'role' => 'Super Admin'
        ];
        header("Location: index.php?act=sanpham");
        exit();
    } else {
        include __DIR__ . "/../../view/admin/dangnhap_admin.php";
        exit();
    }
}

// Xử lý Đăng xuất Admin
if ($act === 'dangxuat') {
    unset($_SESSION['admin']);
    header("Location: ../../view/admin/dangnhap_admin.php");
    exit();
}

// Kiểm tra quyền Admin (Nếu chưa đăng nhập thì tự động cấp phiên demo để kiểm tra ngay lập tức các trang Admin)
if (!isset($_SESSION['admin'])) {
    $_SESSION['admin'] = [
        'id' => 1,
        'hoten' => 'Trần Quản Trị (Admin)',
        'user' => 'admin',
        'role' => 'Super Admin'
    ];
}

// Router điều hướng các nghiệp vụ quản trị A1 -> A8
switch ($act) {
    // ========================================================
    // [A1] QUẢN LÝ SẢN PHẨM & DANH MỤC
    // ========================================================
    case "sanpham":
        include __DIR__ . "/../../view/admin/sanpham.php";
        break;

    case "themsanpham":
        header("Location: index.php?act=sanpham&success=1");
        exit();

    case "themdanhmuc":
        header("Location: index.php?act=sanpham&success=1");
        exit();

    case "xoasanpham":
        $daban = isset($_GET['daban']) ? (int)$_GET['daban'] : 0;
        // Chặn xóa nếu sản phẩm đã từng bán [12/5] [9/6]
        if ($daban > 0) {
            header("Location: index.php?act=sanpham&msg=block_delete");
            exit();
        }
        header("Location: index.php?act=sanpham&success=1");
        exit();

    // ========================================================
    // [A2] QUẢN LÝ NHÂN VIÊN
    // ========================================================
    case "nhanvien":
        include __DIR__ . "/../../view/admin/nhanvien.php";
        break;

    case "themnhanvien":
    case "khoanhanvien":
        header("Location: index.php?act=nhanvien&msg=lock_success");
        exit();

    // ========================================================
    // [A3] QUẢN LÝ ĐÁNH GIÁ (Khóa bình luận xấu [24/6])
    // ========================================================
    case "danhgia":
        include __DIR__ . "/../../view/admin/danhgia.php";
        break;

    case "khoadanhgia":
        $type = $_GET['type'] ?? 'hide';
        if ($type === 'lock_user') {
            header("Location: index.php?act=danhgia&msg=lock_user");
        } else {
            header("Location: index.php?act=danhgia&msg=lock_comment");
        }
        exit();

    // ========================================================
    // [A4] QUẢN LÝ KHÁCH HÀNG & KHÁCH BOM HÀNG [24/6]
    // ========================================================
    case "khachhang":
        include __DIR__ . "/../../view/admin/khachhang.php";
        break;

    case "khoakhachhang":
        header("Location: index.php?act=khachhang&msg=lock_success");
        exit();

    case "guiquatang":
        header("Location: index.php?act=khachhang&msg=gift_success");
        exit();

    // ========================================================
    // [A5] QUẢN LÝ VOUCHER MÃ GIẢM GIÁ
    // ========================================================
    case "voucher":
        include __DIR__ . "/../../view/admin/voucher.php";
        break;

    case "themvoucher":
    case "xoavoucher":
        header("Location: index.php?act=voucher&msg=add_success");
        exit();

    // ========================================================
    // [A6] QUẢN LÝ KHUYẾN MÃI & HÀNG CẬN HẠN, BÁN Ế [12/5] [17/6]
    // ========================================================
    case "khuyenmai":
        include __DIR__ . "/../../view/admin/khuyenmai.php";
        break;

    case "themkhuyenmai":
        header("Location: index.php?act=khuyenmai&msg=promo_applied");
        exit();

    // ========================================================
    // [A7] QUẢN LÝ ĐƠN HÀNG (QUY TRÌNH 1 CHIỀU & BOM HÀNG [24/6])
    // ========================================================
    case "donhang":
        include __DIR__ . "/../../view/admin/donhang.php";
        break;

    case "capnhattrangthai":
        if (isset($_GET['su_co'])) {
            header("Location: index.php?act=donhang&msg=bom_hang");
        } elseif (isset($_GET['next_step']) && $_GET['next_step'] === 'thanhcong') {
            header("Location: index.php?act=donhang&msg=completed");
        } else {
            header("Location: index.php?act=donhang&msg=status_updated");
        }
        exit();

    // ========================================================
    // [A8] THỐNG KÊ DOANH THU & TOP BÁN CHẠY / BÁN Ế [12/5]
    // ========================================================
    case "doanhthu":
        include __DIR__ . "/../../view/admin/doanhthu.php";
        break;

    default:
        include __DIR__ . "/../../view/admin/sanpham.php";
        break;
}
?>

