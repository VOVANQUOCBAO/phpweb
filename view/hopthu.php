<div class="container my-5">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 pb-2 border-bottom gap-3">
        <div>
            <h2 class="fw-bold text-primary mb-1">
                <i class="fas fa-inbox me-2"></i> Hộp Thư Cá Nhân (Inbox) [U9]
            </h2>
            <p class="text-muted small mb-0">Xem email xác nhận thanh toán, thư tặng quà sinh nhật & voucher do Admin gửi [17/6]</p>
        </div>
        <span class="badge bg-danger rounded-pill px-3 py-2 fs-6">2 thư mới</span>
    </div>

    <div class="row g-4">
        <!-- Cột Danh sách Thư -->
        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                <div class="p-3 bg-light border-bottom d-flex justify-content-between align-items-center">
                    <span class="fw-bold small text-secondary">DANH SÁCH THƯ ĐÃ NHẬN</span>
                    <span class="small text-muted">SMTP Gmail Lưu Trữ [9/6]</span>
                </div>

                <div class="list-group list-group-flush" id="emailList">
                    
                    <!-- Thư 1: Quà tặng sinh nhật [17/6] -->
                    <a href="javascript:void(0)" class="list-group-item list-group-item-action p-3 active border-start border-4 border-primary" onclick="showMail(1, this)">
                        <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                            <span class="fw-bold small"><i class="fas fa-birthday-cake text-danger me-1"></i> Admin ĐiệnThoạiZ</span>
                            <small class="opacity-75">Hôm nay</small>
                        </div>
                        <h6 class="mb-1 fw-bold text-truncate" style="font-size: 0.95rem;">🎁 Chúc Mừng Sinh Nhật! Tặng Bạn Voucher 1.000.000đ [17/6]</h6>
                        <p class="mb-1 small opacity-75 text-truncate">Nhân dịp sinh nhật của bạn, ĐiệnThoạiZ xin gửi tặng bạn mã giảm giá...</p>
                        <span class="badge bg-warning text-dark" style="font-size: 0.7rem;">Quà Sinh Nhật</span>
                    </a>

                    <!-- Thư 2: Xác nhận đơn hàng SMTP [12/5] -->
                    <a href="javascript:void(0)" class="list-group-item list-group-item-action p-3" onclick="showMail(2, this)">
                        <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                            <span class="fw-bold small text-dark"><i class="fas fa-receipt text-primary me-1"></i> Hệ Thống Đơn Hàng</span>
                            <small class="text-muted">18/10/2026</small>
                        </div>
                        <h6 class="mb-1 fw-bold text-dark text-truncate" style="font-size: 0.95rem;">Xác Nhận Đơn Hàng #DH-20261018 Thành Công</h6>
                        <p class="mb-1 small text-muted text-truncate">Cảm ơn bạn đã đặt mua sản phẩm Samsung Galaxy S24 Ultra 5G...</p>
                        <span class="badge bg-success" style="font-size: 0.7rem;">Hóa đơn SMTP</span>
                    </a>

                    <!-- Thư 3: Nâng hạng thành viên -->
                    <a href="javascript:void(0)" class="list-group-item list-group-item-action p-3" onclick="showMail(3, this)">
                        <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                            <span class="fw-bold small text-dark"><i class="fas fa-crown text-warning me-1"></i> Chăm Sóc Khách Hàng</span>
                            <small class="text-muted">10/10/2026</small>
                        </div>
                        <h6 class="mb-1 fw-bold text-dark text-truncate" style="font-size: 0.95rem;">Chào Mừng Bạn Đạt Hạng Thành Viên Bạc (Silver)</h6>
                        <p class="mb-1 small text-muted text-truncate">Chúc mừng bạn đã tích lũy đủ điểm và được nâng hạng thành viên...</p>
                        <span class="badge bg-info text-dark" style="font-size: 0.7rem;">Nâng hạng VIP</span>
                    </a>

                </div>
            </div>
        </div>

        <!-- Cột Xem Nội Dung Chi Tiết Thư -->
        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100 border-blue" id="mailDetailCard">
                
                <!-- Nội dung thư 1 (Mặc định hiển thị) -->
                <div id="mailContent1">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="fas fa-gift fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-0">🎁 Quà Tặng Sinh Nhật Đặc Quyền [17/6]</h5>
                                <small class="text-muted">Từ: <strong>admin@dienthoaiz.vn</strong> | Gửi qua: Gmail SMTP</small>
                            </div>
                        </div>
                        <span class="badge bg-light text-dark border p-2">18/10/2026 08:00</span>
                    </div>

                    <div class="mail-body text-secondary lh-lg mb-4">
                        <p>Thân gửi Quý khách hàng <strong>Nguyễn Văn A</strong>,</p>
                        <p>Nhân ngày sinh nhật của bạn (<strong><?=htmlspecialchars($_SESSION['user']['ngaysinh'] ?? '18/10')?></strong>), Ban Giám đốc và toàn thể đội ngũ <strong>ĐiệnThoạiZ</strong> xin gửi lời chúc mừng sinh nhật ấm áp, hạnh phúc và thành công nhất!</p>
                        
                        <div class="p-4 bg-light rounded-4 border border-warning text-center my-4">
                            <div class="text-warning display-6 mb-2"><i class="fas fa-birthday-cake"></i></div>
                            <h5 class="fw-bold text-danger mb-1">MÃ VOUCHER QUÀ TẶNG SINH NHẬT</h5>
                            <p class="small text-muted mb-2">Giảm ngay 1.000.000đ khi đặt mua smartphone bất kỳ</p>
                            <div class="d-inline-block bg-white border border-2 border-danger px-4 py-2 rounded-pill fs-4 fw-bold text-danger tracking-wider">
                                SINHNHAT2026
                            </div>
                            <div class="mt-2 small text-muted">Hạn sử dụng: Đến hết ngày 31/10/2026</div>
                        </div>

                        <p>Mã voucher đã được lưu sẵn trong hệ thống và bạn có thể nhập trực tiếp tại trang thanh toán.</p>
                        <p class="mb-0">Trân trọng cảm ơn bạn đã luôn đồng hành cùng ĐiệnThoạiZ!</p>
                    </div>

                    <div class="d-flex gap-2 border-top pt-3">
                        <a href="index.php?act=trangchu" class="btn btn-primary rounded-pill px-4 fw-bold">
                            <i class="fas fa-shopping-bag me-1"></i> Sử dụng Voucher Ngay
                        </a>
                    </div>
                </div>

                <!-- Nội dung thư 2: Xác nhận đơn hàng -->
                <div id="mailContent2" class="d-none">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="fas fa-receipt fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-0">Xác Nhận Đơn Hàng #DH-20261018</h5>
                                <small class="text-muted">Từ: <strong>order@dienthoaiz.vn</strong> | Trạng thái: Chờ xác nhận</small>
                            </div>
                        </div>
                        <span class="badge bg-light text-dark border p-2">18/10/2026 08:31</span>
                    </div>

                    <div class="mail-body text-secondary lh-lg mb-4">
                        <p>Chào bạn <strong>Nguyễn Văn A</strong>,</p>
                        <p>Hệ thống vừa ghi nhận đơn đặt hàng của bạn với các thông tin chi tiết sau:</p>
                        <div class="table-responsive border rounded-3 p-3 bg-light my-3">
                            <table class="table table-borderless small mb-0">
                                <tr>
                                    <td><strong>Sản phẩm:</strong></td>
                                    <td>Samsung Galaxy S24 Ultra 5G (Số lượng: 1)</td>
                                </tr>
                                <tr>
                                    <td><strong>Địa chỉ nhận:</strong></td>
                                    <td>624 Âu Cơ, P.10, Q. Tân Bình, TP. HCM</td>
                                </tr>
                                <tr>
                                    <td><strong>Tổng thanh toán:</strong></td>
                                    <td class="text-danger fw-bold fs-6">28.490.000đ (COD)</td>
                                </tr>
                            </table>
                        </div>
                        <p>Đơn hàng sẽ được nhân viên gọi điện xác nhận và chuyển phát nhanh trong 1-2 giờ.</p>
                    </div>

                    <div class="d-flex gap-2 border-top pt-3">
                        <a href="index.php?act=theodoidonhang&id=DH-20261018" class="btn btn-outline-primary rounded-pill px-4">
                            <i class="fas fa-truck me-1"></i> Xem lộ trình giao hàng
                        </a>
                    </div>
                </div>

                <!-- Nội dung thư 3: Nâng hạng thành viên -->
                <div id="mailContent3" class="d-none">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="fas fa-crown fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-0">Chúc Mừng Bạn Đạt Hạng Silver (Bạc)</h5>
                                <small class="text-muted">Từ: <strong>vip@dienthoaiz.vn</strong></small>
                            </div>
                        </div>
                        <span class="badge bg-light text-dark border p-2">10/10/2026 10:00</span>
                    </div>

                    <div class="mail-body text-secondary lh-lg mb-4">
                        <p>Xin chúc mừng! Tổng chi tiêu và điểm tích lũy của bạn đã đạt điều kiện trở thành Thành viên Bạc.</p>
                        <p>Quyền lợi hạng Bạc [12/5] [17/6]:</p>
                        <ul class="ps-3">
                            <li>Áp dụng mã FREESHIP miễn phí giao hàng toàn quốc.</li>
                            <li>Tặng thêm 1 điểm cho mỗi 100.000đ mua hàng.</li>
                            <li>Ưu tiên hỗ trợ kỹ thuật và bảo hành nhanh trong 24h.</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
function showMail(id, el) {
    document.querySelectorAll('#emailList .list-group-item').forEach(item => {
        item.classList.remove('active', 'border-start', 'border-4', 'border-primary');
    });
    el.classList.add('active', 'border-start', 'border-4', 'border-primary');

    document.getElementById('mailContent1').classList.add('d-none');
    document.getElementById('mailContent2').classList.add('d-none');
    document.getElementById('mailContent3').classList.add('d-none');

    const target = document.getElementById('mailContent' + id);
    if (target) {
        target.classList.remove('d-none');
    }
}
</script>

