<?php
require_once __DIR__ . '/header_admin.php';
?>

<div class="container-fluid px-0">
    <!-- Tiêu đề trang -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">
                <i class="fas fa-key text-info me-2"></i> [A10] Đổi Mật Khẩu Quản Trị Viên (Admin)
            </h4>
            <p class="text-muted small mb-0">
                Quản lý bảo mật tài khoản admin, cập nhật mật khẩu đồng bộ trực tiếp vào cơ sở dữ liệu MySQL (CSDL).
            </p>
        </div>
        <div>
            <a href="<?=$admin_ctrl_url?>&act=sanpham" class="btn btn-outline-secondary btn-sm rounded-pill px-3 shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> Quay lại Bảng điều khiển
            </a>
        </div>
    </div>

    <!-- Thông báo thành công / lỗi -->
    <?php if (!empty($thongBao)): ?>
        <div class="alert alert-success rounded-4 d-flex align-items-center gap-2 shadow-sm mb-4">
            <i class="fas fa-check-circle fs-4 text-success flex-shrink-0"></i>
            <div>
                <strong>Thành công!</strong> <?=$thongBao?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($loi)): ?>
        <div class="alert alert-danger rounded-4 d-flex align-items-center gap-2 shadow-sm mb-4">
            <i class="fas fa-exclamation-triangle fs-4 text-danger flex-shrink-0"></i>
            <div>
                <strong>Lỗi:</strong> <?=$loi?>
            </div>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- Form đổi mật khẩu -->
        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="fw-bold text-dark mb-0">
                        <i class="fas fa-lock text-primary me-2"></i> Cập Nhật Mật Khẩu Mới
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form action="<?=$admin_ctrl_url?>&act=doimatkhau" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Tài khoản Quản Trị Đang Đăng Nhập</label>
                            <input type="text" class="form-control bg-light" value="<?=htmlspecialchars($_SESSION['admin']['ho_ten'] ?? $_SESSION['admin']['email'] ?? 'admin')?> (<?=htmlspecialchars($_SESSION['admin']['email'] ?? 'admin@local.test')?>)" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Mật khẩu mới <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-key text-muted"></i></span>
                                <input type="password" name="mat_khau_moi" id="matKhauMoi" class="form-control" placeholder="Nhập mật khẩu mới mong muốn (ví dụ: 123 hoặc mật khẩu bất kỳ)" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('matKhauMoi')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="form-text small text-muted">Hệ thống cho phép bạn đặt mật khẩu tùy ý (ví dụ: 123) và lưu chuẩn vào CSDL.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Nhập lại mật khẩu mới <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-check-double text-muted"></i></span>
                                <input type="password" name="xac_nhan_mat_khau" id="xacNhanMatKhau" class="form-control" placeholder="Nhập lại mật khẩu mới vừa nhập" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('xacNhanMatKhau')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm">
                                <i class="fas fa-save me-2"></i> Lưu Mật Khẩu Vào CSDL
                            </button>
                            <a href="<?=$admin_ctrl_url?>&act=sanpham" class="btn btn-light rounded-pill px-3 py-2 text-muted">
                                Hủy bỏ
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Hướng dẫn CSDL & phpMyAdmin -->
        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="fw-bold text-dark mb-0">
                        <i class="fas fa-database text-success me-2"></i> Thông Tin Lưu Trữ Trong CSDL
                    </h6>
                </div>
                <div class="card-body p-4">
                    <p class="small text-muted">
                        Tài khoản Quản Trị Viên được đồng bộ và lưu trữ ở 2 bảng dữ liệu trong CSDL <code>webbanhang_mvc</code>:
                    </p>

                    <div class="border rounded-3 p-3 mb-3 bg-light">
                        <div class="fw-bold text-dark small mb-1">
                            <i class="fas fa-table text-primary me-1"></i> Bảng <code>nhanvien</code>:
                        </div>
                        <ul class="small text-muted mb-0 ps-3">
                            <li>Cột <code>ho_ten</code>: <strong>admin</strong></li>
                            <li>Cột <code>email</code>: <strong>admin@local.test</strong></li>
                            <li>Cột <code>vai_tro</code>: <strong>Admin</strong></li>
                            <li>Cột <code>mat_khau</code>: Lưu mật khẩu (hỗ trợ hash bcrypt, MD5 hoặc chuỗi text thường nếu chỉnh tay trong phpMyAdmin)</li>
                        </ul>
                    </div>

                    <div class="border rounded-3 p-3 mb-3 bg-light">
                        <div class="fw-bold text-dark small mb-1">
                            <i class="fas fa-table text-primary me-1"></i> Bảng <code>khachhang</code>:
                        </div>
                        <ul class="small text-muted mb-0 ps-3">
                            <li>Cột <code>ten_dang_nhap</code>: <strong>admin</strong></li>
                            <li>Cột <code>email</code>: <strong>admin@local.test</strong></li>
                            <li>Cột <code>ho_ten</code>: <strong>Quản Trị Viên (Admin)</strong></li>
                            <li>Cột <code>hang</code>: <strong>Diamond</strong></li>
                        </ul>
                    </div>

                    <div class="alert alert-info rounded-3 small p-3 mb-0">
                        <i class="fas fa-info-circle me-1"></i> <strong>Lưu ý:</strong> Khi bạn sửa mật khẩu trực tiếp trong phpMyAdmin (ví dụ gõ chữ thường <code>123</code> vào cột <code>mat_khau</code>), hệ thống vẫn tự động nhận diện và cho phép đăng nhập bình thường!
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(id) {
    const el = document.getElementById(id);
    if (el) {
        el.type = el.type === 'password' ? 'text' : 'password';
    }
}
</script>

