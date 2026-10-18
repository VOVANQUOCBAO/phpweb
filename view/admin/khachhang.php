<?php
include "header_admin.php";
?>

<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h3 class="fw-bold text-dark mb-1">
                <i class="fas fa-users text-primary me-2"></i> [A4] Quản Lý Khách Hàng, Phân Hạng & Khách Bom Hàng
            </h3>
            <p class="text-muted small mb-0">Hệ thống phân hạng tự động (Silver/Gold/Diamond), tặng quà sinh nhật [17/6] và xử lý khách bom hàng [24/6]</p>
        </div>
        <div class="d-flex gap-2">
            <a href="#blacklistSection" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                <i class="fas fa-user-slash me-1"></i> Bảng Lọc Khách Bom Hàng [24/6]
            </a>
            <button class="btn btn-primary btn-sm rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#modalTangVoucher">
                <i class="fas fa-gift me-1"></i> Tặng Voucher Qua Email SMTP [17/6]
            </button>
        </div>
    </div>

    <!-- Thông báo tác vụ -->
    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'gift_success'): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 small" role="alert">
            <i class="fas fa-gift me-1"></i> <strong>ĐÃ GỬI VOUCHER SINH NHẬT / QUÀ TẶNG THÀNH CÔNG! [17/6]</strong> Hệ thống đã tự động gửi email qua Gmail SMTP và đồng thời lưu vào hộp thư của khách hàng [U9].
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'lock_success'): ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-3 small" role="alert">
            <i class="fas fa-user-lock me-1"></i> <strong>ĐÃ KHÓA TÀI KHOẢN KHÁCH HÀNG THÀNH CÔNG! [12/5]</strong> Tuyệt đối không xóa tài khoản để bảo toàn lịch sử giao dịch.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- THẺ THỐNG KÊ NHANH -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="small text-muted fw-bold">TỔNG KHÁCH HÀNG</span>
                        <h3 class="fw-bold text-dark mb-0">1.250</h3>
                    </div>
                    <div class="bg-primary-subtle text-primary rounded-circle p-3 fs-4"><i class="fas fa-users"></i></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="small text-muted fw-bold">KHÁCH HÀNG VIP (GOLD/DIAMOND)</span>
                        <h3 class="fw-bold text-warning mb-0">185</h3>
                    </div>
                    <div class="bg-warning-subtle text-warning rounded-circle p-3 fs-4"><i class="fas fa-crown"></i></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="small text-muted fw-bold">SINH NHẬT THÁNG NÀY [17/6]</span>
                        <h3 class="fw-bold text-danger mb-0">28</h3>
                    </div>
                    <div class="bg-danger-subtle text-danger rounded-circle p-3 fs-4"><i class="fas fa-birthday-cake"></i></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="small text-muted fw-bold">CẢNH BÁO BOM/TRẢ HÀNG [24/6]</span>
                        <h3 class="fw-bold text-danger mb-0">4</h3>
                    </div>
                    <div class="bg-danger text-white rounded-circle p-3 fs-4"><i class="fas fa-ban"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================
         PHẦN 1: BẢNG DANH SÁCH KHÁCH HÀNG & PHÂN HẠNG TỰ ĐỘNG
         ======================================================== -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="card-header bg-white py-3 px-4 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <h5 class="mb-0 fw-bold text-dark">
                <i class="fas fa-id-card text-primary me-2"></i> Danh Sách Khách Hàng (Kèm Tổng Đơn & Tổng Chi Tiêu [17/6])
            </h5>
            
            <!-- Bộ lọc sinh nhật / kỷ niệm [17/6] -->
            <form action="index.php" method="GET" class="d-flex align-items-center gap-2">
                <input type="hidden" name="act" value="khachhang">
                <label class="small text-muted fw-bold d-none d-md-inline"><i class="fas fa-filter"></i> Lọc ngày sinh nhật [17/6]:</label>
                <input type="month" name="thang_sinh" class="form-control form-control-sm rounded-pill" value="<?=date('Y-m')?>">
                <button type="submit" class="btn btn-outline-primary btn-sm rounded-pill px-3">Lọc</button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="table-light small fw-bold text-uppercase">
                    <tr>
                        <th>STT</th>
                        <th class="text-start">Họ Tên & Email</th>
                        <th>Số ĐT</th>
                        <th>Ngày Sinh [17/6]</th>
                        <th>Phân Hạng [17/6]</th>
                        <th>Điểm Tích Lũy</th>
                        <th>Tổng Đơn [17/6]</th>
                        <th>Tổng Tiền Mua [17/6]</th>
                        <th>Trạng Thái [12/5]</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody class="small">
                    
                    <!-- Khách 1: Hạng Diamond (Chi tiêu cao) -->
                    <tr>
                        <td class="fw-bold">1</td>
                        <td class="text-start">
                            <strong class="text-dark">Nguyễn Hoàng Quân</strong>
                            <div class="text-muted" style="font-size: 0.75rem;">quan.nguyen@email.com</div>
                        </td>
                        <td>0901.222.333</td>
                        <td>18/10/1995 <span class="badge bg-danger ms-1">🎂 Hôm nay</span></td>
                        <td><span class="badge bg-info text-dark fw-bold"><i class="fas fa-gem me-1"></i> Diamond (KC)</span></td>
                        <td><strong class="text-primary">1.450 điểm</strong></td>
                        <!-- Cột tổng số đơn [17/6] -->
                        <td><span class="badge bg-primary">8 đơn</span></td>
                        <!-- Cột tổng tiền đã đặt [17/6] -->
                        <td class="fw-bold text-danger">145.890.000đ</td>
                        <td><span class="badge bg-success">Hoạt động</span></td>
                        <td>
                            <!-- Nút gửi voucher sinh nhật qua email SMTP [17/6] -->
                            <a href="index.php?act=guiquatang&id=1&email=quan.nguyen@email.com" class="btn btn-warning btn-sm rounded-pill px-2 py-0 fw-bold text-dark" title="Gửi quà sinh nhật qua SMTP">
                                <i class="fas fa-gift"></i> Tặng Quà
                            </a>
                            <!-- Nút Khóa (CHỈ CÓ KHÓA, TUYỆT ĐỐI KHÔNG XÓA [12/5]) -->
                            <a href="index.php?act=khoakhachhang&id=1&status=lock" class="btn btn-outline-danger btn-sm rounded-pill px-2 py-0" onclick="return confirm('Bạn có chắc muốn KHÓA tài khoản khách hàng này? (Tuyệt đối không xóa dữ liệu)');">
                                Khóa
                            </a>
                        </td>
                    </tr>

                    <!-- Khách 2: Hạng Gold -->
                    <tr>
                        <td class="fw-bold">2</td>
                        <td class="text-start">
                            <strong class="text-dark">Trần Mai Anh</strong>
                            <div class="text-muted" style="font-size: 0.75rem;">maianh@email.com</div>
                        </td>
                        <td>0918.444.555</td>
                        <td>25/10/1998</td>
                        <td><span class="badge bg-warning text-dark fw-bold"><i class="fas fa-medal me-1"></i> Gold (Vàng)</span></td>
                        <td><strong class="text-primary">680 điểm</strong></td>
                        <td><span class="badge bg-primary">4 đơn</span></td>
                        <td class="fw-bold text-danger">68.450.000đ</td>
                        <td><span class="badge bg-success">Hoạt động</span></td>
                        <td>
                            <a href="index.php?act=guiquatang&id=2&email=maianh@email.com" class="btn btn-outline-warning btn-sm rounded-pill px-2 py-0 text-dark">
                                <i class="fas fa-gift"></i> Tặng Quà
                            </a>
                            <a href="index.php?act=khoakhachhang&id=2&status=lock" class="btn btn-outline-danger btn-sm rounded-pill px-2 py-0" onclick="return confirm('Bạn có chắc muốn KHÓA tài khoản khách hàng này?');">
                                Khóa
                            </a>
                        </td>
                    </tr>

                    <!-- Khách 3: Hạng Silver (Mặc định) -->
                    <tr>
                        <td class="fw-bold">3</td>
                        <td class="text-start">
                            <strong class="text-dark">Lê Minh Tuấn</strong>
                            <div class="text-muted" style="font-size: 0.75rem;">tuan.le@email.com</div>
                        </td>
                        <td>0977.888.999</td>
                        <td>05/11/2000</td>
                        <td><span class="badge bg-secondary fw-bold">Silver (Bạc)</span></td>
                        <td><strong class="text-primary">140 điểm</strong></td>
                        <td><span class="badge bg-primary">1 đơn</span></td>
                        <td class="fw-bold text-danger">13.990.000đ</td>
                        <td><span class="badge bg-success">Hoạt động</span></td>
                        <td>
                            <a href="index.php?act=guiquatang&id=3&email=tuan.le@email.com" class="btn btn-outline-warning btn-sm rounded-pill px-2 py-0 text-dark">
                                <i class="fas fa-gift"></i> Tặng Quà
                            </a>
                            <a href="index.php?act=khoakhachhang&id=3&status=lock" class="btn btn-outline-danger btn-sm rounded-pill px-2 py-0" onclick="return confirm('Bạn có chắc muốn KHÓA tài khoản khách hàng này?');">
                                Khóa
                            </a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <div class="card-footer bg-light p-3 small text-muted">
            <i class="fas fa-info-circle text-primary me-1"></i> <strong>Quy tắc hệ thống:</strong> Điểm tích lũy và Phân hạng được tự động thăng hạng (Silver &rarr; Gold &ge; 500 điểm &rarr; Diamond &ge; 1000 điểm). Tuyệt đối <strong>chỉ có nút Khóa khách hàng, không bao giờ có nút Xóa</strong> để bảo toàn lịch sử kinh doanh [12/5].
        </div>
    </div>

    <!-- ========================================================
         PHẦN 2: BẢNG LỌC KHÁCH BOM HÀNG & HỦY ĐƠN THƯỜNG XUYÊN [24/6]
         ======================================================== -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 border-danger" id="blacklistSection">
        <div class="card-header bg-danger text-white py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-ban me-2"></i> Bảng Lọc Khách Bom Hàng & Hủy Đơn Thường Xuyên [24/6]
            </h5>
            <span class="badge bg-white text-danger fw-bold">Phân hệ Blacklist bảo vệ Shop</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="table-light small fw-bold text-uppercase">
                    <tr>
                        <th>Mã KH</th>
                        <th class="text-start">Khách Hàng Nghi Vấn</th>
                        <th>Số ĐT</th>
                        <th>Số Lần Tự Hủy</th>
                        <th>Phân Loại Hành Vi Vi Phạm [24/6]</th>
                        <th>Mức Độ Cảnh Báo</th>
                        <th>Hành Động Khẩn Cấp</th>
                    </tr>
                </thead>
                <tbody class="small">
                    
                    <!-- Khách Bom Hàng 1 -->
                    <tr class="table-danger-subtle">
                        <td><code>KH-BOM01</code></td>
                        <td class="text-start">
                            <strong class="text-danger">Vũ Văn Bùng</strong>
                            <div class="text-muted" style="font-size: 0.72rem;">bung.vu@fake.com</div>
                        </td>
                        <td>0933.000.111</td>
                        <td><span class="badge bg-danger fs-6">4 lần</span></td>
                        <!-- Phân loại rõ "Bom hàng" (Shipper gọi không nghe máy) [24/6] -->
                        <td class="text-start">
                            <span class="badge bg-danger p-2 mb-1 d-inline-block">
                                <i class="fas fa-phone-slash me-1"></i> Bom Hàng (Shipper gọi không nghe máy)
                            </span>
                            <div class="text-danger small">Shipper báo gọi 5 cuộc liên tiếp khi giao iPhone 15 Pro Max không nhấc máy.</div>
                        </td>
                        <td><span class="badge bg-danger fs-6">Cực kỳ nguy hiểm</span></td>
                        <td>
                            <!-- Admin bấm nút Khóa tài khoản ngay lập tức [24/6] -->
                            <a href="index.php?act=khoakhachhang&id=99&status=lock" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold shadow" onclick="return confirm('Khóa tài khoản khách BOM HÀNG này ngay lập tức?');">
                                <i class="fas fa-user-slash me-1"></i> KHÓA TÀI KHOẢN NGAY [24/6]
                            </a>
                        </td>
                    </tr>

                    <!-- Khách Trả Hàng 2 -->
                    <tr class="table-warning-subtle">
                        <td><code>KH-TRA02</code></td>
                        <td class="text-start">
                            <strong class="text-dark">Ngô Thất Hứa</strong>
                            <div class="text-muted" style="font-size: 0.72rem;">hua.ngo@gmail.com</div>
                        </td>
                        <td>0912.999.888</td>
                        <td><span class="badge bg-warning text-dark fs-6">3 lần</span></td>
                        <!-- Phân loại rõ "Trả hàng" (Nghe máy nhưng từ chối nhận) [24/6] -->
                        <td class="text-start">
                            <span class="badge bg-warning text-dark p-2 mb-1 d-inline-block">
                                <i class="fas fa-undo-alt me-1"></i> Trả Hàng (Nghe máy nhưng từ chối nhận)
                            </span>
                            <div class="text-muted small">Khách nghe máy nhưng báo "Hết tiền, đổi ý không mua nữa".</div>
                        </td>
                        <td><span class="badge bg-warning text-dark">Rủi ro cao</span></td>
                        <td>
                            <a href="index.php?act=khoakhachhang&id=98&status=lock" class="btn btn-warning btn-sm rounded-pill px-3 fw-bold text-dark shadow" onclick="return confirm('Khóa tài khoản khách TRẢ HÀNG nhiều lần này?');">
                                <i class="fas fa-user-lock me-1"></i> KHÓA TÀI KHOẢN [24/6]
                            </a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <div class="card-footer bg-light p-3 small text-muted">
            <i class="fas fa-shield-alt text-danger me-1"></i> <strong>Cơ chế xử lý tự động [24/6]:</strong> Khi đơn hàng bị Admin đánh dấu <em>"Khách bom hàng"</em> hoặc <em>"Khách trả hàng"</em> ở trang [A7], hệ thống sẽ tự động hoàn lại tồn kho cho sản phẩm, đồng thời đẩy khách hàng vào bảng Blacklist này để Admin khóa vĩnh viễn quyền đặt hàng.
        </div>
    </div>
