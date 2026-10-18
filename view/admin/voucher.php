<?php
include "header_admin.php";
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">
                <i class="fas fa-ticket-alt text-primary me-2"></i> [A5] Quản Lý Mã Giảm Giá (Voucher)
            </h3>
            <p class="text-muted small mb-0">Tạo mã giảm giá, giới hạn số lượng, thời hạn [12/5] và phân quyền theo hạng khách [17/6]</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#modalThemVoucher">
            <i class="fas fa-plus-circle me-1"></i> Tạo Voucher Mới [W]
        </button>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'add_success'): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 small" role="alert">
            <i class="fas fa-check-circle me-1"></i> Tạo mã Voucher mới thành công!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Bảng Danh Sách Voucher -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-dark">Danh Sách Mã Giảm Giá Hiện Hành</h5>
            <span class="badge bg-primary">4 mã voucher</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="table-light small fw-bold text-uppercase">
                    <tr>
                        <th>STT</th>
                        <th>Mã Code [12/5]</th>
                        <th>Loại Giảm</th>
                        <th>Mức Giảm</th>
                        <th>Đơn Tối Thiểu</th>
                        <th>Số Lượng (Đã Dùng / Tổng)</th>
                        <th>Thời Hạn (Từ - Đến) [12/5]</th>
                        <th>Hạng Khách Áp Dụng [17/6]</th>
                        <th>Trạng Thái</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody class="small">
                    
                    <!-- Voucher 1: CHAOBAN -->
                    <tr>
                        <td class="fw-bold">1</td>
                        <td><span class="badge bg-primary fs-6">CHAOBAN</span></td>
                        <td>Giảm tiền mặt</td>
                        <td class="fw-bold text-danger">500.000đ</td>
                        <td>10.000.000đ</td>
                        <td><span class="fw-bold text-dark">45</span> / 100</td>
                        <td>01/10/2026 - 31/10/2026</td>
                        <!-- Áp dụng mọi hạng -->
                        <td><span class="badge bg-secondary">Mọi hạng khách</span></td>
                        <td><span class="badge bg-success">Còn hiệu lực</span></td>
                        <td>
                            <a href="index.php?act=xoavoucher&id=1" class="btn btn-outline-danger btn-sm rounded-pill px-2 py-0" onclick="return confirm('Xóa mã voucher này?');">Xóa</a>
                        </td>
                    </tr>

                    <!-- Voucher 2: FREESHIP [17/6] -->
                    <tr>
                        <td class="fw-bold">2</td>
                        <td><span class="badge bg-success fs-6">FREESHIP</span></td>
                        <td>Miễn phí ship</td>
                        <td class="fw-bold text-success">50.000đ (100% Ship)</td>
                        <td>5.000.000đ</td>
                        <td><span class="fw-bold text-dark">120</span> / 500</td>
                        <td>01/01/2026 - 31/12/2026</td>
                        <!-- Gán riêng cho Silver trở lên [17/6] -->
                        <td><span class="badge bg-info text-dark fw-bold">Silver trở lên [17/6]</span></td>
                        <td><span class="badge bg-success">Còn hiệu lực</span></td>
                        <td>
                            <a href="index.php?act=xoavoucher&id=2" class="btn btn-outline-danger btn-sm rounded-pill px-2 py-0" onclick="return confirm('Xóa mã voucher này?');">Xóa</a>
                        </td>
                    </tr>

                    <!-- Voucher 3: VIPGOLD [17/6] -->
                    <tr>
                        <td class="fw-bold">3</td>
                        <td><span class="badge bg-warning text-dark fs-6">VIPGOLD</span></td>
                        <td>Giảm %</td>
                        <td class="fw-bold text-danger">10% (Tối đa 2.000.000đ)</td>
                        <td>20.000.000đ</td>
                        <td><span class="fw-bold text-dark">12</span> / 50</td>
                        <td>01/10/2026 - 30/11/2026</td>
                        <!-- Chỉ Gold hoặc Diamond [17/6] -->
                        <td><span class="badge bg-warning text-dark fw-bold">Chỉ Gold & Diamond [17/6]</span></td>
                        <td><span class="badge bg-success">Còn hiệu lực</span></td>
                        <td>
                            <a href="index.php?act=xoavoucher&id=3" class="btn btn-outline-danger btn-sm rounded-pill px-2 py-0" onclick="return confirm('Xóa mã voucher này?');">Xóa</a>
                        </td>
                    </tr>

                    <!-- Voucher 4: SINHNHAT2026 [17/6] -->
                    <tr>
                        <td class="fw-bold">4</td>
                        <td><span class="badge bg-danger fs-6">SINHNHAT2026</span></td>
                        <td>Quà Sinh Nhật</td>
                        <td class="fw-bold text-danger">1.000.000đ</td>
                        <td>15.000.000đ</td>
                        <td><span class="fw-bold text-dark">5</span> / 50</td>
                        <td>01/10/2026 - 31/10/2026</td>
                        <td><span class="badge bg-danger">Khách có sinh nhật [17/6]</span></td>
                        <td><span class="badge bg-success">Đang kích hoạt</span></td>
                        <td>
                            <a href="index.php?act=xoavoucher&id=4" class="btn btn-outline-danger btn-sm rounded-pill px-2 py-0">Xóa</a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL TẠO VOUCHER MỚI [W] [12/5] [17/6] -->
<div class="modal fade" id="modalThemVoucher" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-primary text-white rounded-top-4">
                <h5 class="modal-title fw-bold"><i class="fas fa-ticket-alt me-2"></i> Tạo Mã Voucher Mới [12/5]</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?act=themvoucher" method="POST">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold">Mã Code Voucher <span class="text-danger">*</span></label>
                            <input type="text" name="ma_code" class="form-control text-uppercase" placeholder="SALE2026" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold">Hình thức giảm</label>
                            <select name="loai_giam" class="form-select">
                                <option value="tien">Giảm số tiền cụ thể (VNĐ)</option>
                                <option value="phantram">Giảm theo phần trăm (%)</option>
                                <option value="freeship">Miễn phí giao hàng</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold">Giá trị giảm (VNĐ hoặc %)</label>
                            <input type="number" name="gia_tri" class="form-control" placeholder="500000" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold">Đơn hàng tối thiểu</label>
                            <input type="number" name="don_toi_thieu" class="form-control" placeholder="10000000" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold">Số lượng phát hành [12/5]</label>
                            <input type="number" name="so_luong" class="form-control" placeholder="100" min="1" required>
                        </div>
                        <!-- Tùy chọn gán cho hạng khách thân thiết [17/6] -->
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold">Hạng khách áp dụng [17/6]</label>
                            <select name="hang_ap_dung" class="form-select">
                                <option value="all">Tất cả khách hàng</option>
                                <option value="silver">Chỉ khách Silver trở lên</option>
                                <option value="gold">Chỉ khách Gold & Diamond</option>
                                <option value="diamond">Chỉ riêng Diamond (Kim Cương)</option>
                            </select>
                        </div>
                        <!-- Thời hạn sử dụng ngày bắt đầu - ngày kết thúc [12/5] -->
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold">Ngày Bắt Đầu [12/5]</label>
                            <input type="date" name="ngay_bat_dau" class="form-control" value="<?=date('Y-m-d')?>" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold">Ngày Kết Thúc [12/5]</label>
                            <input type="date" name="ngay_ket_thuc" class="form-control" value="<?=date('Y-m-d', strtotime('+30 days'))?>" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Lưu Voucher</button>
                </div>
            </form>
        </div>
    </div>
</div>

        </div>
    </main>
</body>
</html>

