<?php
include "header_admin.php";
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">
                <i class="fas fa-star-half-alt text-warning me-2"></i> [A3] Quản Lý Bình Luận & Đánh Giá
            </h3>
            <p class="text-muted small mb-0">Xử lý “Đánh giá xấu thì khóa lại” [24/6]: Khóa ẩn bình luận hoặc Khóa tài khoản khách cố tình spam</p>
        </div>
        <div class="d-flex gap-2">
            <a href="index.php?act=danhgia&filter=bad" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                <i class="fas fa-filter me-1"></i> Lọc đánh giá xấu (1-2 sao) [24/6]
            </a>
            <a href="index.php?act=danhgia" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                Tất cả đánh giá
            </a>
        </div>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'lock_comment'): ?>
        <div class="alert alert-warning alert-dismissible fade show rounded-3 small" role="alert">
            <i class="fas fa-eye-slash me-1"></i> <strong>ĐÃ KHÓA BÌNH LUẬN XẤU [24/6]!</strong> Bình luận này đã được ẩn hoàn toàn khỏi trang chi tiết sản phẩm của khách hàng.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'lock_user'): ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-3 small" role="alert">
            <i class="fas fa-user-slash me-1"></i> <strong>ĐÃ KHÓA TÀI KHOẢN KHÁCH HÀNG SPAM [24/6]!</strong> Khách hàng này sẽ bị chặn đăng nhập và mua hàng.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Bảng Danh Sách Đánh Giá -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-dark">Toàn Bộ Bình Luận Của Khách Hàng [W]</h5>
            <span class="badge bg-primary">Tổng cộng: 4 đánh giá</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="table-light small fw-bold text-uppercase">
                    <tr>
                        <th>STT</th>
                        <th class="text-start">Khách Hàng</th>
                        <th class="text-start">Sản Phẩm</th>
                        <th>Chấm Sao</th>
                        <th class="text-start" style="width: 35%;">Nội Dung Bình Luận</th>
                        <th>Thời Gian</th>
                        <th>Trạng Thái</th>
                        <th>Hành Động [24/6]</th>
                    </tr>
                </thead>
                <tbody class="small">
                    
                    <!-- Đánh giá 1: Tốt -->
                    <tr>
                        <td class="fw-bold">1</td>
                        <td class="text-start">
                            <strong>Nguyễn Hoàng Quân</strong>
                            <div class="text-muted" style="font-size: 0.75rem;">quan.nguyen@email.com</div>
                        </td>
                        <td class="text-start fw-semibold text-primary">Samsung Galaxy S24 Ultra</td>
                        <td><span class="text-warning">⭐⭐⭐⭐⭐</span></td>
                        <td class="text-start">Máy mượt, chụp hình siêu nét. Giao hàng nhanh 1 tiếng!</td>
                        <td>18/10/2026</td>
                        <td><span class="badge bg-success">Hiển thị</span></td>
                        <td>
                            <a href="index.php?act=khoadanhgia&id=1&type=hide" class="btn btn-outline-secondary btn-sm py-0 px-2" title="Ẩn bình luận">Khóa ẩn</a>
                        </td>
                    </tr>

                    <!-- Đánh giá 2: Xấu / Spam -> Cần khóa [24/6] -->
                    <tr class="table-danger-subtle">
                        <td class="fw-bold">2</td>
                        <td class="text-start">
                            <strong class="text-danger">Trần Văn Phá Hoại</strong>
                            <div class="text-danger" style="font-size: 0.75rem;">Tài khoản nghi vấn spam</div>
                        </td>
                        <td class="text-start fw-semibold text-dark">iPhone 15 Pro Max</td>
                        <td><span class="text-danger fw-bold">⭐ (1 sao)</span></td>
                        <td class="text-start text-danger">
                            "Shop lừa đảo, hàng dỏm đừng ai mua, mua bên shop khác rẻ hơn gấp 10 lần blah blah..."
                        </td>
                        <td>17/10/2026</td>
                        <td><span class="badge bg-danger">Chưa khóa (Nguy hiểm)</span></td>
                        <td>
                            <div class="d-flex flex-column gap-1">
                                <!-- Khóa bình luận [24/6] -->
                                <a href="index.php?act=khoadanhgia&id=2&type=hide" class="btn btn-warning btn-sm py-0 px-2 fw-bold text-dark">
                                    <i class="fas fa-eye-slash"></i> Khóa bình luận [24/6]
                                </a>
                                <!-- Khóa tài khoản khách [24/6] -->
                                <a href="index.php?act=khoadanhgia&id=2&type=lock_user&user_id=8" class="btn btn-danger btn-sm py-0 px-2 fw-bold" onclick="return confirm('Bạn chắc chắn muốn KHÓA tài khoản khách này vì spam đánh giá xấu?')">
                                    <i class="fas fa-user-lock"></i> Khóa TK khách [24/6]
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Đánh giá 3: Đã bị Admin khóa [24/6] -->
                    <tr class="table-secondary">
                        <td class="fw-bold">3</td>
                        <td class="text-start text-muted">
                            <strong>Khách Ẩn Danh</strong>
                        </td>
                        <td class="text-start text-muted">Xiaomi 14 5G</td>
                        <td><span class="text-muted">⭐</span></td>
                        <td class="text-start text-muted"><em>[Bình luận đã bị ẩn khỏi trang chi tiết bởi quản trị viên]</em></td>
                        <td>15/10/2026</td>
                        <td><span class="badge bg-secondary"><i class="fas fa-lock me-1"></i> Đã khóa [24/6]</span></td>
                        <td>
                            <a href="index.php?act=khoadanhgia&id=3&type=unhide" class="btn btn-outline-success btn-sm py-0 px-2">Mở lại</a>
                        </td>
                    </tr>

                    <!-- Đánh giá 4: Tốt -->
                    <tr>
                        <td class="fw-bold">4</td>
                        <td class="text-start">
                            <strong>Trần Mai Anh</strong>
                        </td>
                        <td class="text-start fw-semibold text-primary">OPPO Reno11 F 5G</td>
                        <td><span class="text-warning">⭐⭐⭐⭐⭐</span></td>
                        <td class="text-start">Màu máy bên ngoài rất đẹp, camera chân dung xóa phông rất ảo. Rất hài lòng!</td>
                        <td>12/10/2026</td>
                        <td><span class="badge bg-success">Hiển thị</span></td>
                        <td>
                            <a href="index.php?act=khoadanhgia&id=4&type=hide" class="btn btn-outline-secondary btn-sm py-0 px-2">Khóa ẩn</a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <div class="card-footer bg-light p-3 small text-muted">
            <i class="fas fa-shield-alt text-primary me-1"></i> <strong>Quy tắc xử lý đánh giá xấu [24/6]:</strong> Khóa bình luận sẽ lập tức ẩn nội dung đó trên trang chi tiết sản phẩm của khách hàng (`chitiet_sanpham.php`). Nếu phát hiện khách cố tình spam tiêu cực, bấm <strong>Khóa TK khách</strong> để vô hiệu hóa toàn bộ quyền đăng nhập.
        </div>
    </div>
</div>

        </div>
    </main>
</body>
</html>

