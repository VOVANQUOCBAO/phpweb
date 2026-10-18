<?php
include "header_admin.php";
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">
                <i class="fas fa-percent text-danger me-2"></i> [A6] Quản Lý Khuyến Mãi & Hàng Cận Hạn, Bán Ế
            </h3>
            <p class="text-muted small mb-0">Tự động gợi ý sản phẩm bán ế đưa vào khuyến mãi [12/5] và áp dụng KM hàng loạt theo danh mục [17/6]</p>
        </div>
        <button class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalThemKM">
            <i class="fas fa-plus-circle me-1"></i> Tạo Đợt Khuyến Mãi Mới [W]
        </button>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'promo_applied'): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 small" role="alert">
            <i class="fas fa-check-circle me-1"></i> <strong>ĐÃ ÁP DỤNG KHUYẾN MÃI XẢ HÀNG THÀNH CÔNG! [12/5] [17/6]</strong> Các sản phẩm bán ế đã được cập nhật giá khuyến mãi hiển thị ra trang chủ.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- ========================================================
         PHẦN 1: DANH SÁCH GỢI Ý TỰ ĐỘNG: SẢN PHẨM BÁN Ế & TỒN LÂU [12/5] [17/6]
         ======================================================== -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 border-warning">
        <div class="card-header bg-warning py-3 px-4 d-flex justify-content-between align-items-center text-dark">
            <div>
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-robot me-2"></i> Hệ Thống Gợi Ý Tự Động: Sản Phẩm Bán Ế & Tồn Lâu [12/5] [17/6]
                </h5>
                <small class="text-muted">Thuật toán phân tích dựa trên: Ngày tạo kho &gt; 30 ngày nhưng số lượng bán ra &lt; 5 chiếc</small>
            </div>
            <span class="badge bg-danger fs-6">2 sản phẩm cần xả hàng</span>
        </div>

        <form action="index.php?act=themkhuyenmai" method="POST">
            <input type="hidden" name="type" value="xa_hang_e">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-light small fw-bold text-uppercase">
                        <tr>
                            <th style="width: 5%;">Chọn</th>
                            <th>Mã SP</th>
                            <th>Hình</th>
                            <th class="text-start">Tên Điện Thoại</th>
                            <th>Tồn Kho Hiện Tại</th>
                            <th>Đã Bán Ra</th>
                            <th>Giá Gốc</th>
                            <th>Đề Xuất Mức Giảm [12/5]</th>
                            <th>Trạng Thái Phân Tích</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        
                        <!-- SP Gợi ý 1: Xiaomi 14 tồn 78 chiếc, bán được 2 chiếc -->
                        <tr class="table-warning-subtle">
                            <td>
                                <input type="checkbox" name="sp_ids[]" value="3" class="form-check-input" checked>
                            </td>
                            <td><code>XM14</code></td>
                            <td><img src="../../view/image/Xiaomi 14 5G 256GB.jpg" style="width: 45px; height: 45px; object-fit: contain;" class="rounded border p-1"></td>
                            <td class="text-start fw-bold">Xiaomi 14 5G 256GB Ống Kính Leica</td>
                            <td><span class="badge bg-dark fs-6">78 chiếc</span></td>
                            <td><strong class="text-danger">2 chiếc (Rất chậm)</strong></td>
                            <td class="text-muted text-decoration-line-through">22.990.000đ</td>
                            <td>
                                <span class="badge bg-danger p-2 fs-6">Giảm -15% (Còn 19.540.000đ)</span>
                            </td>
                            <td><span class="badge badge-alert-yellow"><i class="fas fa-exclamation-triangle"></i> Tồn kho 65 ngày [12/5]</span></td>
                        </tr>

                        <!-- SP Gợi ý 2: iPhone 13 tồn 45 chiếc -->
                        <tr class="table-warning-subtle">
                            <td>
                                <input type="checkbox" name="sp_ids[]" value="5" class="form-check-input" checked>
                            </td>
                            <td><code>IP13-128</code></td>
                            <td><img src="../../view/image/iPhone 13 128GB.png" style="width: 45px; height: 45px; object-fit: contain;" class="rounded border p-1"></td>
                            <td class="text-start fw-bold">iPhone 13 128GB Xanh Midnight</td>
                            <td><span class="badge bg-dark fs-6">45 chiếc</span></td>
                            <td><strong class="text-warning">15 chiếc (Tồn vốn cao)</strong></td>
                            <td class="text-muted text-decoration-line-through">14.990.000đ</td>
                            <td>
                                <span class="badge bg-danger p-2 fs-6">Giảm -10% (Còn 13.490.000đ)</span>
                            </td>
                            <td><span class="badge badge-alert-yellow"><i class="fas fa-exclamation-triangle"></i> Cận vòng đời sản phẩm</span></td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-white p-3 d-flex justify-content-between align-items-center">
                <span class="small text-muted">Admin tích chọn các sản phẩm trên để áp dụng giá xả hàng ngay lập tức.</span>
                <button type="submit" class="btn btn-danger btn-sm rounded-pill px-4 fw-bold shadow">
                    <i class="fas fa-bolt me-1"></i> ÁP DỤNG ĐỢT KHUYẾN MÃI XẢ HÀNG Ế NGAY [12/5] [17/6]
                </button>
            </div>
        </form>
    </div>

    <!-- ========================================================
         PHẦN 2: DANH SÁCH CÁC ĐỢT KHUYẾN MÃI ĐANG HOẠT ĐỘNG
         ======================================================== -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-dark">Chương Trình Khuyến Mãi Đang Chạy</h5>
            <span class="badge bg-primary">2 chiến dịch</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="table-light small fw-bold text-uppercase">
                    <tr>
                        <th>STT</th>
                        <th class="text-start">Tên Chiến Dịch Khuyến Mãi</th>
                        <th>Hình Thức Áp Dụng</th>
                        <th>Mức Giảm</th>
                        <th>Thời Hạn Áp Dụng</th>
                        <th>Trạng Thái</th>
                    </tr>
                </thead>
                <tbody class="small">
                    <tr>
                        <td class="fw-bold">1</td>
                        <td class="text-start fw-bold text-primary">🔥 Siêu Sale Điện Thoại Mùa Thu 2026</td>
                        <!-- Áp dụng theo nhóm sản phẩm (Danh mục) [17/6] -->
                        <td><span class="badge bg-info text-dark">Hàng loạt theo Danh mục: Apple & Samsung [17/6]</span></td>
                        <td><span class="badge bg-danger fs-6">Giảm 15% - 20%</span></td>
                        <td>10/10/2026 - 31/10/2026</td>
                        <td><span class="badge bg-success">Đang diễn ra</span></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">2</td>
                        <td class="text-start fw-bold text-primary">⚡ Xả Kho Hàng Cận Hạn / Hàng Ế [12/5]</td>
                        <td><span class="badge bg-warning text-dark">Theo danh sách SP bán chậm</span></td>
                        <td><span class="badge bg-danger fs-6">Giảm trực tiếp 1.500.000đ</span></td>
                        <td>15/10/2026 - 25/10/2026</td>
                        <td><span class="badge bg-success">Đang diễn ra</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL TẠO KHUYẾN MÃI HÀNG LOẠT THEO DANH MỤC [17/6] -->
