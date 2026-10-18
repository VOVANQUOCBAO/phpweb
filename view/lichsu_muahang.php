<div class="container my-5">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 pb-2 border-bottom gap-3">
        <div>
            <h2 class="fw-bold text-primary mb-1">
                <i class="fas fa-history me-2"></i> Lịch Sử Mua Hàng [U7]
            </h2>
            <p class="text-muted small mb-0">Theo dõi tiến trình, quản lý đơn đặt hàng, hủy đơn & khiếu nại</p>
        </div>
        <a href="index.php?act=theodoidonhang" class="btn btn-outline-primary rounded-pill px-3">
            <i class="fas fa-shipping-fast me-1"></i> Tra cứu vận đơn nhanh [U8]
        </a>
    </div>

    <!-- Thông báo xử lý hủy đơn / khiếu nại thành công -->
    <?php if (isset($_GET['cancel_success'])): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-check-circle fs-4"></i>
                <div>
                    <strong>Đã hủy đơn hàng thành công! [12/5] [17/6]</strong><br>
                    Hệ thống đã tự động hoàn lại số lượng sản phẩm vào kho và lưu thành hóa đơn hủy trong cơ sở dữ liệu.
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif (isset($_GET['complain_success'])): ?>
        <div class="alert alert-info alert-dismissible fade show rounded-4 shadow-sm" role="alert">
            <i class="fas fa-info-circle me-1"></i> Đã gửi khiếu nại thành công. Đội ngũ CSKH ĐiệnThoạiZ sẽ phản hồi bạn trong 24 giờ.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Danh sách Đơn Hàng Mẫu / Thực Tế -->
    <div class="d-flex flex-column gap-4">
        
        <!-- ĐƠN HÀNG 1: ĐANG Ở TRẠNG THÁI "CHỜ XÁC NHẬN" (Cho phép HỦY ĐƠN [W]) -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden border-blue bg-white">
            <div class="card-header bg-light py-3 px-4 d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div class="d-flex align-items-center gap-3">
                    <span class="fw-bold text-primary fs-6">Đơn hàng #DH-20261018</span>
                    <span class="text-muted small">| Ngày đặt: 18/10/2026 08:30</span>
                </div>
                <div>
                    <!-- Trạng thái Chờ xác nhận -->
                    <span class="badge bg-warning text-dark px-3 py-2 fw-bold">
                        <i class="fas fa-clock me-1"></i> Chờ xác nhận
                    </span>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="row align-items-center g-3">
                    <div class="col-12 col-md-8">
                        <div class="d-flex align-items-center gap-3">
                            <img src="view/image/Samsung Galaxy S24 Ultra 5G.jpg" alt="Samsung S24" class="rounded border p-1" style="width: 70px; height: 70px; object-fit: contain;">
                            <div>
                                <h6 class="fw-bold mb-1 text-dark">Samsung Galaxy S24 Ultra 5G 256GB</h6>
                                <div class="text-muted small">Số lượng: 1 | Màu sắc: Titan Xám | Thanh toán: COD</div>
                                <div class="text-danger fw-bold mt-1">28.990.000đ</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 text-md-end">
                        <div class="mb-2">
                            <span class="small text-muted">Tổng thanh toán:</span>
                            <div class="fs-4 fw-bold text-danger">28.490.000đ</div>
                            <small class="text-success"><i class="fas fa-tag"></i> Đã giảm 500k Voucher</small>
                        </div>
                        <div class="d-flex justify-content-md-end gap-2">
                            <!-- Nút Hủy Đơn: Chỉ hiển thị khi đang Chờ xác nhận [W] [12/5] -->
                            <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalHuyDon" data-order="DH-20261018">
                                <i class="fas fa-times-circle me-1"></i> Hủy đơn hàng [W]
                            </button>
                            <a href="index.php?act=theodoidonhang&id=DH-20261018" class="btn btn-primary btn-sm rounded-pill px-3">
                                <i class="fas fa-eye me-1"></i> Theo dõi [U8]
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ĐƠN HÀNG 2: TRẠNG THÁI "ĐANG GIAO" (Không cho phép hủy) -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
            <div class="card-header bg-light py-3 px-4 d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div class="d-flex align-items-center gap-3">
                    <span class="fw-bold text-dark fs-6">Đơn hàng #DH-20261015</span>
                    <span class="text-muted small">| Ngày đặt: 15/10/2026 14:15</span>
                </div>
                <div>
                    <span class="badge bg-primary px-3 py-2 fw-bold">
                        <i class="fas fa-truck me-1"></i> Đang giao hàng
                    </span>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="row align-items-center g-3">
                    <div class="col-12 col-md-8">
                        <div class="d-flex align-items-center gap-3">
                            <img src="view/image/iphone 15 pro max.jpeg" alt="iPhone 15 Pro Max" class="rounded border p-1" style="width: 70px; height: 70px; object-fit: contain;">
                            <div>
                                <h6 class="fw-bold mb-1 text-dark">iPhone 15 Pro Max 256GB Titan Tự Nhiên</h6>
                                <div class="text-muted small">Số lượng: 1 | Đơn vị vận chuyển: Giao Hàng Nhanh (GHN)</div>
                                <div class="text-danger fw-bold mt-1">29.990.000đ</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 text-md-end">
                        <div class="mb-2">
                            <span class="small text-muted">Tổng thanh toán:</span>
                            <div class="fs-4 fw-bold text-danger">29.990.000đ</div>
                        </div>
                        <div class="d-flex justify-content-md-end gap-2">
                            <button type="button" class="btn btn-secondary btn-sm rounded-pill px-3 disabled" title="Đơn đã xuất kho không thể tự hủy trực tiếp">
                                <i class="fas fa-ban me-1"></i> Không thể hủy
                            </button>
                            <a href="index.php?act=theodoidonhang&id=DH-20261015" class="btn btn-primary btn-sm rounded-pill px-3">
                                <i class="fas fa-shipping-fast me-1"></i> Xem lộ trình giao
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ĐƠN HÀNG 3: TRẠNG THÁI "THÀNH CÔNG" (Có nút Gửi Khiếu Nại [12/5]) -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
            <div class="card-header bg-light py-3 px-4 d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div class="d-flex align-items-center gap-3">
                    <span class="fw-bold text-dark fs-6">Đơn hàng #DH-20260920</span>
                    <span class="text-muted small">| Ngày đặt: 20/09/2026 10:00</span>
                </div>
                <div>
                    <span class="badge bg-success px-3 py-2 fw-bold">
                        <i class="fas fa-check-double me-1"></i> Giao thành công
                    </span>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="row align-items-center g-3">
                    <div class="col-12 col-md-8">
                        <div class="d-flex align-items-center gap-3">
                            <img src="view/image/iPhone 13 128GB.png" alt="iPhone 13" class="rounded border p-1" style="width: 70px; height: 70px; object-fit: contain;">
                            <div>
                                <h6 class="fw-bold mb-1 text-dark">iPhone 13 128GB Xanh Midnight</h6>
                                <div class="text-muted small">Số lượng: 1 | Đã tích lũy: +140 điểm [17/6]</div>
                                <div class="text-danger fw-bold mt-1">13.990.000đ</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 text-md-end">
                        <div class="mb-2">
                            <span class="small text-muted">Tổng thanh toán:</span>
                            <div class="fs-4 fw-bold text-danger">13.990.000đ</div>
                        </div>
                        <div class="d-flex justify-content-md-end gap-2">
                            <!-- Nút gửi khiếu nại [W] [12/5] -->
                            <button type="button" class="btn btn-outline-warning text-dark btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalKhieuNai" data-order="DH-20260920">
                                <i class="fas fa-exclamation-triangle text-danger me-1"></i> Gửi khiếu nại [12/5]
                            </button>
                            <a href="index.php?act=chitiet&id=5#review" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                <i class="fas fa-star me-1"></i> Đánh giá
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- ========================================================
     MODAL HỦY ĐƠN HÀNG [12/5] [17/6] [19/5]
     ======================================================== -->
