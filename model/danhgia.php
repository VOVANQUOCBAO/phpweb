<?php

require_once __DIR__ . '/xl_database.php';

class danhgia extends xl_database
{
    public function layDSTheoSP(int $idSanPham): array
    {
        return $this->select(
            'SELECT dg.*, kh.ho_ten
             FROM danhgia dg
             JOIN khachhang kh ON kh.id = dg.id_khachhang
             WHERE dg.id_sanpham = ? AND dg.trang_thai = 1
             ORDER BY dg.ngay_tao DESC',
            [$idSanPham]
        );
    }

    public function layAllAdmin(): array
    {
        return $this->select(
            'SELECT dg.*, kh.ho_ten, kh.email, sp.ten_sp
             FROM danhgia dg
             JOIN khachhang kh ON kh.id = dg.id_khachhang
             JOIN sanpham sp ON sp.id = dg.id_sanpham
             ORDER BY dg.ngay_tao DESC'
        );
    }

    public function them(int $idSanPham, int $idKhachHang, int $soSao, string $noiDung): array
    {
        if ($soSao < 1 || $soSao > 5) {
            return ['ok' => false, 'loi' => 'So sao phai tu 1 den 5'];
        }
        $noiDung = trim($noiDung);
        if ($noiDung === '') {
            return ['ok' => false, 'loi' => 'Noi dung danh gia khong duoc rong'];
        }
        if ($this->selectOne('SELECT id FROM sanpham WHERE id = ?', [$idSanPham]) === null
            || $this->selectOne('SELECT id FROM khachhang WHERE id = ? AND trang_thai = 1', [$idKhachHang]) === null) {
            return ['ok' => false, 'loi' => 'San pham hoac khach hang khong hop le'];
        }
        $id = $this->insert('danhgia', [
            'id_sanpham' => $idSanPham,
            'id_khachhang' => $idKhachHang,
            'so_sao' => $soSao,
            'noi_dung' => $noiDung,
            'trang_thai' => 1,
        ]);
        return ['ok' => true, 'id' => $id];
    }

    public function khoa(int $id): array
    {
        $this->update('danhgia', ['trang_thai' => 0], 'id = ?', [$id]);
        return ['ok' => true];
    }
}
