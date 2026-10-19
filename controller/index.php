<?php

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

date_default_timezone_set('Asia/Ho_Chi_Minh');

/* Hop dong View: support/README.md. Chua co View thi tra JSON de test. */
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!function_exists('chatbot_build_fallback_reply')) {
    function chatbot_build_fallback_reply(string $message): string
    {
        $q = strtolower(trim($message));
        if ($q === '') {
            return 'Bạn chưa nhập câu hỏi cho AI. Hãy nêu nhu cầu tìm điện thoại, mức giá hoặc tính năng bạn muốn.';
        }

        if (str_contains($q, 'iphone') || str_contains($q, 'apple') || str_contains($q, '16') || str_contains($q, '15')) {
            return "🔥 Gợi ý cho bạn dòng <strong>Apple iPhone</strong> đỉnh cao:<ul class='mb-2 ps-3 mt-1'><li><strong>iPhone 16 256GB</strong>: 28.990.000đ (Siêu phẩm mới nhất)</li><li><strong>iPhone 15 Pro Max 256GB</strong>: 29.990.000đ (Giảm 20%)</li><li><strong>iPhone 13 128GB</strong>: 13.990.000đ (Bán chạy, giá hời)</li></ul><a href='index.php?act=chitiet&id=1' class='btn btn-primary btn-sm rounded-pill text-white text-decoration-none'>Xem iPhone 15 Pro Max</a>";
        }

        if (str_contains($q, 'samsung') || str_contains($q, 's24') || str_contains($q, 'ai')) {
            return "✨ Bạn đang quan tâm dòng <strong>Samsung Galaxy AI</strong>:<ul class='mb-2 ps-3 mt-1'><li><strong>Samsung Galaxy S24 Ultra 5G</strong>: 28.990.000đ (Quyền năng AI đỉnh cao, bút S-Pen, viền Titanium)</li></ul><a href='index.php?act=chitiet&id=2' class='btn btn-primary btn-sm rounded-pill text-white text-decoration-none'>Xem Galaxy S24 Ultra</a>";
        }

        if (str_contains($q, 'dưới 15') || str_contains($q, 'rẻ') || str_contains($q, 'sinh viên') || str_contains($q, '10 triệu')) {
            return "💰 Phân khúc tầm trung giá tốt cho bạn:<ul class='mb-2 ps-3 mt-1'><li><strong>OPPO Reno11 F 5G</strong>: 8.990.000đ (Chuyên gia chân dung)</li><li><strong>iPhone 13 128GB</strong>: 13.990.000đ (Hiệu năng cực bền)</li></ul><a href='index.php?act=chitiet&id=4' class='btn btn-primary btn-sm rounded-pill text-white text-decoration-none'>Xem OPPO Reno11 F</a>";
        }

        if (str_contains($q, 'ảnh') || str_contains($q, 'chụp') || str_contains($q, 'leica') || str_contains($q, 'xiaomi')) {
            return "📷 Siêu phẩm chụp ảnh chuyên nghiệp:<ul class='mb-2 ps-3 mt-1'><li><strong>Xiaomi 14 5G 256GB</strong>: 20.990.000đ (Ống kính huyền thoại Leica)</li><li><strong>Samsung S24 Ultra</strong>: Camera 200MP Zoom 100x</li></ul><a href='index.php?act=chitiet&id=3' class='btn btn-primary btn-sm rounded-pill text-white text-decoration-none'>Xem Xiaomi 14 Leica</a>";
        }

        return "Cảm ơn bạn đã nhắn! ĐiệnThoạiZ hiện đang có chương trình khuyến mãi lớn cho các dòng <strong>iPhone 16, Samsung Galaxy S24 Ultra, Xiaomi 14 và OPPO Reno11</strong>. Bạn có muốn xem danh sách ưu đãi hôm nay không?";
    }
}

