<?php
// Tự động nhận diện đường dẫn ảnh
if (!isset($img_path)) {
    if (file_exists('view/image/iphone 15 pro max.jpeg')) {
        $img_path = 'view/image/';
    } elseif (file_exists('../view/image/iphone 15 pro max.jpeg')) {
        $img_path = '../view/image/';
    } else {
        $img_path = 'view/image/';
    }
}

// Tính tổng tiền giỏ hàng
$cart_items = [];
$tam_tinh = 0;
if (isset($giohang['items']) && is_array($giohang['items'])) {
    foreach ($giohang['items'] as $it) {
        $cart_items[] = [
            $it['id'],
            $it['ten_sp'],
            $it['gia'],
            $it['so_luong'],
            $it['hinh'] ?: 'iphone 15 pro max.jpeg'
        ];
        $tam_tinh += ($it['gia'] * $it['so_luong']);
    }
} elseif (isset($_SESSION['giohang']) && is_array($_SESSION['giohang'])) {
    foreach ($_SESSION['giohang'] as $k => $sp) {
        if (is_array($sp)) {
            $cart_items[] = $sp;
            $tam_tinh += ((float)$sp[2] * (int)$sp[3]);
        } elseif (is_numeric($sp) && class_exists('sanpham')) {
            $spInfo = (new sanpham())->layChiTiet((int)$k);
            if ($spInfo) {
                $cart_items[] = [$spInfo['id'], $spInfo['ten_sp'], (float)$spInfo['gia'], (int)$sp, $spInfo['hinh'] ?: 'iphone 15 pro max.jpeg'];
                $tam_tinh += ((float)$spInfo['gia'] * (int)$sp);
            }
        }
    }
}
$phi_ship = ($tam_tinh > 0) ? (isset($user['hang']) && in_array($user['hang'], ['Gold', 'Diamond']) ? 0 : 30000) : 0;
?>

