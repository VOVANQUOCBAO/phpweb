<?php

require_once dirname(__DIR__) . '/model/email.php';
require_once dirname(__DIR__) . '/model/khachhang.php';
require_once dirname(__DIR__) . '/model/chitietdonhang.php';

// Ban tai tu GitHub co san thu vien nho trong lib/; Composer van duoc ho tro.
$mailAutoload = dirname(__DIR__) . '/vendor/autoload.php';
if (is_file($mailAutoload)) {
    require_once $mailAutoload;
} else {
    foreach (['Exception', 'PHPMailer', 'SMTP'] as $mailClass) {
        $mailFile = dirname(__DIR__) . '/lib/PHPMailer/' . $mailClass . '.php';
        if (is_file($mailFile)) {
            require_once $mailFile;
        }
    }
}

class xuly_email
{
    public function guiDonHang(int $idKh, int $idDon, array $don, array $dong): array
    {
        $kh = (new khachhang())->layTheoId($idKh);
        $dongText = '';
        foreach ($dong as $item) {
            $dongText .= '- SP#' . $item['id_sanpham'] . ' x' . $item['so_luong']
                . ' @ ' . $item['don_gia'] . "\n";
        }
        $tieuDe = 'Xac nhan don hang #' . $idDon;
        $noiDung = "Xin chao " . ($kh['ho_ten'] ?? '') . ",\n"
            . "Ngay dat: " . date('Y-m-d H:i:s') . "\n"
            . "Trang thai: " . ($don['trang_thai'] ?? 'Chờ xác nhận') . "\n"
            . "Tong tien: " . ($don['tong_tien'] ?? '') . "\n"
            . "Chi tiet:\n{$dongText}";

        $idThu = (new email())->luuThu($idKh, $tieuDe, $noiDung, 'donhang');
        $smtp = $this->guiSmtp($kh['email'] ?? '', $tieuDe, $noiDung);
        return ['ok' => true, 'id_thu' => $idThu, 'smtp' => $smtp];
    }

    public function guiChung(int $idKh, string $tieuDe, string $noiDung, string $loai = 'hethong'): array
    {
        $kh = (new khachhang())->layTheoId($idKh);
        $idThu = (new email())->luuThu($idKh, $tieuDe, $noiDung, $loai);
        $smtp = $this->guiSmtp($kh['email'] ?? '', $tieuDe, $noiDung);
        return ['ok' => true, 'id_thu' => $idThu, 'smtp' => $smtp];
    }

    private function guiSmtp(string $to, string $tieuDe, string $noiDung): array
    {
        $cfg = (new email())->cauHinhSmtp();
        if ($cfg['user'] === '' || $cfg['pass'] === '') {
            return ['ok' => false, 'loi' => 'Chua cau hinh SMTP (van da luu hop thu)'];
        }
        if (!class_exists(PHPMailer\PHPMailer\PHPMailer::class)) {
            return ['ok' => false, 'loi' => 'Thieu thu vien PHPMailer (van da luu hop thu)'];
        }
        try {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $cfg['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $cfg['user'];
            $mail->Password = $cfg['pass'];
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = (int) $cfg['port'];
            $mail->Timeout = 10;
            $mail->CharSet = 'UTF-8';
            $mail->setFrom($cfg['from'], $cfg['from_name']);
            $mail->addAddress($to);
            $mail->Subject = $tieuDe;
            $mail->Body = $noiDung;
            $mail->send();
            return ['ok' => true];
        } catch (Throwable $e) {
            return ['ok' => false, 'loi' => $e->getMessage()];
        }
    }
}