<div class="modal fade" id="modalHuyDon" tabindex="-1" aria-labelledby="modalHuyDonLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-danger text-white rounded-top-4">
                <h5 class="modal-title fw-bold" id="modalHuyDonLabel">
                    <i class="fas fa-exclamation-circle me-2"></i> Xác Nhận Hủy Đơn Hàng [W]
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="index.php?act=huydonhang" method="POST">
                <div class="modal-body p-4">
                    <p class="mb-3">Bạn có chắc chắn muốn hủy đơn hàng <strong id="cancelOrderIdText" class="text-danger">#DH-20261018</strong>?</p>
                    <input type="hidden" name="order_id" id="cancelOrderIdInput" value="DH-20261018">

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Lý do hủy đơn <span class="text-danger">*</span> (Lưu vào hóa đơn hủy [17/6]):</label>
                        <select class="form-select rounded-3" name="ly_do" required>
                            <option value="Tôi muốn thay đổi màu sắc / dung lượng">Tôi muốn thay đổi màu sắc / dung lượng</option>
                            <option value="Tìm thấy mức giá rẻ hơn ở nơi khác">Tìm thấy mức giá rẻ hơn ở nơi khác</option>
                            <option value="Thời gian giao hàng lâu hơn dự kiến">Thời gian giao hàng lâu hơn dự kiến</option>
                            <option value="Tôi đổi ý, không có nhu cầu mua nữa">Tôi đổi ý, không có nhu cầu mua nữa</option>
                            <option value="Lý do khác">Lý do khác</option>
                        </select>
                    </div>

                    <div class="alert alert-warning small rounded-3 mb-0">
                        <i class="fas fa-info-circle me-1"></i> <strong>Quy trình xử lý hệ thống [12/5] [17/6]:</strong>
                        <ul class="mb-0 ps-3 mt-1 text-secondary">
                            <li>Hệ thống tự động cộng hoàn lại số lượng sản phẩm vào kho.</li>
                            <li>Lưu vết hóa đơn hủy kèm lý do và thời gian, không xóa đơn hàng khỏi hệ thống.</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">Xác nhận Hủy Đơn</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================================
     MODAL GỬI KHIẾU NẠI ĐƠN HÀNG [12/5]
     ======================================================== -->
