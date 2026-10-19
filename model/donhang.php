<?php

require_once __DIR__ . '/xl_database.php';
require_once __DIR__ . '/sanpham.php';
require_once __DIR__ . '/chitietdonhang.php';
require_once __DIR__ . '/voucher.php';
require_once __DIR__ . '/khachhang.php';
require_once __DIR__ . '/khuyenmai.php';

class donhang extends xl_database
{
    public const CHO_XAC_NHAN = 'Chờ xác nhận';
    public const XAC_NHAN = 'Xác nhận đơn hàng';
    public const DANG_GIAO = 'Đang giao';
    public const DA_GIAO = 'Đã giao';
    public const THANH_CONG = 'Thành công';
    public const DA_HUY = 'Đã hủy';
    public const BOM_HANG = 'Bom hàng';
    public const TRA_HANG = 'Trả hàng';
    public const PHI_SHIP_MAC_DINH = 30000.0;

    private const LUONG = [
        self::CHO_XAC_NHAN => [self::XAC_NHAN, self::DA_HUY],
        self::XAC_NHAN => [self::DANG_GIAO],
        self::DANG_GIAO => [self::DA_GIAO, self::BOM_HANG, self::TRA_HANG],
        self::DA_GIAO => [self::THANH_CONG],
        self::THANH_CONG => [], self::DA_HUY => [], self::BOM_HANG => [], self::TRA_HANG => [],
    ];

    public function layTheoKhach(int $idKh): array
    {
        return $this->select('SELECT * FROM donhang WHERE id_khachhang = ? ORDER BY ngay_dat DESC, id DESC', [$idKh]);
    }

