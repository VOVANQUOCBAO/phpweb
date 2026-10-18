<?php
include "header_admin.php";
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">
                <i class="fas fa-shipping-fast text-primary me-2"></i> [A7] Quản Lý Đơn Hàng & Cập Nhật Trạng Thái Quy Trình Một Chiều
            </h3>
            <p class="text-muted small mb-0">Quy trình nghiêm ngặt [16/6]: Chờ xác nhận &rarr; Xác nhận &rarr; Đang giao &rarr; Đã giao &rarr; Thành công (+Điểm VIP) | Xử lý bom hàng [24/6]</p>
        </div>
        <div class="d-flex gap-2">
            <span class="badge bg-primary p-2">Quy Trình 1 Chiều [16/6]</span>
            <span class="badge bg-danger p-2">Xử Lý Bom Hàng [24/6]</span>
        </div>
    </div>

    <!-- Thông báo kết quả xử lý nghiệp vụ -->
    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'status_updated'): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 small" role="alert">
            <i class="fas fa-check-circle me-1"></i> Cập nhật trạng thái đơn hàng theo đúng quy trình 1 chiều thành công!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'bom_hang'): ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-3 small" role="alert">
            <i class="fas fa-ban me-1"></i> <strong>ĐÃ GHI NHẬN SỰ CỐ KHÁCH BOM HÀNG / TRẢ HÀNG [24/6]!</strong> Hệ thống đã tự động cộng hoàn lại số lượng tồn kho cho sản phẩm và ghi nhận vi phạm vào hồ sơ khách hàng.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'completed'): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 small" role="alert">
            <i class="fas fa-crown me-1"></i> <strong>ĐƠN HÀNG HOÀN TẤT THÀNH CÔNG!</strong> Hệ thống đã tự động cộng điểm tích lũy và xét duyệt thăng hạng (Silver/Gold/Diamond) cho khách hàng.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Bảng Danh Sách Đơn Hàng -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-dark">Danh Sách Đơn Hàng Cần Xử Lý [16/6]</h5>
            <span class="badge bg-primary">4 đơn hàng</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="table-light small fw-bold text-uppercase">
                    <tr>
                        <th>Mã Đơn [16/6]</th>
                        <th class="text-start">Khách Hàng & SĐT</th>
                        <th>Ngày Đặt</th>
                        <th>Tổng Tiền</th>
                        <th>PT Thanh Toán</th>
                        <th>Trạng Thái Hiện Tại</th>
                        <th>Cập Nhật Tiến Trình Một Chiều [16/6] [24/6]</th>
                        <th>Chi Tiết [16/6]</th>
                    </tr>
                </thead>
                <tbody class="small">
                    
                    <!-- ĐƠN 1: ĐANG Ở "CHỜ XÁC NHẬN" -> Chỉ cho phép chuyển "Xác nhận đơn hàng" -->
                    <tr>
                        <td><code>#DH-1018</code></td>
                        <td class="text-start">
                            <strong class="text-dark">Nguyễn Văn A</strong>
                            <div class="text-muted" style="font-size: 0.72rem;">0901.234.567</div>
                        </td>
                        <td>18/10/2026 08:30</td>
                        <td class="fw-bold text-danger">28.490.000đ</td>
                        <td><span class="badge bg-light text-dark border">COD</span></td>
                        <td>
                            <span class="badge bg-warning text-dark p-2"><i class="fas fa-clock me-1"></i> Chờ xác nhận</span>
                        </td>
                        <td>
                            <!-- Bước kế tiếp hợp lệ: Xác nhận đơn hàng (Chặn lùi/nhảy cóc) [16/6] -->
                            <a href="index.php?act=capnhattrangthai&id=1018&next_step=xacnhan" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold">
                                1. Xác nhận đơn hàng &rarr;
                            </a>
                        </td>
                        <td>
                            <button class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-1" data-bs-toggle="modal" data-bs-target="#modalCTDH1">
                                <i class="fas fa-eye me-1"></i> Xem chi tiết [16/6]
                            </button>
                        </td>
                    </tr>

                    <!-- ĐƠN 2: ĐANG Ở "XÁC NHẬN ĐƠN HÀNG" -> Chỉ cho phép chuyển "Đang giao" -->
                    <tr>
                        <td><code>#DH-1017</code></td>
                        <td class="text-start">
                            <strong class="text-dark">Trần Mai Anh</strong>
                            <div class="text-muted" style="font-size: 0.72rem;">0918.444.555</div>
                        </td>
                        <td>17/10/2026 15:20</td>
                        <td class="fw-bold text-danger">8.990.000đ</td>
                        <td><span class="badge bg-success-subtle text-success border">VietQR</span></td>
                        <td>
                            <span class="badge bg-info text-dark p-2"><i class="fas fa-box me-1"></i> Xác nhận đơn hàng</span>
                        </td>
                        <td>
                            <!-- Bước kế tiếp: Chuyển sang Đang giao -->
                            <a href="index.php?act=capnhattrangthai&id=1017&next_step=danggiao" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold">
                                2. Xuất kho &rarr; Đang giao
                            </a>
                        </td>
                        <td>
                            <button class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-1" data-bs-toggle="modal" data-bs-target="#modalCTDH2">
                                <i class="fas fa-eye me-1"></i> Xem chi tiết [16/6]
                            </button>
                        </td>
                    </tr>

                    <!-- ĐƠN 3: ĐANG Ở "ĐANG GIAO" -> Có 2 tùy chọn bình thường và 2 tùy chọn SỰ CỐ BOM HÀNG [24/6] -->
                    <tr class="table-primary-subtle">
                        <td><code>#DH-1015</code></td>
                        <td class="text-start">
                            <strong class="text-danger">Vũ Văn Bùng</strong>
                            <div class="text-muted" style="font-size: 0.72rem;">0933.000.111</div>
                        </td>
                        <td>15/10/2026 14:15</td>
                        <td class="fw-bold text-danger">29.990.000đ</td>
                        <td><span class="badge bg-light text-dark border">COD</span></td>
                        <td>
                            <span class="badge bg-primary p-2"><i class="fas fa-truck me-1"></i> Đang giao hàng</span>
                        </td>
                        <td>
                            <div class="d-flex flex-column gap-1">
                                <!-- Tiến trình bình thường: Đã giao -->
                                <a href="index.php?act=capnhattrangthai&id=1015&next_step=dagiao" class="btn btn-success btn-sm rounded-pill px-2 py-1 fw-bold">
                                    3. Giao thành công &rarr; Đã giao
                                </a>
                                <!-- Sự cố 1: Khách bom hàng (Gọi không nghe máy) [24/6] -->
                                <a href="index.php?act=capnhattrangthai&id=1015&su_co=bom_hang" class="btn btn-danger btn-sm rounded-pill px-2 py-1" onclick="return confirm('Xác nhận khách BOM HÀNG? Hệ thống sẽ tự hoàn lại tồn kho và đưa khách vào blacklist!');">
                                    <i class="fas fa-phone-slash"></i> Khách bom hàng (Không nghe máy) [24/6]
                                </a>
                                <!-- Sự cố 2: Khách trả hàng (Nghe máy không lấy) [24/6] -->
                                <a href="index.php?act=capnhattrangthai&id=1015&su_co=tra_hang" class="btn btn-warning btn-sm rounded-pill px-2 py-1 text-dark" onclick="return confirm('Xác nhận khách TRẢ HÀNG? Hệ thống sẽ tự hoàn tồn kho!');">
                                    <i class="fas fa-undo-alt"></i> Khách trả hàng (Không nhận) [24/6]
                                </a>
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-1">
                                <i class="fas fa-eye me-1"></i> Xem [16/6]
                            </button>
                        </td>
                    </tr>

                    <!-- ĐƠN 4: ĐANG Ở "ĐÃ GIAO" -> Bước cuối cùng: Chuyển sang "Thành công" -->
                    <tr>
                        <td><code>#DH-0920</code></td>
                        <td class="text-start">
                            <strong class="text-dark">Lê Minh Tuấn</strong>
                            <div class="text-muted" style="font-size: 0.72rem;">0977.888.999</div>
                        </td>
                        <td>20/09/2026 10:00</td>
                        <td class="fw-bold text-danger">13.990.000đ</td>
                        <td><span class="badge bg-light text-dark border">COD</span></td>
                        <td>
                            <span class="badge bg-info p-2"><i class="fas fa-check-circle me-1"></i> Đã giao hàng</span>
                        </td>
                        <td>
                            <!-- Bước cuối: Chuyển sang Thành công (Cộng điểm VIP) -->
                            <a href="index.php?act=capnhattrangthai&id=0920&next_step=thanhcong" class="btn btn-success btn-sm rounded-pill px-3 py-1 fw-bold shadow">
                                4. Hoàn tất &rarr; Thành công (+Điểm VIP)
                            </a>
                        </td>
                        <td>
                            <button class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-1">
                                <i class="fas fa-eye me-1"></i> Xem [16/6]
                            </button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <div class="card-footer bg-light p-3 small text-muted">
            <i class="fas fa-shield-alt text-primary me-1"></i> <strong>Ràng buộc logic [16/6]:</strong> Code PHP chặn nghiêm ngặt không cho phép nhảy cóc bước hoặc chọn lùi trạng thái đơn hàng. Ở bước <em>Đang giao</em>, nếu chọn <em>Khách bom hàng</em> hoặc <em>Khách trả hàng</em> [24/6], tồn kho được hoàn trả tự động và ghi nhận lịch sử vi phạm.
        </div>
    </div>