<div class="modal fade" id="modalThemKM" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-danger text-white rounded-top-4">
                <h5 class="modal-title fw-bold"><i class="fas fa-tags me-2"></i> Tạo Khuyến Mãi Hàng Loạt [17/6]</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?act=themkhuyenmai" method="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Tên Chương Trình Khuyến Mãi <span class="text-danger">*</span></label>
                        <input type="text" name="ten_km" class="form-control" placeholder="Flash Sale Cuối Tuần" required>
                    </div>

                    <!-- Áp dụng hàng loạt theo Danh mục [17/6] -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Áp dụng cho Nhóm Sản Phẩm (Danh mục) [17/6]:</label>
                        <select name="id_danhmuc" class="form-select">
                            <option value="all">Toàn bộ tất cả sản phẩm</option>
                            <option value="1">Toàn bộ dòng Apple (iPhone)</option>
                            <option value="2">Toàn bộ dòng Samsung Galaxy</option>
                            <option value="3">Toàn bộ dòng Xiaomi</option>
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Phần trăm giảm (%)</label>
                            <input type="number" name="phan_tram_giam" class="form-control" placeholder="10" min="1" max="90" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Gán Badge nổi bật</label>
                            <select name="badge" class="form-select">
                                <option value="-10%">-10%</option>
                                <option value="-15%">-15%</option>
                                <option value="-20%">-20%</option>
                                <option value="Hot">Hot</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Ngày bắt đầu</label>
                            <input type="date" name="ngay_bat_dau" class="form-control" value="<?=date('Y-m-d')?>" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Ngày kết thúc</label>
                            <input type="date" name="ngay_ket_thuc" class="form-control" value="<?=date('Y-m-d', strtotime('+7 days'))?>" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">Kích Hoạt Khuyến Mãi</button>
                </div>
            </form>
        </div>
    </div>
</div>

        </div>
    </main>
</body>
</html>