<div class="modal fade" id="modalKhieuNai" tabindex="-1" aria-labelledby="modalKhieuNaiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-warning text-dark rounded-top-4">
                <h5 class="modal-title fw-bold" id="modalKhieuNaiLabel">
                    <i class="fas fa-headset me-2"></i> Gửi Khiếu Nại Đơn Hàng [12/5]
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="index.php?act=khieunai" method="POST">
                <div class="modal-body p-4">
                    <input type="hidden" name="order_id" id="complainOrderIdInput" value="DH-20260920">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Loại khiếu nại:</label>
                        <select class="form-select rounded-3" name="loai_khieunai" required>
                            <option value="Sản phẩm bị lỗi / trầy xước">Sản phẩm bị lỗi / trầy xước</option>
                            <option value="Giao sai mẫu mã hoặc màu sắc">Giao sai mẫu mã hoặc màu sắc</option>
                            <option value="Thái độ shipper không chuẩn mực">Thái độ shipper không chuẩn mực</option>
                            <option value="Chưa nhận được quà tặng kèm">Chưa nhận được quà tặng kèm</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Mô tả chi tiết vấn đề bạn gặp phải:</label>
                        <textarea class="form-control rounded-3" name="noidung" rows="3" placeholder="Vui lòng cung cấp chi tiết..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Gửi Khiếu Nại</button>
                </div>
            </form>
        </div>
    </div>
</div>

