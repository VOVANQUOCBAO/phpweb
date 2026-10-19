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
            'ds_sanpham' => $sp->layDSAdmin(),
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
        try {
            if ($hanhDong === 'them') {
                $id = $dm->them(
                    (string) ($data['ten_danhmuc'] ?? ''),
                    isset($data['mo_ta']) ? (string) $data['mo_ta'] : null
                );
                return ['ok' => true, 'id' => $id];
            }
            if ($hanhDong === 'sua') {
                $dm->sua(
                    (int) ($data['id'] ?? 0),
                    (string) ($data['ten_danhmuc'] ?? ''),
                    isset($data['mo_ta']) ? (string) $data['mo_ta'] : null
                );
                return ['ok' => true];
            }
            if ($hanhDong === 'xoa') {
                return $dm->xoa((int) ($data['id'] ?? 0));
            }
        } catch (InvalidArgumentException $e) {
            return ['ok' => false, 'loi' => $e->getMessage()];
        } catch (Throwable $e) {
            error_log('Xu ly danh muc: ' . $e->getMessage());
            return ['ok' => false, 'loi' => 'Không thể lưu danh mục lúc này'];
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

    public function trangGiaoDien(): array
    {
        $file = dirname(__DIR__, 2) . '/support/config/theme.json';
        $cfg = ['season' => 'default', 'font' => 'font-segoe', 'bg' => 'bg-light-gray'];
        if (is_file($file)) {
            $saved = json_decode((string)file_get_contents($file), true);
            if (is_array($saved)) {
                $cfg = array_merge($cfg, $saved);
            }
        }
        return ['theme' => $cfg];
    }

    public function luuGiaoDien(array $data): array
    {
        $validSeasons = ['default', 'theme-spring', 'theme-summer', 'theme-autumn', 'theme-winter'];
        $validFonts = ['font-segoe', 'font-bevietnam', 'font-roboto', 'font-montserrat'];
        $validBgs = ['bg-light-gray', 'bg-white-pure', 'bg-soft-blue'];

        $season = in_array($data['season'] ?? '', $validSeasons, true) ? $data['season'] : 'default';
        $font = in_array($data['font'] ?? '', $validFonts, true) ? $data['font'] : 'font-segoe';
        $bg = in_array($data['bg'] ?? '', $validBgs, true) ? $data['bg'] : 'bg-light-gray';

        $cfg = [
            'season' => $season,
            'font' => $font,
            'bg' => $bg,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $dir = dirname(__DIR__, 2) . '/support/config';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        file_put_contents($dir . '/theme.json', json_encode($cfg, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return ['ok' => true, 'theme' => $cfg];
    }
}
