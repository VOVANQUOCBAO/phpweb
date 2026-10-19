<?php
// Đường dẫn tương đối
$admin_base_url = file_exists('../css/theme.css') ? '../' : (file_exists('view/css/theme.css') ? 'view/' : '../../view/');
$admin_ctrl_url = 'index.php?khu=admin';
$user_home_url = 'index.php?act=trangchu';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập Quản Trị Hệ Thống - ĐiệnThoạiZ Admin [A0]</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?=$admin_base_url?>css/theme.css">
    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.1);
            background: #ffffff;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-7 col-lg-5">
                
                <div class="card login-card border-0">
                    <div class="card-header bg-dark text-white text-center py-4 border-0">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 55px; height: 55px;">
                            <i class="fas fa-shield-alt fs-3"></i>
                        </div>
                        <h4 class="fw-bold mb-0">CỔNG QUẢN TRỊ ADMIN</h4>
                        <small class="text-secondary">Dành riêng cho Nhân viên & Ban quản trị</small>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <?php if (!empty($thongBao)): ?>
                            <div class="alert alert-success rounded-3 small mb-4">
                                <i class="fas fa-check-circle me-1"></i> <?=$thongBao?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($loi)): ?>
                            <div class="alert alert-danger rounded-3 small mb-4">
                                <i class="fas fa-exclamation-triangle me-1"></i> <?=$loi?>
                            </div>
                        <?php elseif (isset($_GET['error']) && $_GET['error'] == 'locked'): ?>
                            <div class="alert alert-danger rounded-3 small d-flex align-items-center gap-2 mb-4">
                                <i class="fas fa-user-lock fs-4"></i>
                                <div>
                                    <strong>Tài khoản nhân viên đang bị KHÓA!</strong><br>
                                    Tài khoản của bạn đã bị vô hiệu hóa quyền truy cập hệ thống. Vui lòng liên hệ Admin cấp cao.
                                </div>
                            </div>
                        <?php endif; ?>

                        <form action="<?=$admin_ctrl_url?>&act=dangnhap" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-dark">Email hoặc tên đăng nhập</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-id-badge text-muted"></i></span>
                                    <input type="text" name="admin_user" class="form-control" placeholder="Nhập email hoặc tên đăng nhập" autocomplete="username" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold small text-dark">Mật khẩu</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-key text-muted"></i></span>
                                    <input type="password" name="admin_pass" class="form-control" placeholder="Nhập mật khẩu" autocomplete="current-password" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow">
                                <i class="fas fa-sign-in-alt me-1"></i> ĐĂNG NHẬP HỆ THỐNG
                            </button>
                        </form>

                        <div class="mt-4 pt-3 border-top text-center">
                            <a href="<?=$user_home_url?>" class="text-decoration-none small text-muted">
                                <i class="fas fa-arrow-left me-1"></i> Quay lại Cửa Hàng Khách Hàng
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
