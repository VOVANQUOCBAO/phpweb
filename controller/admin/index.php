<?php

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__, 2));
}

if (session_status() !== PHP_SESSION_ACTIVE) {
    ini_set('session.use_strict_mode', '1');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => !empty($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

require_once BASE_PATH . '/controller/controller.php';
require_once BASE_PATH . '/controller/admin/admin_controller.php';

$ctrl = new controller();
$admin = new admin_controller();
$act = $ctrl->act();
if ($act === 'trangchu') {
    $act = empty($_SESSION['admin']) ? 'dangnhap' : 'sanpham';
}

$thongBao = null;
$loi = null;

if ($act === 'dangnhap') {
    if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
        if (!$ctrl->verifyCsrfToken($_POST['_csrf'] ?? null)) {
            http_response_code(403);
            $loi = 'Phiên biểu mẫu không hợp lệ hoặc đã hết hạn. Vui lòng tải lại trang và thử lại.';
        } else {
            $email = $_POST['email'] ?? $_POST['admin_user'] ?? '';
            $pass = $_POST['mat_khau'] ?? $_POST['admin_pass'] ?? '';
            if ($email === 'admin') {
                $email = 'admin@local.test';
            }
            $kq = $admin->dangNhap($email, $pass);
            if ($kq['ok'] && in_array($kq['nhanvien']['vai_tro'] ?? '', [
                nhanvien::ROLE_SUPER_ADMIN,
                nhanvien::ROLE_MANAGER,
                nhanvien::ROLE_EMPLOYEE,
                'Admin',
            ], true)) {
                session_regenerate_id(true);
                unset($_SESSION['admin_csrf']);
                $nv = $kq['nhanvien'];
                $nv['hoten'] = $nv['ho_ten'] ?? 'Quản Trị Viên';
                $_SESSION['admin'] = $nv;
                $ctrl->redirect('sanpham', [], 'admin');
            }
            $loi = $kq['ok'] ? 'Tài khoản không có quyền quản trị.' : $kq['loi'];
        }
    }
    $ctrl->render('admin/dangnhap_admin.php', compact('thongBao', 'loi') + ['act' => $act]);
    return;
}

if ($act === 'dangxuat') {
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        http_response_code(405);
        header('Allow: POST');
        exit('Thao tác đăng xuất phải gửi bằng POST.');
    }
    if (!$ctrl->verifyCsrfToken($_POST['_csrf'] ?? null)) {
        http_response_code(403);
        exit('Phiên biểu mẫu không hợp lệ hoặc đã hết hạn.');
    }
    unset($_SESSION['admin']);
    unset($_SESSION['admin_csrf']);
    $ctrl->redirect('dangnhap', [], 'admin');
}

if ($ctrl->requireAdmin() === null) {
    $ctrl->redirect('dangnhap', [], 'admin');
}
$currentAdmin = $_SESSION['admin'];
if (!$ctrl->canAccessAdminAction($act, (string) $currentAdmin['vai_tro'])) {
    http_response_code(403);
    exit('Tài khoản của bạn không có quyền thực hiện chức năng này.');
}

$mutationActions = [
    'themsanpham',
    'suasanpham',
    'xoasanpham',
    'danhmuc',
    'themdanhmuc',
    'themnhanvien',
    'khoanhanvien',
    'doivaitronhanvien',
    'khoadanhgia',
    'khoakhachhang',
    'guiquatang',
    'themvoucher',
    'xoavoucher',
    'themkhuyenmai',
    'capnhattrangthai',
    'doimatkhau',
];
$isMutation = in_array($act, $mutationActions, true)
    || ($act === 'giaodien' && ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST');
if ($isMutation) {
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        http_response_code(405);
        header('Allow: POST');
        exit('Thao tác này phải gửi bằng POST.');
    }
    if (!$ctrl->verifyCsrfToken($_POST['_csrf'] ?? null)) {
        http_response_code(403);
        exit('Phiên biểu mẫu không hợp lệ hoặc đã hết hạn.');
    }
}

