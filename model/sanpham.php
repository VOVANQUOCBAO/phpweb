<?php

require_once __DIR__ . '/xl_database.php';

class sanpham extends xl_database
{
    public function layDSAdmin(): array
    {
        return $this->select(
            'SELECT sp.*, dm.ten_danhmuc,
                    COALESCE(SUM(ct.so_luong), 0) AS da_ban
             FROM sanpham sp
             JOIN danhmuc dm ON dm.id = sp.id_danhmuc
             LEFT JOIN chitietdonhang ct ON ct.id_sanpham = sp.id
             GROUP BY sp.id
             ORDER BY sp.ngay_tao DESC, sp.id DESC'
        );
    }

    public function layDS(string $sapXep = 'moi'): array
    {
        $order = $sapXep === 'cu' ? 'ngay_tao ASC, id ASC' : 'ngay_tao DESC, id DESC';
        return $this->select("SELECT * FROM sanpham ORDER BY {$order}");
    }

    public function layDSMoi(int $limit = 12): array
    {
        $limit = max(1, min(100, $limit));
        return $this->select("SELECT * FROM sanpham ORDER BY ngay_tao DESC, id DESC LIMIT {$limit}");
    }

    public function timKiem(?string $tuKhoa = null, ?int $idDm = null, string $sapXep = 'moi', ?int $limit = null, int $offset = 0): array
    {
        $order = $sapXep === 'cu' ? 'ngay_tao ASC, id ASC' : 'ngay_tao DESC, id DESC';
        $sql = 'SELECT * FROM sanpham WHERE 1=1';
        $params = [];
        if ($tuKhoa !== null && trim($tuKhoa) !== '') {
            $sql .= ' AND (ten_sp LIKE ? OR ma_sp LIKE ? OR mo_ta LIKE ?)';
            $kw = '%' . trim($tuKhoa) . '%';
            $params[] = $kw;
            $params[] = $kw;
            $params[] = $kw;
        }
        if ($idDm !== null && $idDm > 0) {
            $sql .= ' AND id_danhmuc = ?';
            $params[] = $idDm;
        }
        $sql .= " ORDER BY {$order}";
        if ($limit !== null) {
            $sql .= ' LIMIT ' . max(1, min(100, $limit)) . ' OFFSET ' . max(0, $offset);
        }
        return $this->select($sql, $params);
    }

    public function demTimKiem(?string $tuKhoa = null, ?int $idDm = null): int
    {
        $sql = 'SELECT COUNT(*) AS tong FROM sanpham WHERE 1=1';
        $params = [];
        if ($tuKhoa !== null && trim($tuKhoa) !== '') {
            $sql .= ' AND (ten_sp LIKE ? OR ma_sp LIKE ? OR mo_ta LIKE ?)';
            $kw = '%' . trim($tuKhoa) . '%';
            $params = [$kw, $kw, $kw];
        }
        if ($idDm !== null && $idDm > 0) {
            $sql .= ' AND id_danhmuc = ?';
            $params[] = $idDm;
        }
        return (int) $this->selectOne($sql, $params)['tong'];
    }

    public function layDSKhuyenMai(int $limit = 12): array
    {
        $limit = max(1, min(100, $limit));
        return $this->select("SELECT sp.* FROM sanpham sp WHERE EXISTS (
            SELECT 1 FROM khuyenmai km WHERE CURDATE() BETWEEN km.ngay_bd AND km.ngay_kt
            AND ((km.loai = 'sanpham' AND km.id_sanpham = sp.id)
              OR (km.loai = 'danhmuc' AND km.id_danhmuc = sp.id_danhmuc))
            ) ORDER BY sp.ngay_tao DESC, sp.id DESC LIMIT {$limit}");
    }

