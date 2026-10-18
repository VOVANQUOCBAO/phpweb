<?php

require_once __DIR__ . '/xl_database.php';

class danhmuc extends xl_database
{
    public function layDS(): array
    {
        return $this->select('SELECT * FROM danhmuc ORDER BY ten_danhmuc');
    }

    public function layTheoId(int $id): ?array
    {
        return $this->selectOne('SELECT * FROM danhmuc WHERE id = ?', [$id]);
    }

    public function them(string $ten, ?string $moTa = null): int
    {
        $ten = trim($ten);
        if ($ten === '') {
            throw new InvalidArgumentException('Ten danh muc khong duoc rong');
        }
        return $this->insert('danhmuc', [
            'ten_danhmuc' => $ten,
            'mo_ta' => $moTa,
        ]);
    }

    public function sua(int $id, string $ten, ?string $moTa = null): int
    {
        $ten = trim($ten);
        if ($ten === '') {
            throw new InvalidArgumentException('Ten danh muc khong duoc rong');
        }
        return $this->update('danhmuc', [
            'ten_danhmuc' => $ten,
            'mo_ta' => $moTa,
        ], 'id = ?', [$id]);
    }

    public function xoa(int $id): array
    {
        $conSp = $this->selectOne('SELECT COUNT(*) AS c FROM sanpham WHERE id_danhmuc = ?', [$id]);
        if ((int) ($conSp['c'] ?? 0) > 0) {
            return ['ok' => false, 'loi' => 'Khong the xoa danh muc van con san pham'];
        }
        $this->delete('khuyenmai', 'id_danhmuc = ?', [$id]);
        $this->delete('danhmuc', 'id = ?', [$id]);
        return ['ok' => true];
    }
}
