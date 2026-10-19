<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-7 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden border-blue">
                <div class="card-header bg-primary text-white text-center py-4">
                    <div class="display-6 mb-1"><i class="fas fa-sign-in-alt"></i></div>
                    <h4 class="fw-bold mb-0 text-uppercase">Đăng Nhập Tài Khoản</h4>
                    <p class="small opacity-75 mb-0">Chào mừng bạn quay lại với ĐiệnThoạiZ</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    
                    <!-- Thông báo Thành công -->
                    <?php if (!empty($thongBao)): ?>
                        <div class="alert alert-success rounded-3 small d-flex align-items-center gap-2 shadow-sm">
                            <i class="fas fa-check-circle fs-4 text-success"></i>
                            <div><?=$thongBao?></div>
                        </div>
                    <?php endif; ?>

                    <!-- Thông báo Lỗi -->
                    <?php if (!empty($loi)): ?>
                        <div class="alert alert-danger rounded-3 small d-flex align-items-center gap-2 shadow-sm">
                            <i class="fas fa-exclamation-triangle fs-4 text-danger"></i>
                            <div><?=$loi?></div>
                        </div>
                    <?php elseif (isset($_GET['error']) && $_GET['error'] == 'locked'): ?>
                        <div class="alert alert-danger rounded-3 small d-flex align-items-center gap-2">
                            <i class="fas fa-ban fs-4"></i>
                            <div>
                                <strong>Tài khoản đã bị tạm khóa!</strong><br>
                                Tài khoản của bạn đã bị quản trị viên khóa do vi phạm chính sách hoặc bom hàng/trả hàng. Vui lòng liên hệ hotline 1800.6868.
                            </div>
                        </div>
                    <?php elseif (isset($error_msg)): ?>
                        <div class="alert alert-danger rounded-3 small">
                            <i class="fas fa-exclamation-circle me-1"></i> <?=$error_msg?>
                        </div>
                    <?php endif; ?>

                    <!-- Google Identity Services posts a signed ID token to the server. -->
                    <div class="mb-4">
                        <?php if (!empty($googleClientId)): ?>
                            <div id="g_id_onload"
                                 data-client_id="<?=htmlspecialchars($googleClientId, ENT_QUOTES, 'UTF-8')?>"
                                 data-context="signin"
                                 data-ux_mode="redirect"
                                 data-login_uri="<?=htmlspecialchars($googleLoginUri, ENT_QUOTES, 'UTF-8')?>"
                                 data-auto_prompt="false"></div>
                            <div class="g_id_signin" data-type="standard" data-shape="pill" data-theme="outline" data-text="continue_with" data-size="large" data-width="320"></div>
                            <script src="https://accounts.google.com/gsi/client" async defer></script>
                        <?php else: ?>
                            <div class="alert alert-secondary small mb-0">Đăng nhập Google chưa được cấu hình trên máy chủ.</div>
                        <?php endif; ?>
                        <div class="position-relative text-center my-3">
                            <hr class="text-muted">
                            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 small text-muted">hoặc đăng nhập bằng tài khoản</span>
                        </div>
                    </div>

                    <!-- Form Đăng nhập -->
                    <form action="index.php?act=dangnhap" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Tên đăng nhập hoặc Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-user text-muted"></i></span>
                                <input type="text" name="username" class="form-control" placeholder="Nhập email hoặc tên đăng nhập của bạn" value="<?=htmlspecialchars($_POST['username'] ?? $_POST['email'] ?? '')?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <label class="form-label fw-semibold small">Mật khẩu</label>
                                <a href="#" class="small text-decoration-none text-muted" onclick="alert('Vui lòng liên hệ hỗ trợ qua hotline 1800.6868 để lấy lại mật khẩu.')">Quên mật khẩu?</a>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-lock text-muted"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="••••••••" autocomplete="current-password" required>
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMe" checked>
                            <label class="form-check-label small text-muted" for="rememberMe">Ghi nhớ đăng nhập</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow">
                            <i class="fas fa-arrow-right-to-bracket me-1"></i> ĐĂNG NHẬP
                        </button>
                    </form>

                    <!-- Lưu ý chính sách bảo mật & giỏ hàng theo Lab [19/5] -->
                    <div class="mt-4 p-3 bg-light rounded-3 small text-muted">
                        <i class="fas fa-shield-alt text-success me-1"></i> 
                        <strong>Bảo mật:</strong> Thông tin tài khoản được bảo vệ và mã hóa an toàn theo tiêu chuẩn hệ thống.
                    </div>

                    <div class="text-center mt-4 small text-secondary">
                        Chưa có tài khoản? <a href="index.php?act=dangky" class="text-primary fw-bold text-decoration-none">Đăng ký thành viên bằng Gmail</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