switch ($act) {
    case 'sanpham':
        $data = $admin->trangSanPham();
        $ctrl->render('admin/sanpham.php', $data + compact('thongBao', 'loi') + ['act' => $act]);
        break;

    case 'themsanpham':
        $kq = ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST'
            ? (!empty($_POST['id'])
                ? $admin->suaSanPham((int) $_POST['id'], $_POST)
                : $admin->themSanPham($_POST))
            : ['ok' => false, 'loi' => 'Thao tác sản phẩm phải gửi bằng POST'];
        $loi = $kq['ok'] ? null : $kq['loi'];
        $thongBao = $kq['ok'] ? (!empty($_POST['id']) ? 'Đã cập nhật sản phẩm' : 'Đã thêm sản phẩm') : null;
        $data = $admin->trangSanPham();
        $ctrl->render('admin/sanpham.php', $data + compact('thongBao', 'loi') + ['act' => 'sanpham']);
        break;

    case 'suasanpham':
        $kq = ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST'
            ? $admin->suaSanPham((int) ($_POST['id'] ?? 0), $_POST)
            : ['ok' => false, 'loi' => 'Thao tác sản phẩm phải gửi bằng POST'];
        $loi = $kq['ok'] ? null : $kq['loi'];
        $thongBao = $kq['ok'] ? 'Đã cập nhật sản phẩm' : null;
        $data = $admin->trangSanPham();
        $ctrl->render('admin/sanpham.php', $data + compact('thongBao', 'loi') + ['act' => 'sanpham']);
        break;

    case 'xoasanpham':
        $kq = ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST'
            ? $admin->xoaSanPham((int) ($_POST['id'] ?? 0))
            : ['ok' => false, 'loi' => 'Thao tác sản phẩm phải gửi bằng POST'];
        $loi = $kq['ok'] ? null : $kq['loi'];
        $thongBao = $kq['ok'] ? 'Đã xóa sản phẩm' : null;
        $data = $admin->trangSanPham();
        $ctrl->render('admin/sanpham.php', $data + compact('thongBao', 'loi') + ['act' => 'sanpham']);
        break;

    case 'danhmuc':
    case 'themdanhmuc':
        $kq = ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST'
            ? $admin->xuLyDanhMuc((string) ($_POST['hanh_dong'] ?? 'them'), $_POST)
            : ['ok' => false, 'loi' => 'Thao tác danh mục phải gửi bằng POST'];
        $loi = $kq['ok'] ? null : ($kq['loi'] ?? null);
        $thongBao = $kq['ok'] ? 'Đã lưu thay đổi danh mục' : null;
        $data = $admin->trangSanPham();
        $ctrl->render('admin/sanpham.php', $data + compact('thongBao', 'loi') + ['act' => 'sanpham']);
        break;

    case 'nhanvien':
        $data = $admin->trangNhanVien();
        $ctrl->render('admin/nhanvien.php', $data + compact('thongBao', 'loi') + ['act' => $act]);
        break;

    case 'themnhanvien':
        $kq = ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST'
            ? $admin->themNhanVien($_POST)
            : ['ok' => false, 'loi' => 'Thao tác nhân viên phải gửi bằng POST'];
        $loi = $kq['ok'] ? null : $kq['loi'];
        $thongBao = $kq['ok'] ? 'Đã thêm tài khoản nhân viên' : null;
        $data = $admin->trangNhanVien();
        $ctrl->render('admin/nhanvien.php', $data + compact('thongBao', 'loi') + ['act' => 'nhanvien']);
        break;

    case 'khoanhanvien':
        if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
            $kq = ['ok' => false, 'loi' => 'Thao tác trạng thái nhân viên phải gửi bằng POST'];
        } else {
            $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
            $tt = filter_var($_POST['trang_thai'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 1]]);
            $kq = $id === false || $tt === false
                ? ['ok' => false, 'loi' => 'Mã nhân viên hoặc trạng thái không hợp lệ']
                : $admin->khoaNhanVien($id, $tt);
        }
        $data = $admin->trangNhanVien();
        $ctrl->render('admin/nhanvien.php', $data + [
            'thongBao' => $kq['ok'] ? 'Đã cập nhật trạng thái nhân viên' : null,
            'loi' => $kq['ok'] ? null : $kq['loi'],
            'act' => 'nhanvien',
        ]);
        break;

    case 'doivaitronhanvien':
        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        $vaiTro = $_POST['vai_tro'] ?? '';
        $kq = $id === false || !is_string($vaiTro)
            ? ['ok' => false, 'loi' => 'Mã nhân viên hoặc vai trò không hợp lệ']
            : (new nhanvien())->doiVaiTro($id, $vaiTro, (int) $currentAdmin['id']);
        $data = $admin->trangNhanVien();
        $ctrl->render('admin/nhanvien.php', $data + [
            'thongBao' => $kq['ok'] ? 'Đã cập nhật vai trò nhân viên' : null,
            'loi' => $kq['ok'] ? null : $kq['loi'],
            'act' => 'nhanvien',
        ]);
        break;

    case 'danhgia':
        $data = $admin->trangDanhGia();
        $ctrl->render('admin/danhgia.php', $data + compact('thongBao', 'loi') + ['act' => $act]);
        break;

    case 'khoadanhgia':
        $admin->khoaDanhGia((int) ($_GET['id'] ?? $_POST['id'] ?? 0));
        if (!empty($_POST['khoa_khach'])) {
            $admin->khoaKhachHang((int) $_POST['khoa_khach'], 0);
        }
        $data = $admin->trangDanhGia();
        $ctrl->render('admin/danhgia.php', $data + ['thongBao' => 'Da khoa danh gia', 'loi' => null, 'act' => 'danhgia']);
        break;

    case 'khachhang':
        $data = $admin->trangKhachHang();
        $ctrl->render('admin/khachhang.php', $data + compact('thongBao', 'loi') + ['act' => $act]);
        break;

    case 'khoakhachhang':
        $id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
        $tt = (int) ($_GET['trang_thai'] ?? $_POST['trang_thai'] ?? 0);
        $admin->khoaKhachHang($id, $tt);
        $data = $admin->trangKhachHang();
        $ctrl->render('admin/khachhang.php', $data + ['thongBao' => 'Da cap nhat trang thai khach', 'loi' => null, 'act' => 'khachhang']);
        break;

    case 'guiquatang':
        $kq = $admin->guiQuaTang($_POST);
        $data = $admin->trangKhachHang();
        $ctrl->render('admin/khachhang.php', $data + [
            'thongBao' => 'Da gui qua cho ' . ($kq['so_khach'] ?? 0) . ' khach',
            'loi' => null,
            'act' => 'khachhang',
        ]);
        break;

    case 'voucher':
        $data = $admin->trangVoucher();
        $ctrl->render('admin/voucher.php', $data + compact('thongBao', 'loi') + ['act' => $act]);
        break;

    case 'themvoucher':
        $kq = $admin->themVoucher($_POST);
        $loi = $kq['ok'] ? null : $kq['loi'];
        $thongBao = $kq['ok'] ? 'Da tao voucher' : null;
        $data = $admin->trangVoucher();
        $ctrl->render('admin/voucher.php', $data + compact('thongBao', 'loi') + ['act' => 'voucher']);
        break;

    case 'xoavoucher':
        $admin->xoaVoucher((int) ($_GET['id'] ?? $_POST['id'] ?? 0));
        $data = $admin->trangVoucher();
        $ctrl->render('admin/voucher.php', $data + ['thongBao' => 'Da xoa voucher', 'loi' => null, 'act' => 'voucher']);
        break;

    case 'khuyenmai':
        $data = $admin->trangKhuyenMai();
        $ctrl->render('admin/khuyenmai.php', $data + compact('thongBao', 'loi') + ['act' => $act]);
        break;

    case 'themkhuyenmai':
        $kq = $admin->themKhuyenMai($_POST);
        $loi = $kq['ok'] ? null : $kq['loi'];
        $thongBao = $kq['ok'] ? 'Da tao khuyen mai' : null;
        $data = $admin->trangKhuyenMai();
        $ctrl->render('admin/khuyenmai.php', $data + compact('thongBao', 'loi') + ['act' => 'khuyenmai']);
        break;

    case 'donhang':
        $data = $admin->trangDonHang();
        $ctrl->render('admin/donhang.php', $data + compact('thongBao', 'loi') + ['act' => $act]);
        break;

    case 'chitietdonhang':
        $kq = $admin->chiTietDonHang((int) ($_GET['id'] ?? 0));
        $ctrl->render('admin/donhang.php', [
            'ds_donhang' => $admin->trangDonHang()['ds_donhang'],
            'chitiet' => $kq['ok'] ? $kq['donhang'] : null,
            'thongBao' => null,
            'loi' => $kq['ok'] ? null : $kq['loi'],
            'act' => $act,
        ]);
        break;

    case 'capnhattrangthai':
        $kq = $admin->capNhatTrangThai(
            (int) ($_POST['id'] ?? $_GET['id'] ?? 0),
            (string) ($_POST['trang_thai'] ?? $_GET['trang_thai'] ?? ''),
            (string) ($_POST['ly_do'] ?? '')
        );
        $loi = $kq['ok'] ? null : $kq['loi'];
        $thongBao = $kq['ok'] ? 'Da cap nhat trang thai' : null;
        $data = $admin->trangDonHang();
        $ctrl->render('admin/donhang.php', $data + compact('thongBao', 'loi') + ['act' => 'donhang']);
        break;

    case 'doanhthu':
        $ky = $_GET['ky'] ?? 'thang';
        $data = $admin->doanhThu($ky);
        $ctrl->render('admin/doanhthu.php', $data + compact('thongBao', 'loi', 'ky') + ['act' => $act]);
        break;

    case 'csdl':
        require_once BASE_PATH . '/model/csdl.php';
        $tables = [
            'danhmuc' => 'Danh mục',
            'sanpham' => 'Sản phẩm',
            'khachhang' => 'Khách hàng',
            'nhanvien' => 'Nhân viên',
            'danhgia' => 'Đánh giá',
            'voucher' => 'Voucher',
            'khuyenmai' => 'Khuyến mãi',
            'donhang' => 'Đơn hàng',
            'chitietdonhang' => 'Chi tiết đơn hàng',
            'email' => 'Email',
        ];
        $table = $_GET['bang'] ?? 'donhang';
        if (!is_string($table) || !isset($tables[$table])) {
            http_response_code(400);
            $table = 'donhang';
            $loi = 'Bảng dữ liệu được yêu cầu không hợp lệ.';
        }

        $pdo = csdl::shared();
        $tableCounts = [];
        foreach ($tables as $name => $label) {
            $tableCounts[$name] = (int) $pdo->query("SELECT COUNT(*) FROM `{$name}`")->fetchColumn();
        }

        $page = filter_var($_GET['trang'] ?? 1, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if ($page === false) {
            http_response_code(400);
            $page = 1;
            $loi = 'Số trang không hợp lệ.';
        }
        $pageSize = 25;
        $totalRows = $tableCounts[$table];
        $totalPages = max(1, (int) ceil($totalRows / $pageSize));
        $page = min((int) $page, $totalPages);

        $columns = $pdo->query("SHOW COLUMNS FROM `{$table}`")->fetchAll(PDO::FETCH_COLUMN);
        $visibleColumns = array_values(array_filter(
            $columns,
            static fn(string $column): bool => !preg_match('/(?:mat_khau|password|token|secret|otp)/i', $column)
        ));
        $offset = ($page - 1) * $pageSize;
        $statement = $pdo->prepare(
            'SELECT ' . implode(', ', array_map(static fn(string $column): string => "`{$column}`", $visibleColumns))
            . " FROM `{$table}` ORDER BY 1 DESC LIMIT :page_size OFFSET :row_offset"
        );
        $statement->bindValue(':page_size', $pageSize, PDO::PARAM_INT);
        $statement->bindValue(':row_offset', $offset, PDO::PARAM_INT);
        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        $ctrl->render('admin/csdl.php', compact(
            'tables',
            'tableCounts',
            'table',
            'columns',
            'visibleColumns',
            'rows',
            'page',
            'pageSize',
            'totalRows',
            'totalPages',
            'thongBao',
            'loi'
        ) + ['act' => $act]);
        break;

    case 'giaodien':
        if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
            $kq = $admin->luuGiaoDien($_POST);
            $thongBao = 'Đã lưu và áp dụng cấu hình giao diện cho toàn hệ thống thành công!';
        }
        $data = $admin->trangGiaoDien();
        $ctrl->render('admin/giaodien.php', $data + compact('thongBao', 'loi') + ['act' => 'giaodien']);
        break;

    case 'doimatkhau':
        if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
            $matKhauMoi = trim((string)($_POST['mat_khau_moi'] ?? ''));
            $xacNhan = trim((string)($_POST['xac_nhan_mat_khau'] ?? ''));
            if ($matKhauMoi === '') {
                $loi = 'Vui lòng nhập mật khẩu mới.';
            } elseif ($matKhauMoi !== $xacNhan) {
                $loi = 'Xác nhận mật khẩu mới không khớp.';
            } else {
                $nvModel = new nhanvien();
                $adminId = (int)($_SESSION['admin']['id'] ?? 1);
                $kq = $nvModel->doiMatKhau($adminId, $matKhauMoi);
                if ($kq['ok']) {
                    // Đồng bộ sang bảng khachhang cho tài khoản admin
                    $khModel = new khachhang();
                    $khAdmin = $khModel->selectOne("SELECT id FROM khachhang WHERE ten_dang_nhap = 'admin' OR email = 'admin@local.test'");
                    if ($khAdmin) {
                        $khModel->doiMatKhau((int)$khAdmin['id'], $matKhauMoi);
                    }
                    $thongBao = 'Đổi mật khẩu Quản Trị Viên thành công! Mật khẩu mới đã được cập nhật đồng bộ trong CSDL.';
                } else {
                    $loi = $kq['loi'];
                }
            }
        }
        $ctrl->render('admin/doimatkhau.php', compact('thongBao', 'loi') + ['act' => 'doimatkhau']);
        break;

    default:
        $ctrl->json(['ok' => false, 'loi' => 'Khong ro act admin', 'act' => $act], 400);
}
