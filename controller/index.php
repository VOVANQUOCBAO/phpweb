<?php

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

date_default_timezone_set('Asia/Ho_Chi_Minh');

/* Hop dong View: support/README.md. Chua co View thi tra JSON de test. */
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once BASE_PATH . '/controller/controller.php';
require_once BASE_PATH . '/controller/giohang.php';
require_once BASE_PATH . '/controller/xuly_email.php';
require_once BASE_PATH . '/model/danhmuc.php';
require_once BASE_PATH . '/model/sanpham.php';
require_once BASE_PATH . '/model/khachhang.php';
require_once BASE_PATH . '/model/danhgia.php';
require_once BASE_PATH . '/model/donhang.php';
require_once BASE_PATH . '/model/chitietdonhang.php';
require_once BASE_PATH . '/model/voucher.php';
require_once BASE_PATH . '/model/khuyenmai.php';
require_once BASE_PATH . '/model/email.php';

$ctrl = new controller();
$act = $ctrl->act();
$thongBao = null;
$loi = null;

try {
    foreach ([$_GET, $_POST] as $inputs) {
        foreach ($inputs as $key => $value) {
            if (is_array($value) || is_object($value)) {
                throw new InvalidArgumentException('Tham so phai la gia tri don');
            }
            if (in_array($key, ['id', 'id_sanpham', 'id_danhmuc', 'sl', 'so_sao', 'trang', 'moi_trang'], true)
                && !($key === 'id_danhmuc' && $value === '')
                && filter_var($value, FILTER_VALIDATE_INT) === false) {
                throw new InvalidArgumentException('Tham so so nguyen khong hop le');
            }
        }
    }
    $dmModel = new danhmuc();
    $spModel = new sanpham();
    $khModel = new khachhang();
    $dgModel = new danhgia();
    $dhModel = new donhang();
    $kmModel = new khuyenmai();
    $emModel = new email();

    switch ($act) {
        case 'dangky':
            if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
                $payload = $_POST;
                if (!isset($payload['ho_ten']) && isset($payload['hoten'])) {
                    $payload['ho_ten'] = $payload['hoten'];
                }
                if (!isset($payload['mat_khau']) && isset($payload['password'])) {
                    $payload['mat_khau'] = $payload['password'];
                }
                if (!isset($payload['ngay_sinh']) && isset($payload['ngaysinh'])) {
                    $payload['ngay_sinh'] = $payload['ngaysinh'];
                }
                $kq = $khModel->themKhachHang($payload);
                if ($kq['ok']) {
                    $thongBao = 'Dang ky thanh cong, vui long dang nhap';
                    $ctrl->render('dangky.php', compact('thongBao', 'loi') + ['act' => $act]);
                    break;
                }
                $loi = $kq['loi'];
            }
            $ctrl->render('dangky.php', compact('thongBao', 'loi') + ['act' => $act]);
            break;

        case 'dangnhap':
            if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
                $email = $_POST['email'] ?? $_POST['username'] ?? '';
                $pass = $_POST['mat_khau'] ?? $_POST['password'] ?? '';
                $kq = $khModel->kiemTraDangNhap($email, $pass);
                if ($kq['ok']) {
                    session_regenerate_id(true);
                    $u = $kq['khachhang'];
                    $u['hoten'] = $u['ho_ten'] ?? '';
                    $_SESSION['user'] = $u;
                    $ctrl->redirect('trangchu');
                }
                $loi = $kq['loi'];
            }
            $ctrl->render('dangnhap.php', compact('thongBao', 'loi') + ['act' => $act]);
            break;

        case 'dangxuat':
            unset($_SESSION['user'], $_SESSION['giohang']);
            session_regenerate_id(true);
            $ctrl->redirect('trangchu');
            break;

        case 'timkiem':
        case 'trangchu':
            $tuKhoa = isset($_GET['q']) ? trim((string) $_GET['q']) : (isset($_GET['keyword']) ? trim((string) $_GET['keyword']) : '');
            $idDm = isset($_GET['id_danhmuc']) ? (int) $_GET['id_danhmuc'] : 0;
            $sapXep = ($_GET['sapxep'] ?? $_GET['sort'] ?? 'moi') === 'cu' ? 'cu' : 'moi';
            $trang = max(1, min(1000000, (int) ($_GET['trang'] ?? 1)));
            $moi_trang = max(1, min(100, (int) ($_GET['moi_trang'] ?? 12)));
            $tong_sanpham = $spModel->demTimKiem($tuKhoa !== '' ? $tuKhoa : null, $idDm > 0 ? $idDm : null);
            $con_tiep = $trang * $moi_trang < $tong_sanpham;
            $ds_danhmuc = $dmModel->layDS();
            $ds_sanpham = $spModel->timKiem($tuKhoa !== '' ? $tuKhoa : null, $idDm > 0 ? $idDm : null,
                $sapXep, $moi_trang, ($trang - 1) * $moi_trang);
            foreach ($ds_sanpham as &$sp) {
                $giaKm = $kmModel->giaSauKM($sp);
                $sp['gia_goc'] = $giaKm['gia_goc'];
                $sp['gia_km'] = $giaKm['gia_km'];
                $sp['het_hang'] = (int) $sp['so_luong_ton'] <= 0;
            }
            unset($sp);
            $sp_moi = $spModel->layDSMoi();
            $sp_km = $spModel->layDSKhuyenMai();
            foreach (['sp_moi', 'sp_km'] as $tenDanhSach) {
                foreach (${$tenDanhSach} as &$sp) {
                    $giaKm = $kmModel->giaSauKM($sp);
                    $sp['gia_goc'] = $giaKm['gia_goc'];
                    $sp['gia_km'] = $giaKm['gia_km'];
                    $sp['het_hang'] = (int) $sp['so_luong_ton'] <= 0;
                }
                unset($sp);
            }
            $ctrl->render('trangchu.php', compact(
                'ds_danhmuc',
                'ds_sanpham',
                'sp_moi',
                'sp_km',
                'tuKhoa',
                'idDm',
                'sapXep',
                'trang', 'moi_trang', 'tong_sanpham', 'con_tiep',
                'thongBao',
                'loi'
            ) + ['act' => $act]);
            break;

        case 'chitiet':
            $id = (int) ($_GET['id'] ?? $_GET['id_sp'] ?? 0);
            $chitiet = $spModel->layChiTiet($id);
            if ($chitiet === null) {
                $ctrl->json(['ok' => false, 'loi' => 'Khong tim thay san pham'], 404);
                break;
            }
            $giaKm = $kmModel->giaSauKM($chitiet);
            $chitiet['gia_goc'] = $giaKm['gia_goc'];
            $chitiet['gia_km'] = $giaKm['gia_km'];
            $chitiet['het_hang'] = (int) $chitiet['so_luong_ton'] <= 0;
            $ds_danhgia = $dgModel->layDSTheoSP($id);
            $ctrl->render('chitiet_sanpham.php', compact('chitiet', 'ds_danhgia', 'thongBao', 'loi') + ['act' => $act]);
            break;

        case 'themdanhgia':
            $user = $ctrl->requireUser();
            $idSp = (int) ($_POST['id_sanpham'] ?? $_GET['id_sanpham'] ?? $_POST['id_sp'] ?? $_GET['id_sp'] ?? 0);
            if ($user === null) {
                $ctrl->redirect('dangnhap');
            }
            $chitiet = $spModel->layChiTiet($idSp);
            if ($chitiet === null) {
                $ctrl->json(['ok' => false, 'loi' => 'Khong tim thay san pham'], 404);
                break;
            }
            $giaKm = $kmModel->giaSauKM($chitiet);
            $chitiet['gia_goc'] = $giaKm['gia_goc'];
            $chitiet['gia_km'] = $giaKm['gia_km'];
            $chitiet['het_hang'] = (int) $chitiet['so_luong_ton'] <= 0;
            $soSao = (int) ($_POST['so_sao'] ?? $_POST['sao'] ?? 0);
            $noiDung = (string) ($_POST['noi_dung'] ?? $_POST['noidung'] ?? '');
            $kq = $dgModel->them($idSp, (int) $user['id'], $soSao, $noiDung);
            if (!$kq['ok']) {
                $loi = $kq['loi'];
            } else {
                $thongBao = 'Da gui danh gia';
            }
            $ds_danhgia = $dgModel->layDSTheoSP($idSp);
            $ctrl->render('chitiet_sanpham.php', compact('chitiet', 'ds_danhgia', 'thongBao', 'loi') + ['act' => 'chitiet']);
            break;

        case 'giohang':
            $ctrl->render('giohang.php', ['giohang' => giohang::chiTiet(), 'act' => $act, 'thongBao' => $thongBao, 'loi' => $loi]);
            break;

        case 'themgiohang':
            $idSp = (int) ($_GET['id'] ?? $_POST['id'] ?? $_GET['id_sp'] ?? 0);
            $sl = (int) ($_GET['sl'] ?? $_POST['sl'] ?? 1);
            if (filter_var($_GET['sl'] ?? $_POST['sl'] ?? 1, FILTER_VALIDATE_INT) === false) {
                throw new InvalidArgumentException('So luong phai la so nguyen');
            }
            $kq = giohang::them($idSp, $sl);
            $loi = $kq['ok'] ? null : $kq['loi'];
            $thongBao = $kq['ok'] ? 'Da them vao gio' : null;
            $ctrl->render('giohang.php', ['giohang' => giohang::chiTiet(), 'act' => 'giohang', 'thongBao' => $thongBao, 'loi' => $loi]);
            break;

        case 'xoagiohang':
            $idSp = (int) ($_GET['id'] ?? $_POST['id'] ?? $_GET['del'] ?? 0);
            giohang::xoa($idSp);
            $ctrl->render('giohang.php', ['giohang' => giohang::chiTiet(), 'act' => 'giohang', 'thongBao' => 'Da xoa san pham', 'loi' => null]);
            break;

        case 'suagiohang':
            $idSp = (int) ($_POST['id'] ?? $_GET['id'] ?? 0);
            $sl = (int) ($_POST['sl'] ?? $_GET['sl'] ?? 0);
            if (filter_var($_POST['sl'] ?? $_GET['sl'] ?? 0, FILTER_VALIDATE_INT) === false) {
                throw new InvalidArgumentException('So luong phai la so nguyen');
            }
            $kq = giohang::sua($idSp, $sl);
            $loi = $kq['ok'] ? null : $kq['loi'];
            $ctrl->render('giohang.php', ['giohang' => giohang::chiTiet(), 'act' => 'giohang', 'thongBao' => $kq['ok'] ? 'Da cap nhat gio' : null, 'loi' => $loi]);
            break;

        case 'thanhtoan':
            $user = $ctrl->requireUser();
            if ($user === null) {
                $ctrl->redirect('dangnhap');
            }
            $gio = giohang::chiTiet();
            if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
                $kq = $dhModel->taoDon(
                    (int) $user['id'],
                    giohang::get(),
                    [
                        'dia_chi' => $_POST['dia_chi'] ?? $_POST['diachi'] ?? '',
                        'sdt' => $_POST['sdt'] ?? '',
                    ],
                    $_POST['ma_voucher'] ?? $_POST['voucher'] ?? null
                );
                if (!$kq['ok']) {
                    $ctrl->render('thanhtoan.php', [
                        'giohang' => $gio,
                        'loi' => $kq['loi'],
                        'thongBao' => null,
                        'act' => $act,
                        'user' => $user,
                    ]);
                    break;
                }
                $don = $dhModel->layTheoId((int) $kq['id']);
                giohang::xoaHet();
                // Don da commit: loi mail khong duoc lam gio hang con lai de dat trung.
                try {
                    $email_result = (new xuly_email())->guiDonHang((int) $user['id'], (int) $kq['id'], $don ?? [], $kq['dong']);
                } catch (Throwable $e) {
                    error_log('Email don hang: ' . $e->getMessage());
                    $email_result = ['ok' => false, 'loi' => 'Don da luu, thong bao email chua gui duoc'];
                }
                $ctrl->render('thanhtoan.php', [
                    'ok' => true,
                    'id_don' => $kq['id'],
                    'donhang' => $don,
                    'email_result' => $email_result,
                    'thongBao' => 'Dat hang thanh cong',
                    'loi' => null,
                    'act' => $act,
                    'giohang' => ['items' => [], 'tong' => 0],
                ]);
                break;
            }
            $ctrl->render('thanhtoan.php', [
                'giohang' => $gio,
                'user' => $user,
                'act' => $act,
                'thongBao' => $thongBao,
                'loi' => $loi,
            ]);
            break;

        case 'lichsumuahang':
            $user = $ctrl->requireUser();
            if ($user === null) {
                $ctrl->redirect('dangnhap');
            }
            $ds_donhang = $dhModel->layTheoKhach((int) $user['id']);
            $ctrl->render('lichsu_muahang.php', compact('ds_donhang', 'thongBao', 'loi') + ['act' => $act]);
            break;

        case 'huydonhang':
            $user = $ctrl->requireUser();
            if ($user === null) {
                $ctrl->redirect('dangnhap');
            }
            $rawId = $_GET['id'] ?? $_POST['id'] ?? ($_POST['order_id'] ?? 0);
            $idDon = is_numeric($rawId) ? (int)$rawId : (int)preg_replace('/\D/', '', (string)$rawId);
            $lyDo = (string) ($_POST['ly_do'] ?? $_POST['lydo'] ?? 'Khach huy don');
            $kq = $dhModel->huyDon($idDon, (int) $user['id'], $lyDo);
            $loi = $kq['ok'] ? null : $kq['loi'];
            $thongBao = $kq['ok'] ? 'Da huy don hang' : null;
            $ds_donhang = $dhModel->layTheoKhach((int) $user['id']);
            $ctrl->render('lichsu_muahang.php', compact('ds_donhang', 'thongBao', 'loi') + ['act' => 'lichsumuahang']);
            break;

        case 'khieunai':
            $user = $ctrl->requireUser();
            if ($user === null) {
                $ctrl->redirect('dangnhap');
            }
            $rawId = $_POST['id'] ?? $_GET['id'] ?? ($_POST['order_id'] ?? 0);
            $idDon = is_numeric($rawId) ? (int)$rawId : (int)preg_replace('/\D/', '', (string)$rawId);
            $noiDung = (string) ($_POST['noi_dung'] ?? $_POST['noidung'] ?? '');
            $kq = $dhModel->ghiKhieuNai($idDon, (int) $user['id'], $noiDung);
            $loi = $kq['ok'] ? null : $kq['loi'];
            $thongBao = $kq['ok'] ? 'Da gui khieu nai' : null;
            $ds_donhang = $dhModel->layTheoKhach((int) $user['id']);
            $ctrl->render('lichsu_muahang.php', compact('ds_donhang', 'thongBao', 'loi') + ['act' => 'lichsumuahang']);
            break;

        case 'theodoidonhang':
            $user = $ctrl->requireUser();
            if ($user === null) {
                $ctrl->redirect('dangnhap');
            }
            $idDon = (int) ($_GET['id'] ?? 0);
            $donhang = $dhModel->layTrangThai($idDon);
            if ($donhang === null || (int) $donhang['id_khachhang'] !== (int) $user['id']) {
                $loi = 'Khong tim thay don hang';
                $donhang = null;
            }
            $ctrl->render('theodoi_donhang.php', compact('donhang', 'thongBao', 'loi') + ['act' => $act]);
            break;

        case 'hopthu':
            $user = $ctrl->requireUser();
            if ($user === null) {
                $ctrl->redirect('dangnhap');
            }
            $ds_thu = $emModel->layThuCuaKhach((int) $user['id']);
            $ctrl->render('hopthu.php', compact('ds_thu', 'thongBao', 'loi') + ['act' => $act]);
            break;

        case 'admin':
            $ctrl->redirect('sanpham', [], 'admin');
            break;

        default:
            $ctrl->json(['ok' => false, 'loi' => 'Khong ro act', 'act' => $act], 400);
    }
} catch (InvalidArgumentException | TypeError $e) {
    $ctrl->json(['ok' => false, 'loi' => 'Du lieu gui len khong hop le'], 400);
} catch (Throwable $e) {
    error_log('Controller User: ' . $e->getMessage());
    $ctrl->json(['ok' => false, 'loi' => 'Khong the xu ly yeu cau. Vui long kiem tra ket noi CSDL.'], 500);
}