    public function boSungThongTinReal(array &$sp): void
    {
        $id = (int)($sp['id'] ?? 0);
        if ($id <= 0) {
            return;
        }
        $sp['so_luong_ton'] = (int)($sp['so_luong_ton'] ?? 0);
        $sp['so_luong_goc'] = (int)($sp['so_luong_goc'] ?? $sp['so_luong_ton']);
        $sp['het_hang'] = $sp['so_luong_ton'] <= 0;

        // 1. Đã bán thực tế từ CSDL: tính từ chitietdonhang của các đơn hàng không bị hủy/bom/trả
        $banRow = $this->selectOne(
            "SELECT COALESCE(SUM(ct.so_luong), 0) AS da_ban 
             FROM chitietdonhang ct 
             JOIN donhang dh ON dh.id = ct.id_donhang 
             WHERE ct.id_sanpham = ? AND dh.trang_thai NOT IN ('Đã hủy', 'Bom hàng', 'Trả hàng')",
            [$id]
        );
        $daBanTuDon = (int)($banRow['da_ban'] ?? 0);
        $chenhLech = max(0, $sp['so_luong_goc'] - $sp['so_luong_ton']);
        $sp['da_ban'] = max($daBanTuDon, $chenhLech);

        // 2. Số sao & tổng số lượt đánh giá thực tế từ bảng danhgia trong CSDL
        $dgRow = $this->selectOne(
            "SELECT AVG(so_sao) AS sao_tb, COUNT(id) AS tong_dg 
             FROM danhgia 
             WHERE id_sanpham = ? AND trang_thai = 1",
            [$id]
        );
        $tongDg = (int)($dgRow['tong_dg'] ?? 0);
        $saoTb = $tongDg > 0 ? round((float)$dgRow['sao_tb'], 1) : 5.0;
        $sp['sao_tb'] = $saoTb;
        $sp['so_danh_gia'] = $tongDg;
    }

    public function layChiTiet(int $id): ?array
    {
        $sp = $this->selectOne('SELECT * FROM sanpham WHERE id = ?', [$id]);
        if ($sp !== null) {
            $this->boSungThongTinReal($sp);
        }
        return $sp;
    }

    public function layTheoMa(string $maSp): ?array
    {
        return $this->selectOne('SELECT * FROM sanpham WHERE ma_sp = ?', [$maSp]);
    }

    public function them(array $data): array
    {
        $loi = $this->kiemTraDuLieu($data);
        if ($loi !== null) {
            return ['ok' => false, 'loi' => $loi];
        }
        $ma = trim((string) ($data['ma_sp'] ?? ''));
        if ($ma === '') {
            return ['ok' => false, 'loi' => 'Bat buoc nhap ma san pham'];
        }
        if ($this->layTheoMa($ma) !== null) {
            return ['ok' => false, 'loi' => 'Ma san pham da ton tai'];
        }
        $goc = (int) ($data['so_luong_goc'] ?? 0);
        $ton = (int) ($data['so_luong_ton'] ?? $goc);
        $check = $this->kiemTraSoLuong($goc, $ton);
        if ($check !== null) {
            return ['ok' => false, 'loi' => $check];
        }
        try {
            $id = $this->insert('sanpham', [
                'ma_sp' => $ma,
                'ten_sp' => trim((string) ($data['ten_sp'] ?? '')),
                'id_danhmuc' => (int) ($data['id_danhmuc'] ?? 0),
                'gia' => (float) ($data['gia'] ?? 0),
                'so_luong_goc' => $goc,
                'so_luong_ton' => $ton,
                'hinh' => !empty($data['hinh']) ? $data['hinh'] : null,
                'mo_ta' => !empty($data['mo_ta']) ? $data['mo_ta'] : null,
                'han_su_dung' => !empty($data['han_su_dung']) ? $data['han_su_dung'] : null,
            ]);
        } catch (PDOException $e) {
            error_log('Them san pham: ' . $e->getMessage());
            return ['ok' => false, 'loi' => $e->getCode() === '23000'
                ? 'Mã sản phẩm đã tồn tại' : 'Không thể lưu sản phẩm lúc này'];
        }
        return ['ok' => true, 'id' => $id];
    }