    public function layDS(): array
    {
        return $this->select('SELECT dh.*, kh.ho_ten, kh.email FROM donhang dh
            JOIN khachhang kh ON kh.id = dh.id_khachhang ORDER BY dh.ngay_dat DESC, dh.id DESC');
    }

    public function layTheoId(int $id): ?array
    {
        return $this->selectOne('SELECT * FROM donhang WHERE id = ?', [$id]);
    }

    public function layTrangThai(int $id): ?array
    {
        $dh = $this->layTheoId($id);
        if ($dh !== null) {
            $dh['chitiet'] = (new chitietdonhang())->layTheoDon($id);
            $dh['timeline'] = [self::CHO_XAC_NHAN, self::XAC_NHAN, self::DANG_GIAO, self::DA_GIAO, self::THANH_CONG];
        }
        return $dh;
    }

    public function taoDon(int $idKh, array $gioHang, array $info, ?string $maVoucher = null): array
    {
        $diaChi = trim((string) ($info['dia_chi'] ?? ''));
        $sdt = trim((string) ($info['sdt'] ?? ''));
        if ($diaChi === '' || strlen($diaChi) > 1000 || !preg_match('/^\\+?[0-9][0-9 .()-]{7,18}$/', $sdt)) {
            return ['ok' => false, 'loi' => 'Dia chi hoac so dien thoai khong hop le'];
        }
        if ($gioHang === []) {
            return ['ok' => false, 'loi' => 'Gio hang trong'];
        }
        $gio = [];
        foreach ($gioHang as $idSp => $sl) {
            if (!$this->soNguyenHopLe($idSp, 1) || !$this->soNguyenHopLe($sl, 1)) {
                return ['ok' => false, 'loi' => 'Ma san pham va so luong mua phai la so nguyen duong'];
            }
            $gio[(int) $idSp] = (int) $sl;
        }
        ksort($gio, SORT_NUMERIC); // Khoa san pham theo cung thu tu giua cac giao dich.
        $maVc = strtoupper(trim($maVoucher ?? ''));

        try {
            $this->begin();
            $kh = $this->selectOne('SELECT * FROM khachhang WHERE id = ? FOR UPDATE', [$idKh]);
            if ($kh === null || (int) $kh['trang_thai'] !== 1) {
                throw new DomainException('Khach hang khong ton tai hoac da bi khoa');
            }
            $spModel = new sanpham();
            $kmModel = new khuyenmai();
            $dong = [];
            $tamTinh = 0.0;
            foreach ($gio as $idSp => $sl) {
                $sp = $this->selectOne('SELECT * FROM sanpham WHERE id = ? FOR UPDATE', [$idSp]);
                if ($sp === null || (int) $sp['so_luong_ton'] < $sl) {
                    throw new DomainException('San pham khong ton tai hoac khong du ton kho');
                }
                $gia = $kmModel->giaSauKM($sp)['gia_km'];
                $dong[] = ['id_sanpham' => $idSp, 'so_luong' => $sl, 'don_gia' => $gia];
                $tamTinh = round($tamTinh + $gia * $sl, 2);
            }

            $phiShip = (new khachhang())->quyenLoiHang($kh['hang'])['mien_ship'] ? 0.0 : self::PHI_SHIP_MAC_DINH;
            $giam = 0.0;
            $vcModel = new voucher();
            if ($maVc !== '') {
                $vc = $vcModel->kiemTra($maVc, $kh['hang'], $tamTinh, $phiShip, true);
                if (!$vc['ok']) {
                    throw new DomainException($vc['loi']);
                }
                $giam = $vc['giam'];
                $phiShip = $vc['phi_ship'];
            }
            $tong = round(max(0, $tamTinh - $giam) + $phiShip, 2);
            if (!$this->soTienHopLe($tong)) {
                throw new DomainException('Tong tien vuot gioi han luu tru');
            }
            $idDon = $this->insert('donhang', [
                'id_khachhang' => $idKh, 'tong_tien' => $tong, 'phi_ship' => $phiShip,
                'ma_voucher' => $maVc !== '' ? $maVc : null, 'dia_chi' => $diaChi,
                'sdt' => $sdt, 'trang_thai' => self::CHO_XAC_NHAN,
            ]);
            (new chitietdonhang())->themNhieu($idDon, $dong);
            foreach ($dong as $item) {
                $tru = $spModel->truTon($item['id_sanpham'], $item['so_luong']);
                if (!$tru['ok']) {
                    throw new DomainException($tru['loi']);
                }
            }
            if ($maVc !== '') {
                $truVc = $vcModel->truSoLuong($maVc);
                if (!$truVc['ok']) {
                    throw new DomainException($truVc['loi']);
                }
            }
            $this->commit();
            return ['ok' => true, 'id' => $idDon, 'tong_tien' => $tong,
                'tam_tinh' => $tamTinh, 'tien_giam' => $giam, 'phi_ship' => $phiShip, 'dong' => $dong];
        } catch (Throwable $e) {
            $this->rollback();
            return $this->loiGiaoDich($e);
        }
    }

    public function huyDon(int $id, int $idKh, string $lyDo = ''): array
    {
        return $this->chuyenTrangThai($id, self::DA_HUY, $lyDo !== '' ? $lyDo : 'Khach huy don', $idKh);
    }

    public function capNhatTrangThai(int $id, string $trangThaiMoi, string $lyDo = ''): array
    {
        return $this->chuyenTrangThai($id, $trangThaiMoi, $lyDo);
    }

    private function chuyenTrangThai(int $id, string $moi, string $lyDo, ?int $idKh = null): array
    {
        try {
            $this->begin();
            // Doc va kiem tra trang thai SAU khi khoa, de chi xu ly moi buoc mot lan.
            $dh = $this->selectOne('SELECT * FROM donhang WHERE id = ? FOR UPDATE', [$id]);
            if ($dh === null || ($idKh !== null && (int) $dh['id_khachhang'] !== $idKh)) {
                throw new DomainException('Khong tim thay don hang');
            }
            if (!in_array($moi, self::LUONG[$dh['trang_thai']] ?? [], true)) {
                throw new DomainException('Khong duoc nhay coc, lui hoac lap lai trang thai');
            }
            $this->selectOne('SELECT id FROM khachhang WHERE id = ? FOR UPDATE', [$dh['id_khachhang']]);
            $fields = ['trang_thai' => $moi];
            $viPham = [self::DA_HUY => 'huy', self::BOM_HANG => 'bom', self::TRA_HANG => 'tra'];
            if (isset($viPham[$moi])) {
                $ct = (new chitietdonhang())->layTheoDon($id);
                usort($ct, static fn($a, $b) => (int) $a['id_sanpham'] <=> (int) $b['id_sanpham']);
                foreach ($ct as $item) {
                    $hoan = (new sanpham())->congTon((int) $item['id_sanpham'], (int) $item['so_luong']);
                    if (!$hoan['ok']) {
                        throw new DomainException($hoan['loi']);
                    }
                }
                $fields['ly_do_huy'] = (trim($lyDo) !== '' ? trim($lyDo) : $moi) . ' | ' . date('Y-m-d H:i:s');
                (new khachhang())->tangViPham((int) $dh['id_khachhang'], $viPham[$moi]);
            }
            $this->update('donhang', $fields, 'id = ?', [$id]);
            if ($moi === self::THANH_CONG) {
                $diem = (new khachhang())->congDiemVaXetHang((int) $dh['id_khachhang'], (float) $dh['tong_tien']);
                if (!$diem['ok']) {
                    throw new DomainException($diem['loi']);
                }
            }
            $this->commit();
            return ['ok' => true];
        } catch (Throwable $e) {
            $this->rollback();
            return $this->loiGiaoDich($e);
        }
    }

    private function loiGiaoDich(Throwable $e): array
    {
        if ($e instanceof DomainException) {
            return ['ok' => false, 'loi' => $e->getMessage()];
        }
        error_log('Giao dich don hang: ' . $e->getMessage());
        return ['ok' => false, 'loi' => 'Khong the xu ly don hang luc nay, vui long thu lai'];
    }

    public function thongKeDoanhThu(string $ky = 'thang'): array
    {
        $nhan = match ($ky) {
            'tuan' => "DATE_FORMAT(ngay_dat, '%x-W%v')",
            'nam' => "DATE_FORMAT(ngay_dat, '%Y')",
            default => "DATE_FORMAT(ngay_dat, '%Y-%m')",
        };
        $doanhThu = $this->select("SELECT {$nhan} AS nhan, SUM(tong_tien) AS doanh_thu, COUNT(*) AS so_don
            FROM donhang WHERE trang_thai = ? GROUP BY {$nhan} ORDER BY nhan", [self::THANH_CONG]);
        $banChay = $this->select('SELECT sp.id, sp.ma_sp, sp.ten_sp, SUM(ct.so_luong) AS da_ban
            FROM chitietdonhang ct JOIN donhang dh ON dh.id = ct.id_donhang JOIN sanpham sp ON sp.id = ct.id_sanpham
            WHERE dh.trang_thai = ? GROUP BY sp.id, sp.ma_sp, sp.ten_sp ORDER BY da_ban DESC, sp.id LIMIT 10', [self::THANH_CONG]);
        return ['doanh_thu' => $doanhThu, 'ban_chay' => $banChay, 'ban_e' => (new sanpham())->hangE()];
    }

    public function ghiKhieuNai(int $id, int $idKh, string $noiDung): array
    {
        $dh = $this->layTheoId($id);
        if ($dh === null || (int) $dh['id_khachhang'] !== $idKh) {
            return ['ok' => false, 'loi' => 'Khong tim thay don hang'];
        }
        $noiDung = trim($noiDung);
        if ($noiDung === '' || mb_strlen($noiDung) > 5000) {
            return ['ok' => false, 'loi' => 'Nội dung khiếu nại phải từ 1 đến 5000 ký tự'];
        }
        require_once __DIR__ . '/email.php';
        (new email())->luuThu($idKh, 'Khiếu nại đơn #' . $id, $noiDung, 'khieunai');
        return ['ok' => true];
    }
}
