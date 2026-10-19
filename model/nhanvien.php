<?php

require_once __DIR__ . '/xl_database.php';

class nhanvien extends xl_database
{
    public function layDS(): array
    {
        return $this->select('SELECT id, ho_ten, email, vai_tro, trang_thai FROM nhanvien ORDER BY id');
    }

    public function layTheoId(int $id): ?array
    {
        return $this->selectOne(
            'SELECT id, ho_ten, email, vai_tro, trang_thai FROM nhanvien WHERE id = ?',
            [$id]
        );
    }

    public function them(array $data): array
    {
        $email = trim((string) ($data['email'] ?? ''));
        $hoTen = trim((string) ($data['ho_ten'] ?? ''));
        $matKhau = (string) ($data['mat_khau'] ?? '');
        if ($email === '' || $hoTen === '' || $matKhau === '') {
            return ['ok' => false, 'loi' => 'Thieu thong tin nhan vien'];
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['ok' => false, 'loi' => 'Email nhan vien khong hop le'];
        }
        $tonTai = $this->selectOne('SELECT id FROM nhanvien WHERE email = ?', [$email]);
        if ($tonTai !== null) {
            return ['ok' => false, 'loi' => 'Email nhan vien da ton tai'];
        }
        $id = $this->insert('nhanvien', [
            'ho_ten' => $hoTen,
            'email' => $email,
            'mat_khau' => password_hash($matKhau, PASSWORD_DEFAULT),
            'vai_tro' => $data['vai_tro'] ?? 'NhanVien',
            'trang_thai' => 1,
        ]);
        return ['ok' => true, 'id' => $id];
    }

    public function kiemTraDangNhap(string $email, string $matKhau): array
    {
        $clean = trim($email);
        $nv = null;
        if (strtolower($clean) === 'admin') {
            $nv = $this->selectOne("SELECT * FROM nhanvien WHERE email = 'admin@local.test' OR ho_ten = 'admin' OR vai_tro = 'Admin' ORDER BY id ASC LIMIT 1");
        }
        if ($nv === null) {
            $nv = $this->selectOne('SELECT * FROM nhanvien WHERE email = ?', [$clean]);
        }
        if ($nv === null) {
            $nv = $this->selectOne('SELECT * FROM nhanvien WHERE ho_ten = ?', [$clean]);
        }
        if ($nv === null) {
            return ['ok' => false, 'loi' => 'Email hoac mat khau khong dung'];
        }
        $matKhauDb = (string)($nv['mat_khau'] ?? '');
        $hopLe = false;
        if ($matKhau === $matKhauDb) {
            $hopLe = true; // Cho phép khớp plain text khi đổi trực tiếp trong phpMyAdmin
        } elseif (password_verify($matKhau, $matKhauDb)) {
            $hopLe = true; // Khớp chuẩn bcrypt
        } elseif (md5($matKhau) === $matKhauDb) {
            $hopLe = true; // Khớp chuẩn MD5 phpMyAdmin
        }
        if (!$hopLe) {
            return ['ok' => false, 'loi' => 'Email hoac mat khau khong dung'];
        }
        if ((int) $nv['trang_thai'] !== 1) {
            return ['ok' => false, 'loi' => 'Tai khoan nhan vien dang bi khoa'];
        }
        unset($nv['mat_khau']);
        return ['ok' => true, 'nhanvien' => $nv];
    }

    public function doiMatKhau(int $id, string $matKhauMoi): array
    {
        $matKhauMoi = trim($matKhauMoi);
        if ($matKhauMoi === '') {
            return ['ok' => false, 'loi' => 'Mật khẩu mới không được để trống'];
        }
        $hash = password_hash($matKhauMoi, PASSWORD_DEFAULT);
        $this->update('nhanvien', ['mat_khau' => $hash], 'id = ?', [$id]);
        return ['ok' => true];
    }

    public function doiTrangThai(int $id, int $trangThai): array
    {
        $this->update('nhanvien', ['trang_thai' => $trangThai ? 1 : 0], 'id = ?', [$id]);
        return ['ok' => true];
    }
}
