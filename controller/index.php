<?php
// Bắt đầu phiên làm việc Session theo đúng bài mẫu Lab 3.1
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['giohang'])) {
    $_SESSION['giohang'] = [];
}

// Nhúng file kiểm tra giỏ hàng trong controller theo bài mẫu
include_once __DIR__ . "/giohang.php";

// Khởi tạo phiên khách hàng mặc định (Hạng Silver, có ngày sinh nhật [17/6]) nếu chưa đăng xuất
if (!isset($_SESSION['user']) && !isset($_SESSION['guest_mode'])) {
    $_SESSION['user'] = [
        'id' => 1,
        'username' => 'hoangquan',
        'hoten' => 'Nguyễn Hoàng Quân',
        'email' => 'quan.nguyen@email.com',
        'sdt' => '0901.234.567',
        'ngaysinh' => '1995-10-18',
        'hang' => 'Silver',
        'diem' => 140
    ];
}

// Tiếp nhận tham số điều hướng
$act = $_REQUEST['act'] ?? $_REQUEST['case'] ?? 'trangchu';

switch ($act) {
    // ========================================================
    // CASE 'trangchu' / 'timkiem' [U3]
    // ========================================================
    case "trangchu":
    case "timkiem":
        include __DIR__ . "/../view/header.php";
        include __DIR__ . "/../view/menu.php";
        include __DIR__ . "/../view/trangchu.php";
        include __DIR__ . "/../view/footer.php";
        break;

    // ========================================================
    // CASE 'chitiet' & 'themdanhgia' [U4]
    // ========================================================
    case "chitiet":
        include __DIR__ . "/../view/header.php";
        include __DIR__ . "/../view/menu.php";
        include __DIR__ . "/../view/chitiet_sanpham.php";
        include __DIR__ . "/../view/footer.php";
        break;

    case "themdanhgia":
        $id_sp = $_REQUEST['id_sp'] ?? 2;
        header("Location: index.php?act=chitiet&id=" . $id_sp . "&review_success=1");
        exit();

    // ========================================================
    // CÁC CASE GIỎ HÀNG CHUẨN THEO BÀI MẪU CỦA THẦY (Lab 3.1)
    // ========================================================
    case "giohang":
        include __DIR__ . "/../view/header.php";
        include __DIR__ . "/../view/menu.php";
        include __DIR__ . "/../view/giohang.php";
        include __DIR__ . "/../view/footer.php";
        break;

    case "themgiohang":
        if (isset($_REQUEST['id']) && isset($_REQUEST['tensp'])) {
            $id = $_REQUEST['id'];
            $tensp = $_REQUEST['tensp'];
            $dongia = (float)$_REQUEST['dongia'];
            $hinh = $_REQUEST['hinh'] ?? 'iphone 15 pro max.jpeg';
            $sl = isset($_REQUEST['sl']) ? (int)$_REQUEST['sl'] : 1;
            if ($sl <= 0) $sl = 1;

            $sp = [$id, $tensp, $dongia, $sl, $hinh];
            $vitri = kiemtra($sp);

            if ($vitri === -1) {
                $_SESSION['giohang'][] = $sp;
            } else {
                $_SESSION['giohang'][$vitri][3] += $sl;
            }
        }

        if (isset($_REQUEST['ajax'])) {
            echo "success";
            exit();
        }

        include __DIR__ . "/../view/header.php";
        include __DIR__ . "/../view/menu.php";
        include __DIR__ . "/../view/giohang.php";
        include __DIR__ . "/../view/footer.php";
        break;

    case "xoagiohang":
        if (isset($_REQUEST['del'])) {
            $id_del = $_REQUEST['del'];
            $sp = [$id_del];
            $vitri = kiemtra($sp);
            if ($vitri !== -1) {
                array_splice($_SESSION['giohang'], $vitri, 1);
            }
        }
        include __DIR__ . "/../view/header.php";
        include __DIR__ . "/../view/menu.php";
        include __DIR__ . "/../view/giohang.php";
        include __DIR__ . "/../view/footer.php";
        break;

    case "suagiohang":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_REQUEST['id'];
            $sl = (int)$_REQUEST['sl'];
            if ($sl <= 0) $sl = 1;

            $sp = [$id, $sl];
            $vitri = kiemtra($sp);
            if ($vitri !== -1) {
                $_SESSION['giohang'][$vitri][3] = $sl;
            }
        }
        include __DIR__ . "/../view/header.php";
        include __DIR__ . "/../view/menu.php";
        include __DIR__ . "/../view/giohang.php";
        include __DIR__ . "/../view/footer.php";
        break;

    // ========================================================
    // CASE 'dangky' [U1] & 'dangnhap' [U2] & 'dangxuat' [19/5]
    // ========================================================
    case "dangky":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_SESSION['user'] = [
                'id' => rand(10, 999),
                'username' => $_POST['username'] ?? 'user',
                'hoten' => $_POST['hoten'] ?? 'Khách Hàng Mới',
                'email' => $_POST['email'] ?? 'email@example.com',
                'sdt' => $_POST['sdt'] ?? '',
                'ngaysinh' => $_POST['ngaysinh'] ?? date('Y-m-d'),
                'hang' => 'Silver',
                'diem' => 0
            ];
            unset($_SESSION['guest_mode']);
            header("Location: index.php?act=trangchu");
            exit();
        }
        include __DIR__ . "/../view/header.php";
        include __DIR__ . "/../view/menu.php";
        include __DIR__ . "/../view/dangky.php";
        include __DIR__ . "/../view/footer.php";
        break;

    case "dangnhap":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = $_POST['username'] ?? '';
            if (strtolower($user) === 'khoa' || strtolower($user) === 'lock') {
                header("Location: index.php?act=dangnhap&error=locked");
                exit();
            }

            $_SESSION['user'] = [
                'id' => 1,
                'username' => $user,
                'hoten' => 'Nguyễn Hoàng Quân',
                'email' => 'quan.nguyen@email.com',
                'sdt' => '0901.234.567',
                'ngaysinh' => '1995-10-18',
                'hang' => 'Silver',
                'diem' => 140
            ];
            unset($_SESSION['guest_mode']);
            header("Location: index.php?act=trangchu");
            exit();
        }
        include __DIR__ . "/../view/header.php";
        include __DIR__ . "/../view/menu.php";
        include __DIR__ . "/../view/dangnhap.php";
        include __DIR__ . "/../view/footer.php";
        break;

    case "dangxuat":
        unset($_SESSION['user']);
        unset($_SESSION['giohang']);
        $_SESSION['guest_mode'] = true;
        header("Location: index.php?act=trangchu");
        exit();

    // ========================================================
    // CASE 'thanhtoan' [U6]
    // ========================================================
    case "thanhtoan":
        if ($_SERVER["REQUEST_METHOD"] == "POST" || isset($_POST['btn_dathang'])) {
            unset($_SESSION['giohang']);
            header("Location: index.php?act=thanhtoan&success=1");
            exit();
        }
        include __DIR__ . "/../view/header.php";
        include __DIR__ . "/../view/menu.php";
        include __DIR__ . "/../view/thanhtoan.php";
        include __DIR__ . "/../view/footer.php";
        break;

    // ========================================================
    // CASE 'lichsumuahang' [U7] & 'huydonhang' & 'khieunai'
    // ========================================================
    case "lichsumuahang":
        include __DIR__ . "/../view/header.php";
        include __DIR__ . "/../view/menu.php";
        include __DIR__ . "/../view/lichsu_muahang.php";
        include __DIR__ . "/../view/footer.php";
        break;

    case "huydonhang":
        header("Location: index.php?act=lichsumuahang&cancel_success=1");
        exit();

    case "khieunai":
        header("Location: index.php?act=lichsumuahang&complain_success=1");
        exit();

    // ========================================================
    // CASE 'theodoidonhang' [U8]
    // ========================================================
    case "theodoidonhang":
        include __DIR__ . "/../view/header.php";
        include __DIR__ . "/../view/menu.php";
        include __DIR__ . "/../view/theodoi_donhang.php";
        include __DIR__ . "/../view/footer.php";
        break;

    // ========================================================
    // CASE 'hopthu' [U9]
    // ========================================================
    case "hopthu":
        include __DIR__ . "/../view/header.php";
        include __DIR__ . "/../view/menu.php";
        include __DIR__ . "/../view/hopthu.php";
        include __DIR__ . "/../view/footer.php";
        break;

    case "admin":
        header("Location: admin/index.php");
        exit();

    default:
        include __DIR__ . "/../view/header.php";
        include __DIR__ . "/../view/menu.php";
        include __DIR__ . "/../view/trangchu.php";
        include __DIR__ . "/../view/footer.php";
        break;
}
?>

