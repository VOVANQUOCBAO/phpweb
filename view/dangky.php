<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden border-blue">
                <div class="card-header bg-primary text-white text-center py-4">
                    <div class="display-6 mb-1"><i class="fas fa-user-plus"></i></div>
                    <h4 class="fw-bold mb-0 text-uppercase">Đăng Ký Tài Khoản [U1]</h4>
                    <p class="small opacity-75 mb-0">Nhận ngay ưu đãi thành viên & quà tặng sinh nhật</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    <?php if (isset($error_msg)): ?>
                        <div class="alert alert-danger rounded-3 small">
                            <i class="fas fa-exclamation-triangle me-1"></i> <?=$error_msg?>
                        </div>
                    <?php endif; ?>

                    <form action="index.php?act=dangky" method="POST">
                        <!-- Họ và tên -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Họ và tên của bạn <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-user text-muted"></i></span>
                                <input type="text" name="hoten" class="form-control" placeholder="Nguyễn Văn A" required>
                            </div>
                        </div>

                        <!-- Tên đăng nhập -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Tên đăng nhập <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-at text-muted"></i></span>
                                <input type="text" name="username" class="form-control" placeholder="nguyenvana" required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Địa chỉ Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-envelope text-muted"></i></span>
                                <input type="email" name="email" class="form-control" placeholder="email@example.com" required>
                            </div>
                        </div>

                        <!-- Ngày tháng năm sinh để nhận quà/voucher [17/6] -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">
                                <i class="fas fa-birthday-cake text-danger me-1"></i> Ngày sinh (Nhận quà tặng & Voucher sinh nhật) [17/6] <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-calendar-alt text-muted"></i></span>
                                <input type="date" name="ngaysinh" class="form-control" required>
                            </div>
                            <small class="text-muted">Hệ thống sẽ tự động gửi mã giảm giá chúc mừng sinh nhật vào hộp thư của bạn.</small>
                        </div>

                        <!-- Số điện thoại -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Số điện thoại nhận hàng <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-phone text-muted"></i></span>
                                <input type="tel" name="sdt" class="form-control" placeholder="0901234567" required>
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

                        <!-- Thông tin phân hạng mặc định [17/6] -->
                        <div class="alert alert-info rounded-3 p-3 small mb-4">
                            <div class="d-flex align-items-center gap-2 mb-1 fw-bold text-primary">
                                <i class="fas fa-medal fs-5"></i> Đặc quyền thành viên mới:
                            </div>
                            <div>Khởi tạo hạng mặc định: <strong>Silver (Bạc)</strong> | Điểm tích lũy ban đầu: <strong>0 điểm</strong>. Tích điểm nâng hạng Gold / Diamond để nhận voucher freeship trọn đời!</div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow">
                            <i class="fas fa-check-circle me-1"></i> HOÀN TẤT ĐĂNG KÝ
                        </button>
                    </form>

                    <div class="text-center mt-4 small text-secondary">
                        Đã có tài khoản? <a href="index.php?act=dangnhap" class="text-primary fw-bold text-decoration-none">Đăng nhập ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