</div>

<!-- MODAL XEM CHI TIẾT ĐƠN HÀNG [16/6] -->
<div class="modal fade" id="modalCTDH1" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-primary text-white rounded-top-4">
                <h5 class="modal-title fw-bold"><i class="fas fa-file-invoice me-2"></i> Chi Tiết Mặt Hàng Trong Đơn #DH-1018 [16/6]</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3 mb-3 small">
                    <div class="col-md-6">
                        <strong>Người nhận:</strong> Nguyễn Văn A<br>
                        <strong>Số điện thoại:</strong> 0901.234.567<br>
                        <strong>Email:</strong> nguyenvana@email.com
                    </div>
                    <div class="col-md-6">
                        <strong>Địa chỉ giao:</strong> 624 Âu Cơ, P.10, Q. Tân Bình, TP. HCM<br>
                        <strong>Phương thức:</strong> COD (Thu tiền tận nơi)<br>
                        <strong>Ghi chú:</strong> Gọi trước 15 phút.
                    </div>
                </div>

                <div class="table-responsive border rounded-3 overflow-hidden">
                    <table class="table table-hover align-middle mb-0 text-center small">
                        <thead class="table-light fw-bold">
                            <tr>
                                <th>Mã SP</th>
                                <th>Hình</th>
                                <th class="text-start">Tên Mặt Hàng</th>
                                <th>Đơn Giá</th>
                                <th>Số Lượng</th>
                                <th>Thành Tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>S24U</code></td>
                                <td><img src="../../view/image/Samsung Galaxy S24 Ultra 5G.jpg" style="width: 40px; height: 40px; object-fit: contain;"></td>
                                <td class="text-start fw-bold">Samsung Galaxy S24 Ultra 5G 256GB</td>
                                <td>28.990.000đ</td>
                                <td>1</td>
                                <td class="fw-bold text-danger">28.990.000đ</td>
                            </tr>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="5" class="text-end fw-bold">Voucher giảm giá (CHAOBAN):</td>
                                <td class="text-success fw-bold">-500.000đ</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-end fw-bold fs-6">Tổng Thanh Toán:</td>
                                <td class="text-danger fw-bold fs-6">28.490.000đ</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light rounded-bottom-4">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

        </div>
    </main>
</body>
</html>