    public function sua(int $id, array $data): array
    {
        try {
            $this->begin();
            $sp = $this->selectOne('SELECT * FROM sanpham WHERE id = ? FOR UPDATE', [$id]);
            if ($sp === null) {
                $this->rollback();
                return ['ok' => false, 'loi' => 'Không tìm thấy sản phẩm'];
            }
            $data = array_replace($sp, $data);
            if ((int) $data['so_luong_goc'] !== (int) $sp['so_luong_goc']) {
                $this->rollback();
                return ['ok' => false, 'loi' => 'Không được thay đổi số lượng tạo ban đầu'];
            }
            $loi = $this->kiemTraDuLieu($data);
            if ($loi !== null) {
                $this->rollback();
                return ['ok' => false, 'loi' => $loi];
            }
            $goc = (int) $data['so_luong_goc'];
            $ton = (int) $data['so_luong_ton'];
            $check = $this->kiemTraSoLuong($goc, $ton);
            if ($check !== null) {
                $this->rollback();
                return ['ok' => false, 'loi' => $check];
            }
            $fields = [
                'ten_sp' => trim((string) $data['ten_sp']),
                'id_danhmuc' => (int) $data['id_danhmuc'],
                'gia' => (float) $data['gia'],
                'so_luong_goc' => $goc,
                'so_luong_ton' => $ton,
                'hinh' => $data['hinh'] ?? null,
                'mo_ta' => $data['mo_ta'] ?? null,
                'han_su_dung' => $data['han_su_dung'] ?: null,
            ];
            $ma = trim((string) $data['ma_sp']);
            if ($ma !== $sp['ma_sp']) {
                $existing = $this->layTheoMa($ma);
                if ($existing !== null && (int) $existing['id'] !== $id) {
                    $this->rollback();
                    return ['ok' => false, 'loi' => 'Mã sản phẩm đã tồn tại'];
                }
                $fields['ma_sp'] = $ma;
            }
            $this->update('sanpham', $fields, 'id = ?', [$id]);
            $this->commit();
        } catch (PDOException $e) {
            $this->rollback();
            error_log('Sua san pham: ' . $e->getMessage());
            return ['ok' => false, 'loi' => $e->getCode() === '23000'
                ? 'Mã sản phẩm đã tồn tại' : 'Không thể cập nhật sản phẩm lúc này'];
        } catch (Throwable $e) {
            $this->rollback();
            error_log('Sua san pham: ' . $e->getMessage());
            return ['ok' => false, 'loi' => 'Không thể cập nhật sản phẩm lúc này'];
        }
        return ['ok' => true];
    }

    public function xoa(int $id): array
    {
        try {
            $this->begin();
            if ($this->selectOne('SELECT id FROM sanpham WHERE id = ? FOR UPDATE', [$id]) === null) {
                $this->rollback();
                return ['ok' => false, 'loi' => 'Khong tim thay san pham'];
            }
            $daBan = $this->selectOne(
                'SELECT COUNT(*) AS c FROM chitietdonhang WHERE id_sanpham = ?',
                [$id]
            );
            if ((int) ($daBan['c'] ?? 0) > 0) {
                $this->rollback();
                return ['ok' => false, 'loi' => 'San pham da co giao dich, khong duoc xoa'];
            }
            $this->delete('danhgia', 'id_sanpham = ?', [$id]);
            $this->delete('khuyenmai', 'id_sanpham = ?', [$id]);
            $this->delete('sanpham', 'id = ?', [$id]);
            $this->commit();
            return ['ok' => true];
        } catch (Throwable $e) {
            $this->rollback();
            error_log('Xoa san pham: ' . $e->getMessage());
            return ['ok' => false, 'loi' => 'Không thể xóa sản phẩm vì dữ liệu đang được sử dụng'];
        }
    }

    public function truTon(int $id, int $sl): array
    {
        if ($sl <= 0) {
            return ['ok' => false, 'loi' => 'So luong khong hop le'];
        }
        $n = $this->execute(
            'UPDATE sanpham SET so_luong_ton = so_luong_ton - ? WHERE id = ? AND so_luong_ton >= ?',
            [$sl, $id, $sl]
        );
        if ($n === 0) {
            return ['ok' => false, 'loi' => 'Khong du so luong ton kho'];
        }
        return ['ok' => true];
    }

