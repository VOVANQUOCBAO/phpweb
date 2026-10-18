<?php

require_once __DIR__ . '/xl_database.php';

class email extends xl_database
{
    public function cauHinhSmtp(): array
    {
        return [
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'user' => getenv('SMTP_USER') ?: '',
            'pass' => getenv('SMTP_PASS') ?: '',
            'from' => getenv('SMTP_FROM') ?: (getenv('SMTP_USER') ?: 'noreply@localhost'),
            'from_name' => 'Web ban hang MVC',
        ];
    }

    public function luuThu(int $idKhachHang, string $tieuDe, string $noiDung, string $loai = 'hethong'): int
    {
        return $this->insert('email', [
            'id_khachhang' => $idKhachHang,
            'tieu_de' => $tieuDe,
            'noi_dung' => $noiDung,
            'loai' => $loai,
        ]);
    }

    public function layThuCuaKhach(int $idKhachHang): array
    {
        return $this->select(
            'SELECT * FROM email WHERE id_khachhang = ? ORDER BY ngay_gui DESC',
            [$idKhachHang]
        );
    }
}