</div>

<!-- MODAL TẶNG VOUCHER / QUÀ QUA EMAIL SMTP [17/6] -->
<div class="modal fade" id="modalTangVoucher" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-primary text-white rounded-top-4">
                <h5 class="modal-title fw-bold"><i class="fas fa-gift me-2"></i> Tặng Voucher / Quà Qua Email SMTP [17/6]</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?act=guiquatang" method="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Chọn nhóm đối tượng khách hàng:</label>
                        <select name="nhom_khach" class="form-select rounded-3">
                            <option value="sinhnhat">Khách hàng có sinh nhật trong tháng [17/6]</option>
                            <option value="diamond">Toàn bộ khách hàng Hạng Kim Cương (Diamond)</option>
                            <option value="gold">Toàn bộ khách hàng Hạng Vàng (Gold)</option>
                            <option value="tatca">Tất cả khách hàng thân thiết</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Mã Voucher Tặng Kèm:</label>
                        <select name="ma_voucher" class="form-select rounded-3">
                            <option value="SINHNHAT2026">SINHNHAT2026 (Giảm 1.000.000đ)</option>
                            <option value="TRIANVIP">TRIANVIP (Giảm 10% tối đa 2 Triệu)</option>
                            <option value="FREESHIP">FREESHIP (Miễn phí vận chuyển)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Tiêu đề thư gửi qua Gmail SMTP:</label>
                        <input type="text" name="tieude" class="form-control rounded-3" value="🎁 Chúc Mừng Sinh Nhật! ĐiệnThoạiZ Tặng Bạn Voucher 1.000.000đ" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Lời chúc và thông điệp:</label>
                        <textarea name="loinhan" class="form-control rounded-3" rows="3">Chúc mừng sinh nhật quý khách! Chúc bạn luôn vui vẻ và thành công. Mã voucher đã được kích hoạt trong tài khoản của bạn.</textarea>
                    </div>
                    <div class="alert alert-info small rounded-3 mb-0">
                        <i class="fas fa-envelope-open-text me-1"></i> Thư sẽ được gửi bằng <strong>Gmail SMTP (PHPMailer)</strong> và đồng thời lưu vào bảng <code>email</code> để khách xem tại [U9] Hộp thư.
                    </div>
                </div>
                <div class="modal-footer bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Gửi Mail SMTP Ngay</button>
                </div>
            </form>
        </div>
    </div>
</div>

        </div>
    </main>
</body>
</html>

