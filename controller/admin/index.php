<?php

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__, 2));
}

if (session_status() !== PHP_SESSION_ACTIVE) {
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
        $email = $_POST['email'] ?? $_POST['admin_user'] ?? '';
        $pass = $_POST['mat_khau'] ?? $_POST['admin_pass'] ?? '';
        if ($email === 'admin') {
            $email = 'admin@local.test';
        }
        $kq = $admin->dangNhap($email, $pass);
        if ($kq['ok']) {
            session_regenerate_id(true);
            $nv = $kq['nhanvien'];
            $nv['hoten'] = $nv['ho_ten'] ?? 'Quản Trị Viên';
            $_SESSION['admin'] = $nv;
            $ctrl->redirect('sanpham', [], 'admin');
        }
        $loi = $kq['loi'];
    }
    $ctrl->render('admin/dangnhap_admin.php', compact('thongBao', 'loi') + ['act' => $act]);
    return;
}

if ($act === 'dangxuat') {
    unset($_SESSION['admin']);
    $ctrl->redirect('dangnhap', [], 'admin');
}

if ($ctrl->requireAdmin() === null) {
    $ctrl->redirect('dangnhap', [], 'admin');
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
        $kq = $admin->themNhanVien($_POST);
        $loi = $kq['ok'] ? null : $kq['loi'];
        $thongBao = $kq['ok'] ? 'Da them nhan vien' : null;
        $data = $admin->trangNhanVien();
        $ctrl->render('admin/nhanvien.php', $data + compact('thongBao', 'loi') + ['act' => 'nhanvien']);
        break;

    case 'khoanhanvien':
        $id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
        $tt = (int) ($_GET['trang_thai'] ?? $_POST['trang_thai'] ?? 0);
        $admin->khoaNhanVien($id, $tt);
        $data = $admin->trangNhanVien();
        $ctrl->render('admin/nhanvien.php', $data + ['thongBao' => 'Da cap nhat trang thai nhan vien', 'loi' => null, 'act' => 'nhanvien']);
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
