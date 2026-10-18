<?php

require_once __DIR__ . '/xl_database.php';

class khuyenmai extends xl_database
{
    public function layDS(): array
    {
        return $this->select('SELECT * FROM khuyenmai ORDER BY id DESC');
    }

    public function dsDangChay(): array
    {
        return $this->select(
            'SELECT * FROM khuyenmai WHERE CURDATE() BETWEEN ngay_bd AND ngay_kt ORDER BY phan_tram DESC'
        );
    }

    public function them(array $data): array
    {
        $loai = $data['loai'] ?? 'sanpham';
        if (!in_array($loai, ['sanpham', 'danhmuc'], true)) {
            return ['ok' => false, 'loi' => 'Loai khuyen mai khong hop le'];
        }
        if (trim((string) ($data['ten_km'] ?? '')) === ''
            || !$this->soTienHopLe($data['phan_tram'] ?? null) || (float) $data['phan_tram'] > 100) {
            return ['ok' => false, 'loi' => 'Ten hoac phan tram khuyen mai khong hop le'];
        }
        if (!$this->ngayHopLe($data['ngay_bd'] ?? null) || !$this->ngayHopLe($data['ngay_kt'] ?? null)
            || $data['ngay_bd'] > $data['ngay_kt']) {
            return ['ok' => false, 'loi' => 'Thoi han khuyen mai khong hop le'];
        }
        $bang = $loai === 'sanpham' ? 'sanpham' : 'danhmuc';
        $id = $data[$loai === 'sanpham' ? 'id_sanpham' : 'id_danhmuc'] ?? null;
        if (!$this->soNguyenHopLe($id, 1) || $this->selectOne("SELECT id FROM {$bang} WHERE id = ?", [$id]) === null) {
            return ['ok' => false, 'loi' => 'Doi tuong ap dung khuyen mai khong ton tai'];
        }
        $id = $this->insert('khuyenmai', [
            'ten_km' => trim((string) ($data['ten_km'] ?? '')),
            'loai' => $loai,
            'id_sanpham' => $loai === 'sanpham' ? (int) ($data['id_sanpham'] ?? 0) : null,
            'id_danhmuc' => $loai === 'danhmuc' ? (int) ($data['id_danhmuc'] ?? 0) : null,
            'phan_tram' => (float) ($data['phan_tram'] ?? 0),
            'ngay_bd' => $data['ngay_bd'],
            'ngay_kt' => $data['ngay_kt'],
            'ghi_chu' => $data['ghi_chu'] ?? null,
        ]);
        return ['ok' => true, 'id' => $id];
    }

    public function giaSauKM(array $sp): array
    {
        $giaGoc = (float) $sp['gia'];
        $km = $this->selectOne(
            'SELECT * FROM khuyenmai
             WHERE CURDATE() BETWEEN ngay_bd AND ngay_kt
               AND (
                    (loai = \'sanpham\' AND id_sanpham = ?)
                 OR (loai = \'danhmuc\' AND id_danhmuc = ?)
               )
             ORDER BY phan_tram DESC
             LIMIT 1',
            [(int) $sp['id'], (int) $sp['id_danhmuc']]
        );
        if ($km === null) {
            return ['gia_goc' => $giaGoc, 'gia_km' => $giaGoc, 'khuyenmai' => null];
        }
        $giaKm = max(0, round($giaGoc * (1 - ((float) $km['phan_tram'] / 100)), 2));
        return ['gia_goc' => $giaGoc, 'gia_km' => $giaKm, 'khuyenmai' => $km];
    }
}