    public function congTon(int $id, int $sl): array
    {
        if ($sl <= 0) {
            return ['ok' => false, 'loi' => 'So luong khong hop le'];
        }
        $this->execute('UPDATE sanpham SET so_luong_ton = LEAST(so_luong_goc, so_luong_ton + ?) WHERE id = ?', [$sl, $id]);
        $sp = $this->layChiTiet($id);
        return $sp === null ? ['ok' => false, 'loi' => 'Khong tim thay san pham']
            : ['ok' => true, 'so_luong_ton' => (int) $sp['so_luong_ton']];
    }

    public function canhBaoSapHet(int $nguong = 5): array
    {
        return $this->select(
            'SELECT * FROM sanpham WHERE so_luong_ton <= ?',
            [$nguong]
        );
    }

    public function hangE(int $soNgay = 30, int $nguongBan = 2): array
    {
        return $this->select(
            'SELECT sp.*, COALESCE(ban.da_ban, 0) AS da_ban
             FROM sanpham sp
             LEFT JOIN (
                SELECT ct.id_sanpham, SUM(ct.so_luong) AS da_ban
                FROM chitietdonhang ct
                JOIN donhang dh ON dh.id = ct.id_donhang
                WHERE dh.trang_thai = ?
                GROUP BY ct.id_sanpham
             ) ban ON ban.id_sanpham = sp.id
             WHERE sp.ngay_tao <= DATE_SUB(NOW(), INTERVAL ? DAY)
               AND COALESCE(ban.da_ban, 0) <= ?',
            ['Thành công', $soNgay, $nguongBan]
        );
    }

    public function canHan(int $soNgay = 14): array
    {
        return $this->select(
            'SELECT * FROM sanpham
             WHERE han_su_dung IS NOT NULL
               AND han_su_dung <= DATE_ADD(CURDATE(), INTERVAL ? DAY)
               AND han_su_dung >= CURDATE()',
            [$soNgay]
        );
    }

    public function kiemTraSoLuong(int $goc, int $ton): ?string
    {
        if ($goc < 0 || $ton < 0) {
            return 'So luong khong duoc am';
        }
        if ($ton > $goc) {
            return 'So luong ton khong duoc vuot so luong goc';
        }
        return null;
    }

    private function kiemTraDuLieu(array $data): ?string
    {
        $ma = trim((string) ($data['ma_sp'] ?? ''));
        $ten = trim((string) ($data['ten_sp'] ?? ''));
        if ($ma === '' || strlen($ma) > 200) {
            return 'Mã sản phẩm bắt buộc và tối đa 50 ký tự';
        }
        if ($ten === '' || strlen($ten) > 1020) {
            return 'Tên sản phẩm bắt buộc và tối đa 255 ký tự';
        }
        if (!$this->soTienHopLe($data['gia'] ?? null)) {
            return 'Giá sản phẩm không hợp lệ';
        }
        if (!$this->soNguyenHopLe($data['so_luong_goc'] ?? null)
            || !$this->soNguyenHopLe($data['so_luong_ton'] ?? $data['so_luong_goc'])) {
            return 'So luong phai la so nguyen khong am';
        }
        if (!$this->soNguyenHopLe($data['id_danhmuc'] ?? null, 1)
            || $this->selectOne('SELECT id FROM danhmuc WHERE id = ?', [$data['id_danhmuc']]) === null) {
            return 'Danh muc khong ton tai';
        }
        if (!empty($data['han_su_dung']) && !$this->ngayHopLe($data['han_su_dung'])) {
            return 'Han su dung khong hop le';
        }
        if (isset($data['hinh']) && $data['hinh'] !== null && strlen((string) $data['hinh']) > 1020) {
            return 'Đường dẫn ảnh tối đa 255 ký tự';
        }
        return null;
    }
}