if (!function_exists('chatbot_call_api')) {
    function chatbot_call_api(string $message, string $apiKey, string $apiUrl, string $model): ?string
    {
        if (!function_exists('curl_init') || $apiKey === '' || $apiUrl === '') {
            return null;
        }

        $isGemini = stripos($apiUrl, 'googleapis.com') !== false || stripos($apiUrl, 'gemini') !== false;

        if ($isGemini) {
            $endpoint = rtrim($apiUrl, '/');
            if (stripos($endpoint, '?') === false) {
                $endpoint .= '?key=' . rawurlencode($apiKey);
            } else {
                $endpoint .= '&key=' . rawurlencode($apiKey);
            }

            $payload = [
                'contents' => [
                    [
                        'parts' => [[ 'text' => $message ]],
                    ],
                ],
            ];
            $headers = ['Content-Type: application/json'];
        } else {
            $endpoint = $apiUrl;
            $payload = [
                'model' => $model !== '' ? $model : 'gpt-4o-mini',
                'messages' => [[
                    'role' => 'user',
                    'content' => $message,
                ]],
                'temperature' => 0.7,
            ];
            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $apiKey,
            ];
        }

        $ch = curl_init($endpoint);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_UNICODE),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
        ]);

        $response = curl_exec($ch);
        $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response === false || $httpCode >= 400) {
            return null;
        }

        $decoded = json_decode($response, true);
        if (!is_array($decoded)) {
            return null;
        }

        if ($isGemini) {
            $text = $decoded['candidates'][0]['content']['parts'][0]['text'] ?? null;
            return is_string($text) ? $text : null;
        }

        $text = $decoded['choices'][0]['message']['content'] ?? null;
        if (is_array($text)) {
            $text = implode('', array_map(static fn ($part) => is_array($part) ? ($part['text'] ?? '') : (string) $part, $text));
        }

        return is_string($text) ? $text : null;
    }
}

// Bắt điều hướng khu vực Admin trực tiếp từ controller/index.php
$khu = $_GET['khu'] ?? '';
if ($khu === 'admin') {
    require __DIR__ . '/admin/index.php';
    return;
}

require_once BASE_PATH . '/controller/controller.php';
require_once BASE_PATH . '/controller/giohang.php';
require_once BASE_PATH . '/controller/xuly_email.php';
require_once BASE_PATH . '/model/danhmuc.php';
require_once BASE_PATH . '/model/sanpham.php';
require_once BASE_PATH . '/model/khachhang.php';
require_once BASE_PATH . '/model/nhanvien.php';
require_once BASE_PATH . '/model/danhgia.php';
require_once BASE_PATH . '/model/donhang.php';
require_once BASE_PATH . '/model/chitietdonhang.php';
require_once BASE_PATH . '/model/voucher.php';
require_once BASE_PATH . '/model/khuyenmai.php';
require_once BASE_PATH . '/model/email.php';

$ctrl = new controller();
$act = $ctrl->act();
$thongBao = null;
$loi = null;

