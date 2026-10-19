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
                    <?php if (!empty($loi)): ?>
                        <div class="alert alert-danger rounded-3 small">
                            <i class="fas fa-exclamation-triangle me-1"></i> <?=htmlspecialchars((string) $loi, ENT_QUOTES, 'UTF-8')?>
                        </div>
                    <?php elseif (!empty($thongBao)): ?>
                        <div class="alert alert-success rounded-3 small"><?=htmlspecialchars((string) $thongBao, ENT_QUOTES, 'UTF-8')?></div>
                    <?php endif; ?>

                    <form action="index.php?act=dangky" method="POST">
                        <!-- Họ và tên -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Họ và tên của bạn <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-user text-muted"></i></span>
                                <input type="text" name="ho_ten" class="form-control" placeholder="Nguyễn Văn A" required>
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
                                <i class="fas fa-birthday-cake text-danger me-1"></i> Ngày sinh (không bắt buộc)
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-calendar-alt text-muted"></i></span>
                                <input type="date" name="ngay_sinh" class="form-control">
                            </div>
                            <small class="text-muted">Không bắt buộc. Có ngày sinh, bạn có thể nhận ưu đãi sinh nhật.</small>
                        </div>

                        <!-- Mật khẩu -->
                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" name="mat_khau" class="form-control" placeholder="••••••••" required>
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
