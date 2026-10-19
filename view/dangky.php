<?php
$isOtpPending = isset($_SESSION['dangky_pending']) && !empty($_SESSION['dangky_pending']['otp']);
$pendingEmail = $_SESSION['dangky_pending']['payload']['email'] ?? '';
$pendingName = $_SESSION['dangky_pending']['payload']['ho_ten'] ?? '';
?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden border-blue">
                <div class="card-header bg-primary text-white text-center py-4">
                    <div class="display-6 mb-1"><i class="fas fa-user-plus"></i></div>
                    <h4 class="fw-bold mb-0 text-uppercase">Đăng Ký Thành Viên ĐiệnThoạiZ</h4>
                    <p class="small opacity-75 mb-0">Hỗ trợ đăng ký bằng Gmail thật sự - Nhận ngay Voucher chào mừng</p>
                </div>

                <div class="card-body p-4 p-md-5">

                    <!-- Thông báo Thành công -->
                    <?php if (!empty($thongBao)): ?>
                        <div class="alert alert-success rounded-3 small d-flex align-items-center gap-2 shadow-sm mb-4">
                            <i class="fas fa-check-circle fs-4 text-success flex-shrink-0"></i>
                            <div><?=$thongBao?></div>
                        </div>
                    <?php endif; ?>

                    <!-- Thông báo Lỗi -->
                    <?php if (!empty($loi)): ?>
                        <div class="alert alert-danger rounded-3 small d-flex align-items-center gap-2 shadow-sm mb-4">
                            <i class="fas fa-exclamation-triangle fs-4 text-danger flex-shrink-0"></i>
                            <div><?=$loi?></div>
                        </div>
                    <?php elseif (isset($error_msg)): ?>
                        <div class="alert alert-danger rounded-3 small mb-4">
                            <i class="fas fa-exclamation-triangle me-1"></i> <?=$error_msg?>
                        </div>
                    <?php endif; ?>

                    <?php if ($isOtpPending): ?>
                        <!-- BƯỚC 2: XÁC THỰC MÃ OTP GỬI VỀ GMAIL THẬT -->
                        <div class="text-center mb-4">
                            <div class="badge bg-primary-subtle text-primary border border-primary px-3 py-2 rounded-pill mb-2">
                                <i class="fas fa-envelope-open-text me-1"></i> Bước 2: Nhập mã OTP
                            </div>
                            <h5 class="fw-bold text-dark mb-1">Xác Thực Địa Chỉ Gmail Của Bạn</h5>
                            <p class="small text-muted mb-0">
                                Mã 6 chữ số đã được gửi đến: <strong class="text-primary"><?=htmlspecialchars($pendingEmail)?></strong>
                            </p>
                        </div>

                        <form action="index.php?act=dangky" method="POST">
                            <input type="hidden" name="action" value="xacnhan_otp">
                            
                            <div class="mb-4">
                                <label class="form-label fw-semibold small text-center w-100">Nhập mã xác thực OTP (6 chữ số):</label>
                                <div class="d-flex justify-content-center">
                                    <input type="text" name="otp" class="form-control text-center fw-bold fs-4 tracking-widest text-primary border-2 border-primary rounded-3" style="max-width: 220px; letter-spacing: 6px;" placeholder="••••••" maxlength="6" pattern="[0-9]{6}" autofocus required>
                                </div>
                                <div class="text-center small text-muted mt-2">
                                    <i class="fas fa-clock me-1"></i> Mã có hiệu lực trong 15 phút. Kiểm tra cả mục Spam/Thư rác.
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow mb-3">
                                <i class="fas fa-check-circle me-1"></i> XÁC NHẬN VÀ KÍCH HOẠT TÀI KHOẢN
                            </button>
                        </form>

                        <div class="text-center">
                            <form action="index.php?act=dangky" method="POST" class="d-inline">
                                <input type="hidden" name="action" value="gui_otp">
                                <?php foreach ($_SESSION['dangky_pending']['payload'] as $k => $v): ?>
                                    <input type="hidden" name="<?=htmlspecialchars($k)?>" value="<?=htmlspecialchars($v)?>">
                                <?php endforeach; ?>
                                <button type="submit" class="btn btn-link text-decoration-none small text-muted p-0">
                                    <i class="fas fa-redo-alt me-1"></i> Chưa nhận được mã? Gửi lại mã OTP
                                </button>
                            </form>
                        </div>

                    <?php else: ?>
                        <!-- BƯỚC 1: ĐIỀN THÔNG TIN ĐĂNG KÝ HOẶC CHỌN GOOGLE -->

                        <!-- Nút Đăng ký nhanh với Google như website lớn -->
                        <div class="mb-4">
                            <button type="button" class="btn btn-outline-dark w-100 rounded-pill py-2 fw-semibold d-flex align-items-center justify-content-center gap-2 shadow-sm" onclick="showGoogleRegisterModal()">
                                <svg width="20" height="20" viewBox="0 0 48 48">
                                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                                    <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                                    <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                                    <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                                </svg>
                                Đăng ký nhanh bằng Google (Gmail)
                            </button>
                            <div class="position-relative text-center my-3">
                                <hr class="text-muted">
                                <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 small text-muted">hoặc đăng ký bằng biểu mẫu</span>
                            </div>
                        </div>

                        <form action="index.php?act=dangky" method="POST" id="formDangKy">
                            <!-- Họ và tên -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Họ và tên của bạn <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-user text-muted"></i></span>
                                    <input type="text" name="hoten" class="form-control" placeholder="Nguyễn Văn A" value="<?=htmlspecialchars($_POST['hoten'] ?? $_POST['ho_ten'] ?? '')?>" required>
                                </div>
                            </div>

                            <!-- Tên đăng nhập -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Tên đăng nhập <span class="text-muted fw-normal">(tuỳ chọn)</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-at text-muted"></i></span>
                                    <input type="text" name="username" class="form-control" placeholder="nguyenvana (dùng để đăng nhập thay email)" value="<?=htmlspecialchars($_POST['username'] ?? '')?>">
                                </div>
                            </div>

                            <!-- Địa chỉ Gmail thật -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="form-label fw-semibold small mb-1">
                                        <i class="fab fa-google text-danger me-1"></i> Địa chỉ Gmail chính chủ <span class="text-danger">*</span>
                                    </label>
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle small">Khuyên dùng Gmail</span>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" id="emailInput" class="form-control" placeholder="ten_cua_ban@gmail.com" value="<?=htmlspecialchars($_POST['email'] ?? '')?>" required>
                                </div>
                                <div class="form-text small text-muted">Hệ thống sẽ gửi mã xác thực OTP và quà tặng sinh nhật đến địa chỉ này.</div>
                            </div>

                            <!-- Ngày sinh -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">
                                    <i class="fas fa-birthday-cake text-danger me-1"></i> Ngày sinh (Nhận quà tặng & Voucher sinh nhật) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-calendar-alt text-muted"></i></span>
                                    <input type="date" name="ngaysinh" class="form-control" value="<?=htmlspecialchars($_POST['ngaysinh'] ?? $_POST['ngay_sinh'] ?? '')?>" required>
                                </div>
                            </div>

                            <!-- Số điện thoại -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Số điện thoại nhận hàng <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-phone text-muted"></i></span>
                                    <input type="tel" name="sdt" class="form-control" placeholder="0901234567" value="<?=htmlspecialchars($_POST['sdt'] ?? '')?>" required>
                                </div>
                            </div>

                            <!-- Mật khẩu -->
                            <div class="row g-2 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Mật khẩu <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Nhập lại mật khẩu <span class="text-danger">*</span></label>
                                    <input type="password" name="re_password" class="form-control" placeholder="••••••••" required>
                                </div>
                            </div>

                            <!-- Đặc quyền thành viên -->
                            <div class="alert alert-info rounded-3 p-3 small mb-4">
                                <div class="d-flex align-items-center gap-2 mb-1 fw-bold text-primary">
                                    <i class="fas fa-medal fs-5"></i> Đặc quyền thành viên mới:
                                </div>
                                <div>Khởi tạo hạng mặc định: <strong>Silver (Bạc)</strong> | Nhận ngay thông báo đơn hàng và mã giảm giá qua Gmail thật.</div>
                            </div>

                            <!-- Nút Đăng Ký Lưu Ngay Vào CSDL -->
                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" name="action" value="dangky" class="btn btn-primary rounded-pill py-3 fw-bold shadow fs-5">
                                    <i class="fas fa-user-plus me-2"></i> ĐĂNG KÝ VÀ LƯU VÀO CSDL
                                </button>
                            </div>

                            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                <span class="small text-muted"><i class="fab fa-google text-danger me-1"></i> Muốn xác thực hộp thư Gmail?</span>
                                <button type="submit" name="action" value="gui_otp" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                    <i class="fas fa-paper-plane me-1"></i> Gửi mã OTP về Gmail
                                </button>
                            </div>
                        </form>
                    <?php endif; ?>

                    <div class="text-center mt-4 small text-secondary">
                        Đã có tài khoản? <a href="index.php?act=dangnhap" class="text-primary fw-bold text-decoration-none">Đăng nhập ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Đăng Ký / Đăng Nhập Google Nhanh -->
<div class="modal fade" id="googleRegisterModal" tabindex="-1" aria-labelledby="googleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="googleModalLabel">
                    <img src="https://www.gstatic.com/images/branding/googlelogo/svg/googlelogo_clr_74x24px.svg" height="24" alt="Google" class="me-2"> 
                    Đăng ký bằng Google (Gmail)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted small">Nhập địa chỉ Gmail của bạn để tạo tài khoản ngay lập tức mà không cần điền nhiều thông tin:</p>
                <form action="index.php?act=google_login" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Địa chỉ Gmail thật</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fab fa-google text-danger"></i></span>
                            <input type="email" name="google_email" class="form-control" placeholder="ten_cua_ban@gmail.com" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Họ và tên của bạn</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-user text-muted"></i></span>
                            <input type="text" name="google_name" class="form-control" placeholder="Nguyễn Văn A" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-danger w-100 rounded-pill py-2 fw-bold">
                        <i class="fab fa-google me-1"></i> Hoàn Tất Đăng Ký Với Google
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function showGoogleRegisterModal() {
    var myModal = new bootstrap.Modal(document.getElementById('googleRegisterModal'));
    myModal.show();
}
</script>
