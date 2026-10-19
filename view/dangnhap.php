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

                    <!-- Nút Đăng nhập nhanh bằng Google như các trang web lớn -->
                    <div class="mb-4">
                        <button type="button" class="btn btn-outline-dark w-100 rounded-pill py-2 fw-semibold d-flex align-items-center justify-content-center gap-2 shadow-sm" onclick="showGoogleLoginModal()">
                            <svg width="20" height="20" viewBox="0 0 48 48">
                                <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                                <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                                <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                                <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                            </svg>
                            Tiếp tục với Google (Gmail)
                        </button>
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

<!-- Modal Đăng nhập / Đăng ký Google nhanh -->
<div class="modal fade" id="googleLoginModal" tabindex="-1" aria-labelledby="googleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="googleModalLabel">
                    <img src="https://www.gstatic.com/images/branding/googlelogo/svg/googlelogo_clr_74x24px.svg" height="24" alt="Google" class="me-2"> 
                    Đăng nhập bằng tài khoản Google
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted small">Nhập địa chỉ Gmail của bạn để đăng nhập hoặc tự động tạo tài khoản mới ngay lập tức:</p>
                <form action="index.php?act=google_login" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Địa chỉ Gmail</label>
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
                        <i class="fab fa-google me-1"></i> Xác Nhận Đăng Nhập Với Gmail
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function showGoogleLoginModal() {
    var myModal = new bootstrap.Modal(document.getElementById('googleLoginModal'));
    myModal.show();
}
</script>