try {
    foreach ([$_GET, $_POST] as $inputs) {
        foreach ($inputs as $key => $value) {
            if (is_array($value) || is_object($value)) {
                throw new InvalidArgumentException('Tham so phai la gia tri don');
            }
            if (in_array($key, ['id', 'id_sanpham', 'id_danhmuc', 'sl', 'so_sao', 'trang', 'moi_trang'], true)
                && !($key === 'id_danhmuc' && $value === '')
                && filter_var($value, FILTER_VALIDATE_INT) === false) {
                throw new InvalidArgumentException('Tham so so nguyen khong hop le');
            }
        }
    }
    $dmModel = new danhmuc();
    $spModel = new sanpham();
    $khModel = new khachhang();
    $nvModel = new nhanvien();
    $dgModel = new danhgia();
    $dhModel = new donhang();
    $kmModel = new khuyenmai();
    $emModel = new email();

    switch ($act) {
        case 'dangky':
            if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
                $payload = $_POST;
                $action = $payload['action'] ?? 'dangky';
                if (!isset($payload['ho_ten']) && isset($payload['hoten'])) {
                    $payload['ho_ten'] = $payload['hoten'];
                }
                if (!isset($payload['mat_khau']) && isset($payload['password'])) {
                    $payload['mat_khau'] = $payload['password'];
                }
                if (!isset($payload['ngay_sinh']) && isset($payload['ngaysinh'])) {
                    $payload['ngay_sinh'] = $payload['ngaysinh'];
                }

                $email = trim((string)($payload['email'] ?? ''));
                $hoTen = trim((string)($payload['ho_ten'] ?? ''));
                $matKhau = (string)($payload['mat_khau'] ?? '');
                $rePass = (string)($payload['re_password'] ?? $matKhau);

                if ($matKhau !== $rePass) {
                    $loi = 'Mật khẩu xác nhận không trùng khớp';
                } elseif ($action === 'gui_otp') {
                    // Bước 1: Gửi mã OTP xác thực Gmail thật
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $loi = 'Địa chỉ email không hợp lệ';
                    } elseif ($khModel->layTheoEmail($email) !== null) {
                        $loi = 'Email này đã tồn tại trong hệ thống. Vui lòng đăng nhập hoặc dùng email khác';
                    } else {
                        $otp = (string)random_int(100000, 999999);
                        $_SESSION['dangky_pending'] = [
                            'otp' => $otp,
                            'time' => time(),
                            'payload' => $payload,
                        ];
                        // Gửi email thật qua PHPMailer / Gmail SMTP
                        $mailRes = (new xuly_email())->guiOtp($email, $otp, $hoTen);
                        if ($mailRes['ok']) {
                            $thongBao = "Mã xác thực OTP đã được gửi đến hộp thư Gmail <strong>" . htmlspecialchars($email) . "</strong>! Vui lòng kiểm tra Hộp thư đến (hoặc Thư rác/Spam) để lấy mã.";
                        } else {
                            $thongBao = "Mã xác thực OTP của bạn là: <strong class='text-primary fs-5'>{$otp}</strong> (Hệ thống đã tạo mã. Bạn có thể cấu hình Gmail App Password trong support/config/smtp.local.php để gửi thẳng về hòm thư Gmail thật).";
                        }
                    }
                } elseif ($action === 'xacnhan_otp') {
                    // Bước 2: Xác nhận mã OTP
                    $nhapOtp = trim((string)($payload['otp'] ?? ''));
                    $pending = $_SESSION['dangky_pending'] ?? null;
                    if ($pending === null || (time() - $pending['time']) > 900) {
                        $loi = 'Mã xác thực OTP đã hết hạn (15 phút). Vui lòng yêu cầu gửi mã mới.';
                    } elseif ($nhapOtp !== $pending['otp']) {
                        $loi = 'Mã xác thực OTP không chính xác. Vui lòng kiểm tra lại.';
                    } else {
                        $kq = $khModel->themKhachHang($pending['payload']);
                        if ($kq['ok']) {
                            unset($_SESSION['dangky_pending']);
                            (new xuly_email())->guiChaoMung($pending['payload']['email'], $pending['payload']['ho_ten'] ?? '');
                            $thongBao = 'Đăng ký thành công tài khoản Gmail chính hãng! Vui lòng đăng nhập.';
                            $ctrl->render('dangnhap.php', compact('thongBao', 'loi') + ['act' => 'dangnhap']);
                            break;
                        }
                        $loi = $kq['loi'];
                    }
                } else {
                    // Đăng ký trực tiếp (1 bước)
                    $kq = $khModel->themKhachHang($payload);
                    if ($kq['ok']) {
                        (new xuly_email())->guiChaoMung($payload['email'], $payload['ho_ten'] ?? '');
                        $thongBao = 'Đăng ký thành công tài khoản ' . htmlspecialchars($payload['email']) . '! Dữ liệu đã được lưu vào CSDL (bảng khachhang). Vui lòng đăng nhập.';
                        $ctrl->render('dangnhap.php', compact('thongBao', 'loi') + ['act' => 'dangnhap']);
                        break;
                    }
                    $loi = $kq['loi'];
                }
            }
            $ctrl->render('dangky.php', compact('thongBao', 'loi') + ['act' => $act]);
            break;

        case 'dangnhap':
            if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
                $email = trim((string)($_POST['email'] ?? $_POST['username'] ?? ''));
                $pass = (string)($_POST['mat_khau'] ?? $_POST['password'] ?? '');

                if ($email === '' || $pass === '') {
                    $loi = 'Vui lòng nhập đầy đủ tên đăng nhập/email và mật khẩu.';
                } else {
                    // 1. Kiểm tra tài khoản Quản trị / Nhân viên trước (Đăng nhập chung giao diện)
                    $kqAdmin = $nvModel->kiemTraDangNhap($email, $pass);
                    if ($kqAdmin['ok']) {
                        session_regenerate_id(true);
                        $nv = $kqAdmin['nhanvien'];
                        $nv['hoten'] = $nv['ho_ten'] ?? 'Quản Trị Viên';
                        $_SESSION['admin'] = $nv;
                        $ctrl->redirect('sanpham', [], 'admin');
                        return;
                    }

                    // 2. Kiểm tra tài khoản Khách hàng
                    $kqKhach = $khModel->kiemTraDangNhap($email, $pass);
                    if ($kqKhach['ok']) {
                        session_regenerate_id(true);
                        $u = $kqKhach['khachhang'];
                        $u['hoten'] = $u['ho_ten'] ?? '';
                        // Nếu là tài khoản Admin (tên đăng nhập admin hoặc email admin@local.test)
                        if (strtolower(trim($email)) === 'admin' 
                            || strtolower(trim($u['email'] ?? '')) === 'admin@local.test' 
                            || strtolower(trim($u['ten_dang_nhap'] ?? '')) === 'admin') {
                            $adminNv = $nvModel->selectOne("SELECT * FROM nhanvien WHERE vai_tro = 'Admin' LIMIT 1");
                            if ($adminNv) {
                                unset($adminNv['mat_khau']);
                                $adminNv['hoten'] = $adminNv['ho_ten'] ?? 'Quản Trị Viên';
                                $_SESSION['admin'] = $adminNv;
                            } else {
                                $_SESSION['admin'] = [
                                    'id' => $u['id'],
                                    'ho_ten' => $u['ho_ten'],
                                    'hoten' => $u['ho_ten'],
                                    'email' => $u['email'],
                                    'vai_tro' => 'Admin'
                                ];
                            }
                            $ctrl->redirect('sanpham', [], 'admin');
                            return;
                        }
                        $_SESSION['user'] = $u;
                        $ctrl->redirect('trangchu');
                        return;
                    }

                    $loi = 'Tài khoản hoặc mật khẩu không chính xác.';
                }
            }
            if (isset($_GET['loi_admin'])) {
                $loi = 'Khu vực này yêu cầu đăng nhập bằng tài khoản Quản trị viên.';
            }
            if (isset($_GET['msg']) && $_GET['msg'] === 'registered') {
                $thongBao = 'Đăng ký tài khoản thành công! Vui lòng đăng nhập để tiếp tục.';
            }
            $ctrl->render('dangnhap.php', compact('thongBao', 'loi') + ['act' => $act]);
            break;

        case 'google_login':
            $gEmail = trim((string)($_POST['google_email'] ?? $_GET['google_email'] ?? ''));
            $gName = trim((string)($_POST['google_name'] ?? $_GET['google_name'] ?? ''));
            if ($gEmail !== '' && filter_var($gEmail, FILTER_VALIDATE_EMAIL)) {
                $kh = $khModel->layTheoEmail($gEmail);
                if ($kh === null) {
                    $khModel->themKhachHang([
                        'ho_ten' => $gName ?: explode('@', $gEmail)[0],
                        'email' => $gEmail,
                        'mat_khau' => bin2hex(random_bytes(8)),
                        'hang' => khachhang::HANG_SILVER,
                    ]);
                    $kh = $khModel->layTheoEmail($gEmail);
                    (new xuly_email())->guiChaoMung($gEmail, $kh['ho_ten'] ?? '');
                }
                if ($kh && (int)$kh['trang_thai'] === 1) {
                    session_regenerate_id(true);
                    $kh['hoten'] = $kh['ho_ten'] ?? '';
                    $_SESSION['user'] = $kh;
                    $ctrl->redirect('trangchu');
                    return;
                }
            }
            $ctrl->redirect('dangnhap', ['loi' => 'dangnhap_google_thatbai']);
            break;

        case 'dangxuat':
            unset($_SESSION['user'], $_SESSION['giohang'], $_SESSION['admin']);
            session_regenerate_id(true);
            $ctrl->redirect('trangchu');
            break;

        case 'timkiem':
        case 'trangchu':
            $tuKhoa = isset($_GET['q']) ? trim((string) $_GET['q']) : (isset($_GET['keyword']) ? trim((string) $_GET['keyword']) : '');
            $idDm = isset($_GET['id_danhmuc']) ? (int) $_GET['id_danhmuc'] : 0;
            $sapXep = ($_GET['sapxep'] ?? $_GET['sort'] ?? 'moi') === 'cu' ? 'cu' : 'moi';
            $trang = max(1, min(1000000, (int) ($_GET['trang'] ?? 1)));
            $moi_trang = max(1, min(100, (int) ($_GET['moi_trang'] ?? 12)));
            $tong_sanpham = $spModel->demTimKiem($tuKhoa !== '' ? $tuKhoa : null, $idDm > 0 ? $idDm : null);
            $con_tiep = $trang * $moi_trang < $tong_sanpham;
            $ds_danhmuc = $dmModel->layDS();
            $ds_sanpham = $spModel->timKiem($tuKhoa !== '' ? $tuKhoa : null, $idDm > 0 ? $idDm : null,
                $sapXep, $moi_trang, ($trang - 1) * $moi_trang);
            foreach ($ds_sanpham as &$sp) {
                $giaKm = $kmModel->giaSauKM($sp);
                $sp['gia_goc'] = $giaKm['gia_goc'];
                $sp['gia_km'] = $giaKm['gia_km'];
                $spModel->boSungThongTinReal($sp);
            }
            unset($sp);
            $sp_moi = $spModel->layDSMoi();
            $sp_km = $spModel->layDSKhuyenMai();
            foreach (['sp_moi', 'sp_km'] as $tenDanhSach) {
                foreach (${$tenDanhSach} as &$sp) {
                    $giaKm = $kmModel->giaSauKM($sp);
                    $sp['gia_goc'] = $giaKm['gia_goc'];
                    $sp['gia_km'] = $giaKm['gia_km'];
                    $spModel->boSungThongTinReal($sp);
                }
                unset($sp);
            }
            $ctrl->render('trangchu.php', compact(
                'ds_danhmuc',
                'ds_sanpham',
                'sp_moi',
                'sp_km',
                'tuKhoa',
                'idDm',
                'sapXep',
                'trang', 'moi_trang', 'tong_sanpham', 'con_tiep',
                'thongBao',
                'loi'
            ) + ['act' => $act]);
            break;

        case 'chitiet':
            $id = (int) ($_GET['id'] ?? $_GET['id_sp'] ?? 0);
            $chitiet = $spModel->layChiTiet($id);
            if ($chitiet === null) {
                $ctrl->json(['ok' => false, 'loi' => 'Khong tim thay san pham'], 404);
                break;
            }
            $giaKm = $kmModel->giaSauKM($chitiet);
            $chitiet['gia_goc'] = $giaKm['gia_goc'];
            $chitiet['gia_km'] = $giaKm['gia_km'];
            $chitiet['het_hang'] = (int) $chitiet['so_luong_ton'] <= 0;
            $ds_danhgia = $dgModel->layDSTheoSP($id);
            $ctrl->render('chitiet_sanpham.php', compact('chitiet', 'ds_danhgia', 'thongBao', 'loi') + ['act' => $act]);
            break;

        case 'themdanhgia':
            $user = $ctrl->requireUser();
            $idSp = (int) ($_POST['id_sanpham'] ?? $_GET['id_sanpham'] ?? $_POST['id_sp'] ?? $_GET['id_sp'] ?? 0);
            if ($user === null) {
                $ctrl->redirect('dangnhap');
            }
            $chitiet = $spModel->layChiTiet($idSp);
            if ($chitiet === null) {
                $ctrl->json(['ok' => false, 'loi' => 'Khong tim thay san pham'], 404);
                break;
            }
            $giaKm = $kmModel->giaSauKM($chitiet);
            $chitiet['gia_goc'] = $giaKm['gia_goc'];
            $chitiet['gia_km'] = $giaKm['gia_km'];
            $chitiet['het_hang'] = (int) $chitiet['so_luong_ton'] <= 0;
            $soSao = (int) ($_POST['so_sao'] ?? $_POST['sao'] ?? 0);
            $noiDung = (string) ($_POST['noi_dung'] ?? $_POST['noidung'] ?? '');
            $kq = $dgModel->them($idSp, (int) $user['id'], $soSao, $noiDung);
            if (!$kq['ok']) {
                $loi = $kq['loi'];
            } else {
                $thongBao = 'Da gui danh gia';
            }
            $ds_danhgia = $dgModel->layDSTheoSP($idSp);
            $ctrl->render('chitiet_sanpham.php', compact('chitiet', 'ds_danhgia', 'thongBao', 'loi') + ['act' => 'chitiet']);
            break;

        case 'giohang':
            $ctrl->render('giohang.php', ['giohang' => giohang::chiTiet(), 'act' => $act, 'thongBao' => $thongBao, 'loi' => $loi]);
            break;

        case 'themgiohang':
            $idSp = (int) ($_GET['id'] ?? $_POST['id'] ?? $_GET['id_sp'] ?? 0);
            $sl = (int) ($_GET['sl'] ?? $_POST['sl'] ?? 1);
            if (filter_var($_GET['sl'] ?? $_POST['sl'] ?? 1, FILTER_VALIDATE_INT) === false) {
                throw new InvalidArgumentException('So luong phai la so nguyen');
            }
            $kq = giohang::them($idSp, $sl);
            $loi = $kq['ok'] ? null : $kq['loi'];
            $thongBao = $kq['ok'] ? 'Da them vao gio' : null;
            $ctrl->render('giohang.php', ['giohang' => giohang::chiTiet(), 'act' => 'giohang', 'thongBao' => $thongBao, 'loi' => $loi]);
            break;

        case 'xoagiohang':
            $idSp = (int) ($_GET['id'] ?? $_POST['id'] ?? $_GET['del'] ?? 0);
            giohang::xoa($idSp);
            $ctrl->render('giohang.php', ['giohang' => giohang::chiTiet(), 'act' => 'giohang', 'thongBao' => 'Da xoa san pham', 'loi' => null]);
            break;

        case 'suagiohang':
            $idSp = (int) ($_POST['id'] ?? $_GET['id'] ?? 0);
            $sl = (int) ($_POST['sl'] ?? $_GET['sl'] ?? 0);
            if (filter_var($_POST['sl'] ?? $_GET['sl'] ?? 0, FILTER_VALIDATE_INT) === false) {
                throw new InvalidArgumentException('So luong phai la so nguyen');
            }
            $kq = giohang::sua($idSp, $sl);
            $loi = $kq['ok'] ? null : $kq['loi'];
            $ctrl->render('giohang.php', ['giohang' => giohang::chiTiet(), 'act' => 'giohang', 'thongBao' => $kq['ok'] ? 'Da cap nhat gio' : null, 'loi' => $loi]);
            break;

        case 'thanhtoan':
            $user = $ctrl->requireUser();
            if ($user === null) {
                $ctrl->redirect('dangnhap');
            }
            $gio = giohang::chiTiet();
            if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
                $kq = $dhModel->taoDon(
                    (int) $user['id'],
                    giohang::get(),
                    [
                        'dia_chi' => $_POST['dia_chi'] ?? $_POST['diachi'] ?? '',
                        'sdt' => $_POST['sdt'] ?? '',
                    ],
                    $_POST['ma_voucher'] ?? $_POST['voucher'] ?? null
                );
                if (!$kq['ok']) {
                    $ctrl->render('thanhtoan.php', [
                        'giohang' => $gio,
                        'loi' => $kq['loi'],
                        'thongBao' => null,
                        'act' => $act,
                        'user' => $user,
                    ]);
                    break;
                }
                $don = $dhModel->layTheoId((int) $kq['id']);
                giohang::xoaHet();
                // Don da commit: loi mail khong duoc lam gio hang con lai de dat trung.
                try {
                    $email_result = (new xuly_email())->guiDonHang((int) $user['id'], (int) $kq['id'], $don ?? [], $kq['dong']);
                } catch (Throwable $e) {
                    error_log('Email don hang: ' . $e->getMessage());
                    $email_result = ['ok' => false, 'loi' => 'Don da luu, thong bao email chua gui duoc'];
                }
                $ctrl->render('thanhtoan.php', [
                    'ok' => true,
                    'id_don' => $kq['id'],
                    'donhang' => $don,
                    'email_result' => $email_result,
                    'thongBao' => 'Dat hang thanh cong',
                    'loi' => null,
                    'act' => $act,
                    'giohang' => ['items' => [], 'tong' => 0],
                ]);
                break;
            }
            $ctrl->render('thanhtoan.php', [
                'giohang' => $gio,
                'user' => $user,
                'act' => $act,
                'thongBao' => $thongBao,
                'loi' => $loi,
            ]);
            break;

        case 'lichsumuahang':
            $user = $ctrl->requireUser();
            if ($user === null) {
                $ctrl->redirect('dangnhap');
            }
            $ds_donhang = $dhModel->layTheoKhach((int) $user['id']);
            $ctrl->render('lichsu_muahang.php', compact('ds_donhang', 'thongBao', 'loi') + ['act' => $act]);
            break;

        case 'huydonhang':
            $user = $ctrl->requireUser();
            if ($user === null) {
                $ctrl->redirect('dangnhap');
            }
            $rawId = $_GET['id'] ?? $_POST['id'] ?? ($_POST['order_id'] ?? 0);
            $idDon = is_numeric($rawId) ? (int)$rawId : (int)preg_replace('/\D/', '', (string)$rawId);
            $lyDo = (string) ($_POST['ly_do'] ?? $_POST['lydo'] ?? 'Khach huy don');
            $kq = $dhModel->huyDon($idDon, (int) $user['id'], $lyDo);
            $loi = $kq['ok'] ? null : $kq['loi'];
            $thongBao = $kq['ok'] ? 'Da huy don hang' : null;
            $ds_donhang = $dhModel->layTheoKhach((int) $user['id']);
            $ctrl->render('lichsu_muahang.php', compact('ds_donhang', 'thongBao', 'loi') + ['act' => 'lichsumuahang']);
            break;

        case 'khieunai':
            $user = $ctrl->requireUser();
            if ($user === null) {
                $ctrl->redirect('dangnhap');
            }
            $rawId = $_POST['id'] ?? $_GET['id'] ?? ($_POST['order_id'] ?? 0);
            $idDon = is_numeric($rawId) ? (int)$rawId : (int)preg_replace('/\D/', '', (string)$rawId);
            $noiDung = (string) ($_POST['noi_dung'] ?? $_POST['noidung'] ?? '');
            $kq = $dhModel->ghiKhieuNai($idDon, (int) $user['id'], $noiDung);
            $loi = $kq['ok'] ? null : $kq['loi'];
            $thongBao = $kq['ok'] ? 'Da gui khieu nai' : null;
            $ds_donhang = $dhModel->layTheoKhach((int) $user['id']);
            $ctrl->render('lichsu_muahang.php', compact('ds_donhang', 'thongBao', 'loi') + ['act' => 'lichsumuahang']);
            break;

        case 'theodoidonhang':
            $user = $ctrl->requireUser();
            if ($user === null) {
                $ctrl->redirect('dangnhap');
            }
            $idDon = (int) ($_GET['id'] ?? 0);
            $donhang = $dhModel->layTrangThai($idDon);
            if ($donhang === null || (int) $donhang['id_khachhang'] !== (int) $user['id']) {
                $loi = 'Khong tim thay don hang';
                $donhang = null;
            }
            $ctrl->render('theodoi_donhang.php', compact('donhang', 'thongBao', 'loi') + ['act' => $act]);
            break;

        case 'hopthu':
            $user = $ctrl->requireUser();
            if ($user === null) {
                $ctrl->redirect('dangnhap');
            }
            $ds_thu = $emModel->layThuCuaKhach((int) $user['id']);
            $ctrl->render('hopthu.php', compact('ds_thu', 'thongBao', 'loi') + ['act' => $act]);
            break;

        case 'admin':
            if (!empty($_SESSION['admin'])) {
                $ctrl->redirect('sanpham', [], 'admin');
            } else {
                $ctrl->redirect('dangnhap', ['loi_admin' => '1']);
            }
            break;

        case 'chatbot':
            $json = file_get_contents('php://input');
            $payload = [];
            if ($json !== false && trim($json) !== '') {
                $data = json_decode($json, true);
                if (is_array($data)) {
                    $payload = $data;
                }
            }
            $message = trim((string) ($payload['message'] ?? $_POST['message'] ?? $_GET['message'] ?? ''));
            if ($message === '') {
                $ctrl->json(['ok' => false, 'reply' => 'Bạn chưa nhập câu hỏi cho AI.'], 400);
                break;
            }

            $chatbotConfigPath = BASE_PATH . '/support/config/chatbot.local.php';
            if (!is_file($chatbotConfigPath)) {
                $chatbotConfigPath = BASE_PATH . '/support/config/chatbot.example.php';
            }

            $chatbotConfig = is_file($chatbotConfigPath) ? include $chatbotConfigPath : [];
            $apiKey = getenv('CHATBOT_API_KEY') ?: (string) ($chatbotConfig['api_key'] ?? '');
            $apiUrl = getenv('CHATBOT_API_URL') ?: (string) ($chatbotConfig['api_url'] ?? '');
            $model = getenv('CHATBOT_MODEL') ?: (string) ($chatbotConfig['model'] ?? 'gpt-4o-mini');
            $enabled = filter_var(getenv('CHATBOT_ENABLED') ?: (string) ($chatbotConfig['enabled'] ?? 'false'), FILTER_VALIDATE_BOOLEAN);

            $reply = null;
            $source = 'local';
            if ($enabled && $apiKey !== '' && $apiUrl !== '') {
                $reply = chatbot_call_api($message, $apiKey, $apiUrl, $model);
                if ($reply !== null && trim($reply) !== '') {
                    $source = 'api';
                }
            }

            if ($reply === null || trim($reply) === '') {
                $reply = chatbot_build_fallback_reply($message);
            }

            $ctrl->json(['ok' => true, 'reply' => $reply, 'source' => $source], 200);
            break;

        default:
            $ctrl->json(['ok' => false, 'loi' => 'Khong ro act', 'act' => $act], 400);
    }
} catch (InvalidArgumentException | TypeError $e) {
    $ctrl->json(['ok' => false, 'loi' => 'Du lieu gui len khong hop le'], 400);
} catch (Throwable $e) {
    error_log('Controller User: ' . $e->getMessage());
    $ctrl->json(['ok' => false, 'loi' => 'Khong the xu ly yeu cau. Vui long kiem tra ket noi CSDL.'], 500);
}
