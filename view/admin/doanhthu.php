<?php
include "header_admin.php";
$time_filter = $_GET['time'] ?? 'thang';
?>

<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h3 class="fw-bold text-dark mb-1">
                <i class="fas fa-chart-line text-success me-2"></i> [A8] Thống Kê Doanh Thu & Xếp Hạng Bán Chạy / Bán Ế
            </h3>
            <p class="text-muted small mb-0">Thống kê chuẩn [12/5]: <strong>Chỉ tính doanh thu từ các đơn hàng ở trạng thái “Thành công”</strong></p>
        </div>
        
        <!-- Bộ lọc thời gian: Tuần, Tháng, Năm [W] [12/5] -->
        <div class="btn-group shadow-sm rounded-pill p-1 bg-white border">
            <a href="index.php?act=doanhthu&time=tuan" class="btn btn-sm rounded-pill px-3 <?=$time_filter == 'tuan' ? 'btn-primary' : 'btn-light'?>">Theo Tuần</a>
            <a href="index.php?act=doanhthu&time=thang" class="btn btn-sm rounded-pill px-3 <?=$time_filter == 'thang' ? 'btn-primary' : 'btn-light'?>">Theo Tháng</a>
            <a href="index.php?act=doanhthu&time=nam" class="btn btn-sm rounded-pill px-3 <?=$time_filter == 'nam' ? 'btn-primary' : 'btn-light'?>">Theo Năm</a>
        </div>
    </div>

    <!-- 4 THẺ CHỈ SỐ KPI CHÍNH -->
    <div class="row g-3 mb-4">
        <!-- Doanh thu thực nhận -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white border-start border-4 border-success">
                <span class="small text-muted fw-bold text-uppercase">DOANH THU THỰC NHẬN [12/5]</span>
                <h3 class="fw-bold text-success mb-1 mt-2">458.750.000đ</h3>
                <small class="text-success"><i class="fas fa-check-double me-1"></i> 100% đơn giao thành công</small>
            </div>
        </div>
        <!-- Tổng đơn thành công -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white border-start border-4 border-primary">
                <span class="small text-muted fw-bold text-uppercase">ĐƠN HÀNG THÀNH CÔNG</span>
                <h3 class="fw-bold text-primary mb-1 mt-2">24 Đơn</h3>
                <small class="text-muted">Đã giao tận tay khách hàng</small>
            </div>
        </div>
        <!-- Giá trị trung bình đơn -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white border-start border-4 border-info">
                <span class="small text-muted fw-bold text-uppercase">GIÁ TRỊ TB / ĐƠN</span>
                <h3 class="fw-bold text-dark mb-1 mt-2">19.114.000đ</h3>
                <small class="text-info"><i class="fas fa-arrow-up me-1"></i> Tăng 12% so với kỳ trước</small>
            </div>
        </div>
        <!-- Tỷ lệ bom/hủy -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white border-start border-4 border-danger">
                <span class="small text-muted fw-bold text-uppercase">TỶ LỆ BOM / HỦY HÀNG [24/6]</span>
                <h3 class="fw-bold text-danger mb-1 mt-2">4.1%</h3>
                <small class="text-danger"><i class="fas fa-shield-alt me-1"></i> Đã đưa vào Blacklist xử lý</small>
            </div>
        </div>
    </div>

    <!-- BIỂU ĐỒ DOANH THU TRỰC QUAN -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white">
        <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-dark">
                <i class="fas fa-chart-bar text-primary me-2"></i> Biểu Đồ Doanh Thu (Đơn Hàng Thành Công [12/5])
            </h5>
            <span class="badge bg-success-subtle text-success border border-success">Kỳ báo cáo: <?=$time_filter == 'tuan' ? '7 Ngày Qua' : ($time_filter == 'thang' ? 'Tháng 10/2026' : 'Năm 2026')?></span>
        </div>
        <div class="card-body p-4">
            <!-- Biểu đồ cột CSS / Canvas mô phỏng trực quan -->
            <div class="d-flex align-items-end justify-content-between gap-2 pt-4 px-2" style="height: 240px; border-bottom: 2px solid #dee2e6;">
                <div class="d-flex flex-column align-items-center flex-fill" style="height: 100%;">
                    <span class="small text-muted mb-1" style="font-size: 0.7rem;">45Tr</span>
                    <div class="w-75 bg-primary rounded-top" style="height: 45%; transition: height 0.5s;"></div>
                    <span class="small text-muted mt-2">Tuần 1</span>
                </div>
                <div class="d-flex flex-column align-items-center flex-fill" style="height: 100%;">
                    <span class="small text-muted mb-1" style="font-size: 0.7rem;">82Tr</span>
                    <div class="w-75 bg-primary rounded-top" style="height: 82%; transition: height 0.5s;"></div>
                    <span class="small text-muted mt-2">Tuần 2</span>
                </div>
                <div class="d-flex flex-column align-items-center flex-fill" style="height: 100%;">
                    <span class="small text-muted mb-1" style="font-size: 0.7rem;">98Tr</span>
                    <div class="w-75 bg-primary rounded-top" style="height: 98%; transition: height 0.5s;"></div>
                    <span class="small text-muted mt-2">Tuần 3</span>
                </div>
                <div class="d-flex flex-column align-items-center flex-fill" style="height: 100%;">
                    <span class="small text-success fw-bold mb-1" style="font-size: 0.7rem;">125Tr</span>
                    <div class="w-75 bg-success rounded-top" style="height: 100%; transition: height 0.5s;"></div>
                    <span class="small text-dark fw-bold mt-2">Tuần 4 (Hiện tại)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================
         2 BẢNG SO SÁNH: TOP SẢN PHẨM BÁN CHẠY & TOP SẢN PHẨM BÁN Ế [W]
         ======================================================== -->
    <div class="row g-4 mb-4">
        
        <!-- Cột Trái: 🏆 BẢNG TOP SẢN PHẨM BÁN CHẠY NHẤT -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 bg-white">
                <div class="card-header bg-success text-white py-3 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-trophy text-warning me-2"></i> Top Sản Phẩm Bán Chạy Nhất [W]
                    </h5>
                    <span class="badge bg-white text-success fw-bold">Top 3 HOT</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-center small">
                        <thead class="table-light fw-bold text-uppercase">
                            <tr>
                                <th>Hạng</th>
                                <th class="text-start">Tên Điện Thoại</th>
                                <th>Đã Bán</th>
                                <th>Doanh Thu Thu Về</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="badge bg-warning text-dark fs-6 rounded-circle">🥇 1</span></td>
                                <td class="text-start fw-bold">
                                    <div class="text-dark">iPhone 13 128GB</div>
                                    <small class="text-muted">Giá: 13.990.000đ</small>
                                </td>
                                <td><span class="badge bg-success fs-6">1.450 máy</span></td>
                                <td class="fw-bold text-danger">20.285.500.000đ</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-secondary fs-6 rounded-circle">🥈 2</span></td>
                                <td class="text-start fw-bold">
                                    <div class="text-dark">iPhone 15 Pro Max 256GB</div>
                                    <small class="text-muted">Giá: 29.990.000đ</small>
                                </td>
                                <td><span class="badge bg-success fs-6">215 máy</span></td>
                                <td class="fw-bold text-danger">6.447.850.000đ</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-danger fs-6 rounded-circle">🥉 3</span></td>
                                <td class="text-start fw-bold">
                                    <div class="text-dark">Samsung Galaxy S24 Ultra 5G</div>
                                    <small class="text-muted">Giá: 28.990.000đ</small>
                                </td>
                                <td><span class="badge bg-success fs-6">148 máy</span></td>
                                <td class="fw-bold text-danger">4.290.520.000đ</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Cột Phải: ⚠️ BẢNG TOP SẢN PHẨM BÁN Ế NHẤT (KÈM NÚT TẮT ĐƯA SANG KHUYẾN MÃI) [W] -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 bg-white border-warning">
                <div class="card-header bg-warning text-dark py-3 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-exclamation-triangle text-danger me-2"></i> Top Sản Phẩm Bán Ế / Tồn Lâu [W]
                    </h5>
                    <span class="badge bg-danger text-white">Cần Xả Kho Gấp</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-center small">
                        <thead class="table-light fw-bold text-uppercase">
                            <tr>
                                <th>Mã SP</th>
                                <th class="text-start">Tên Điện Thoại</th>
                                <th>Tồn Kho</th>
                                <th>Số Bán Ra</th>
                                <th>Nút Tắt Chuyển Khuyến Mãi [W]</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- SP ế 1: Xiaomi 14 -->
                            <tr class="table-warning-subtle">
                                <td><code>XM14</code></td>
                                <td class="text-start fw-bold">
                                    <div class="text-dark">Xiaomi 14 5G 256GB</div>
                                    <small class="text-muted">Tồn kho 65 ngày</small>
                                </td>
                                <td><span class="badge bg-dark fs-6">78 máy</span></td>
                                <td><strong class="text-danger">2 máy</strong></td>
                                <td>
                                    <!-- Nút tắt chuyển nhanh sản phẩm ế sang trang Khuyến mãi [W] -->
                                    <a href="index.php?act=khuyenmai&add_id=3" class="btn btn-danger btn-sm rounded-pill px-3 py-1 fw-bold shadow-sm">
                                        <i class="fas fa-bolt me-1"></i> Đưa sang Khuyến Mãi &rarr;
                                    </a>
                                </td>
                            </tr>
                            <!-- SP ế 2: Poco X6 -->
                            <tr class="table-warning-subtle">
                                <td><code>POCO-X6</code></td>
                                <td class="text-start fw-bold">
                                    <div class="text-dark">POCO X6 Pro 5G</div>
                                    <small class="text-muted">Tồn kho 50 ngày</small>
                                </td>
                                <td><span class="badge bg-dark fs-6">40 máy</span></td>
                                <td><strong class="text-danger">4 máy</strong></td>
                                <td>
                                    <a href="index.php?act=khuyenmai&add_id=8" class="btn btn-danger btn-sm rounded-pill px-3 py-1 fw-bold shadow-sm">
                                        <i class="fas fa-bolt me-1"></i> Đưa sang Khuyến Mãi &rarr;
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-light p-3 small text-muted">
                    <i class="fas fa-lightbulb text-warning me-1"></i> Bấm <strong>Đưa sang Khuyến Mãi</strong> sẽ tự động chuyển dữ liệu sản phẩm ế này vào trang [A6] để áp dụng giảm giá kích cầu bán hàng.
                </div>
            </div>
        </div>

    </div>
</div>

        </div>
    </main>
</body>
</html>

