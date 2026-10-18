<?php
$order_id = $_GET['id'] ?? 'DH-20261018';
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 pb-2 border-bottom gap-3">
                <div>
                    <h2 class="fw-bold text-primary mb-1">
                        <i class="fas fa-route me-2"></i> Theo Dõi Quá Trình Giao Hàng [U8]
                    </h2>
                    <p class="text-muted small mb-0">Theo dõi tiến trình trực quan thời gian thực (Order Tracking) [12/5]</p>
                </div>
                <a href="index.php?act=lichsumuahang" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="fas fa-arrow-left me-1"></i> Quay lại lịch sử đơn
                </a>
            </div>

            <!-- Ô tìm kiếm mã đơn nhanh -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <form action="index.php" method="GET" class="row g-3 align-items-center">
                    <input type="hidden" name="act" value="theodoidonhang">
                    <div class="col-12 col-md-8">
                        <label class="form-label small fw-semibold text-muted">Tra cứu theo Mã đơn hàng hoặc Số điện thoại:</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-barcode text-primary"></i></span>
                            <input type="text" name="id" class="form-control border-start-0" placeholder="Ví dụ: DH-20261018 hoặc 0901234567" value="<?=htmlspecialchars($order_id)?>" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow">
                            <i class="fas fa-search me-1"></i> Tra Cứu Đơn
                        </button>
                    </div>
                </form>
            </div>

            <!-- Khung Hiển Thị Tiến Trình Đơn Hàng -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white border-blue mb-4">
                <div class="card-header bg-primary text-white py-3 px-4 d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div>
                        <span class="small opacity-75">Mã đơn hàng:</span>
                        <h5 class="mb-0 fw-bold"><?=htmlspecialchars($order_id)?></h5>
                    </div>
                    <div>
                        <span class="badge bg-warning text-dark px-3 py-2 fw-bold fs-6">
                            <i class="fas fa-truck-moving me-1"></i> Đang Giao Hàng (Bước 3/5)
                        </span>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    
                    <!-- THANH TIẾN TRÌNH TRỰC QUAN 5 BƯỚC THEO ĐÚNG LAB [W] [12/5] -->
                    <!-- Chờ xác nhận → Xác nhận đơn hàng → Đang giao → Đã giao → Thành công -->
                    <div class="tracking-timeline mb-5">
                        
                        <!-- Bước 1: Chờ xác nhận -->
                        <div class="timeline-step completed">
                            <div class="timeline-icon">
                                <i class="fas fa-file-invoice"></i>
                            </div>
                            <h6 class="timeline-title small mb-1">Chờ xác nhận</h6>
                            <span class="small text-muted d-block" style="font-size: 0.72rem;">08:30 18/10</span>
                        </div>

                        <!-- Bước 2: Xác nhận đơn hàng -->
                        <div class="timeline-step completed">
                            <div class="timeline-icon">
                                <i class="fas fa-box-check"></i>
                            </div>
                            <h6 class="timeline-title small mb-1">Xác nhận đơn</h6>
                            <span class="small text-muted d-block" style="font-size: 0.72rem;">09:15 18/10</span>
                        </div>

                        <!-- Bước 3: Đang giao hàng (Active) -->
                        <div class="timeline-step active">
                            <div class="timeline-icon">
                                <i class="fas fa-truck-fast"></i>
                            </div>
                            <h6 class="timeline-title small mb-1">Đang giao</h6>
                            <span class="small text-primary fw-bold d-block" style="font-size: 0.72rem;">Đang trên đường</span>
                        </div>

                        <!-- Bước 4: Đã giao -->
                        <div class="timeline-step">
                            <div class="timeline-icon">
                                <i class="fas fa-hand-holding-box"></i>
                            </div>
                            <h6 class="timeline-title small mb-1">Đã giao</h6>
                            <span class="small text-muted d-block" style="font-size: 0.72rem;">Dự kiến 11:30</span>
                        </div>

                        <!-- Bước 5: Thành công -->
                        <div class="timeline-step">
                            <div class="timeline-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <h6 class="timeline-title small mb-1">Thành công</h6>
                            <span class="small text-muted d-block" style="font-size: 0.72rem;">+Điểm tích lũy</span>
                        </div>

                    </div>

                    <!-- Thông tin Shipper và Lộ trình chi tiết -->
                    <div class="row g-4 mt-2">
                        <div class="col-12 col-md-6">
                            <div class="p-3 bg-light rounded-4 h-100">
                                <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                                    <i class="fas fa-user-astronaut text-primary me-2"></i> Thông Tin Nhân Viên Giao Hàng
                                </h6>
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        <i class="fas fa-motorcycle fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">Nguyễn Văn Bình (Shipper Siêu Tốc)</div>
                                        <div class="small text-muted">SĐT: <strong class="text-primary">0988.123.456</strong></div>
                                        <div class="small text-warning">⭐⭐⭐⭐⭐ (4.9/5)</div>
                                    </div>
                                </div>
                                <div class="small text-secondary">
                                    <p class="mb-1"><i class="fas fa-map-pin text-danger me-2"></i> <strong>Địa chỉ giao:</strong> 624 Âu Cơ, P.10, Q. Tân Bình, TP. HCM</p>
                                    <p class="mb-0"><i class="fas fa-comment-dots text-info me-2"></i> <strong>Ghi chú:</strong> Gọi trước 15 phút khi đến nơi.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="p-3 bg-light rounded-4 h-100">
                                <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                                    <i class="fas fa-history text-primary me-2"></i> Chi Tiết Nhật Ký Vận Chuyển
                                </h6>
                                <ul class="list-unstyled small mb-0 lh-lg">
                                    <li class="d-flex gap-2">
                                        <span class="text-primary fw-bold">10:05</span>
                                        <span>Shipper đã nhận hàng từ kho tổng và đang di chuyển tới địa chỉ nhận.</span>
                                    </li>
                                    <li class="d-flex gap-2 text-muted">
                                        <span class="fw-bold">09:15</span>
                                        <span>Đơn hàng đã được đóng gói niêm phong, kiểm tra chất lượng.</span>
                                    </li>
                                    <li class="d-flex gap-2 text-muted">
                                        <span class="fw-bold">08:30</span>
                                        <span>Khách hàng đặt hàng thành công trên website.</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