<div class="container my-5">
    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
        <h2 class="fw-bold text-primary mb-0">
            <i class="fas fa-credit-card me-2"></i> Thanh Toán & Đặt Hàng [U6]
        </h2>
        <a href="index.php?act=giohang" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="fas fa-arrow-left me-1"></i> Quay lại giỏ hàng
        </a>
    </div>

    <?php if ((isset($ok) && $ok) || isset($_GET['success'])): ?>
        <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white border-blue">
            <div class="display-3 text-success mb-3"><i class="fas fa-check-circle"></i></div>
            <h3 class="fw-bold text-success">Đặt Hàng Thành Công!</h3>
            <p class="text-secondary fs-5">Mã đơn hàng: <strong class="text-dark">#DH-<?=isset($id_don) ? $id_don : strtoupper(substr(md5(time()), 0, 8))?></strong></p>
            <div class="alert alert-info rounded-3 text-start mx-auto p-4 small" style="max-width: 600px;">
                <p class="mb-2"><strong><i class="fas fa-shield-alt text-primary"></i> Quy trình hệ thống đã tự động thực hiện [12/5] [19/5]:</strong></p>
                <ul class="mb-0 ps-3 text-muted lh-lg">
                    <li>Trạng thái đơn hàng mặc định: <span class="badge bg-warning text-dark">Chờ xác nhận</span></li>
                    <li>Đã tự động trừ số lượng sản phẩm tồn kho trong hệ thống [19/5].</li>
                    <li>Đã xóa sạch giỏ hàng trong Session (unset giỏ hàng) [19/5].</li>
                    <li>Đã gửi email tự động qua Gmail SMTP xác nhận đơn và lưu vào <a href="index.php?act=hopthu" class="text-primary fw-bold">Hộp thư cá nhân [U9]</a> [9/6].</li>
                </ul>
            </div>
            <div class="d-flex justify-content-center gap-3 mt-4">
                <a href="index.php?act=theodoidonhang" class="btn btn-primary rounded-pill px-4 py-2 fw-bold">
                    <i class="fas fa-shipping-fast me-1"></i> Theo dõi tiến trình đơn hàng [U8]
                </a>
                <a href="index.php?act=trangchu" class="btn btn-outline-primary rounded-pill px-4 py-2">
                    <i class="fas fa-home me-1"></i> Về Trang Chủ
                </a>
            </div>
        </div>
    <?php else: ?>

        <form action="index.php?act=thanhtoan" method="POST" id="checkoutForm">
            <div class="row g-4">
                
                <!-- Cột Trái: Thông tin giao hàng & Phương thức thanh toán -->
                <div class="col-12 col-lg-7">
                    <!-- 1. Thông tin giao hàng -->
                    <div class="bg-white p-4 rounded-4 shadow-sm mb-4 border-0">
                        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">
                            <i class="fas fa-map-marker-alt text-danger me-2"></i> 1. Thông Tin Nhận Hàng
                        </h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Họ và tên người nhận <span class="text-danger">*</span></label>
                                <input type="text" name="hoten" class="form-control rounded-3" value="<?=$_SESSION['user']['hoten'] ?? 'Nguyễn Văn A'?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Số điện thoại liên hệ <span class="text-danger">*</span></label>
                                <input type="tel" name="sdt" class="form-control rounded-3" value="<?=$_SESSION['user']['sdt'] ?? '0901234567'?>" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-semibold">Địa chỉ Email nhận hóa đơn & thông báo SMTP <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control rounded-3" value="<?=$_SESSION['user']['email'] ?? 'khachhang@example.com'?>" required>
                                <small class="text-muted">Hệ thống sẽ gửi hóa đơn điện tử và mã vận đơn qua email này [12/5].</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Tỉnh / Thành phố <span class="text-danger">*</span></label>
                                <select class="form-select rounded-3" required>
                                    <option value="HCM" selected>TP. Hồ Chí Minh</option>
                                    <option value="HN">Hà Nội</option>
                                    <option value="DN">Đà Nẵng</option>
                                    <option value="BD">Bình Dương</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Quận / Huyện <span class="text-danger">*</span></label>
                                <input type="text" name="quan_huyen" class="form-control rounded-3" placeholder="Quận 1, Quận Gò Vấp..." value="Quận 1" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-semibold">Địa chỉ chi tiết (Số nhà, tên đường, phường) <span class="text-danger">*</span></label>
                                <input type="text" name="diachi" class="form-control rounded-3" placeholder="Số 123 Đường Nguyễn Huệ, Phường Bến Nghé" value="624 Âu Cơ, P.10, Q. Tân Bình" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-semibold">Ghi chú giao hàng</label>
                                <textarea name="ghichu" class="form-control rounded-3" rows="2" placeholder="Ví dụ: Giao giờ hành chính, gọi trước khi đến..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Phương thức thanh toán -->
                    <div class="bg-white p-4 rounded-4 shadow-sm border-0">
                        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">
                            <i class="fas fa-wallet text-primary me-2"></i> 2. Phương Thức Thanh Toán
                        </h5>

                        <div class="d-flex flex-column gap-3">
                            <div class="border rounded-3 p-3 d-flex align-items-center justify-content-between">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="payCOD" value="COD" checked>
                                    <label class="form-check-label fw-semibold" for="payCOD">
                                        <i class="fas fa-money-bill-wave text-success me-2 fs-5"></i> Thanh toán tiền mặt khi nhận hàng (COD)
                                        <div class="small text-muted fw-normal">Kiểm tra sản phẩm trước khi thanh toán cho shipper.</div>
                                    </label>
                                </div>
                                <span class="badge bg-success-subtle text-success">Khuyên dùng</span>
                            </div>

                            <div class="border rounded-3 p-3">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="payment_method" id="payVietQR" value="VietQR">
                                    <label class="form-check-label fw-semibold" for="payVietQR">
                                        <i class="fas fa-qrcode text-primary me-2 fs-5"></i> Chuyển khoản nhanh qua VietQR (Quét mã miễn phí)
                                        <div class="small text-muted fw-normal">Tự động xác nhận giao dịch trong 30 giây qua ngân hàng.</div>
                                    </label>
                                </div>
                                <!-- Demo box VietQR -->
                                <div class="alert alert-light border small text-center mt-2 d-none" id="qrDemoBox">
                                    <div class="fw-bold text-primary mb-1">Mã QR VietQR Thanh Toán Ngân Hàng:</div>
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=WEBBANDT_THANHTOAN" class="img-thumbnail" alt="QR VietQR">
                                    <div class="mt-2 text-muted">Nội dung CK: <strong class="text-danger">WEBBANDT 0901234567</strong></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cột Phải: Áp Voucher & Tóm tắt đơn hàng -->
                <div class="col-12 col-lg-5">
                    
                    <!-- 3. Khu vực Áp Voucher [12/5] [17/6] -->
                    <div class="bg-white p-4 rounded-4 shadow-sm mb-4 border-0">
                        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">
                            <i class="fas fa-tags text-warning me-2"></i> 3. Áp Dụng Mã Giảm Giá (Voucher)
                        </h5>

                        <div class="input-group mb-2">
                            <input type="text" id="voucherInput" name="ma_voucher" class="form-control rounded-start-pill text-uppercase" placeholder="Nhập mã: CHAOBAN, FREESHIP..." value="CHAOBAN">
                            <button type="button" class="btn btn-primary rounded-end-pill px-3 fw-bold" onclick="applyVoucher()">
                                Áp dụng
                            </button>
                        </div>
                        <div id="voucherMsg" class="small text-success fw-bold mb-3">
                            <i class="fas fa-check-circle"></i> Đã kích hoạt mã CHAOBAN: Giảm ngay 500.000đ!
                        </div>

                        <!-- Danh sách voucher gợi ý theo hạng khách [17/6] -->
                        <div class="bg-light p-3 rounded-3 small">
                            <div class="fw-bold text-secondary mb-2">Mã voucher khả dụng cho bạn:</div>
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                <div>
                                    <span class="badge bg-primary">CHAOBAN</span>
                                    <span class="text-dark fw-bold ms-1">Giảm 500.000đ</span>
                                    <div class="text-muted" style="font-size: 0.75rem;">Mọi hạng khách hàng [12/5]</div>
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill py-0 px-2" onclick="setVoucher('CHAOBAN')">Dùng</button>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-success">FREESHIP</span>
                                    <span class="text-dark fw-bold ms-1">Miễn phí ship</span>
                                    <div class="text-muted" style="font-size: 0.75rem;">Dành riêng hạng Silver trở lên [17/6]</div>
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill py-0 px-2" onclick="setVoucher('FREESHIP')">Dùng</button>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Tóm tắt Đơn Hàng -->
                    <div class="bg-white p-4 rounded-4 shadow-sm border-0 border-blue">
                        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">
                            <i class="fas fa-clipboard-list text-primary me-2"></i> 4. Đơn Hàng Của Bạn
                        </h5>

                        <div class="order-items-list mb-3" style="max-height: 240px; overflow-y: auto;">
                            <?php if (!empty($cart_items)): ?>
                                <?php foreach ($cart_items as $sp): ?>
                                    <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="<?=$img_path . ($sp[4] ?? 'iphone 15 pro max.jpeg')?>" alt="<?=$sp[1]?>" style="width: 40px; height: 40px; object-fit: contain;" class="rounded border">
                                            <div>
                                                <div class="small fw-semibold text-truncate" style="max-width: 180px;"><?=$sp[1]?></div>
                                                <div class="small text-muted">Số lượng: <strong><?=$sp[3]?></strong> × <?=number_format($sp[2], 0, ',', '.')?>đ</div>
                                            </div>
                                        </div>
                                        <div class="fw-bold small text-dark">
                                            <?=number_format($sp[2] * $sp[3], 0, ',', '.')?>đ
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center py-3 text-muted small">Chưa có sản phẩm trong giỏ hàng.</div>
                            <?php endif; ?>
                        </div>

                        <!-- Bảng tính tiền -->
                        <div class="lh-lg small">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Tạm tính giỏ hàng:</span>
                                <span class="fw-semibold" id="valTamTinh"><?=number_format($tam_tinh, 0, ',', '.')?>đ</span>
                            </div>
                            <div class="d-flex justify-content-between text-success">
                                <span>Giảm giá Voucher:</span>
                                <span class="fw-bold" id="valGiamGia">-500.000đ</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Phí giao hàng:</span>
                                <span class="fw-semibold" id="valShip"><?=number_format($phi_ship, 0, ',', '.')?>đ</span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between fs-5 fw-bold text-danger">
                                <span>Tổng thanh toán:</span>
                                <span id="valTongTien"><?=number_format(max(0, $tam_tinh - 500000 + $phi_ship), 0, ',', '.')?>đ</span>
                            </div>
                        </div>

                        <!-- Nút Xác Nhận Đặt Hàng -->
                        <div class="mt-4">
                            <button type="submit" name="btn_dathang" class="btn btn-danger btn-lg w-100 rounded-pill fw-bold shadow py-3">
                                <i class="fas fa-check-circle me-1"></i> XÁC NHẬN ĐẶT HÀNG (TRỪ TỒN KHO)
                            </button>
                            <div class="text-center mt-2 small text-muted">
                                <i class="fas fa-lock me-1"></i> Thông tin được mã hóa bảo mật tuyệt đối.
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </form>

    <?php endif; ?>
