<?php

require_once dirname(__DIR__, 2) . '/model/danhmuc.php';
require_once dirname(__DIR__, 2) . '/model/sanpham.php';
require_once dirname(__DIR__, 2) . '/model/nhanvien.php';
require_once dirname(__DIR__, 2) . '/model/danhgia.php';
require_once dirname(__DIR__, 2) . '/model/khachhang.php';
require_once dirname(__DIR__, 2) . '/model/voucher.php';
require_once dirname(__DIR__, 2) . '/model/khuyenmai.php';
require_once dirname(__DIR__, 2) . '/model/donhang.php';
require_once dirname(__DIR__, 2) . '/model/chitietdonhang.php';
require_once dirname(__DIR__, 2) . '/controller/xuly_email.php';

class admin_controller
{
    public function dangNhap(string $email, string $matKhau): array
    {
        return (new nhanvien())->kiemTraDangNhap($email, $matKhau);
    }

    public function trangSanPham(): array
    {
        $sp = new sanpham();
        return [
            'ds_sanpham' => $sp->layDS(),
            'ds_danhmuc' => (new danhmuc())->layDS(),
            'sap_het' => $sp->canhBaoSapHet(5),
            'hang_e' => $sp->hangE(),
            'can_han' => $sp->canHan(),
        ];
    }

    public function themSanPham(array $data): array
    {
        return (new sanpham())->them($data);
    }

    public function suaSanPham(int $id, array $data): array
    {
        return (new sanpham())->sua($id, $data);
    }

    public function xoaSanPham(int $id): array
    {
        return (new sanpham())->xoa($id);
    }

    public function xuLyDanhMuc(string $hanhDong, array $data): array
    {
        $dm = new danhmuc();
        if ($hanhDong === 'them') {
            $id = $dm->them((string) ($data['ten_danhmuc'] ?? ''), $data['mo_ta'] ?? null);
            return ['ok' => true, 'id' => $id];
        }
        if ($hanhDong === 'sua') {
            $dm->sua((int) $data['id'], (string) $data['ten_danhmuc'], $data['mo_ta'] ?? null);
            return ['ok' => true];
        }
        if ($hanhDong === 'xoa') {
            return $dm->xoa((int) $data['id']);
        }
        return ['ok' => false, 'loi' => 'Hanh dong danh muc khong hop le'];
    }

    public function trangNhanVien(): array
    {
        return ['ds_nhanvien' => (new nhanvien())->layDS()];
    }

    public function themNhanVien(array $data): array
    {
        return (new nhanvien())->them($data);
    }

    public function khoaNhanVien(int $id, int $trangThai): array
    {
        return (new nhanvien())->doiTrangThai($id, $trangThai);
    }

    public function trangDanhGia(): array
    {
        return ['ds_danhgia' => (new danhgia())->layAllAdmin()];
    }

    public function khoaDanhGia(int $id): array
    {
        return (new danhgia())->khoa($id);
    }

    public function trangKhachHang(): array
    {
        $kh = new khachhang();
        return [
            'ds_khachhang' => $kh->layDS(),
            'ds_bom_huy_tra' => $kh->dsBomHuyTra(),
        ];
    }

    public function khoaKhachHang(int $id, int $trangThai): array
    {
        return $trangThai ? (new khachhang())->moKhoa($id) : (new khachhang())->khoa($id);
    }

    public function guiQuaTang(array $data): array
    {
        $ngay = isset($data['ngay']) && $data['ngay'] !== '' ? (int) $data['ngay'] : null;
        $thang = isset($data['thang']) && $data['thang'] !== '' ? (int) $data['thang'] : null;
        $nam = isset($data['nam']) && $data['nam'] !== '' ? (int) $data['nam'] : null;
        $ds = (new khachhang())->locTheoNgaySinh($ngay, $thang, $nam);
        $mail = new xuly_email();
        $gui = [];
        foreach ($ds as $kh) {
            $gui[] = $mail->guiChung(
                (int) $kh['id'],
                (string) ($data['tieu_de'] ?? 'Tang qua / voucher'),
                (string) ($data['noi_dung'] ?? 'Chuc mung ban nhan duoc qua tang'),
                'quatang'
            );
        }
        return ['ok' => true, 'so_khach' => count($ds), 'gui' => $gui];
    }

    public function trangVoucher(): array
    {
        return ['ds_voucher' => (new voucher())->layDS()];
    }

    public function themVoucher(array $data): array
    {
        return (new voucher())->them($data);
    }

    public function xoaVoucher(int $id): array
    {
        return (new voucher())->xoa($id);
    }

    public function trangKhuyenMai(): array
    {
        $sp = new sanpham();
        return [
            'ds_khuyenmai' => (new khuyenmai())->layDS(),
            'goi_y_e' => $sp->hangE(),
            'goi_y_can_han' => $sp->canHan(),
            'ds_danhmuc' => (new danhmuc())->layDS(),
            'ds_sanpham' => $sp->layDS(),
        ];
    }

    public function themKhuyenMai(array $data): array
    {
        return (new khuyenmai())->them($data);
    }

    public function trangDonHang(): array
    {
        return ['ds_donhang' => (new donhang())->layDS()];
    }

    public function chiTietDonHang(int $id): array
    {
        $dh = (new donhang())->layTrangThai($id);
        if ($dh === null) {
            return ['ok' => false, 'loi' => 'Khong tim thay don hang'];
        }
        return ['ok' => true, 'donhang' => $dh];
    }

    public function capNhatTrangThai(int $id, string $trangThai, string $lyDo = ''): array
    {
        return (new donhang())->capNhatTrangThai($id, $trangThai, $lyDo);
    }

    public function doanhThu(string $ky = 'thang'): array
    {
        return (new donhang())->thongKeDoanhThu($ky);
    }
}
