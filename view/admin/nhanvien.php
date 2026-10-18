<?php
include "header_admin.php";
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">
                <i class="fas fa-user-tie text-primary me-2"></i> [A2] Quản Lý Nhân Viên
            </h3>
            <p class="text-muted small mb-0">Thêm nhân viên mới, phân quyền và Khóa/Mở khóa tài khoản (Không xóa để giữ lịch sử) [12/5]</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#modalThemNV">
            <i class="fas fa-user-plus me-1"></i> Thêm Nhân Viên Mới
        </button>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'lock_success'): ?>
        <div class="alert alert-warning alert-dismissible fade show rounded-3 small" role="alert">
            <i class="fas fa-user-lock me-1"></i> <strong>ĐÃ ĐỔI TRẠNG THÁI KHÓA/MỞ KHÓA TÀI KHOẢN [12/5]!</strong> Nhân viên bị khóa sẽ không thể đăng nhập vào hệ thống quản trị [A0].
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Bảng Danh Sách Nhân Viên -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-white py-3 px-4">
            <h5 class="mb-0 fw-bold text-dark">Danh Sách Nhân Viên Hệ Thống</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="table-light small fw-bold text-uppercase">
                    <tr>
                        <th>STT</th>
                        <th>Mã NV</th>
                        <th class="text-start">Họ Và Tên</th>
                        <th>Chức Vụ</th>
                        <th>Email</th>
                        <th>Số Điện Thoại</th>
                        <th>Trạng Thái [12/5]</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody class="small">
                    <!-- NV 1: Admin Tổng -->
                    <tr>
                        <td class="fw-bold">1</td>
                        <td><code>NV-ADMIN</code></td>
                        <td class="text-start fw-bold">Trần Quản Trị</td>
                        <td><span class="badge bg-danger">Quản Trị Viên (Super Admin)</span></td>
                        <td>admin@dienthoaiz.vn</td>
                        <td>0909.111.222</td>
                        <td><span class="badge bg-success">Đang hoạt động</span></td>
                        <td>
                            <button class="btn btn-secondary btn-sm rounded-pill px-3 py-1 disabled" title="Không thể khóa Super Admin">
                                <i class="fas fa-lock"></i> Khóa
                            </button>
                        </td>
                    </tr>

                    <!-- NV 2: Nhân viên kinh doanh (Hoạt động) -->
                    <tr>
                        <td class="fw-bold">2</td>
                        <td><code>NV002</code></td>
                        <td class="text-start fw-bold">Lê Văn Hùng</td>
                        <td><span class="badge bg-primary">Nhân Viên Bán Hàng</span></td>
                        <td>hung.le@dienthoaiz.vn</td>
                        <td>0912.333.444</td>
                        <td><span class="badge bg-success">Đang hoạt động</span></td>
                        <td>
                            <!-- Nút Khóa tài khoản [12/5] -->
                            <a href="index.php?act=khoanhanvien&id=2&status=lock" class="btn btn-outline-danger btn-sm rounded-pill px-3 py-1" onclick="return confirm('Bạn có chắc muốn KHÓA tài khoản nhân viên này?');">
                                <i class="fas fa-lock me-1"></i> Khóa tài khoản
                            </a>
                        </td>
                    </tr>

                    <!-- NV 3: Nhân viên đã bị khóa [12/5] -->
                    <tr class="table-danger-subtle">
                        <td class="fw-bold">3</td>
                        <td><code>NV003</code></td>
                        <td class="text-start fw-bold text-muted">Nguyễn Thị Mai</td>
                        <td><span class="badge bg-secondary">Nhân Viên Kho</span></td>
                        <td class="text-muted">mai.nguyen@dienthoaiz.vn</td>
                        <td>0934.555.666</td>
                        <td><span class="badge bg-danger"><i class="fas fa-ban me-1"></i> Đã bị khóa [12/5]</span></td>
                        <td>
                            <!-- Nút Mở khóa tài khoản [12/5] -->
                            <a href="index.php?act=khoanhanvien&id=3&status=unlock" class="btn btn-outline-success btn-sm rounded-pill px-3 py-1">
                                <i class="fas fa-unlock me-1"></i> Mở khóa
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-light p-3 small text-muted">
            <i class="fas fa-info-circle text-primary me-1"></i> <strong>Chính sách hệ thống [12/5]:</strong> Nghiêm cấm xóa nhân viên để bảo toàn tính toàn vẹn dữ liệu và lịch sử các đơn hàng/sản phẩm đã lập. Chỉ sử dụng tính năng <strong>Khóa tài khoản</strong>.
        </div>
    </div>
</div>

<!-- MODAL THÊM NHÂN VIÊN MỚI [W] -->
<div class="modal fade" id="modalThemNV" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-primary text-white rounded-top-4">
                <h5 class="modal-title fw-bold"><i class="fas fa-user-plus me-2"></i> Thêm Nhân Viên Mới [W]</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?act=themnhanvien" method="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Mã Nhân Viên <span class="text-danger">*</span></label>
                        <input type="text" name="ma_nv" class="form-control" placeholder="NV004" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Họ và Tên Nhân Viên <span class="text-danger">*</span></label>
                        <input type="text" name="hoten" class="form-control" placeholder="Phạm Nhật Minh" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Chức Vụ</label>
                        <select name="chucvu" class="form-select">
                            <option value="Bán hàng">Nhân viên Bán hàng</option>
                            <option value="Thủ kho">Nhân viên Quản lý Kho</option>
                            <option value="CSKH">Nhân viên Chăm sóc khách hàng</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="minh.pham@dienthoaiz.vn" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Số Điện Thoại</label>
                        <input type="tel" name="sdt" class="form-control" placeholder="0987654321" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Mật Khẩu Khởi Tạo</label>
                        <input type="password" name="password" class="form-control" value="123456" required>
                    </div>
                </div>
                <div class="modal-footer bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Tạo Tài Khoản</button>
                </div>
            </form>
        </div>
    </div>
</div>

        </div>
    </main>
</body>
</html>

