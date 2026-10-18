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
        $kq = $admin->dangNhap($_POST['email'] ?? '', $_POST['mat_khau'] ?? '');
        if ($kq['ok']) {
            $_SESSION['admin'] = $kq['nhanvien'];
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
        $kq = $admin->themSanPham($_POST);
        $loi = $kq['ok'] ? null : $kq['loi'];
        $thongBao = $kq['ok'] ? 'Da them san pham' : null;
        $data = $admin->trangSanPham();
        $ctrl->render('admin/sanpham.php', $data + compact('thongBao', 'loi') + ['act' => 'sanpham']);
        break;

    case 'suasanpham':
        $kq = $admin->suaSanPham((int) ($_POST['id'] ?? 0), $_POST);
        $loi = $kq['ok'] ? null : $kq['loi'];
        $thongBao = $kq['ok'] ? 'Da sua san pham' : null;
        $data = $admin->trangSanPham();
        $ctrl->render('admin/sanpham.php', $data + compact('thongBao', 'loi') + ['act' => 'sanpham']);
        break;

    case 'xoasanpham':
        $kq = $admin->xoaSanPham((int) ($_GET['id'] ?? $_POST['id'] ?? 0));
        $loi = $kq['ok'] ? null : $kq['loi'];
        $thongBao = $kq['ok'] ? 'Da xoa san pham' : null;
        $data = $admin->trangSanPham();
        $ctrl->render('admin/sanpham.php', $data + compact('thongBao', 'loi') + ['act' => 'sanpham']);
        break;

    case 'danhmuc':
        $hanhDong = $_POST['hanh_dong'] ?? $_GET['hanh_dong'] ?? 'them';
        $kq = $admin->xuLyDanhMuc($hanhDong, $_POST + $_GET);
        $loi = $kq['ok'] ? null : ($kq['loi'] ?? null);
        $thongBao = $kq['ok'] ? 'Da cap nhat danh muc' : null;
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
            'thongBao' => 'Da gui qua cho ' . $kq['so_khach'] . ' khach',
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

    default:
        $ctrl->json(['ok' => false, 'loi' => 'Khong ro act admin', 'act' => $act], 400);
}
