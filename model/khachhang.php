<?php

require_once __DIR__ . '/xl_database.php';

class khachhang extends xl_database
{
    public const HANG_SILVER = 'Silver';
    public const HANG_GOLD = 'Gold';
    public const HANG_DIAMOND = 'Diamond';
    public const NGUONG_GOLD = 500;
    public const NGUONG_DIAMOND = 2000;

    public function layDS(): array
    {
        return $this->select(
            'SELECT kh.*,
                    COALESCE(dh.c_don, 0) AS tong_don,
                    COALESCE(dh.tong_tien, 0) AS tong_tien
             FROM khachhang kh
             LEFT JOIN (
                SELECT id_khachhang, COUNT(*) AS c_don, SUM(tong_tien) AS tong_tien
                FROM donhang
                GROUP BY id_khachhang
             ) dh ON dh.id_khachhang = kh.id
             ORDER BY kh.id DESC'
        );
    }

    public function layTheoId(int $id): ?array
    {
        return $this->selectOne('SELECT * FROM khachhang WHERE id = ?', [$id]);
    }

    public function layTheoEmail(string $email): ?array
    {
        return $this->selectOne('SELECT * FROM khachhang WHERE email = ?', [trim($email)]);
    }

    public function themKhachHang(array $data): array
    {
        $email = trim((string) ($data['email'] ?? ''));
        $hoTen = trim((string) ($data['ho_ten'] ?? ''));
        $matKhau = (string) ($data['mat_khau'] ?? '');
        if ($email === '' || $hoTen === '' || $matKhau === '') {
            return ['ok' => false, 'loi' => 'Thieu ho ten, email hoac mat khau'];
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['ok' => false, 'loi' => 'Email khong hop le'];
        }
        $ngaySinh = $data['ngay_sinh'] ?? null;
        if ($ngaySinh === '') {
            $ngaySinh = null;
        }
        if ($ngaySinh !== null && (!$this->ngayHopLe($ngaySinh) || $ngaySinh > date('Y-m-d'))) {
            return ['ok' => false, 'loi' => 'Ngay sinh khong hop le'];
        }
        if ($this->layTheoEmail($email) !== null) {
            return ['ok' => false, 'loi' => 'Email da duoc dang ky'];
        }
        $id = $this->insert('khachhang', [
            'ho_ten' => $hoTen,
            'email' => $email,
            'mat_khau' => password_hash($matKhau, PASSWORD_DEFAULT),
            'ngay_sinh' => $ngaySinh,
            'hang' => self::HANG_SILVER,
            'diem' => 0,
            'trang_thai' => 1,
        ]);
        return ['ok' => true, 'id' => $id];
    }

    public function kiemTraDangNhap(string $email, string $matKhau): array
    {
        $kh = $this->layTheoEmail($email);
        if ($kh === null || !password_verify($matKhau, $kh['mat_khau'])) {
            return ['ok' => false, 'loi' => 'Email hoac mat khau khong dung'];
        }
        if ((int) $kh['trang_thai'] !== 1) {
            return ['ok' => false, 'loi' => 'Tai khoan da bi khoa'];
        }
        unset($kh['mat_khau']);
        return ['ok' => true, 'khachhang' => $kh];
    }

    public function khoa(int $id): array
    {
        $this->update('khachhang', ['trang_thai' => 0], 'id = ?', [$id]);
        return ['ok' => true];
    }

    public function moKhoa(int $id): array
    {
        $this->update('khachhang', ['trang_thai' => 1], 'id = ?', [$id]);
        return ['ok' => true];
    }

    public function congDiemVaXetHang(int $id, float $tongTien): array
    {
        if (!$this->soTienHopLe($tongTien)) {
            return ['ok' => false, 'loi' => 'Tong tien tinh diem khong hop le'];
        }
        // Mot lenh UPDATE nguyen tu, khong lam mat diem khi hai don hoan tat cung luc.
        $cong = (int) floor($tongTien / 1000);
        $this->execute('UPDATE khachhang SET hang = CASE WHEN diem + ? >= ? THEN ?
            WHEN diem + ? >= ? THEN ? ELSE ? END, diem = diem + ? WHERE id = ?',
            [$cong, self::NGUONG_DIAMOND, self::HANG_DIAMOND, $cong, self::NGUONG_GOLD,
                self::HANG_GOLD, self::HANG_SILVER, $cong, $id]);
        $kh = $this->layTheoId($id);
        return $kh === null ? ['ok' => false, 'loi' => 'Khong tim thay khach hang']
            : ['ok' => true, 'diem' => (int) $kh['diem'], 'hang' => $kh['hang']];
    }

    public function tangViPham(int $id, string $loai): void
    {
        $map = [
            'huy' => 'so_lan_huy',
            'bom' => 'so_lan_bom',
            'tra' => 'so_lan_tra',
        ];
        if (!isset($map[$loai])) {
            throw new InvalidArgumentException('Loai vi pham khong hop le');
        }
        $cot = $map[$loai];
        $this->execute("UPDATE khachhang SET `{$cot}` = `{$cot}` + 1 WHERE id = ?", [$id]);
    }

    public function dsBomHuyTra(): array
    {
        return $this->select(
            'SELECT * FROM khachhang
             WHERE so_lan_huy > 0 OR so_lan_bom > 0 OR so_lan_tra > 0
             ORDER BY so_lan_bom DESC, so_lan_tra DESC, so_lan_huy DESC'
        );
    }

    public function locTheoNgaySinh(?int $ngay = null, ?int $thang = null, ?int $nam = null): array
    {
        $sql = 'SELECT * FROM khachhang WHERE ngay_sinh IS NOT NULL';
        $params = [];
        if ($ngay !== null) {
            $sql .= ' AND DAY(ngay_sinh) = ?';
            $params[] = $ngay;
        }
        if ($thang !== null) {
            $sql .= ' AND MONTH(ngay_sinh) = ?';
            $params[] = $thang;
        }
        if ($nam !== null) {
            $sql .= ' AND YEAR(ngay_sinh) = ?';
            $params[] = $nam;
        }
        return $this->select($sql, $params);
    }

    public function quyenLoiHang(string $hang): array
    {
        return match ($hang) {
            self::HANG_DIAMOND => ['mien_ship' => true, 'mo_ta' => 'Kim cuong: mien ship, nhieu voucher'],
            self::HANG_GOLD => ['mien_ship' => true, 'mo_ta' => 'Vang: mien ship, uu dai voucher'],
            default => ['mien_ship' => false, 'mo_ta' => 'Bac: hang mac dinh'],
        };
    }
}
