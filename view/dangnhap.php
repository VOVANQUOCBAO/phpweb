<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-7 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden border-blue">
                <div class="card-header bg-primary text-white text-center py-4">
                    <div class="display-6 mb-1"><i class="fas fa-sign-in-alt"></i></div>
                    <h4 class="fw-bold mb-0 text-uppercase">Đăng Nhập Khách Hàng [U2]</h4>
                    <p class="small opacity-75 mb-0">Chào mừng bạn quay lại với ĐiệnThoạiZ</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    
                    <!-- Thông báo lỗi tài khoản bị khóa [12/5] -->
                    <?php if (isset($_GET['error']) && $_GET['error'] == 'locked'): ?>
                        <div class="alert alert-danger rounded-3 small d-flex align-items-center gap-2">
                            <i class="fas fa-ban fs-4"></i>
                            <div>
                                <strong>Tài khoản đã bị tạm khóa! [12/5]</strong><br>
                                Tài khoản của bạn đã bị quản trị viên khóa do vi phạm chính sách hoặc bom hàng/trả hàng. Vui lòng liên hệ hotline 1800.6868.
                            </div>
                        </div>
                    <?php elseif (!empty($loi)): ?>
                        <div class="alert alert-danger rounded-3 small">
                            <i class="fas fa-exclamation-circle me-1"></i> <?=htmlspecialchars((string) $loi, ENT_QUOTES, 'UTF-8')?>
                        </div>
                    <?php endif; ?>

                    <!-- Form Đăng nhập -->
                    <form action="index.php?act=dangnhap" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-user text-muted"></i></span>
                                <input type="email" name="email" class="form-control" placeholder="email@example.com" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <label class="form-label fw-semibold small">Mật khẩu</label>
                                <a href="#" class="small text-decoration-none text-muted">Quên mật khẩu?</a>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-lock text-muted"></i></span>
                                <input type="password" name="mat_khau" class="form-control" placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMe">
                            <label class="form-check-label small text-muted" for="rememberMe">Ghi nhớ đăng nhập</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow">
                            <i class="fas fa-arrow-right-to-bracket me-1"></i> ĐĂNG NHẬP
                        </button>
                    </form>

                    <!-- Lưu ý chính sách bảo mật & giỏ hàng theo Lab [19/5] -->
                    <div class="mt-4 p-3 bg-light rounded-3 small text-muted">
                        <i class="fas fa-info-circle text-primary me-1"></i> 
                        <strong>Lưu ý:</strong> Khi bạn thực hiện Đăng xuất, hệ thống sẽ tự động xóa sạch giỏ hàng hiện tại theo đúng quy định bảo mật [19/5].
                    </div>

                    <div class="text-center mt-4 small text-secondary">
                        Chưa có tài khoản? <a href="index.php?act=dangky" class="text-primary fw-bold text-decoration-none">Đăng ký thành viên mới</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
