<?php

require_once __DIR__ . '/xl_database.php';
require_once __DIR__ . '/khachhang.php';

class voucher extends xl_database
{
    public function layDS(): array
    {
        return $this->select('SELECT * FROM voucher ORDER BY id DESC');
    }

    public function layTheoCode(string $code): ?array
    {
        return $this->selectOne('SELECT * FROM voucher WHERE ma_code = ?', [trim($code)]);
    }

    public function them(array $data): array
    {
        $code = strtoupper(trim((string) ($data['ma_code'] ?? '')));
        if ($code === '') {
            return ['ok' => false, 'loi' => 'Thieu ma voucher'];
        }
        if ($this->layTheoCode($code) !== null) {
            return ['ok' => false, 'loi' => 'Ma voucher da ton tai'];
        }
        $loai = $data['loai'] ?? 'tien';
        if (!in_array($loai, ['tien', 'phantram', 'mienship'], true)) {
            return ['ok' => false, 'loi' => 'Loai voucher khong hop le'];
        }
        if (!$this->soTienHopLe($data['gia_tri'] ?? 0)
            || ($loai === 'phantram' && (float) ($data['gia_tri'] ?? 0) > 100)
            || !$this->soNguyenHopLe($data['so_luong'] ?? 0)) {
            return ['ok' => false, 'loi' => 'Muc giam hoac so luong voucher khong hop le'];
        }
        if (!$this->ngayHopLe($data['ngay_bd'] ?? null) || !$this->ngayHopLe($data['ngay_kt'] ?? null)
            || $data['ngay_bd'] > $data['ngay_kt']) {
            return ['ok' => false, 'loi' => 'Thoi han voucher khong hop le'];
        }
        $hang = ($data['hang_ap_dung'] ?? '') === '' ? null : $data['hang_ap_dung'];
        if ($hang !== null && !in_array($hang, ['Silver', 'Gold', 'Diamond'], true)) {
            return ['ok' => false, 'loi' => 'Hang ap dung voucher khong hop le'];
        }
        if (strlen($code) > 50) {
            return ['ok' => false, 'loi' => 'Ma voucher toi da 50 ky tu'];
        }
        $id = $this->insert('voucher', [
            'ma_code' => $code,
            'loai' => $loai,
            'gia_tri' => (float) ($data['gia_tri'] ?? 0),
            'so_luong' => (int) ($data['so_luong'] ?? 0),
            'ngay_bd' => $data['ngay_bd'],
            'ngay_kt' => $data['ngay_kt'],
            'hang_ap_dung' => $hang,
        ]);
        return ['ok' => true, 'id' => $id];
    }

    public function xoa(int $id): array
    {
        $this->delete('voucher', 'id = ?', [$id]);
        return ['ok' => true];
    }

    public function kiemTra(string $code, string $hangKh, float $tamTinh, float $phiShip, bool $khoa = false): array
    {
        $vc = $this->selectOne('SELECT * FROM voucher WHERE ma_code = ?' . ($khoa ? ' FOR UPDATE' : ''), [strtoupper(trim($code))]);
        if ($vc === null) {
            return ['ok' => false, 'loi' => 'Voucher khong ton tai'];
        }
        $homNay = date('Y-m-d');
        if ($homNay < $vc['ngay_bd'] || $homNay > $vc['ngay_kt']) {
            return ['ok' => false, 'loi' => 'Voucher het han hoac chua den ngay'];
        }
        if ((int) $vc['so_luong'] <= 0) {
            return ['ok' => false, 'loi' => 'Voucher da het luot su dung'];
        }
        if ($vc['hang_ap_dung'] !== null && $vc['hang_ap_dung'] !== '' && $vc['hang_ap_dung'] !== $hangKh) {
            return ['ok' => false, 'loi' => 'Hang khach hang chua du dieu kien voucher'];
        }
        $giam = 0.0;
        $phiConLai = $phiShip;
        if ($vc['loai'] === 'tien') {
            $giam = min($tamTinh, (float) $vc['gia_tri']);
        } elseif ($vc['loai'] === 'phantram') {
            $giam = round($tamTinh * ((float) $vc['gia_tri'] / 100), 2);
        } elseif ($vc['loai'] === 'mienship') {
            $phiConLai = 0.0;
        }
        if ($hangKh === khachhang::HANG_GOLD || $hangKh === khachhang::HANG_DIAMOND) {
            $phiConLai = 0.0;
        }
        return [
            'ok' => true,
            'voucher' => $vc,
            'giam' => $giam,
            'phi_ship' => $phiConLai,
            'tong' => max(0, $tamTinh - $giam) + $phiConLai,
        ];
    }

    public function truSoLuong(string $code): array
    {
        $n = $this->execute(
            'UPDATE voucher SET so_luong = so_luong - 1 WHERE ma_code = ? AND so_luong > 0',
            [trim($code)]
        );
        if ($n === 0) {
            return ['ok' => false, 'loi' => 'Khong tru duoc so luong voucher'];
        }
        return ['ok' => true];
    }
}