</div>

<script>
// Toggle QR box when VietQR is selected
document.querySelectorAll('input[name="payment_method"]').forEach(r => {
    r.addEventListener('change', function() {
        const qrBox = document.getElementById('qrDemoBox');
        if (qrBox) {
            qrBox.classList.toggle('d-none', this.value !== 'VietQR');
        }
    });
});

let currentTamTinh = <?=$tam_tinh?>;
let currentShip = <?=$phi_ship?>;
let currentDiscount = 500000;

function setVoucher(code) {
    document.getElementById('voucherInput').value = code;
    applyVoucher();
}

function applyVoucher() {
    const code = document.getElementById('voucherInput').value.trim().toUpperCase();
    const msg = document.getElementById('voucherMsg');
    const giamEl = document.getElementById('valGiamGia');
    const shipEl = document.getElementById('valShip');
    const tongEl = document.getElementById('valTongTien');

    if (code === 'CHAOBAN') {
        currentDiscount = 500000;
        msg.className = 'small text-success fw-bold mb-3';
        msg.innerHTML = '<i class="fas fa-check-circle"></i> Đã áp dụng mã CHAOBAN: Giảm ngay 500.000đ!';
        giamEl.textContent = '-500.000đ';
    } else if (code === 'FREESHIP') {
        currentDiscount = 0;
        currentShip = 0;
        msg.className = 'small text-success fw-bold mb-3';
        msg.innerHTML = '<i class="fas fa-check-circle"></i> Đã áp dụng FREESHIP (Hạng Silver): Miễn phí 50.000đ ship!';
        giamEl.textContent = '-0đ';
        shipEl.textContent = '0đ (Miễn phí)';
    } else if (code === 'VIPGOLD') {
        currentDiscount = 1000000;
        msg.className = 'small text-success fw-bold mb-3';
        msg.innerHTML = '<i class="fas fa-check-circle"></i> Đã áp dụng VIPGOLD: Giảm ngay 1.000.000đ!';
        giamEl.textContent = '-1.000.000đ';
    } else {
        msg.className = 'small text-danger fw-bold mb-3';
        msg.innerHTML = '<i class="fas fa-times-circle"></i> Mã voucher không hợp lệ hoặc đã hết hạn!';
        return;
    }

    let finalTotal = Math.max(0, currentTamTinh - currentDiscount + currentShip);
    tongEl.textContent = new Intl.NumberFormat('vi-VN').format(finalTotal) + 'đ';
}
</script>

